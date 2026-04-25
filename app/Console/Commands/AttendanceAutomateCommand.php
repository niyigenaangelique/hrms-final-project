<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AttendanceAutomateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:automate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process absences and auto-checkout forgotten sessions.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting attendance automation...');
        $yesterday = \Carbon\Carbon::yesterday('Africa/Kigali')->format('Y-m-d');
        
        $this->processLeaveStatus($yesterday);
        $this->processAbsences($yesterday);
        $this->processAutoCheckouts($yesterday);

        $this->info('Attendance automation completed.');
    }

    private function processLeaveStatus($date)
    {
        $this->info("Checking for employees on leave on $date...");
        
        $employeesOnLeave = \App\Models\Employee::where('is_active', true)
            ->whereHas('leaveRequests', function ($q) use ($date) {
                $q->where('status', 'approved')
                  ->whereDate('start_date', '<=', $date)
                  ->whereDate('end_date', '>=', $date);
            })
            ->whereDoesntHave('attendances', function ($q) use ($date) {
                $q->where('date', $date);
            })
            ->get();

        foreach ($employeesOnLeave as $emp) {
            \App\Models\Attendance::create([
                'employee_id' => $emp->id,
                'date'        => $date,
                'daily_status'=> 'On Leave',
                'status'      => \App\Enum\AttendanceStatus::Entered,
                'notes'       => 'System auto-marked: On Approved Leave',
                'code'        => 'ATT-LEA-' . $emp->code . '-' . str_replace('-', '', $date),
            ]);
        }

        $this->info($employeesOnLeave->count() . ' employees marked as On Leave.');
    }

    private function processAbsences($date)
    {
        $this->info("Checking absences for $date...");
        
        $employees = \App\Models\Employee::where('is_active', true)
            ->whereDoesntHave('attendances', function ($q) use ($date) {
                $q->where('date', $date);
            })
            ->whereDoesntHave('leaveRequests', function ($q) use ($date) {
                $q->where('status', 'approved')
                  ->whereDate('start_date', '<=', $date)
                  ->whereDate('end_date', '>=', $date);
            })
            ->get();

        foreach ($employees as $emp) {
            \App\Models\Attendance::create([
                'employee_id' => $emp->id,
                'date'        => $date,
                'daily_status'=> 'Absent',
                'status'      => \App\Enum\AttendanceStatus::Entered,
                'notes'       => 'System auto-marked: Absent (No clock-in detected)',
                'code'        => 'ATT-ABS-' . $emp->code . '-' . str_replace('-', '', $date),
            ]);
        }

        $this->info($employees->count() . ' employees marked as Absent.');
    }

    private function processAutoCheckouts($date)
    {
        $this->info("Checking for forgotten check-outs on $date...");

        $attendances = \App\Models\Attendance::with(['employee.shift'])
            ->where('date', $date)
            ->whereNotNull('check_in')
            ->whereNull('check_out')
            ->get();

        foreach ($attendances as $att) {
            $shift = $att->employee->shift;
            $checkoutTime = $shift ? $shift->end_time->format('H:i:s') : '17:00:00';
            
            // Calculate worked minutes up to shift end
            $ci = \Carbon\Carbon::parse($date . ' ' . $att->check_in, 'Africa/Kigali');
            $co = \Carbon\Carbon::parse($date . ' ' . $checkoutTime, 'Africa/Kigali');
            
            $breaks = \App\Models\AttendanceBreak::where('attendance_id', $att->id)->get();
            $totalBreak = $breaks->sum('total_minutes');

            $worked = (int) $ci->diffInMinutes($co) - (int) $totalBreak;

            $att->update([
                'check_out'           => $checkoutTime,
                'total_worked_minutes'=> max(0, $worked),
                'total_break_minutes' => $totalBreak,
                'notes'               => ($att->notes ? $att->notes . "\n" : "") . "System auto-checkout: Forgot to clock out.",
                'daily_status'        => 'Requires Review',
            ]);
        }

        $this->info($attendances->count() . ' sessions auto-checked out.');
    }
}
