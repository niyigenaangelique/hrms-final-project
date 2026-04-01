<?php

namespace App\Livewire\HR;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Enum\ApprovalStatus;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

#[Title('TalentFlow Pro | Employees')]
class EmployeeManager extends Component
{
    use WithPagination, WithFileUploads;

    // ── List / search ──────────────────────────────────────
    public string $search       = '';
    public string $filterDept   = '';
    public string $filterStatus = '';
    public int    $perPage      = 15;

    // ── Modal state ────────────────────────────────────────
    public bool   $showModal    = false;
    public bool   $showView     = false;
    public bool   $showDelete   = false;
    public ?string $editingId    = null;
    public ?string $deletingId   = null;
    public ?Employee $viewEmployee = null;

    // ── Active form tab ────────────────────────────────────
    public string $activeTab = 'personal';

    // ══ PERSONAL INFORMATION ════════════════════════════════
    public string $code         = '';
    public string $firstName    = '';
    public string $middleName   = '';
    public string $lastName     = '';
    public string $gender       = '';
    public string $birthDate    = '';
    public string $nationality  = '';
    public string $nationalId   = '';
    public string $passportNumber = '';
    public string $rssNumber    = '';
    public string $joinDate     = '';
    public string $phone        = '';
    public string $email        = '';
    public string $city         = '';
    public string $state        = '';
    public string $country      = '';
    public string $address      = '';

    // ══ SALARY INFORMATION ══════════════════════════════════
    public string $basicSalary        = '';
    public string $currency           = 'RWF';
    public string $paymentMethod      = 'bank_transfer';
    public string $bankName           = '';
    public string $accountNumber      = '';
    public string $bankBranch         = '';
    public string $mobileMoneyProvider = '';
    public string $mobileMoneyNumber  = '';
    public string $salaryEffectiveDate = '';
    public string $rssbRate           = '5';
    public string $pensionRate        = '3';
    public bool   $subjectToPaye      = true;

    // Department & Position (from related models if you have them)
    public string $departmentId = '';
    public string $positionId   = '';

    // ── Helpers ────────────────────────────────────────────
    public array  $departments  = [];
    public array  $positions    = [];

    // ── Bank list ──────────────────────────────────────────
    public const BANKS = [
        'AB BANK RWANDA PLC (SGA-00001)',
        'ACCESS BANK (RWANDA) PLC (SGA-00002)',
        'Bank of Kigali (BKIR)',
        'BANK OF KIGALI PLC (SGA-00003)',
        'BPR BANK RWANDA PLC (SGA-00006)',
        'Cogebanque (COGEBANK)',
        'Commercial Bank of Rwanda (BCR)',
        'DEVELOPMENT BANK OF RWANDA (SGA-00007)',
        'ECOBANK RWANDA (SGA-00008)',
        'EQUITY BANK RWANDA PLC (SGA-00009)',
        'GUARANTY TRUST BANK (RWANDA) PLC (SGA-00010)',
        'I AND M BANK (RWANDA) PLC (SGA-00011)',
        'NCBA BANK RWANDA PLC (SGA-00012)',
        'Zigama CSS (SGA-00013)',
    ];

