<?php

namespace App\Livewire\Employee;

use App\Models\Attendance;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

#[Title('TalentFlow Pro | My Attendance')]
class EmployeeAttendance extends Component
{
    public $employee;
    public $attendances;        // current month only
    public $todayAttendance;
    public $notes;
    public $isClockedIn   = false;
    public $isOnBreak     = false;
    public $activeBreak   = null;
    public $todayMinutes  = 0;  // total worked minutes today (excluding breaks)
    public $todayBreakMinutes = 0; // total break minutes today

    // All counts for the stat strip
    public $monthPresentCount = 0;
    public $monthAbsentCount  = 0;
    public $monthLateCount    = 0;

    // Africa/Kigali = UTC+2, no DST
    private const TZ = 'Africa/Kigali';

    private function now(): Carbon
    {
        return Carbon::now(self::TZ);
    }

    public function mount(): void
    {
        $user = Auth::user();
        $this->employee = Employee::with(['departmentAssignment', 'shift'])->where('user_id', $user->id)->first();

        if (!$this->employee) {
            $lastEmployee = Employee::orderBy('id', 'desc')->first();
            $lastCode     = $lastEmployee ? intval(substr($lastEmployee->code, -4)) : 0;
            $newCode      = 'EMP-' . str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);

            $this->employee = Employee::create([
                'code'            => $newCode,
                'first_name'      => $user->first_name,
                'last_name'       => $user->last_name,
                'email'           => $user->email,
                'phone_number'    => $user->phone_number,
                'user_id'         => $user->id,
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
            ]);
        }

