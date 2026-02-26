<?php

namespace App\Livewire;

use App\Enum\ApprovalStatus;
use App\Enum\ProjectStatus;
use App\Enum\UserRole;
use App\Helpers\FlexibleImporterHelper;
use App\Helpers\SimpleImporterHelper;
use App\Jobs\ExportDataJob;
use App\Jobs\ImportDataJob;
use App\Models\Attendance;
use App\Models\AuthorizedOvertime;
use App\Models\BankInfo;
use App\Models\Contract;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Models\JobResult;
use App\Policies\NavigationPolicy;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Symfony\Component\HttpFoundation\StreamedResponse;


#[Title('SGA | C-HRMS | Data Import & Export')]

class DataImportExport extends Component
{
    use WithFileUploads;

    public $file;
    public $exportFormat = 'csv';
    public $selectedTemplate = '';
    public $templates = [];
    public $statusMessage = '';
    public $isProcessing = false;
    public $jobId = null;
    public $showPopup = false;
    public $popupMessage = '';
    public $popupFilePath = null;
    public $fixedValues = [];
    public $project_id;

    public $RwNationalId = '/^[1-2][0-9]{4}[7-8][0-9]{7}[0-9]{1}[0-9]{2}$/'; // Rwanda-specific National ID
    public $RwRssbNumberRegex = '/^\d{8}([A-Za-z])?$/'; // Rwanda-specific RSSB number
    public $loggedUserId;

    protected $rules = [
        'file' => 'required|file|mimes:csv,xlsx|max:10240',
        'exportFormat' => 'required|in:csv,xlsx',
        'selectedTemplate' => 'required|string',
        'fixedValues.project_id' => 'nullable|exists:projects,id',
        'fixedValues.category_id' => 'nullable|exists:categories,id',
        'fixedValues.status' => 'nullable|boolean',
    ];

    public function mount(): void
    {
        $this->loggedUserId = Auth::id();


        $this->templates = $this->getTemplates();
        $this->selectedTemplate = array_key_first($this->templates) ?? '';
        $this->resetFixedValues();
    }