    // ── Validation rules ───────────────────────────────────
    protected function rules(): array
    {
        $empId = $this->editingId;
        
        // Debug: Log what we're working with
        Log::info('VALIDATION DEBUG - editingId: ' . ($empId ?? 'null'));
        if ($empId) {
            Log::info('VALIDATION DEBUG - Employee exists: ' . (Employee::find($empId) ? 'yes' : 'no'));
        }

        return [
            // Personal
            'firstName'    => 'required|string|max:100',
            'middleName'   => 'nullable|string|max:100',
            'lastName'     => 'required|string|max:100',
            'gender'       => 'required|in:male,female,other',
            'birthDate'    => 'nullable|date|before:today',
            'nationality'  => 'nullable|string|max:100',
            'nationalId'   => ['nullable', 'string', 'max:50',
                Rule::unique('employees', 'national_id')->ignore($empId)],
            'passportNumber' => 'nullable|string|max:50',
            'rssNumber'    => 'nullable|string|max:50',
            'joinDate'     => 'nullable|date',
            'phone'        => 'nullable|string|max:30',
            'email'        => [
                'required', 
                'email', 
                'max:200',
                function ($attribute, $value, $fail) use ($empId) {
                    // Debug: Check what we're working with
                    Log::info('EMAIL VALIDATION DEBUG - Checking email: ' . $value);
                    Log::info('EMAIL VALIDATION DEBUG - empId: ' . ($empId ?? 'null'));
                    
                    $exists = Employee::where('email', $value)
                        ->when($empId, fn($q) => $q->where('id', '!=', $empId))
                        ->exists();
                    
                    Log::info('EMAIL VALIDATION DEBUG - Email exists: ' . ($exists ? 'true' : 'false'));
                    
                    if ($exists) {
                        return $fail('This email is already taken.');
                    }
                    return true;
                }
            ],
            'city'         => 'nullable|string|max:100',
            'state'        => 'nullable|string|max:100',
            'country'      => 'nullable|string|max:100',
            'address'      => 'nullable|string|max:300',

            // Salary
            'basicSalary'         => 'nullable|numeric|min:0',
            'currency'            => 'required|in:RWF,USD,EUR',
            'paymentMethod'       => 'required|in:bank_transfer,cash,mobile_money',
            'bankName'            => 'nullable|string|max:200',
            'accountNumber'       => 'nullable|string|max:50',
            'bankBranch'          => 'nullable|string|max:100',
            'mobileMoneyProvider' => 'nullable|string|max:100',
            'mobileMoneyNumber'   => 'nullable|string|max:30',
            'salaryEffectiveDate' => 'nullable|date',
            'rssbRate'            => 'nullable|numeric|min:0|max:100',
            'pensionRate'         => 'nullable|numeric|min:0|max:100',
            'subjectToPaye'       => 'boolean',
        ];
    }

    protected array $messages = [
        'firstName.required'  => 'First name is required.',
        'lastName.required'   => 'Last name is required.',
        'gender.required'     => 'Gender is required.',
        'email.required'      => 'Email address is required.',
        'email.unique'        => 'This email is already taken.',
        'nationalId.unique'   => 'This National ID is already in use.',
    ];

    // ── Lifecycle ──────────────────────────────────────────
    public function mount(): void
    {
        $this->loadDepartmentsAndPositions();
    }

    private function loadDepartmentsAndPositions(): void
    {
        try {
            $this->departments = Department::orderBy('name')->get(['id','name'])->toArray();
            $this->positions   = Position::orderBy('name')->get(['id','name'])->toArray();
            
            Log::info('loadDepartmentsAndPositions - Departments loaded: ' . count($this->departments));
            Log::info('loadDepartmentsAndPositions - Positions loaded: ' . count($this->positions));
            
            if (count($this->departments) > 0) {
                Log::info('loadDepartmentsAndPositions - First department: ' . json_encode($this->departments[0]));
            }
            if (count($this->positions) > 0) {
                Log::info('loadDepartmentsAndPositions - First position: ' . json_encode($this->positions[0]));
            }
        } catch (\Exception $e) {
            Log::error('loadDepartmentsAndPositions failed: ' . $e->getMessage());
            $this->departments = [];
            $this->positions   = [];
        }
    }

    // ── Reset pagination on search/filter change ───────────
    public function updatedSearch(): void    { $this->resetPage(); }
    public function updatedFilterDept(): void { $this->resetPage(); }
    public function updatedFilterStatus(): void { $this->resetPage(); }

    // ── Payment method watcher ─────────────────────────────
    public function updatedPaymentMethod(): void
    {
        if ($this->paymentMethod !== 'bank_transfer') {
            $this->bankName = $this->accountNumber = $this->bankBranch = '';
        }
        if ($this->paymentMethod !== 'mobile_money') {
            $this->mobileMoneyProvider = $this->mobileMoneyNumber = '';
        }
    }

