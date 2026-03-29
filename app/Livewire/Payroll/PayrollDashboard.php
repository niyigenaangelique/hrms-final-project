<?php

namespace App\Livewire\Payroll;

use App\Models\Employee;
use App\Models\PayrollEntry;
use App\Models\PayrollMonth;
use App\Models\PayslipEntry;
use App\Models\PaymentHistory;
use App\Services\TaxService;
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

    public $showProcessModal     = false;
    public $showBulkProcessModal = false;
    public $processingEmployees  = [];
    public $processingMonth      = null;
    public $processingMonthId     = null;  // bound to select in blade
    public $processingStatus     = 'idle';
    public $processingProgress   = 0;
    public $processedCount       = 0;
    public $totalCount           = 0;

    // Tax settings — matches TaxCalculator defaults
    public $useRwandanTax = true;
    public $pensionRate   = 5;
    public $maternityRate = 1;
    public $cbhiRate      = 1;
    public $payeRate      = 30;

    public function mount()
    {
        $this->selectedMonth = now()->month;
        $this->selectedYear  = now()->year;
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $this->totalPayrollEntries = PayrollEntry::count();
        $this->totalPayrollAmount  = PayrollEntry::sum('total_amount');
        $this->totalEmployees      = Employee::where('approval_status', 'approved')->count();

        $this->pendingPayments   = PaymentHistory::where('status', 'pending')->count();
        $this->completedPayments = PaymentHistory::where('status', 'completed')->count();

        $this->currentMonthPayroll = PayrollEntry::whereHas('payrollMonth', function ($q) {
            $q->whereMonth('start_date', now()->month)
              ->whereYear('start_date', now()->year);
        })->sum('total_amount');

        $this->recentPayments = PaymentHistory::with(['employee', 'payslipEntry'])
            ->latest('payment_date')->take(10)->get();

        $this->payrollTrends    = $this->getPayrollTrends();
        $this->monthlyComparison = $this->getMonthlyComparison();
        $this->departmentStats  = $this->getDepartmentStats();
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
        $currentMonth  = $this->selectedMonth;
        $currentYear   = $this->selectedYear;
        $previousMonth = $currentMonth == 1 ? 12 : $currentMonth - 1;
        $previousYear  = $currentMonth == 1 ? $currentYear - 1 : $currentYear;

        $current = PayrollEntry::whereHas('payrollMonth', fn($q) =>
            $q->whereMonth('start_date', $currentMonth)->whereYear('start_date', $currentYear)
        )->sum('total_amount');

        $previous = PayrollEntry::whereHas('payrollMonth', fn($q) =>
            $q->whereMonth('start_date', $previousMonth)->whereYear('start_date', $previousYear)
        )->sum('total_amount');

        return [
            'current'  => $current,
            'previous' => $previous,
            'change'   => $previous > 0 ? round((($current - $previous) / $previous) * 100, 1) : 0,
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

    public function updatedSelectedMonth() { $this->loadDashboardData(); }
    public function updatedSelectedYear()  { $this->loadDashboardData(); }

    // ── Modal open/close ──────────────────────────────────────

    public function openProcessModal()
    {
        $this->showProcessModal    = true;
        $this->processingEmployees = [];
        $this->processingMonth     = null;
        $this->processingMonthId   = null;
        $this->processingStatus    = 'idle';
        $this->processingProgress  = 0;
        $this->processedCount      = 0;
        $this->totalCount          = 0;
    }

    public function closeProcessModal()
    {
        $this->showProcessModal    = false;
        $this->processingEmployees = [];
        $this->processingMonth     = null;
        $this->processingStatus    = 'idle';
        $this->processingProgress  = 0;
        $this->processedCount      = 0;
        $this->totalCount          = 0;
    }

    public function openBulkProcessModal()
    {
        $this->showBulkProcessModal = true;
        $this->processingEmployees  = [];
        $this->processingMonth      = null;
        $this->processingStatus     = 'idle';
        $this->processingProgress   = 0;
        $this->processedCount       = 0;
        $this->totalCount           = 0;
    }

    public function closeBulkProcessModal()
    {
        $this->showBulkProcessModal = false;
        $this->processingEmployees  = [];
        $this->processingMonth      = null;
        $this->processingStatus     = 'idle';
        $this->processingProgress   = 0;
        $this->processedCount       = 0;
        $this->totalCount           = 0;
    }

    // ── Process selected employees ────────────────────────────

    public function processPayroll()
    {
        if (!$this->processingMonthId) {
            session()->flash('error', 'Please select a payroll month.');
            return;
        }

        $payrollMonth = PayrollMonth::find($this->processingMonthId);

        if (!$payrollMonth) {
            session()->flash('error', 'Payroll month not found.');
            return;
        }

        // Collect selected employee IDs from checkbox array
        $selectedIds = collect($this->processingEmployees)
            ->filter(fn($checked) => $checked)
            ->keys()
            ->toArray();

        // Fall back to all approved employees if none ticked
        $employees = empty($selectedIds)
            ? Employee::where('approval_status', 'Approved')->whereNotNull('monthly_salary')->get()
            : Employee::whereIn('id', $selectedIds)->get();

        if ($employees->isEmpty()) {
            session()->flash('error', 'No employees to process.');
            return;
        }

        $this->processingStatus = 'processing';
        $this->totalCount       = $employees->count();
        $this->processedCount   = 0;

        $tax = app(TaxService::class);

        foreach ($employees as $employee) {
            $this->processOneEmployee($tax, $payrollMonth, $employee);
            $this->processedCount++;
            $this->processingProgress = (int)(($this->processedCount / $this->totalCount) * 100);
        }

        $this->processingStatus = 'completed';
        session()->flash('success', "Payroll processed for {$this->processedCount} employee(s) with tax calculations.");
        $this->loadDashboardData();
    }

    // ── Bulk process ALL approved employees ───────────────────

    public function bulkProcessAllEmployees()
    {
        if (!$this->processingMonthId) {
            session()->flash('error', 'Please select a payroll month.');
            return;
        }

        $payrollMonth = PayrollMonth::find($this->processingMonthId);

        if (!$payrollMonth) {
            session()->flash('error', 'Payroll month not found.');
            return;
        }

        $employees = Employee::where('approval_status', 'Approved')
            ->whereNotNull('monthly_salary')
            ->get();

        if ($employees->isEmpty()) {
            session()->flash('error', 'No approved employees with salary found.');
            return;
        }

        $this->processingStatus = 'processing';
        $this->totalCount       = $employees->count();
        $this->processedCount   = 0;

        $tax = app(TaxService::class);

        foreach ($employees as $employee) {
            $this->processOneEmployee($tax, $payrollMonth, $employee);
            $this->processedCount++;
            $this->processingProgress = (int)(($this->processedCount / $this->totalCount) * 100);
        }

        $this->processingStatus = 'completed';
        session()->flash('success', "Bulk payroll completed for {$this->processedCount} employee(s).");
        $this->loadDashboardData();
    }

    // ── Core: one employee — PayrollEntry + PayslipEntry ─────

    private function processOneEmployee(TaxService $tax, PayrollMonth $payrollMonth, Employee $employee): void
    {
        $grossSalary = (float)($employee->monthly_salary ?? 0);

        if ($grossSalary <= 0) {
            return; // skip employees with no salary
        }

        DB::transaction(function () use ($tax, $payrollMonth, $employee, $grossSalary) {

            // 1. Create or find the PayrollEntry
            $payrollEntry = PayrollEntry::firstOrCreate(
                [
                    'payroll_month_id' => $payrollMonth->id,
                    'employee_id'      => $employee->id,
                ],
                [
                    'code'                   => 'PE-' . strtoupper(substr(uniqid(), -6)),
                    'daily_rate'             => round($grossSalary / 22, 2),
                    'work_days'              => 22,
                    'work_days_pay'          => $grossSalary,
                    'overtime_hour_rate'     => 0,
                    'overtime_hours_worked'  => 0,
                    'overtime_total_amount'  => 0,
                    'total_amount'           => $grossSalary,
                    'approval_status'        => 'approved',
                    'created_by'             => auth()->id(),
                ]
            );

            // 2. Calculate taxes using TaxService (same logic as TaxCalculator)
            $result = $tax->calculate(
                grossSalary:   $grossSalary,
                pensionRate:   $this->pensionRate,
                maternityRate: $this->maternityRate,
                cbhiRate:      $this->cbhiRate,
                payeRate:      $this->payeRate,
                useRwandanTax: $this->useRwandanTax,
            );

            // 3. Save PayslipEntry — updateOrCreate so re-running is safe
            PayslipEntry::updateOrCreate(
                ['payroll_entry_id' => $payrollEntry->id],
                [
                    'code'                  => 'PS-' . strtoupper(substr(uniqid(), -6)),
                    'gross_pay'             => $result['gross_pay'],
                    'taxable_income'        => $result['taxable_income'],
                    'paye'                  => $result['paye'],
                    'pension'               => $result['pension'],
                    'maternity'             => $result['maternity'],
                    'cbhi'                  => $result['cbhi'],
                    'employer_contribution' => $result['employer_contribution'],
                    'net_pay'               => $result['net_pay'],
                    'effective_tax_rate'    => $result['effective_tax_rate'],
                    'tax_bracket_used'      => $result['tax_bracket_used'],
                    'status'                => 'Generated',
                    'created_by'            => auth()->id(),
                ]
            );
        });
    }

    // ── Generate payslips (kept for blade button compatibility) ─

    public function generatePayslips()
    {
        session()->flash('info', 'Use "Process Payroll" or "Bulk Process" to generate payslips with tax calculations.');
    }

    public function render()
    {
        return view('livewire.payroll.payroll-dashboard')
            ->layout('components.layouts.app');
    }
}