    public function updatedSelectedTemplate(): void
    {
        $this->resetFixedValues();
    }
    public function downloadTemplateCSV($templateKey)
    {
        if (!isset($this->templates[$templateKey])) {
            session()->flash('message', 'Template not found.');
            return;
        }

        $exportColumns = $this->templates[$templateKey]['export_columns'] ?? [];

        $filename = $templateKey . '_template.csv';

        return response()->streamDownload(function () use ($exportColumns) {
            $handle = fopen('php://output', 'w');
            // Write header row: field keys
            fputcsv($handle, array_keys($exportColumns));
            // Optionally write one row of empty values as an example
            fputcsv($handle, array_fill(0, count($exportColumns), ''));
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
    protected function resetFixedValues(): void
    {
        $this->fixedValues = [];
        if ($this->selectedTemplate && isset($this->templates[$this->selectedTemplate]['fixed_fields'])) {
            foreach ($this->templates[$this->selectedTemplate]['fixed_fields'] as $field => $config) {
                $this->fixedValues[$field] = null;
            }
        }
    }

    protected function getTemplates(): array
    {
        $templates = [
            'user' => [
            'target' => User::class,
            'title' => 'Users',
            'validation_rules' => [
                'code' => 'required|string|unique:users,code',
                'first_name' => 'required|string|max:100',
                'middle_name' => 'nullable|string|max:100',
                'last_name' => 'nullable|string|max:100',
                'username' => 'required|string|max:50|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'phone_number' => 'required|string|max:20',
                'password' => 'required|string|min:8',
                'phone_verified_at' => 'nullable|date',
                'email_verified_at' => 'nullable|date',
                'password_changed_at' => 'nullable|date',
                'role' => 'required',
            ],
            'export_columns' => [
                'code' => 'User Code',
                'first_name' => 'First Name',
                'middle_name' => 'Middle Name',
                'last_name' => 'Last Name',
                'username' => 'Username',
                'email' => 'Email',
                'phone_number' => 'Phone Number',
                'phone_verified_at' => 'Phone Verified At',
                'email_verified_at' => 'Email Verified At',
                'password_changed_at' => 'Password Changed At',
                'role' => 'Role',
            ],
            'fixed_fields' => [
                'password' => 'ChangeMe@123', // You should change this in production
                'role' => 'SiteEmployee', // Default role
            ],
            'field_map' => [
                'User Code' => 'code',
                'First Name' => 'first_name',
                'Middle Name' => 'middle_name',
                'Last Name' => 'last_name',
                'Username' => 'username',
                'Email' => 'email',
                'Phone Number' => 'phone_number',
                'Password' => 'password',
                'Phone Verified At' => 'phone_verified_at',
                'Email Verified At' => 'email_verified_at',
                'Password Changed At' => 'password_changed_at',
                'Role' => 'role',
            ],
        ],
            'project_user' => [
                'target' => ProjectUser::class,
                'title' => 'Project Users',
                'validation_rules' => [
                    'code' => 'required|string|unique:project_users,code',
                    'project_id' => 'required|exists:projects,id',
                    'user_id' => 'required|exists:users,id',
                    'approval_status' => 'nullable|string|in:pending,approved,rejected',
                    'is_locked' => 'nullable|boolean',
                    'created_by' => 'nullable|exists:users,id',
                ],
                'export_columns' => [
                    'code' => 'Assignment Code',
                    'project_id' => 'Project ID',
                    'user_id' => 'User ID',
                    'approval_status' => 'Approval Status',
                    'is_locked' => 'Is Locked',
                    'created_by' => 'Created By',
                    'created_at' => 'Assignment Date',
                ],
                'fixed_fields' => [
                    'project_id' => '0198132b-ee97-72e1-b694-810836577aae',
                    'approval_status' => 'pending',
                    'is_locked' => false,
                    'created_by' => Auth::user()->id,
                ],
                'field_map' => [
                    'Assignment Code' => 'code',
                    'Project ID' => 'project_id',
                    'User ID' => 'user_id',
                    'Approval Status' => 'approval_status',
                    'Is Locked' => 'is_locked',
                    'Created By' => 'created_by',
                    'Assignment Date' => 'created_at',
                ],
            ],

            'employee_contract' => [
                'target' => Contract::class,
                'title' => 'Employee Contracts',
                'validation_rules' => [
                    'code' => 'required|string|unique:employee_contracts,code',
                    'project_id' => 'required|exists:projects,id',
                    'employee_id' => 'required|exists:employees,id',
                    'position_id' => 'required|exists:positions,id',
                    'remuneration' => 'required|numeric',
                    'remuneration_type' => 'required|string|in:hourly,daily,weekly,monthly,yearly',
                    'employee_category' => 'required|string',
                    'daily_working_hours' => 'required|numeric|min:1|max:24',
                    'start_date' => 'required|date',
                    'end_date' => 'nullable|date|after:start_date',
                    'status' => 'nullable|boolean',
                    'approval_status' => 'nullable|string|in:pending,approved,rejected',
                    'is_locked' => 'nullable|boolean',
                    'locked_by' => 'nullable|exists:users,id',
                    'created_by' => 'nullable|exists:users,id',
                ],
                'export_columns' => [
                    'code' => 'Contract Code',
                    'project_id' => 'Project ID',
                    'employee_id' => 'Employee ID',
                    'position_id' => 'Position ID',
                    'remuneration' => 'Remuneration',
                    'remuneration_type' => 'Remuneration Type',
                    'employee_category' => 'Employee Category',
                    'daily_working_hours' => 'Daily Working Hours',
                    'start_date' => 'Start Date',
                    'end_date' => 'End Date',
                    'status' => 'Status',
                    'approval_status' => 'Approval Status',
                    'is_locked' => 'Is Locked',
                    'locked_by' => 'Locked By',
                    'created_by' => 'Created By',
                    'created_at' => 'Created At',
                ],
                'fixed_fields' => [
                    'status' => true,
                    'approval_status' => 'pending',
                    'is_locked' => false,
                    'created_by' => Auth::user()->id,
                ],
                'field_map' => [
                    'Contract Code' => 'code',
                    'Project ID' => 'project_id',
                    'Employee ID' => 'employee_id',
                    'Position ID' => 'position_id',
                    'Remuneration' => 'remuneration',
                    'Remuneration Type' => 'remuneration_type',
                    'Employee Category' => 'employee_category',
                    'Daily Working Hours' => 'daily_working_hours',
                    'Start Date' => 'start_date',
                    'End Date' => 'end_date',
                    'Status' => 'status',
                    'Approval Status' => 'approval_status',
                    'Is Locked' => 'is_locked',
                    'Locked By' => 'locked_by',
                    'Created By' => 'created_by',
                    'Created At' => 'created_at',
                ],
            ],

            'bank_info' => [
                'target' => BankInfo::class,
                'title' => 'Bank Account Information',
                'validation_rules' => [
                    'code' => 'required|string|unique:bank_infos,code',
                    'employee_id' => 'required|exists:employees,id',
                    'bank_id' => 'required|exists:banks,id',
                    'account_number' => 'required|string',
                    'account_name' => 'required|string',
                    'is_active' => 'nullable|boolean',
                    'activation_date' => 'required|date',
                    'deactivation_date' => 'nullable|date|after:activation_date',
                    'created_by' => 'nullable|exists:users,id',
                ],
                'export_columns' => [
                    'code' => 'Bank Info Code',
                    'employee_id' => 'Employee ID',
                    'bank_id' => 'Bank ID',
                    'account_number' => 'Account Number',
                    'account_name' => 'Account Name',
                    'is_active' => 'Is Active',
                    'activation_date' => 'Activation Date',
                    'deactivation_date' => 'Deactivation Date',
                    'created_by' => 'Created By',
                    'created_at' => 'Created At',
                ],
                'fixed_fields' => [
                    'is_active' => true,
                    'created_by' => Auth::user()->id,
                ],
                'field_map' => [
                    'Bank Info Code' => 'code',
                    'Employee ID' => 'employee_id',
                    'Bank ID' => 'bank_id',
                    'Account Number' => 'account_number',
                    'Account Name' => 'account_name',
                    'Is Active' => 'is_active',
                    'Activation Date' => 'activation_date',
                    'Deactivation Date' => 'deactivation_date',
                    'Created By' => 'created_by',
                    'Created At' => 'created_at',
                ],
            ],

            'employee' => [
                'target' => Employee::class,
                'title' => 'Employees',
                'validation_rules' => [
                    'code' => 'required|string|unique:employees,code',
                    'first_name' => 'required|string|max:100',
                    'last_name' => 'required|string|max:100',
                    'middle_name' => 'nullable|string|max:100',
                    'gender' => 'required|string|in:male,female,other',
                    'birth_date' => 'nullable|date',
                    'nationality' => 'required|string|max:100',
                    'national_id' => ['nullable','regex:' . $this->RwNationalId,'max:16','unique:employees,national_id'],
                    'passport_number' => 'nullable|string|max:50',
                    'rss_number' => ['nullable','string', 'regex:' . $this->RwRssbNumberRegex,'unique:employees,rss_number'],
                    'join_date' => 'required|date',
                    'phone_number' => 'nullable|string|max:20',
                    'email' => 'nullable|email|unique:employees,email',
                    'address' => 'nullable|string|max:255',
                    'city' => 'required|string|max:100',
                    'state' => 'required|string|max:100',
                    'country' => 'required|string|max:100',
                    'approval_status' => 'nullable|string|in:pending,approved,rejected',
                    'is_locked' => 'nullable|boolean',
                    'created_by' => 'nullable|exists:users,id',
                ],
                'export_columns' => [
                    'code' => 'Employee Code',
                    'first_name' => 'First Name',
                    'last_name' => 'Last Name',
                    'middle_name' => 'Middle Name',
                    'gender' => 'Gender',
                    'birth_date' => 'Birth Date',
                    'nationality' => 'Nationality',
                    'national_id' => 'National ID',
                    'passport_number' => 'Passport Number',
                    'rss_number' => 'RSS Number',
                    'join_date' => 'Join Date',
                    'phone_number' => 'Phone Number',
                    'email' => 'Email',
                    'address' => 'Address',
                    'city' => 'City',
                    'state' => 'State',
                    'country' => 'Country',
                    'approval_status' => 'Approval Status',
                    'is_locked' => 'Is Locked',
                    'created_by' => 'Created By',
                    'created_at' => 'Created At',
                ],
                'fixed_fields' => [
                    'city' => 'Kigali city',
                    'state' => 'Kigali Province',
                    'country' => 'Rwanda',
                    'nationality' => 'Rwandan',
                    'join_date' => date('Y-m-d'),
                    'approval_status' => 'pending',
                    'is_locked' => false,
                    'created_by' => Auth::user()->id,
                ],
                'field_map' => [
                    'Employee Code' => 'code',
                    'First Name' => 'first_name',
                    'Last Name' => 'last_name',
                    'Middle Name' => 'middle_name',
                    'Gender' => 'gender',
                    'Birth Date' => 'birth_date',
                    'Nationality' => 'nationality',
                    'National ID' => 'national_id',
                    'Passport Number' => 'passport_number',
                    'RSS Number' => 'rss_number',
                    'Join Date' => 'join_date',
                    'Phone Number' => 'phone_number',
                    'Email' => 'email',
                    'Address' => 'address',
                    'City' => 'city',
                    'State' => 'state',
                    'Country' => 'country',
                    'Approval Status' => 'approval_status',
                    'Is Locked' => 'is_locked',
                    'Created By' => 'created_by',
                    'Created At' => 'created_at',
                ],
            ],

            'attendance' => [
                'target' => Attendance::class,
                'title' => 'Employee Attendance Records',
                'validation_rules' => [
                    'code' => 'required|string|unique:attendances,code',
                    'employee_id' => 'required|exists:employees,id',
                    'date' => 'required|date',
                    'check_in' => 'required|date_format:H:i:s',
                    'check_out' => 'nullable|date_format:H:i:s|after:check_in',
                    'device_id' => 'nullable|string|max:100',
                    'check_in_method' => 'required|string|in:biometric,rfid,mobile,manual,web',
                    'check_out_method' => 'nullable|string|in:biometric,rfid,mobile,manual,web',
                    'status' => 'nullable|string|in:present,late,half_day,absent,leave,holiday',
                    'approval_status' => 'nullable|string|in:pending,approved,rejected,adjusted',
                    'is_locked' => 'nullable|boolean',
                    'created_by' => 'nullable|exists:users,id',
                ],
                'export_columns' => [
                    'code' => 'Attendance Code',
                    'employee_id' => 'Employee ID',
                    'date' => 'Date',
                    'check_in' => 'Check-In Time',
                    'check_out' => 'Check-Out Time',
                    'device_id' => 'Device ID',
                    'check_in_method' => 'Check-In Method',
                    'check_out_method' => 'Check-Out Method',
                    'status' => 'Attendance Status',
                    'approval_status' => 'Approval Status',
                    'is_locked' => 'Is Locked',
                    'created_by' => 'Created By',
                    'created_at' => 'Record Created At',
                ],
                'fixed_fields' => [
                    'status' => 'present',
                    'approval_status' => 'pending',
                    'is_locked' => false,
                    'created_by' => Auth::user()->id,
                ],
                'field_map' => [
                    'Attendance Code' => 'code',
                    'Employee ID' => 'employee_id',
                    'Date' => 'date',
                    'Check-In Time' => 'check_in',
                    'Check-Out Time' => 'check_out',
                    'Device ID' => 'device_id',
                    'Check-In Method' => 'check_in_method',
                    'Check-Out Method' => 'check_out_method',
                    'Attendance Status' => 'status',
                    'Approval Status' => 'approval_status',
                    'Is Locked' => 'is_locked',
                    'Created By' => 'created_by',
                    'Record Created At' => 'created_at',
                ],
            ],

            'authorized_overtime' => [
                'target' => AuthorizedOvertime::class,
                'title' => 'Authorized Overtime Records',
                'validation_rules' => [
                    'code' => 'required|string|unique:authorized_overtimes,code',
                    'employee_id' => 'required|exists:employees,id',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'hour_rate' => 'required|numeric|min:0',
                    'approval_status' => 'nullable|string|in:pending,approved,rejected,processed',
                    'is_locked' => 'nullable|boolean',
                    'created_by' => 'nullable|exists:users,id',
                ],
                'export_columns' => [
                    'code' => 'Overtime Code',
                    'employee_id' => 'Employee ID',
                    'start_date' => 'Start Date',
                    'end_date' => 'End Date',
                    'hour_rate' => 'Hourly Rate',
                    'approval_status' => 'Approval Status',
                    'is_locked' => 'Is Locked',
                    'created_by' => 'Created By',
                    'created_at' => 'Authorization Date',
                ],
                'fixed_fields' => [
                    'approval_status' => 'pending',
                    'is_locked' => false,
                    'created_by' => Auth::user()->id,
                ],
                'field_map' => [
                    'Overtime Code' => 'code',
                    'Employee ID' => 'employee_id',
                    'Start Date' => 'start_date',
                    'End Date' => 'end_date',
                    'Hourly Rate' => 'hour_rate',
                    'Approval Status' => 'approval_status',
                    'Is Locked' => 'is_locked',
                    'Created By' => 'created_by',
                    'Authorization Date' => 'created_at',
                ],
            ],

            'position' => [
                'target' => Position::class,
                'title' => 'Position Management',
                'validation_rules' => [
                    'code' => 'required|string|unique:positions,code',
                    'name' => 'required|string|max:100',
                    'description' => 'nullable|string|max:255',
                    'minimum_pay' => 'required|numeric|min:0',
                    'maximum_pay' => 'required|numeric|min:0|gte:minimum_pay',
                    'approval_status' => 'nullable|string|in:pending,approved,rejected',
                    'is_locked' => 'nullable|boolean',
                    'created_by' => 'nullable|exists:users,id',
                ],
                'export_columns' => [
                    'code' => 'Position Code',
                    'name' => 'Position Name',
                    'description' => 'Description',
                    'minimum_pay' => 'Minimum Pay',
                    'maximum_pay' => 'Maximum Pay',
                    'approval_status' => 'Approval Status',
                    'is_locked' => 'Is Locked',
                    'created_by' => 'Created By',
                    'created_at' => 'Created At',
                ],
                'fixed_fields' => [
                    'approval_status' => 'pending',
                    'is_locked' => false,
                    'created_by' => Auth::user()->id,
                ],
                'field_map' => [
                    'Position Code' => 'code',
                    'Position Name' => 'name',
                    'Description' => 'description',
                    'Minimum Pay' => 'minimum_pay',
                    'Maximum Pay' => 'maximum_pay',
                    'Approval Status' => 'approval_status',
                    'Is Locked' => 'is_locked',
                    'Created By' => 'created_by',
                    'Created At' => 'created_at',
                ],
            ],
            'project' => [
                'target' => Project::class,
                'title' => 'Projects',
                'validation_rules' => [
                    'code' => 'required|string|unique:projects,code',
                    'name' => 'required|string|max:150',
                    'description' => 'nullable|string|max:500',
                    'status' => 'required|string|in:planning,active,on_hold,completed,cancelled',
                    'approval_status' => 'nullable|string|in:pending,approved,rejected',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'address' => 'nullable|string|max:255',
                    'city' => 'nullable|string|max:100',
                    'state' => 'nullable|string|max:100',
                    'country' => 'nullable|string|max:100',
                    'manager_id' => 'required|exists:users,id',
                    'is_locked' => 'nullable|boolean',
                    'created_by' => 'nullable|exists:users,id',
                ],
                'export_columns' => [
                    'code' => 'Project Code',
                    'name' => 'Project Name',
                    'description' => 'Description',
                    'status' => 'Status',
                    'approval_status' => 'Approval Status',
                    'start_date' => 'Start Date',
                    'end_date' => 'End Date',
                    'address' => 'Address',
                    'city' => 'City',
                    'state' => 'State',
                    'country' => 'Country',
                    'manager_id' => 'Manager ID',
                    'is_locked' => 'Is Locked',
                    'created_by' => 'Created By',
                    'created_at' => 'Created At',
                ],
                'fixed_fields' => [
                    'status' => 'planning',
                    'approval_status' => 'pending',
                    'is_locked' => false,
                    'created_by' => Auth::user()->id,
                ],
                'field_map' => [
                    'Project Code' => 'code',
                    'Project Name' => 'name',
                    'Description' => 'description',
                    'Status' => 'status',
                    'Approval Status' => 'approval_status',
                    'Start Date' => 'start_date',
                    'End Date' => 'end_date',
                    'Address' => 'address',
                    'City' => 'city',
                    'State' => 'state',
                    'Country' => 'country',
                    'Manager ID' => 'manager_id',
                    'Is Locked' => 'is_locked',
                    'Created By' => 'created_by',
                    'Created At' => 'created_at',
                ],
            ],

        ];

//        // Filter templates based on user role
//        $user = Auth::user();
//        // if ($user->role !== UserRole::SuperAdmin && $user->role !== UserRole::CompanyAdmin) {
//        if (!(new NavigationPolicy)->dataMasterView($user)) {
//            $allowedTemplates = ['users', 'positions'];
//            $templates = array_intersect_key($templates, array_flip($allowedTemplates));
//        }

        return $templates;
    }

    public function import(): void
    {

        $this->validate([
            'file' => $this->rules['file'],
            'selectedTemplate' => $this->rules['selectedTemplate'],
        ]);

        try {

            $template = $this->templates[$this->selectedTemplate];
            $filePath = $this->file->store('uploads', 'public');


            // Use fixed_fields as fixed_values
            $fixedValues = $template['fixed_fields'] ?? [];



            // Validate fixed_values against template rules
            $fixedRules = array_intersect_key($template['validation_rules'], $fixedValues);
            $validator = Validator::make($fixedValues, $fixedRules);
            if ($validator->fails()) {
                $this->isProcessing = false;
                $this->statusMessage = 'Invalid fixed values: ' . implode(', ', $validator->errors()->all());

                return;
            }

//            $result = FlexibleImporterHelper::import(
//                storage_path('app/public/' . $filePath),
//                $template['target'],
//                $template['validation_rules'],
//                100,
//                $fixedValues
//            );
            $result = SimpleImporterHelper::importToArray(
                storage_path('app/public/' . $filePath),
                $template['validation_rules'],
                $template['field_map'],
                $template['fixed_fields'],
            );

            dd($result['valid'], $result['invalid']);



            // Safely retrieve job ID
//            $this->jobId = $this->getJobId($job) ?? Str::uuid()->toString();
            $this->statusMessage = "Import job for {$template['title']} queued successfully.";
            dd($this->jobId);

        } catch (\Exception $e) {
            $this->isProcessing = false;
            $this->statusMessage = 'Failed to queue import: ' . $e->getMessage();
            Log::error('Import dispatch failed', [
                'error' => $e->getMessage(),
                'template' => $this->selectedTemplate,
                'fixed_values' => $fixedValues,
            ]);
        }
    }

    public function export(): void
    {
        $this->validate([
            'exportFormat' => $this->rules['exportFormat'],
            'selectedTemplate' => $this->rules['selectedTemplate'],
        ]);

        try {
            $this->isProcessing = true;
            $this->statusMessage = 'Export job queued. Processing in the background...';
            $this->showPopup = false;

            $template = $this->templates[$this->selectedTemplate];
            $query = $this->buildQueryForTemplate($template);

            $job = ExportDataJob::dispatch(
                $query,
                strtolower($template['title']) . '_export',
                $this->exportFormat,
                $template['export_columns'],
                1000,
                Auth::id()
            )->onQueue('exports');

            // Safely retrieve job ID
            $this->jobId = $this->getJobId($job) ?? Str::uuid()->toString();
            $this->statusMessage = "Export job for {$template['title']} queued successfully.";
        } catch (\Exception $e) {
            $this->isProcessing = false;
            $this->statusMessage = 'Failed to queue export: ' . $e->getMessage();
            Log::error('Export dispatch failed', [
                'error' => $e->getMessage(),
                'template' => $this->selectedTemplate,
            ]);
        }
    }
    protected function getJobId($job): ?string
    {
        return isset($job->job) && method_exists($job->job, 'getJobId') ? $job->job->getJobId() : null;
    }
    protected function buildQueryForTemplate(array $template): EloquentBuilder|QueryBuilder
    {
        $target = $template['target'];
        $columns = array_keys($template['export_columns']);

        if (class_exists($target) && is_subclass_of($target, \Illuminate\Database\Eloquent\Model::class)) {
            return $target::query()->select($columns);
        }

        return DB::table($target)->select($columns);
    }


//    #[On('echo-private:job-results.$loggedUserId,ImportCompleted')]
    public function handleImportCompleted($event): void
    {
        $jobResult = JobResult::find($event['jobResult']['id']);
        if ($event['jobResult']['job_id'] === $this->jobId && Auth::user()->can('view', $jobResult)) {
            $this->isProcessing = false;
            $this->showPopup = true;
            $fixedValues = $event['jobResult']['fixed_values'] ? collect($event['jobResult']['fixed_values'])->map(fn($value, $key) => ucfirst(str_replace('_', ' ', $key)) . ": $value")->implode(', ') : '';
            $this->popupMessage = $event['jobResult']['message'] . ($fixedValues ? " Fixed values: $fixedValues" : '');
            $this->popupFilePath = $event['jobResult']['file_path'];
            $this->jobId = null;
        }
    }

//    #[On('echo-private:job-results.$loggedUserId,ExportCompleted')]
    public function handleExportCompleted($event): void
    {
        $jobResult = JobResult::find($event['jobResult']['id']);
        if ($event['jobResult']['job_id'] === $this->jobId && Auth::user()->can('view', $jobResult)) {
            $this->isProcessing = false;
            $this->showPopup = true;
            $this->popupMessage = $event['jobResult']['message'];
            $this->popupFilePath = $event['jobResult']['file_path'];
            $this->jobId = null;
        }
    }
    public function closePopup(): void
    {
        $this->showPopup = false;
        $this->popupMessage = '';
        $this->popupFilePath = null;
    }

    public function getRecentResults()
    {
        return JobResult::where('user_id', Auth::id())
            ->where('job_type', 'import')
            ->latest()
            ->take(5)
            ->get();
    }
    public function render():object
    {
        return view('livewire.data-import-export-controller');
    }
}
