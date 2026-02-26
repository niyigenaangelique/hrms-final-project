<?php

namespace App\Livewire\Payroll;

use App\Models\PayrollEntry;
use App\Models\PayrollMonth;
use App\Models\PayslipEntry;
use App\Models\PaymentHistory;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Title;
use Carbon\Carbon;

#[Title('TalentFlow Pro | HR Payroll Dashboard')]
class PayrollDashboard extends Component
{
    public $totalPayrollEntries;
    public $totalPayrollAmount;
    public $totalEmployees;
    public $pendingPayments;
    public $completedPayments;
    public $currentMonthPayroll;
    public $recentPayments;
    public $payrollTrends;
    public $monthlyComparison;
    public $departmentStats;
    public $upcomingPayrolls;
    public $selectedMonth;
    public $selectedYear;
    public $showProcessModal = false;
    public $showBulkProcessModal = false;
    public $processingEmployees = [];
    public $processingMonth;
    public $processingStatus = 'idle';
    public $processingProgress = 0;
    public $processedCount = 0;
    public $totalCount = 0;

    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear = now()->year;
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $this->totalPayrollEntries = PayrollEntry::count();
        $this->totalPayrollAmount = PayrollEntry::sum('total_amount');
        $this->totalEmployees = Employee::where('approval_status', 'approved')->count();
        
        $this->pendingPayments = PaymentHistory::where('status', 'pending')->count();
        $this->completedPayments = PaymentHistory::where('status', 'completed')->count();
        
        $this->currentMonthPayroll = PayrollEntry::whereHas('payrollMonth', function($query) {
            $query->whereMonth('start_date', now()->month)
                  ->whereYear('start_date', now()->year);
        })->sum('total_amount');
        
        $this->recentPayments = PaymentHistory::with(['employee', 'payslipEntry'])
            ->latest('payment_date')
            ->take(10)
            ->get();
            
