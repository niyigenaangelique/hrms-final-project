<?php

namespace App\Livewire\HR;

use App\Models\PayrollPeriod;
use App\Models\PayrollEntry;
use App\Models\Employee;
use App\Services\PayrollService;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Attributes\Title;

#[Title('TalentFlow Pro | Payroll Management')]
class PayrollManager extends Component
{
    use WithPagination;
    
    public $selectedPeriod = null;
    public $showCreateModal = false;
    public $showRunPayrollModal = false;
    public $showPreviewModal = false;
    public $showAnalytics = false;
    
    // Create period form
    public $periodName = '';
    public $startDate = '';
    public $endDate = '';
    
    // Analytics data
    public $analytics = [];
    
    protected $paginationTheme = 'bootstrap';
    
    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
        $this->periodName = now()->format('F Y');
    }
    
    public function render()
    {
        $periods = PayrollPeriod::orderBy('created_at', 'desc')->paginate(10);
        $recentEntries = [];
        
        if ($this->selectedPeriod) {
            $recentEntries = PayrollEntry::where('payroll_period_id', $this->selectedPeriod)
                ->with('employee')
                ->paginate(20);
        }
        
        return view('livewire.hr.payroll-manager', [
            'periods' => $periods,
            'recentEntries' => $recentEntries,
            'analytics' => $this->analytics,
        ])->layout('components.layouts.app');
    }
    
    public function createPayrollPeriod()
    {
        $this->validate([
            'periodName' => 'required|string|max:255',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate',
        ]);
        
        $payrollService = new PayrollService();
        $period = $payrollService->createPayrollPeriod(
            $this->periodName,
            Carbon::parse($this->startDate),
            Carbon::parse($this->endDate)
        );
        
        $this->dispatch('show-message', 'Payroll period created successfully!');
        $this->reset(['periodName', 'startDate', 'endDate', 'showCreateModal']);
    }
    
    public function runPayroll($periodId)
    {
        $period = PayrollPeriod::findOrFail($periodId);
        
        if ($period->status !== 'draft') {
            $this->dispatch('show-error', 'Payroll can only be run for draft periods');
            return;
        }
        
        try {
            $payrollService = new PayrollService();
            $results = $payrollService->runPayroll($period);
            
            $this->dispatch('show-message', "Payroll processed successfully! {$results['processed_employees']} employees processed.");
            $this->showRunPayrollModal = false;
            
        } catch (\Exception $e) {
            $this->dispatch('show-error', 'Error running payroll: ' . $e->getMessage());
        }
    }
    
    public function approvePayroll($periodId)
    {
        $period = PayrollPeriod::findOrFail($periodId);
        
        if ($period->status !== 'draft') {
            $this->dispatch('show-error', 'Only draft payrolls can be approved');
            return;
        }
        
        $period->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);
        
        $this->dispatch('show-message', 'Payroll approved successfully!');
    }
    
    public function lockPayroll($periodId)
    {
        $period = PayrollPeriod::findOrFail($periodId);
        
        try {
            $payrollService = new PayrollService();
            $payrollService->lockPayrollPeriod($period);
            
            $this->dispatch('show-message', 'Payroll locked successfully!');
            
        } catch (\Exception $e) {
            $this->dispatch('show-error', 'Error locking payroll: ' . $e->getMessage());
        }
    }
    
    public function deletePayroll($periodId)
    {
        $period = PayrollPeriod::findOrFail($periodId);
        
        if ($period->status === 'locked') {
            $this->dispatch('show-error', 'Locked payroll periods cannot be deleted');
            return;
        }
        
        $period->delete();
        $this->dispatch('show-message', 'Payroll period deleted successfully!');
    }
    
    public function generatePayslip($entryId)
    {
        $entry = PayrollEntry::with(['employee', 'payrollPeriod'])->findOrFail($entryId);
        
        // TODO: Generate PDF payslip
        $this->dispatch('show-message', 'Payslip generation feature coming soon!');
    }
    
    public function generateBankFile($periodId)
    {
        $period = PayrollPeriod::findOrFail($periodId);
        $entries = PayrollEntry::where('payroll_period_id', $periodId)->get();
        
        // TODO: Generate bank transfer file
        $this->dispatch('show-message', 'Bank file generation feature coming soon!');
    }
    
    public function loadAnalytics()
    {
        $payrollService = new PayrollService();
        $this->analytics = $payrollService->getPayrollAnalytics();
        $this->showAnalytics = true;
    }
    
    public function selectPeriod($periodId)
    {
        $this->selectedPeriod = $periodId;
        $this->resetPage();
    }
    
    public function getPayrollPeriodsProperty()
    {
        return PayrollPeriod::orderBy('created_at', 'desc')->get();
    }
    
    public function getRecentEntriesProperty()
    {
        if (!$this->selectedPeriod) {
            return collect();
        }
        
        return PayrollEntry::where('payroll_period_id', $this->selectedPeriod)
            ->with('employee')
            ->paginate(20);
    }
}
