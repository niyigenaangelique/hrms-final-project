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
    public $attendances;
    public $todayAttendance;
    public $notes;
    public $isClockedIn  = false;
    public $todayMinutes = 0;   // total minutes worked today (passed to blade)

    // Africa/Kigali = UTC+2
    private const TZ = 'Africa/Kigali';

    /**
     * Return "now" in the local timezone (Africa/Kigali).
     */
    private function now(): Carbon
    {
        return Carbon::now(self::TZ);
    }

    public function mount()
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
        $today = $this->now()->format('Y-m-d');

        $this->attendances = Attendance::where('employee_id', $this->employee->id)
            ->orderBy('date', 'desc')
            ->take(30)
            ->get();

        $this->todayAttendance = Attendance::where('employee_id', $this->employee->id)
            ->where('date', $today)
            ->first();

        // Calculate today's minutes worked
        $this->todayMinutes = 0;
        if ($this->todayAttendance?->check_in && $this->todayAttendance?->check_out) {
            try {
                $checkIn  = $this->parseTimeValue($this->todayAttendance->check_in);
                $checkOut = $this->parseTimeValue($this->todayAttendance->check_out);

                if ($checkIn && $checkOut) {
                    $diff = $checkIn->diffInMinutes($checkOut, false); // false = signed
                    $this->todayMinutes = max(0, (int) $diff);
                }
            } catch (\Exception $e) {
                \Log::error('todayMinutes calculation failed', ['error' => $e->getMessage()]);
                $this->todayMinutes = 0;
            }
        }

        // Clocked in = has check_in AND no check_out yet
        $this->isClockedIn = $this->todayAttendance
            && $this->todayAttendance->check_in
            && !$this->todayAttendance->check_out;
    }

    public function clockIn(): void
    {
        $now         = $this->now();
        $today       = $now->format('Y-m-d');
        $currentTime = $now->format('H:i:s');

        // Already clocked in today?
        $existing = Attendance::where('employee_id', $this->employee->id)
            ->where('date', $today)
            ->first();

        if ($existing && $existing->check_in) {
            session()->flash('error', 'You have already clocked in today.');
            return;
        }

        // Generate unique code
        $maxNum  = Attendance::where('code', 'like', 'ATT-%')
            ->selectRaw('MAX(CAST(SUBSTRING(code, 5) AS UNSIGNED)) as max_num')
            ->value('max_num') ?? 0;
        $newCode = 'ATT-' . str_pad($maxNum + 1, 4, '0', STR_PAD_LEFT);

        Attendance::updateOrCreate(
            [
                'employee_id' => $this->employee->id,
                'date'        => $today,
            ],
            [
                'code'             => $newCode,
                'check_in'         => $currentTime,
                'check_in_method'  => \App\Enum\AttendanceMethod::Manuel_Input->value,
                'status'           => \App\Enum\AttendanceStatus::Entered,
                'approval_status'  => \App\Enum\ApprovalStatus::NotApplicable,
                'notes'            => $this->notes,
                'created_by'       => Auth::id(),
                'device_id'        => null,
            ]
        );

        $this->notes = '';
        $this->loadAttendanceData();
        session()->flash('success', 'Clocked in at ' . $currentTime);
    }

    public function clockOut(): void
    {
        if (!$this->todayAttendance || !$this->todayAttendance->check_in) {
            session()->flash('error', 'You need to clock in first.');
            return;
        }

        $now         = $this->now();
        $currentTime = $now->format('H:i:s');

        // Parse stored check_in in the same timezone
        try {
            $checkIn  = $this->parseTimeValue($this->todayAttendance->check_in);
            $checkOut = $this->parseTimeValue($currentTime);

            if ($checkIn && $checkOut && $checkOut->lt($checkIn)) {
                session()->flash('error', 'Clock-out time cannot be before clock-in time.');
                return;
            }
        } catch (\Exception $e) {
            \Log::error('Attendance time parse error', ['error' => $e->getMessage()]);
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
     * Parse a time value into a Carbon instance in Africa/Kigali.
     * Handles: Carbon objects, "H:i:s" strings, "Y-m-d H:i:s" strings.
     */
    private function parseTimeValue(mixed $value): ?Carbon
    {
        if (!$value) return null;

        // Already a Carbon — just normalise timezone
        if ($value instanceof Carbon) {
            return $value->copy()->setTimezone(self::TZ);
        }

        $str = (string) $value;

        // Try formats from most to least specific
        $formats = ['H:i:s', 'H:i', 'Y-m-d H:i:s', 'Y-m-d H:i'];
        foreach ($formats as $fmt) {
            try {
                $c = Carbon::createFromFormat($fmt, $str, self::TZ);
                if ($c !== false) return $c;
            } catch (\Exception) {
                // try next format
            }
        }

        // Last resort — flexible parse
        try {
            return Carbon::parse($str, self::TZ);
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