        $this->loadAttendanceData();
    }

    public function loadAttendanceData(): void
    {
        $now   = $this->now();
        $today = $now->format('Y-m-d');

        // ── Current month only ──────────────────────────────────────────────
        $this->attendances = Attendance::where('employee_id', $this->employee->id)
            ->whereYear('date',  $now->year)
            ->whereMonth('date', $now->month)
            ->orderBy('date', 'desc')
            ->get();

        // ── Today's record (find active session first, then today's record) ──
        $this->todayAttendance = Attendance::with('shift')
            ->where('employee_id', $this->employee->id)
            ->whereNull('check_out')
            ->orderBy('date', 'desc')
            ->first();

        if (!$this->todayAttendance) {
            $this->todayAttendance = Attendance::with('shift')
                ->where('employee_id', $this->employee->id)
                ->where('date', $today)
                ->first();
        }

        // ── Breaks today ──────────────────────────────────────────────────
        $this->todayBreakMinutes = 0;
        $this->isOnBreak = false;
        $this->activeBreak = null;
        
        if ($this->todayAttendance) {
            $breaks = \App\Models\AttendanceBreak::where('attendance_id', $this->todayAttendance->id)->get();
            $this->todayBreakMinutes = $breaks->sum('total_minutes');
            $this->activeBreak = $breaks->whereNull('end_time')->first();
            $this->isOnBreak = !empty($this->activeBreak);
        }

        // ── Minutes worked today ────────────────────────────────────────────
        $this->todayMinutes = 0;
        if ($this->todayAttendance?->check_in) {
            $ci = $this->toCarbon($this->todayAttendance->check_in, $this->todayAttendance->date);
            $co = $this->todayAttendance->check_out ? $this->toCarbon($this->todayAttendance->check_out) : $now;
            
            if ($ci && $co && $co->gt($ci)) {
                $this->todayMinutes = (int) $ci->diffInMinutes($co) - (int) $this->todayBreakMinutes;
            }
        }

        // ── Monthly stat counts ─────────────────────────────────────────────
        $this->monthPresentCount = $this->attendances->filter(fn($a) => 
            $a->check_in !== null && 
            !in_array(strtolower($a->daily_status), ['absent', 'rejected', 'on leave'])
        )->count();
        $this->monthAbsentCount = $this->attendances->filter(fn($a) => strtolower($a->daily_status) === 'absent')->count();
        $this->monthLateCount = $this->attendances->filter(fn($a) => strtolower($a->daily_status) === 'late')->count();

        // ── Is clocked in? ──────────────────────────────────────────────────
        $this->isClockedIn = $this->todayAttendance
            && $this->todayAttendance->check_in
            && !$this->todayAttendance->check_out;
    }

    public function clockIn($lat = null, $lng = null): void
    {
        $now   = $this->now();
        $today = $now->format('Y-m-d');

        // Check if on approved leave
        $onLeave = \App\Models\LeaveRequest::where('employee_id', $this->employee->id)
            ->where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->exists();

        if ($onLeave) {
            session()->flash('error', 'Check-in failed: You have an approved leave for today.');
            return;
        }

        // Geofencing Check...
        
        // --- CLEANUP: Close any orphaned sessions from previous days ---
        $orphans = Attendance::where('employee_id', $this->employee->id)
            ->where('date', '<', $today)
            ->whereNull('check_out')
            ->get();
        
        foreach ($orphans as $orphan) {
            $orphan->update([
                'check_out'    => $orphan->check_in, // Close it at the same time it started
                'daily_status' => 'Requires Review',
                'notes'        => '[Auto-closed] Employee forgot to clock out.',
                'updated_by'   => Auth::id(),
            ]);
        }
        if ($lat && $lng) {
            $dept = $this->employee->departmentAssignment;
            if ($dept && $dept->latitude && $dept->longitude) {
                $distance = $this->calculateDistance($lat, $lng, $dept->latitude, $dept->longitude);
                $radius = $dept->geofence_radius_meters ?: 100;
                
                if ($distance > $radius) {
                    session()->flash('error', "Check-in failed: You are outside the office geofence ($distance m).");
                    return;
                }
            }
        }

        $existing = Attendance::where('employee_id', $this->employee->id)
            ->where('date', $today)
            ->first();

        if ($existing && $existing->check_in) {
            session()->flash('error', 'You have already clocked in today.');
            return;
        }

        $shift = $this->employee->shift;
        $lateMinutes = 0;
        $status = 'Present';

        $approvalStatus = \App\Enum\ApprovalStatus::NotApplicable;

        if ($shift) {
            $shiftStart = Carbon::parse($today . ' ' . $shift->start_time->format('H:i:s'), self::TZ);
            $shiftEnd   = Carbon::parse($today . ' ' . $shift->end_time->format('H:i:s'), self::TZ);
            $graceEnd   = $shiftStart->copy()->addMinutes($shift->grace_period_minutes);
            
            if ($now->gt($shiftEnd)) {
                $status = 'Requires Review';
                $approvalStatus = \App\Enum\ApprovalStatus::Pending;
                session()->flash('warning', "Notice: Your shift ended at " . $shift->end_time->format('H:i') . ". This check-in has been flagged for HR review.");
            } elseif ($now->gt($graceEnd)) {
                $lateMinutes = (int) $shiftStart->diffInMinutes($now);
                $status = 'Late';
            }
        }

        $maxNum  = Attendance::where('code', 'like', 'ATT-%')
            ->selectRaw('MAX(CAST(SUBSTRING(code, 5) AS UNSIGNED)) as max_num')
            ->value('max_num') ?? 0;
        $newCode = 'ATT-' . str_pad($maxNum + 1, 4, '0', STR_PAD_LEFT);

        Attendance::updateOrCreate(
            ['employee_id' => $this->employee->id, 'date' => $today],
            [
                'code'               => $newCode,
                'check_in'           => $now->format('H:i:s'),
                'check_in_latitude'  => $lat,
                'check_in_longitude' => $lng,
                'check_in_method'    => \App\Enum\AttendanceMethod::Manuel_Input->value,
                'shift_id'           => $shift?->id,
                'late_minutes'       => $lateMinutes,
                'daily_status'       => $status,
                'status'             => \App\Enum\AttendanceStatus::Entered,
                'approval_status'    => $approvalStatus,
                'notes'              => $this->notes,
                'created_by'         => Auth::id(),
            ]
        );

        $this->notes = '';
        $this->loadAttendanceData();
        session()->flash('success', 'Clocked in at ' . $now->format('H:i:s'));
    }

    public function clockOut($lat = null, $lng = null): void
    {
        if (!$this->todayAttendance?->check_in) {
            session()->flash('error', 'You need to clock in first.');
            return;
        }

        $now = $this->now();

        // Break validation: Must end break before clocking out
        if ($this->isOnBreak) {
            $this->endBreak();
        }

        // --- MASS CLOCK OUT: Close ALL open sessions ---
        $openSessions = Attendance::where('employee_id', $this->employee->id)
            ->whereNull('check_out')
            ->get();

        foreach ($openSessions as $session) {
            $checkInTime = $this->toCarbon($session->check_in, $session->date);
            
            // If it's the one we just processed or from today, calculate properly
            // If it's an old one, just close it.
            $sessionCo = $now;
            $sessionWorked = (int) $checkInTime->diffInMinutes($sessionCo) - (int) $this->todayBreakMinutes;
            $sessionOt = 0;

            $shift = $session->shift;
            if ($shift) {
                $shiftEnd = $this->toCarbon($shift->end_time, $session->date);
                if ($sessionCo->gt($shiftEnd)) {
                    $sessionOt = min(max(0, $sessionWorked), (int) $shiftEnd->diffInMinutes($sessionCo));
                }
            }

            $session->update([
                'check_out'           => $sessionCo->format('H:i:s'),
                'total_worked_minutes'=> max(0, $sessionWorked),
                'overtime_minutes'    => $sessionOt,
                'daily_status'        => $session->date->format('Y-m-d') === $now->format('Y-m-d') ? $session->daily_status : 'Requires Review',
                'notes'               => $this->notes ?: $session->notes,
                'updated_by'          => Auth::id(),
            ]);
        }

        $this->notes = '';
        $this->loadAttendanceData();
        session()->flash('success', 'Clocked out at ' . $now->format('H:i:s'));
    }

    public function startBreak(): void
    {
        if (!$this->isClockedIn || $this->isOnBreak) return;

        $now = $this->now();
        \App\Models\AttendanceBreak::create([
            'attendance_id' => $this->todayAttendance->id,
            'start_time'    => $now,
            'notes'         => 'Manual break',
            'code'          => 'BRK-' . uniqid(),
        ]);

        $this->loadAttendanceData();
        session()->flash('success', 'Break started at ' . $now->format('H:i:s'));
    }

    public function endBreak(): void
    {
        if (!$this->isOnBreak || !$this->activeBreak) return;

        $now = $this->now();
        $diff = (int) $this->toCarbon($this->activeBreak->start_time)->diffInMinutes($now);

        $this->activeBreak->update([
            'end_time'      => $now,
            'total_minutes' => $diff,
        ]);

        $this->loadAttendanceData();
        session()->flash('success', 'Break ended at ' . $now->format('H:i:s') . " ($diff min)");
    }
    public function formatMinutes($mins): string
    {
        if (!$mins || $mins <= 0) return '—';
        $h = floor($mins / 60);
        $m = $mins % 60;
        if ($h > 0) {
            return "{$h}h" . ($m > 0 ? " {$m}m" : "");
        }
        return "{$m}m";
    }
    /**
     * Calculate distance between two points in meters using Haversine formula.
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earthRadius = 6371000; // in meters
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c);
    }

    /**
     * Convert any time/datetime value to a Carbon in Africa/Kigali.
     * Handles: Carbon, "H:i:s", "Y-m-d H:i:s", or any parseable string.
     */
    private function toCarbon(mixed $value, mixed $dateContext = null): ?Carbon
    {
        if (!$value) return null;

        $dateStr = '';
        if ($dateContext) {
            $dateStr = ($dateContext instanceof Carbon) ? $dateContext->format('Y-m-d ') : $dateContext . ' ';
        }

        if ($value instanceof Carbon) {
            // If it's already a Carbon, and we have a date context, force the date part
            if ($dateContext) {
                $timePart = $value->format('H:i:s');
                return Carbon::parse($dateStr . $timePart, self::TZ);
            }
            return $value->copy()->setTimezone(self::TZ);
        }

        try {
            // If the value is just a time (H:i:s), and we have a date context, combine them
            $valStr = (string) $value;
            if ($dateContext && strlen($valStr) <= 8) {
                return Carbon::parse($dateStr . $valStr, self::TZ);
            }
            return Carbon::parse($valStr, self::TZ);
        } catch (\Exception) {
            return null;
        }
    }

    public function render()
    {
        return view('livewire.employee.employee-attendance')
            ->layout('components.layouts.employee');
    }
}