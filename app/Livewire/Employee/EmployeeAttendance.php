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
    public $todayMinutes  = 0;  // total minutes worked today

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
        $this->employee = Employee::where('user_id', $user->id)->first();

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

        // ── Today's record ──────────────────────────────────────────────────
        $this->todayAttendance = Attendance::where('employee_id', $this->employee->id)
            ->where('date', $today)
            ->first();

        // ── Minutes worked today ────────────────────────────────────────────
        // The DB stores check_in/check_out as full datetimes: "2026-03-31 00:19:28"
        // We use Carbon::parse() which handles any format reliably.
        $this->todayMinutes = 0;
        if ($this->todayAttendance?->check_in && $this->todayAttendance?->check_out) {
            try {
                $ci = $this->toCarbon($this->todayAttendance->check_in);
                $co = $this->toCarbon($this->todayAttendance->check_out);
                if ($ci && $co && $co->gt($ci)) {
                    $this->todayMinutes = (int) $ci->diffInMinutes($co);
                }
            } catch (\Exception $e) {
                \Log::error('todayMinutes error', ['err' => $e->getMessage()]);
            }
        }

        // ── Monthly stat counts ─────────────────────────────────────────────
        // Status is "Entered" (= employee showed up), not "present".
        // Count "present" OR "Entered" OR any record that has a check_in.
        $this->monthPresentCount = $this->attendances->filter(
            fn($a) => $a->check_in !== null
        )->count();

        $this->monthAbsentCount = $this->attendances->filter(
            fn($a) => strtolower($a->status?->value ?? '') === 'absent'
        )->count();

        $this->monthLateCount = $this->attendances->filter(
            fn($a) => strtolower($a->status?->value ?? '') === 'late'
        )->count();

        // ── Is clocked in? ──────────────────────────────────────────────────
        $this->isClockedIn = $this->todayAttendance
            && $this->todayAttendance->check_in
            && !$this->todayAttendance->check_out;
    }

    public function clockIn(): void
    {
        $now         = $this->now();
        $today       = $now->format('Y-m-d');
        $currentTime = $now->format('H:i:s');

        $existing = Attendance::where('employee_id', $this->employee->id)
            ->where('date', $today)
            ->first();

        if ($existing && $existing->check_in) {
            session()->flash('error', 'You have already clocked in today.');
            return;
        }

        $maxNum  = Attendance::where('code', 'like', 'ATT-%')
            ->selectRaw('MAX(CAST(SUBSTRING(code, 5) AS UNSIGNED)) as max_num')
            ->value('max_num') ?? 0;
        $newCode = 'ATT-' . str_pad($maxNum + 1, 4, '0', STR_PAD_LEFT);

        Attendance::updateOrCreate(
            ['employee_id' => $this->employee->id, 'date' => $today],
            [
                'code'            => $newCode,
                'check_in'        => $currentTime,
                'check_in_method' => \App\Enum\AttendanceMethod::Manuel_Input->value,
                'status'          => \App\Enum\AttendanceStatus::Entered,
                'approval_status' => \App\Enum\ApprovalStatus::NotApplicable,
                'notes'           => $this->notes,
                'created_by'      => Auth::id(),
                'device_id'       => null,
            ]
        );

        $this->notes = '';
        $this->loadAttendanceData();
        session()->flash('success', 'Clocked in at ' . $currentTime);
    }

    public function clockOut(): void
    {
        if (!$this->todayAttendance?->check_in) {
            session()->flash('error', 'You need to clock in first.');
            return;
        }

        $now         = $this->now();
        $currentTime = $now->format('H:i:s');

        // Prevent clock-out before clock-in
        $ci = $this->toCarbon($this->todayAttendance->check_in);
        $co = $this->toCarbon($currentTime);
        if ($ci && $co && $co->lt($ci)) {
            session()->flash('error', 'Clock-out time cannot be before clock-in time.');
            return;
        }

        $this->todayAttendance->update([
            'check_out'  => $currentTime,
            'notes'      => $this->notes ?: $this->todayAttendance->notes,
            'updated_by' => Auth::id(),
        ]);

        $this->notes = '';
        $this->loadAttendanceData();
        session()->flash('success', 'Clocked out at ' . $currentTime);
    }

    /**
     * Convert any time/datetime value to a Carbon in Africa/Kigali.
     * Handles: Carbon, "H:i:s", "Y-m-d H:i:s", or any parseable string.
     */
    private function toCarbon(mixed $value): ?Carbon
    {
        if (!$value) return null;

        if ($value instanceof Carbon) {
            return $value->copy()->setTimezone(self::TZ);
        }

        // Carbon::parse handles both "H:i:s" and "Y-m-d H:i:s" reliably
        try {
            return Carbon::parse((string) $value, self::TZ);
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