    // ── Generate employee code ─────────────────────────────
    private function generateCode(): string
    {
        $last = Employee::orderBy('id','desc')->first();
        $n    = $last ? ((int) substr($last->code, 4)) + 1 : 1;
        return 'EMP-' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    // ── Open create form ───────────────────────────────────
    public function openCreate(): void
    {
        Log::info('openCreate called - opening Add Employee modal');
        $this->resetForm();
        $this->code      = $this->generateCode();
        $this->activeTab = 'personal';
        $this->showModal = true;
        Log::info('openCreate - Add Employee modal opened successfully');
    }

    // ── Open edit form ─────────────────────────────────────
    public function openEdit(string $id): void
    {
        Log::info('openEdit called with ID: ' . $id);
        Log::info('openEdit - Before setting editingId, current value: ' . ($this->editingId ?? 'null'));
        
        $emp = Employee::findOrFail($id);
        $this->editingId = $id;
        
        Log::info('openEdit - After setting editingId, new value: ' . $this->editingId);
        Log::info('openEdit - Employee found: ' . $emp->code . ' (ID: ' . $emp->id . ')');
        
        $this->fillForm($emp);
        $this->activeTab = 'personal';
        $this->showModal = true;
        Log::info('Edit modal should be open now');
    }

    private function fillForm(Employee $emp): void
    {
        Log::info('fillForm called');
        Log::info('fillForm - Employee gender from DB: "' . ($emp->gender ?? 'null') . '"');
        Log::info('fillForm - Gender type: ' . gettype($emp->gender ?? 'null'));
        Log::info('fillForm - Gender length: ' . strlen($emp->gender ?? ''));
        
        $this->code           = $emp->code ?? '';
        $this->firstName      = $emp->first_name ?? '';
        $this->middleName     = $emp->middle_name ?? '';
        $this->lastName       = $emp->last_name ?? '';
        
        // Fix gender retrieval - trim and normalize the value
        $genderValue = trim($emp->gender ?? '');
        $genderValue = strtolower($genderValue); // normalize to lowercase
        $this->gender = $genderValue;
        
        Log::info('fillForm - Gender set to: "' . $this->gender . '"');
        Log::info('fillForm - Form gender type: ' . gettype($this->gender));
        Log::info('fillForm - Form gender length: ' . strlen($this->gender));
        
        // Also check if the gender value matches expected options
        $validGenders = ['male', 'female', 'other'];
        Log::info('fillForm - Is gender valid: ' . (in_array($this->gender, $validGenders) ? 'yes' : 'no'));
        
        $this->birthDate      = $emp->birth_date?->format('Y-m-d') ?? '';
        $this->nationality    = $emp->nationality ?? '';
        $this->nationalId     = $emp->national_id ?? '';
        $this->passportNumber = $emp->passport_number ?? '';
        $this->rssNumber      = $emp->rss_number ?? '';
        $this->joinDate       = $emp->join_date?->format('Y-m-d') ?? '';
        $this->phone          = $emp->phone_number ?? '';
        $this->email          = $emp->email ?? '';
        $this->city           = $emp->city ?? '';
        $this->state          = $emp->state ?? '';
        $this->country        = $emp->country ?? '';
        $this->address        = $emp->address ?? '';
        $this->departmentId   = $emp->department_id ?? '';
        $this->positionId     = $emp->position_id ?? '';
        
        Log::info('fillForm - department_id from DB: ' . ($emp->department_id ?? 'null'));
        Log::info('fillForm - position_id from DB: ' . ($emp->position_id ?? 'null'));
        Log::info('fillForm - departmentId set to: ' . $this->departmentId);
        Log::info('fillForm - positionId set to: ' . $this->positionId);

        // Salary (assuming salary fields exist directly or via a relation)
        $this->basicSalary          = $emp->basic_salary ?? '';
        $this->currency             = $emp->currency ?? 'RWF';
        $this->paymentMethod        = $emp->payment_method ?? 'bank_transfer';
        $this->bankName             = $emp->bank_name ?? '';
        $this->accountNumber        = $emp->account_number ?? '';
        $this->bankBranch           = $emp->bank_branch ?? '';
        $this->mobileMoneyProvider  = $emp->mobile_money_provider ?? '';
        $this->mobileMoneyNumber    = $emp->mobile_money_number ?? '';
        $this->salaryEffectiveDate  = $emp->salary_effective_date?->format('Y-m-d') ?? '';
        $this->rssbRate             = $emp->rssb_rate ?? '5';
        $this->pensionRate          = $emp->pension_rate ?? '3';
        $this->subjectToPaye        = (bool) ($emp->subject_to_paye ?? true);
    }
    
    // ── View employee ──────────────────────────────────────
    public function openView(string $id): void
    {
        Log::info('openView called with ID: ' . $id);
        try {
            $this->viewEmployee = Employee::findOrFail($id);
            Log::info('openView - Employee loaded: ' . $this->viewEmployee->code);
            Log::info('openView - Department ID: ' . ($this->viewEmployee->department_id ?? 'null'));
            Log::info('openView - Position ID: ' . ($this->viewEmployee->position_id ?? 'null'));
            $this->showView     = true;
            Log::info('View modal should be open now');
        } catch (\Exception $e) {
            Log::error('openView failed: ' . $e->getMessage());
            $this->dispatch('show-message', 'Failed to load employee: ' . $e->getMessage());
        }
    }
    
    public function closeView(): void
    {
        Log::info('closeView called');
        $this->showView     = false;
        $this->viewEmployee = null;
        $this->resetForm();
    }

    // ── Confirm delete ─────────────────────────────────────
    public function confirmDelete(string $id): void
    {
        Log::info('confirmDelete called with ID: ' . $id);
        $this->deletingId  = $id;
        $this->showDelete  = true;
        Log::info('Delete confirmation modal should be open now');
    }

    public function cancelDelete(): void
    {
        Log::info('cancelDelete called');
        $this->deletingId = null;
        $this->showDelete = false;
    }

    public function deleteEmployee(): void
    {
        Log::info('deleteEmployee called with ID: ' . $this->deletingId);
        try {
            $emp = Employee::findOrFail($this->deletingId);
            $emp->delete();
            $this->cancelDelete();
            session()->flash('success', 'Employee deleted successfully.');
            $this->dispatch('show-message', 'Employee deleted successfully.');
            Log::info('Employee deleted successfully');
        } catch (\Exception $e) {
            Log::error('deleteEmployee failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to delete employee: ' . $e->getMessage());
            $this->dispatch('show-message', 'Failed to delete employee: ' . $e->getMessage());
            $this->cancelDelete();
        }
    }

    // ── Close modal ────────────────────────────────────────
    public function closeModal(): void
    {
        Log::info('closeModal called');
        $this->showModal = false;
        $this->resetForm();
    }

    // ── Switch tab ─────────────────────────────────────────
    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    // ── Save (create or update) ────────────────────────────
    public function save(): void
    {
        try {
            $this->validate();
            Log::info('Validation passed, proceeding with save');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ', $e->errors());
            $this->dispatch('validation-error', $e->errors());
            
            // Also dispatch a user-friendly message
            $errorMessages = [];
            foreach ($e->errors() as $field => $messages) {
                $errorMessages[] = $field . ': ' . implode(', ', $messages);
            }
            $this->dispatch('show-message', 'Validation failed: ' . implode('; ', $errorMessages));
            return;
        }

        DB::beginTransaction();
        try {
            $data = [
                'code'                   => $this->code ?: $this->generateCode(),
                'first_name'             => $this->firstName,
                'middle_name'            => $this->middleName ?: null,
                'last_name'              => $this->lastName,
                'gender'                 => $this->gender,
                'birth_date'             => $this->birthDate ?: null,
                'nationality'            => $this->nationality ?: null,
                'national_id'            => $this->nationalId ?: null,
                'passport_number'        => $this->passportNumber ?: null,
                'rss_number'             => $this->rssNumber ?: null,
                'join_date'              => $this->joinDate ?: null,
                'phone_number'           => $this->phone ?: null,
                'email'                  => $this->email,
                'city'                   => $this->city ?: null,
                'state'                  => $this->state ?: null,
                'country'                => $this->country ?: null,
                'address'                => $this->address ?: null,
                'department_id'          => $this->departmentId ?: null,
                'position_id'            => $this->positionId ?: null,
                // Salary fields
                'basic_salary'           => $this->basicSalary ?: null,
                'currency'               => $this->currency,
                'payment_method'         => $this->paymentMethod,
                'bank_name'              => $this->paymentMethod === 'bank_transfer' ? ($this->bankName ?: null) : null,
                'account_number'         => $this->paymentMethod === 'bank_transfer' ? ($this->accountNumber ?: null) : null,
                'bank_branch'            => $this->paymentMethod === 'bank_transfer' ? ($this->bankBranch ?: null) : null,
                'mobile_money_provider'  => $this->paymentMethod === 'mobile_money' ? ($this->mobileMoneyProvider ?: null) : null,
                'mobile_money_number'    => $this->paymentMethod === 'mobile_money' ? ($this->mobileMoneyNumber ?: null) : null,
                'salary_effective_date'  => $this->salaryEffectiveDate ?: null,
                'rssb_rate'              => $this->rssbRate ?: 5,
                'pension_rate'           => $this->pensionRate ?: 3,
                'subject_to_paye'        => $this->subjectToPaye,
                'approval_status'        => ApprovalStatus::Approved,
            ];

            Log::info('Employee data prepared: ', $data);
            
            // Debug department and position specifically
            Log::info('SAVE DEBUG - departmentId being saved: ' . ($this->departmentId ?? 'null'));
            Log::info('SAVE DEBUG - positionId being saved: ' . ($this->positionId ?? 'null'));
            Log::info('SAVE DEBUG - department_id in data array: ' . ($data['department_id'] ?? 'null'));
            Log::info('SAVE DEBUG - position_id in data array: ' . ($data['position_id'] ?? 'null'));

            if ($this->editingId) {
                Employee::findOrFail($this->editingId)->update($data);
                $msg = 'Employee updated successfully.';
                Log::info('Employee updated: ' . $this->editingId);
            } else {
                $employee = Employee::create($data);
                $msg = 'Employee created successfully.';
                Log::info('Employee created: ' . $employee->id);
            }

            DB::commit();
            $this->closeModal();
            session()->flash('success', $msg);
            $this->dispatch('show-message', $msg);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Save failed: ' . $e->getMessage());
            session()->flash('error', 'Save failed: ' . $e->getMessage());
            $this->dispatch('show-message', 'Save failed: ' . $e->getMessage());
        }
    }

    // ── Reset form fields ──────────────────────────────────
    private function resetForm(): void
    {
        $this->editingId          = null;
        $this->code               = '';
        $this->firstName          = '';
        $this->middleName         = '';
        $this->lastName           = '';
        $this->gender             = '';
        $this->birthDate          = '';
        $this->nationality        = '';
        $this->nationalId         = '';
        $this->passportNumber     = '';
        $this->rssNumber          = '';
        $this->joinDate           = '';
        $this->phone              = '';
        $this->email              = '';
        $this->city               = '';
        $this->state              = '';
        $this->country            = '';
        $this->address            = '';
        $this->departmentId       = '';
        $this->positionId         = '';
        $this->basicSalary        = '';
        $this->currency           = 'RWF';
        $this->paymentMethod      = 'bank_transfer';
        $this->bankName           = '';
        $this->accountNumber      = '';
        $this->bankBranch         = '';
        $this->mobileMoneyProvider = '';
        $this->mobileMoneyNumber  = '';
        $this->salaryEffectiveDate = '';
        $this->rssbRate           = '5';
        $this->pensionRate        = '3';
        $this->subjectToPaye      = true;
        $this->resetValidation();
    }

    // ── Render ─────────────────────────────────────────────
    public function render()
    {
        $employees = Employee::query()
            ->when($this->search, fn($q) => $q->where(function($q2) {
                $q2->where('first_name',  'like', "%{$this->search}%")
                   ->orWhere('last_name',   'like', "%{$this->search}%")
                   ->orWhere('email',        'like', "%{$this->search}%")
                   ->orWhere('code',         'like', "%{$this->search}%")
                   ->orWhere('phone_number', 'like', "%{$this->search}%");
            }))
            ->when($this->filterDept,   fn($q) => $q->where('department_id', $this->filterDept))
            ->when($this->filterStatus === 'active',   fn($q) => $q->where('is_active', true))
            ->when($this->filterStatus === 'inactive', fn($q) => $q->where('is_active', false))
            ->when($this->filterStatus === '', fn($q) => $q->where(function($q) {
                $q->where('is_active', true)->orWhereNull('is_active');
            })) // Show active + null status by default
            ->orderBy('created_at','desc')
            ->paginate($this->perPage);

        $totalCount    = Employee::count();
        $activeCount   = Employee::where('is_active', true)->count();
        $inactiveCount = Employee::where('is_active', false)->count();
        $nullCount    = Employee::whereNull('is_active')->count();

        return view('livewire.hr.hr-employee-manager', [
            'employees'     => $employees,
            'totalCount'    => $totalCount,
            'activeCount'   => $activeCount,
            'inactiveCount' => $inactiveCount,
            'nullCount'     => $nullCount,
            'banks'         => self::BANKS,
            'departments'   => $this->departments,
            'positions'     => $this->positions,
        ])->layout('components.layouts.app');
    }
}