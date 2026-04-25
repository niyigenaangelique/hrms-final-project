<?php

namespace App\Console\Commands;

use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveBalance;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitializeLeaveBalances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initialize-leave-balances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize leave balances for all employees across all leave types';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Initializing leave balances for all employees...');
        
        $currentYear = now()->year;
        $employees = Employee::all();
        $leaveTypes = LeaveType::where('is_active', true)->get();
        
        $createdCount = 0;
        $updatedCount = 0;
        
        foreach ($employees as $employee) {
            $this->info("Processing employee: {$employee->first_name} {$employee->last_name} ({$employee->code})");
            
            foreach ($leaveTypes as $leaveType) {
                // Check if employee is eligible for this leave type
                $isEligible = true;
                if ($leaveType->gender_restriction) {
                    if ($leaveType->gender_restriction === 'male' && strtolower($employee->gender) !== 'male') {
                        $isEligible = false;
                    }
                    if ($leaveType->gender_restriction === 'female' && strtolower($employee->gender) !== 'female') {
                        $isEligible = false;
                    }
                }
                
                // Check if balance already exists
                $existingBalance = LeaveBalance::where('employee_id', $employee->id)
                    ->where('leave_type_id', $leaveType->id)
                    ->where('year', $currentYear)
                    ->first();
                
                if (!$existingBalance && $isEligible) {
                    // Create new balance
                    LeaveBalance::create([
                        'code' => 'LB-' . $employee->code . '-' . $leaveType->code . '-' . $currentYear,
                        'employee_id' => $employee->id,
                        'leave_type_id' => $leaveType->id,
                        'total_days' => $leaveType->default_days ?? 0,
                        'used_days' => 0,
                        'balance_days' => $leaveType->default_days ?? 0,
                        'carried_forward_days' => 0,
                        'year' => $currentYear,
                        'created_by' => 1, // System user
                    ]);
                    
                    $createdCount++;
                    $this->line("  Created balance for {$leaveType->name}");
                } elseif ($existingBalance) {
                    $updatedCount++;
                    $this->line("  Balance already exists for {$leaveType->name}");
                } else {
                    $this->line("  Skipped {$leaveType->name} (not eligible)");
                }
            }
            
            $this->newLine();
        }
        
        $this->info("Leave balance initialization complete!");
        $this->info("Created: {$createdCount} new balances");
        $this->info("Found: {$updatedCount} existing balances");
        
        return Command::SUCCESS;
    }
}