        $this->payrollTrends = $this->getPayrollTrends();
        $this->monthlyComparison = $this->getMonthlyComparison();
        $this->departmentStats = $this->getDepartmentStats();
        $this->upcomingPayrolls = $this->getUpcomingPayrolls();
    }

    private function getPayrollTrends()
    {
        return PayrollEntry::selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, SUM(total_amount) as total, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('MONTH(created_at), YEAR(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();
    }

    private function getMonthlyComparison()
    {
        $currentMonth = $this->selectedMonth;
        $currentYear = $this->selectedYear;
        $previousMonth = $currentMonth == 1 ? 12 : $currentMonth - 1;
        $previousYear = $currentMonth == 1 ? $currentYear - 1 : $currentYear;

        $currentMonthTotal = PayrollEntry::whereHas('payrollMonth', function($query) use ($currentMonth, $currentYear) {
            $query->whereMonth('start_date', $currentMonth)->whereYear('start_date', $currentYear);
        })->sum('total_amount');

        $previousMonthTotal = PayrollEntry::whereHas('payrollMonth', function($query) use ($previousMonth, $previousYear) {
            $query->whereMonth('start_date', $previousMonth)->whereYear('start_date', $previousYear);
        })->sum('total_amount');

        return [
            'current' => $currentMonthTotal,
            'previous' => $previousMonthTotal,
            'change' => $previousMonthTotal > 0 ? (($currentMonthTotal - $previousMonthTotal) / $previousMonthTotal) * 100 : 0
        ];
    }

    private function getDepartmentStats()
    {
        return Employee::where('approval_status', 'approved')
            ->selectRaw('COUNT(*) as employee_count, "All Departments" as department')
            ->first();
    }

    private function getUpcomingPayrolls()
    {
        return PayrollMonth::with('payrollEntries.employee')
            ->where('start_date', '>', now())
            ->orderBy('start_date')
            ->take(5)
            ->get();
    }

    public function updatedSelectedMonth()
    {
        $this->loadDashboardData();
    }

    public function updatedSelectedYear()
    {
        $this->loadDashboardData();
    }

    public function openProcessModal()
    {
        $this->showProcessModal = true;
        $this->processingEmployees = [];
        $this->processingMonth = null;
        $this->processingStatus = 'idle';
        $this->processingProgress = 0;
        $this->processedCount = 0;
        $this->totalCount = 0;
    }

    public function openBulkProcessModal()
    {
        $this->showBulkProcessModal = true;
        $this->processingEmployees = [];
        $this->processingMonth = null;
        $this->processingStatus = 'idle';
        $this->processingProgress = 0;
        $this->processedCount = 0;
        $this->totalCount = 0;
    }

    public function selectProcessingMonth($monthId)
    {
        $this->processingMonth = PayrollMonth::find($monthId);
        $this->processingEmployees = [];
        $this->processedCount = 0;
        $this->totalCount = 0;
    }

    public function selectEmployees($employeeIds)
    {
        $this->processingEmployees = Employee::whereIn('id', $employeeIds)->get();
        $this->processedCount = 0;
        $this->totalCount = count($this->processingEmployees);
    }
    
    public function processPayroll()
    {
        if (!$this->processingMonth) {
            session()->flash('error', 'Please select a payroll month.');
            return;
        }

        // Get selected employees or all approved employees if none selected
        $employeesToProcess = [];
        if (!empty($this->processingEmployees)) {
            foreach ($this->processingEmployees as $employeeId => $isSelected) {
                if ($isSelected) {
                    $employeesToProcess[] = Employee::find($employeeId);
                }
            }
        }
        
        if (empty($employeesToProcess)) {
            session()->flash('error', 'Please select at least one employee to process.');
            return;
        }

        $this->processingStatus = 'processing';
        $this->processedCount = 0;
        $this->totalCount = count($employeesToProcess);

        foreach ($employeesToProcess as $employee) {
            if (!$employee) continue;
            
            // Check if entry already exists
            $existingEntry = PayrollEntry::where('payroll_month_id', $this->processingMonth->id)
                ->where('employee_id', $employee->id)
                ->first();
                
            if (!$existingEntry) {
                // Create new payroll entry
                $dailyRate = $employee->daily_rate ?? $employee->calculateDailyRate();
                PayrollEntry::create([
                    'code' => 'PE-' . strtoupper(uniqid()),
                    'payroll_month_id' => $this->processingMonth->id,
                    'employee_id' => $employee->id,
                    'daily_rate' => $dailyRate,
                    'work_days' => 22,
                    'work_days_pay' => $dailyRate * 22,
                    'overtime_hour_rate' => $employee->hourly_rate ?? $employee->calculateHourlyRate() * 1.50,
                    'overtime_hours_worked' => 0,
                    'overtime_total_amount' => 0,
                    'total_amount' => $dailyRate * 22,
                    'status' => 'entered',
                    'created_by' => auth()->id(),
                ]);
            }
            
            $this->processedCount++;
            $this->processingProgress = ($this->processedCount / $this->totalCount) * 100;
            
            // Small delay to show progress
            usleep(100000); // 0.1 second delay
        }

        $this->processingStatus = 'completed';
        session()->flash('success', 'Payroll processed successfully for ' . $this->processedCount . ' employees!');
        $this->loadDashboardData();
    }

    public function bulkProcessAllEmployees()
    {
        if (!$this->processingMonth) {
            session()->flash('error', 'Please select a payroll month to process.');
            return;
        }

        $this->processingStatus = 'processing';
        $allEmployees = Employee::where('approval_status', 'approved')->get();
        $this->processingEmployees = $allEmployees;
        $this->processedCount = 0;
        $this->totalCount = $allEmployees->count();

        foreach ($allEmployees as $employee) {
            // Check if entry already exists
            $existingEntry = PayrollEntry::where('payroll_month_id', $this->processingMonth->id)
                ->where('employee_id', $employee->id)
                ->first();
                
            if (!$existingEntry) {
                // Create new payroll entry
                $dailyRate = $employee->daily_rate ?? $employee->calculateDailyRate();
                PayrollEntry::create([
                    'code' => 'PE-' . strtoupper(uniqid()),
                    'payroll_month_id' => $this->processingMonth->id,
                    'employee_id' => $employee->id,
                    'daily_rate' => $dailyRate,
                    'work_days' => 22,
                    'work_days_pay' => $dailyRate * 22,
                    'overtime_hour_rate' => $employee->hourly_rate ?? $employee->calculateHourlyRate() * 1.50,
                    'overtime_hours_worked' => 0,
                    'overtime_total_amount' => 0,
                    'total_amount' => $dailyRate * 22,
                    'status' => 'entered',
                    'created_by' => auth()->id(),
                ]);
            }
            
            $this->processedCount++;
            $this->processingProgress = ($this->processedCount / $this->totalCount) * 100;
            
            // Small delay to show progress
            usleep(50000); // 0.05 second delay
        }

        $this->processingStatus = 'completed';
        session()->flash('success', 'Bulk payroll processing completed! Processed ' . $this->processedCount . ' employees.');
        $this->loadDashboardData();
    }

    public function generatePayslips()
    {
        if (!$this->processingMonth) {
            session()->flash('error', 'Please select a payroll month first.');
            return;
        }

        $entries = PayrollEntry::where('payroll_month_id', $this->processingMonth->id)->get();
        $generatedCount = 0;

        foreach ($entries as $entry) {
            // Calculate deductions
            $grossPay = $entry->total_amount;
            $paye = $this->calculatePAYE($grossPay);
            $pension = $grossPay * 0.05;
            $rssb = $grossPay * 0.03; // RSSB contribution
            $employerContribution = $grossPay * 0.07;
            $netPay = $grossPay - $paye - $pension - $rssb;

            // Create or update payslip entry
            PayslipEntry::updateOrCreate(
                ['payroll_entry_id' => $entry->id],
                [
                    'code' => 'PS-' . strtoupper(uniqid()),
                    'gross_pay' => $grossPay,
                    'paye' => $paye,
                    'pension' => $pension,
                    'rssb' => $rssb,
                    'employer_contribution' => $employerContribution,
                    'net_pay' => $netPay,
                    'status' => 'generated',
                    'created_by' => auth()->id(),
                ]
            );
            $generatedCount++;
        }

        session()->flash('success', 'Generated ' . $generatedCount . ' payslips successfully!');
    }

    private function calculatePAYE($grossPay)
    {
        // Simplified Rwandan PAYE calculation
        if ($grossPay <= 30000) {
            return 0;
        } elseif ($grossPay <= 100000) {
            return ($grossPay - 30000) * 0.20;
        } elseif ($grossPay <= 500000) {
            return 14000 + (($grossPay - 100000) * 0.25);
        } elseif ($grossPay <= 1000000) {
            return 114000 + (($grossPay - 500000) * 0.30);
        } else {
            return 264000 + (($grossPay - 1000000) * 0.35);
        }
    }

    public function render()
    {
        return view('livewire.payroll.payroll-dashboard')
            ->layout('components.layouts.app');
    }
}
