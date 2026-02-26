<?php

namespace App\Livewire\Employee;

use App\Models\Attendance;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('TalentFlow Pro | My Attendance')]
class EmployeeAttendance extends Component
{
    public $employee;
    public $attendances;
    public $todayAttendance;
    public $clockInTime;
    public $clockOutTime;
    public $notes;
    public $isClockedIn = false;

    public function mount()
    {
        $user = Auth::user();
        $this->employee = Employee::where('user_id', $user->id)->first();
        
        if (!$this->employee) {
            // Get the highest existing employee code number
            $lastEmployee = Employee::orderBy('id', 'desc')->first();
            $lastCode = $lastEmployee ? intval(substr($lastEmployee->code, -4)) : 0;
            $newCode = 'EMP-' . str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);
            
            $this->employee = Employee::create([
                'code' => $newCode,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'user_id' => $user->id,
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
            ]);
        }

        $this->loadAttendanceData();
    }

    public function loadAttendanceData()
    {
        $today = now()->format('Y-m-d');
        
        $this->attendances = Attendance::where('employee_id', $this->employee->id)
            ->orderBy('date', 'desc')
            ->take(30)
            ->get();

        $this->todayAttendance = Attendance::where('employee_id', $this->employee->id)
            ->where('date', $today)
            ->first();

        $this->isClockedIn = $this->todayAttendance && 
                            $this->todayAttendance->check_in && 
                            !$this->todayAttendance->check_out;
    }

    public function clockIn()
    {
        $today = now()->format('Y-m-d');
        $currentTime = now()->format('H:i:s');

        // Check if already clocked in today
        $existing = Attendance::where('employee_id', $this->employee->id)
            ->where('date', $today)
            ->first();

        if ($existing && $existing->clock_in) {
            session()->flash('error', 'You have already clocked in today.');
            return;
        }

        // Generate unique attendance code
        $maxCode = Attendance::where('code', 'like', 'ATT-%')
            ->selectRaw('MAX(CAST(SUBSTRING(code, 5) AS UNSIGNED)) as max_num')
            ->value('max_num') ?? 0;
        $nextCode = 'ATT-' . str_pad($maxCode + 1, 4, '0', STR_PAD_LEFT);

        Attendance::updateOrCreate(
            [
                'employee_id' => $this->employee->id,
                'date' => $today,
            ],
            [
                'code' => $nextCode,
                'check_in' => $currentTime,
                'check_in_method' => \App\Enum\AttendanceMethod::Manuel_Input->value,
                'status' => \App\Enum\AttendanceStatus::Entered,
                'approval_status' => \App\Enum\ApprovalStatus::NotApplicable,
                'notes' => $this->notes,
                'created_by' => Auth::id(),
                'device_id' => null, // Set to null for manual entry
            ]
        );

        $this->notes = '';
        $this->loadAttendanceData();
        session()->flash('success', 'Clocked in successfully at ' . $currentTime);
    }

    public function clockOut()
    {
        if (!$this->todayAttendance || !$this->todayAttendance->check_in) {
            session()->flash('error', 'You need to clock in first.');
            return;
        }

        $currentTime = now()->format('H:i:s');

        $this->todayAttendance->update([
            'check_out' => $currentTime,
            'notes' => $this->notes,
            'updated_by' => Auth::id(),
        ]);

        $this->notes = '';
        $this->loadAttendanceData();
        session()->flash('success', 'Clocked out successfully at ' . $currentTime);
    }

    public function render()
    {
        return view('livewire.employee.employee-attendance')
            ->layout('components.layouts.employee');
    }
}
