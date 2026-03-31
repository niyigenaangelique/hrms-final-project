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
    public $isClockedIn = false;

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
        $monthStart = $this->now()->startOfMonth()->format('Y-m-d');

        // Load all attendance records for the current month
        $this->attendances = Attendance::where('employee_id', $this->employee->id)
            ->where('date', '>=', $monthStart)
            ->orderBy('date', 'desc')
            ->get();

        $this->todayAttendance = Attendance::where('employee_id', $this->employee->id)
            ->where('date', $today)
            ->first();

        // Calculate today's hours worked (stored as total minutes for precision)
        $this->todayHours = 0;
        
        // Simple debugging - write to a separate log file
        $debugInfo = [
            'has_attendance' => $this->todayAttendance ? 'yes' : 'no',
            'attendance_id' => $this->todayAttendance?->id,
            'check_in' => $this->todayAttendance?->check_in,
            'check_out' => $this->todayAttendance?->check_out,
            'check_in_type' => gettype($this->todayAttendance?->check_in),
            'check_out_type' => gettype($this->todayAttendance?->check_out),
        ];
        
        // Write to a simple debug file
        file_put_contents(storage_path('debug_attendance.log'), 
            date('Y-m-d H:i:s') . " - " . json_encode($debugInfo) . "\n", 
            FILE_APPEND
        );
        
        if ($this->todayAttendance && $this->todayAttendance->check_in) {
            try {
                $ci = $this->todayAttendance->check_in;
                $co = $this->todayAttendance->check_out;

                // Simple string handling for check-in
                if (is_string($ci)) {
                    $checkIn = Carbon::createFromFormat('H:i:s', $ci, self::TZ);
                } elseif ($ci instanceof Carbon) {
                    $checkIn = $ci->copy()->setTimezone(self::TZ);
                } else {
                    throw new \Exception('Invalid check_in type: ' . gettype($ci));
                }

                if ($co) {
                    // Has check-out - calculate full hours
                    if (is_string($co)) {
                        $checkOut = Carbon::createFromFormat('H:i:s', $co, self::TZ);
                    } elseif ($co instanceof Carbon) {
                        $checkOut = $co->copy()->setTimezone(self::TZ);
                    } else {
                        throw new \Exception('Invalid check_out type: ' . gettype($co));
                    }

                    $minutes = $checkIn->diffInMinutes($checkOut, false);
                    $this->todayHours = max(0, $minutes);
                    
                    file_put_contents(storage_path('debug_attendance.log'), 
                        date('Y-m-d H:i:s') . " - Full hours: {$minutes} minutes\n", 
                        FILE_APPEND
                    );
                } else {
                    // Only check-in - calculate hours worked so far
                    $now = Carbon::now(self::TZ);
                    $minutes = $checkIn->diffInMinutes($now, false);
                    $this->todayHours = max(0, $minutes);
                    
                    file_put_contents(storage_path('debug_attendance.log'), 
                        date('Y-m-d H:i:s') . " - Partial hours: {$minutes} minutes\n", 
                        FILE_APPEND
                    );
                }
            } catch (\Exception $e) {
                file_put_contents(storage_path('debug_attendance.log'), 
                    date('Y-m-d H:i:s') . " - ERROR: " . $e->getMessage() . "\n", 
                    FILE_APPEND
                );
                $this->todayHours = 0;
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
            $checkIn = Carbon::createFromFormat('H:i:s', $this->todayAttendance->check_in, self::TZ);
            $checkOut = Carbon::createFromFormat('H:i:s', $currentTime, self::TZ);

            if ($checkOut->lt($checkIn)) {
                session()->flash('error', 'Clock-out time cannot be before clock-in time.');
                return;
            }
        } catch (\Exception $e) {
            \Log::error('Attendance time parse error', ['error' => $e->getMessage()]);
            // Continue anyway — don't block the employee
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

    public function render()
    {
        return view('livewire.employee.employee-attendance')
            ->layout('components.layouts.employee');
    }
}