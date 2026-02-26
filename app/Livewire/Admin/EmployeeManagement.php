<?php

namespace App\Livewire\Admin;

use App\Models\Employee;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class EmployeeManagement extends Component
{
    use WithPagination;

    // Search and Filters
    public $search = '';
    public $departmentFilter = '';
    public $statusFilter = '';

    // Employee Form
    public $showCreateEmployeeModal = false;
    public $showEditEmployeeModal = false;
    public $showDeleteEmployeeModal = false;
    public $selectedEmployeeId;
    public $selectedEmployee;

    // Form Fields
    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $department;
    public $position;
    public $employee_code;
    public $hire_date;
    public $salary;
    public $basic_salary;
    public $daily_rate;
    public $hourly_rate;
    public $salary_currency = 'RWF';
    public $payment_method = 'bank';
    public $bank_name;
    public $bank_account_number;
    public $bank_branch;
    public $mobile_money_provider;
    public $mobile_money_number;
    public $salary_effective_date;
    public $is_taxable = true;
    public $rssb_rate = 3.00;
    public $pension_rate = 5.00;
    public $user_id;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone_number' => 'required|string|max:20',
        'department' => 'required|string|max:255',
        'position' => 'required|string|max:255',
        'employee_code' => 'required|string|max:50|unique:employees,employee_code',
        'hire_date' => 'required|date',
        'basic_salary' => 'required|numeric|min:0',
        'salary_currency' => 'required|string|max:3',
        'payment_method' => 'required|in:bank,cash,mobile_money',
        'bank_name' => 'required_if:payment_method,bank|string|max:255',
        'bank_account_number' => 'required_if:payment_method,bank|string|max:50',
        'mobile_money_provider' => 'required_if:payment_method,mobile_money|string|max:255',
        'mobile_money_number' => 'required_if:payment_method,mobile_money|string|max:20',
        'rssb_rate' => 'required|numeric|min:0|max:100',
        'pension_rate' => 'required|numeric|min:0|max:100',
        'user_id' => 'nullable|exists:users,id',
    ];

    public function mount()
    {
        // Initialize with empty values
    }

    public function render()
    {
        $employees = $this->loadEmployees();

        return view('livewire.admin.employee-management', [
            'employees' => $employees,
            'users' => User::where('role', 'Employee')->get(),
            'banks' => \App\Models\Bank::orderBy('name')->get(),
        ])->layout('components.layouts.admin');
    }

    private function loadEmployees()
    {
        $query = Employee::with(['user', 'department', 'position'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('employee_code', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->departmentFilter) {
            $query->where('department', $this->departmentFilter);
        }

        return $query->paginate(10);
    }

    public function openCreateEmployeeModal()
    {
        $this->resetEmployeeForm();
        $this->showCreateEmployeeModal = true;
    }

    public function closeCreateEmployeeModal()
    {
        $this->showCreateEmployeeModal = false;
        $this->resetEmployeeForm();
    }

    public function openEditEmployeeModal($id)
    {
        $this->selectedEmployee = Employee::findOrFail($id);
        $this->selectedEmployeeId = $id;
        
        $this->first_name = $this->selectedEmployee->first_name;
        $this->last_name = $this->selectedEmployee->last_name;
        $this->email = $this->selectedEmployee->email;
        $this->phone_number = $this->selectedEmployee->phone_number;
        $this->department = $this->selectedEmployee->department;
        $this->position = $this->selectedEmployee->position;
        $this->employee_code = $this->selectedEmployee->employee_code;
        $this->hire_date = $this->selectedEmployee->hire_date?->format('Y-m-d');
        $this->basic_salary = $this->selectedEmployee->basic_salary;
        $this->daily_rate = $this->selectedEmployee->daily_rate;
        $this->hourly_rate = $this->selectedEmployee->hourly_rate;
        $this->salary_currency = $this->selectedEmployee->salary_currency;
        $this->payment_method = $this->selectedEmployee->payment_method;
        $this->bank_name = $this->selectedEmployee->bank_name;
        $this->bank_account_number = $this->selectedEmployee->bank_account_number;
        $this->bank_branch = $this->selectedEmployee->bank_branch;
        $this->mobile_money_provider = $this->selectedEmployee->mobile_money_provider;
        $this->mobile_money_number = $this->selectedEmployee->mobile_money_number;
        $this->salary_effective_date = $this->selectedEmployee->salary_effective_date?->format('Y-m-d');
        $this->is_taxable = $this->selectedEmployee->is_taxable;
        $this->rssb_rate = $this->selectedEmployee->rssb_rate ?? 3.00;
        $this->pension_rate = $this->selectedEmployee->pension_rate;
        $this->user_id = $this->selectedEmployee->user_id;
        
        $this->showEditEmployeeModal = true;
    }

    public function closeEditEmployeeModal()
    {
        $this->showEditEmployeeModal = false;
        $this->resetEmployeeForm();
    }

    public function openDeleteEmployeeModal($id)
    {
        $this->selectedEmployeeId = $id;
        $this->selectedEmployee = Employee::findOrFail($id);
        $this->showDeleteEmployeeModal = true;
    }

    public function closeDeleteEmployeeModal()
    {
        $this->showDeleteEmployeeModal = false;
        $this->selectedEmployeeId = null;
        $this->selectedEmployee = null;
    }

    public function resetEmployeeForm()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->phone_number = '';
        $this->department = '';
        $this->position = '';
        $this->employee_code = '';
        $this->hire_date = '';
        $this->basic_salary = '';
        $this->daily_rate = '';
        $this->hourly_rate = '';
        $this->salary_currency = 'RWF';
        $this->payment_method = 'bank';
        $this->bank_name = '';
        $this->bank_account_number = '';
        $this->bank_branch = '';
        $this->mobile_money_provider = '';
        $this->mobile_money_number = '';
        $this->salary_effective_date = '';
        $this->is_taxable = true;
        $this->rssb_rate = 3.00;
        $this->pension_rate = 5.00;
        $this->user_id = null;
        $this->selectedEmployeeId = null;
        $this->selectedEmployee = null;
        $this->showCreateEmployeeModal = false;
        $this->showEditEmployeeModal = false;
        $this->showDeleteEmployeeModal = false;
    }

    public function createEmployee()
    {
        $this->validate();

        // Calculate daily and hourly rates from basic salary
        $dailyRate = $this->basic_salary / 22; // 22 working days
        $hourlyRate = $dailyRate / 8; // 8 working hours

        $employee = Employee::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'department' => $this->department,
            'position' => $this->position,
            'employee_code' => $this->employee_code,
            'hire_date' => $this->hire_date,
            'basic_salary' => $this->basic_salary,
            'daily_rate' => $dailyRate,
            'hourly_rate' => $hourlyRate,
            'salary_currency' => $this->salary_currency,
            'payment_method' => $this->payment_method,
            'bank_name' => $this->bank_name,
            'bank_account_number' => $this->bank_account_number,
            'bank_branch' => $this->bank_branch,
            'mobile_money_provider' => $this->mobile_money_provider,
            'mobile_money_number' => $this->mobile_money_number,
            'salary_effective_date' => $this->salary_effective_date,
            'is_taxable' => $this->is_taxable,
            'rssb_rate' => $this->rssb_rate,
            'pension_rate' => $this->pension_rate,
            'user_id' => $this->user_id,
            'created_by' => auth()->id(),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'employee_created',
            'description' => "Created employee: {$employee->first_name} {$employee->last_name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->closeCreateEmployeeModal();
        session()->flash('success', 'Employee created successfully!');
    }

    public function updateEmployee()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'employee_code' => 'required|string|max:50|unique:employees,employee_code,'.$this->selectedEmployeeId,
            'hire_date' => 'required|date',
            'basic_salary' => 'required|numeric|min:0',
            'salary_currency' => 'required|string|max:3',
            'payment_method' => 'required|in:bank,cash,mobile_money',
            'bank_name' => 'required_if:payment_method,bank|string|max:255',
            'bank_account_number' => 'required_if:payment_method,bank|string|max:50',
            'mobile_money_provider' => 'required_if:payment_method,mobile_money|string|max:255',
            'mobile_money_number' => 'required_if:payment_method,mobile_money|string|max:20',
            'rssb_rate' => 'required|numeric|min:0|max:100',
            'pension_rate' => 'required|numeric|min:0|max:100',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // Calculate daily and hourly rates from basic salary
        $dailyRate = $this->basic_salary / 22; // 22 working days
        $hourlyRate = $dailyRate / 8; // 8 working hours

        $this->selectedEmployee->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'department' => $this->department,
            'position' => $this->position,
            'employee_code' => $this->employee_code,
            'hire_date' => $this->hire_date,
            'basic_salary' => $this->basic_salary,
            'daily_rate' => $dailyRate,
            'hourly_rate' => $hourlyRate,
            'salary_currency' => $this->salary_currency,
            'payment_method' => $this->payment_method,
            'bank_name' => $this->bank_name,
            'bank_account_number' => $this->bank_account_number,
            'bank_branch' => $this->bank_branch,
            'mobile_money_provider' => $this->mobile_money_provider,
            'mobile_money_number' => $this->mobile_money_number,
            'salary_effective_date' => $this->salary_effective_date,
            'is_taxable' => $this->is_taxable,
            'rssb_rate' => $this->rssb_rate,
            'pension_rate' => $this->pension_rate,
            'user_id' => $this->user_id,
            'updated_by' => auth()->id(),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'employee_updated',
            'description' => "Updated employee: {$this->selectedEmployee->first_name} {$this->selectedEmployee->last_name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->closeEditEmployeeModal();
        session()->flash('success', 'Employee updated successfully!');
    }

    public function deleteEmployee()
    {
        $employee = Employee::findOrFail($this->selectedEmployeeId);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'employee_deleted',
            'description' => "Deleted employee: {$employee->first_name} {$employee->last_name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $employee->delete();

        $this->closeDeleteEmployeeModal();
        session()->pass('success', 'Employee deleted successfully!');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedDepartmentFilter()
    {
        $this->resetPage();
    }
}
