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
            $co = $this->todayAttendance->check_out 
                ? $this->toCarbon($this->todayAttendance->check_out, $this->todayAttendance->date) 
                : $now;
            
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