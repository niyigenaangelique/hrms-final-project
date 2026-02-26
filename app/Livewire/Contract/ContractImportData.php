<?php

namespace App\Livewire\Contract;

use App\Enum\ApprovalStatus;
use App\Enum\ContractStatus;
use App\Enum\EmployeeCategory;
use App\Enum\RemunerationType;
use App\Helpers\AdvancedImporterHelper;
use App\Helpers\FormattedCodeHelper;
use App\Models\Contract;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Project;
use Exception;
use Flux\Flux;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Excel;

#[Title('SGA | C-HRMS | Contract Import Data')]
class ContractImportData extends Component
{
    use WithFileUploads;


    public $file;
    public bool $useBatchInsert = true;
    public bool $dryRun = false;
    public bool $previewMode = false;
    public int $chunkSize = 500;
    public ?array $result = null;
    public ?array  $formContracts=null;
    public ?array $invalidResult = null;
    public ?array $validResult = null;



    protected $rules = [
        'file' => ['required', 'file', 'mimes:csv,xlsx,xls', 'max:10240'],
    ];

    protected function contractConfig(): array
    {
        return [
            'rules' => [
                'code' => 'required|string|unique:contracts,code',
                'employee_id' => 'required|exists:employees,id',
                'project_id' => 'required|exists:projects,id',
                'position_id' => 'required|exists:positions,id',
                'remuneration' => 'required|numeric|min:0',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after:start_date',
                'status' => 'required|in:'. implode(',',ContractStatus::getValues()),
                'approval_status' => 'required|in:'. implode(',',ApprovalStatus::getValues()),
                'employee_category' => 'required|in:'. implode(',',EmployeeCategory::getValues()),
                'remuneration_type' => 'required|in:'. implode(',',RemunerationType::getValues()),
                'daily_working_hours' => 'required|numeric|min:0',
                'created_by' => 'nullable|exists:users,id',
            ],
            'fieldMap' => [
                'Code' => 'code',
                'Employee Code' => 'employee_code',
                'Project Code' => 'project_code',
                'Position Code' => 'position_code',
                'Remuneration' => 'remuneration',
                'Start Date' => 'start_date',
            ],
            'fixedValues' => [
                'code' => fn($row) => !empty($row['code'])
                    ? $row['code']
                    :$row['contract_code'],
                'start_date' => fn($row) => !empty($row['start_date'])
                    ? Carbon::parse($row['start_date'])->format('Y-m-d')
                    : Carbon::now()->format('Y-m-d'),

                'end_date' => fn($row) => !empty($row['end_date'])
                    ? Carbon::parse($row['end_date'])->format('Y-m-d')
                    : Carbon::now()->addYear()->format('Y-m-d'),

                'approval_status' => ApprovalStatus::NotApplicable->value,
                'status' => ContractStatus::DRAFT->value,
                'employee_category' => EmployeeCategory::CASUAL->value,
                'remuneration_type' => RemunerationType::DAILY->value,
                'daily_working_hours' => 9.00,
                'created_by' => Auth::user()->id,
            ],
            'lookupFields' => [
                'employee_id' => [
                    'model' => Employee::class,
                    'source_column' => 'code',
                    'target_column' => 'id',
                    'source_field' => 'employee_code',
                ],
                'project_id' => [
                    'model' => Project::class,
                    'source_column' => 'code',
                    'target_column' => 'id',
                    'source_field' => 'project_code',
                ],
                'position_id' => [
                    'model' => Position::class,
                    'source_column' => 'code',
                    'target_column' => 'id',
                    'source_field' => 'position_code',
                ],
            ],
            'customMessages' => [
                'code.unique' => 'Contract code already exists.',
                'employee_id.exists' => 'Employee code not found in employees table.',
                'project_id.exists' => 'Project code not found in projects table.',
                'position_id.exists' => 'Position code not found in positions table.',
                'remuneration.required' => 'Remuneration is required.',
                'start_date.required' => 'Start date is required.',
            ],
            'targetModel' => Contract::class,
        ];
    }

    public function importToArray(): void
    {
        $this->validate();

        try {

            $originalExtension = $this->file->getClientOriginalExtension();
            $filePath = $this->file->store('uploads', 'public');

            $config = $this->contractConfig();

            $this->result = AdvancedImporterHelper::importToArray(
                storage_path('app/public/' . $filePath),
                $config['rules'],
                $config['fieldMap'],
                $config['fixedValues'],
                $config['lookupFields'],
                $config['customMessages'],
                $this->chunkSize,
                null,
                fn($processed, $total) => $this->throttledDispatch($processed, $total)
            );

            if (!empty($this->result['invalid'])) {
                $invalidFilePath = 'imports/invalid_contracts_' . now()->format('YmdHis') . '.xlsx';
                $this->result['invalid'] = array_map(function ($row) {
                    $row['error_message'] = collect($row['errors'] ?? [])->flatten()->implode('; ');
                    return $row;
                }, $this->result['invalid']);


            }

            session()->flash('message', "Preview completed: {$this->result['valid_count']} valid rows, {$this->result['invalid_count']} invalid rows.");

            $this->contractValidData();
//            dd($this->validData);

        } catch (Exception $e) {
            dd($e);
            $this->error = $e->getMessage();
            session()->flash('error', "Preview failed: {$this->error}");
            Log::error("Contract import preview failed", [
                'file' => $filePath,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        } finally {
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
                Log::info("File deleted", [
                    'file' => $filePath,
                ]);
            }
        }
    }

    public function handleImport(): void
    {
        $this->validate();
        $filePath = null;

        try {
            $originalExtension = strtolower($this->file->getClientOriginalExtension());
            $filePath = $this->file->storeAs('imports', uniqid() . '.' . $originalExtension, $this->disk);
            $fullPath = Storage::disk($this->disk)->path($filePath);

            Log::info("File stored", [
                'fullPath' => $fullPath,
                'relativePath' => $filePath,
                'disk' => $this->disk,
                'exists' => Storage::disk($this->disk)->exists($filePath),
                'storageRoot' => Storage::disk($this->disk)->path(''),
            ]);

            if (!Storage::disk($this->disk)->exists($filePath)) {
                throw new Exception("Failed to store file at {$filePath}. Check disk permissions and configuration.");
            }

            $config = $this->contractConfig();

            $this->result = AdvancedImporterHelper::importToDatabase(
                $fullPath,
                $config['targetModel'],
                $config['rules'],
                $config['fieldMap'],
                array_merge($config['fixedValues'], [
                    'code' => fn($row) => isset($row['code']) && !empty($row['code'])
                        ? $row['code']
                        : FormattedCodeHelper::getNextFormattedCode(Contract::class, 'SGA', 5),
                ]),
                $config['lookupFields'],
                $config['customMessages'],
                $this->chunkSize,
                $this->useBatchInsert,
                null,
                $this->format ?: $originalExtension,
                $this->disk,
                $this->dryRun,
                fn($row) => array_merge($row, ['imported_by' => auth()->id()]),
                fn($processed, $total) => $this->throttledDispatch($processed, $total)
            );

            if (!empty($this->result['invalid_rows'])) {
                $invalidFilePath = 'imports/invalid_contracts_' . now()->format('YmdHis') . '.xlsx';
                $this->result['invalid_rows'] = array_map(function ($row) {
                    $row['error_message'] = collect($row['errors'] ?? [])->flatten()->implode('; ');
                    return $row;
                }, $this->result['invalid_rows']);

                AdvancedImporterHelper::exportInvalidRows($this->result['invalid_rows'], $invalidFilePath, $this->disk, 'xlsx');
                $this->result['invalid_file_url'] = Storage::disk($this->disk)->url($invalidFilePath);
            }

            session()->flash('message', $this->dryRun
                ? "Dry run completed: {$this->result['valid_count']} rows would be imported."
                : "Imported {$this->result['inserted']} of {$this->result['valid_count']} valid rows. {$this->result['invalid_count']} rows were invalid."
            );

        } catch (Exception $e) {
            $this->error = $e->getMessage();
            session()->flash('error', "Import failed: {$this->error}");
            Log::error("Contract import failed", [
                'file' => $filePath,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        } finally {
            if ($filePath && Storage::disk($this->disk)->exists($filePath)) {
                Storage::disk($this->disk)->delete($filePath);
                Log::info("File deleted: {$filePath}");
            }
        }
    }

    protected function throttledDispatch(int $processed, int $total): void
    {
        static $lastDispatch = 0;
        if ($processed - $lastDispatch >= 10 || $processed === $total) {
            $lastDispatch = $processed;
            $this->dispatch('import-progress', [
                'processed' => $processed,
                'total' => $total,
                'percentage' => round(($processed / $total) * 100, 2),
            ]);
        }
    }

    #[On('import-progress')]
    public function updateProgress($data)
    {
        $this->result = array_merge($this->result ?? [], [
            'progress' => $data,
        ]);
    }

    public function contractValidData(): void
    {
        $data = collect($this->result['valid'] ?? []);
        // Collect unique IDs
        $employeeIds = $data->pluck('employee_id')->filter()->unique();
        $positionIds = $data->pluck('position_id')->filter()->unique();
        $projectIds  = $data->pluck('project_id')->filter()->unique();

        // Eager-load related data
        $employees = Employee::whereIn('id', $employeeIds)->get()->keyBy('id');
        $positions = Position::whereIn('id', $positionIds)->get()->keyBy('id');
        $projects  = Project::whereIn('id', $projectIds)->get()->keyBy('id');

        // Map contracts with enriched readable values
        $this->formContracts = $data->map(function ($contract) use ($employees, $positions, $projects) {
            $employeeId = $contract['employee_id'] ?? null;
            $positionId = $contract['position_id'] ?? null;
            $projectId  = $contract['project_id'] ?? null;

            return [
                'code' => $contract['code'] ?? null,
                'employee_id' => $employeeId,
                'position_id' => $positionId,
                'project_id' => $projectId,
                'remuneration_type' => $contract['remuneration_type'] ?? null,
                'employee_category' => $contract['employee_category'] ?? null,
                'remuneration' => $contract['remuneration'] ?? null,
                'start_date' => $contract['start_date'] ?? null,
                'end_date' => $contract['end_date'] ?? Carbon::now()->addYear()->format('Y-m-d'),
                'working_hours' => $contract['working_hours'] ?? null,
                'daily_working_hours' => $contract['daily_working_hours'] ?? null,
                'status' => $contract['status'] ?? null,
                'approval_status' => $contract['approval_status'] ?? null,
                'employee_full_name' => $employees[$employeeId]->full_name ?? null,
                'employee_code' => $employees[$employeeId]->code ?? null,
                'position_name' => $positions[$positionId]->name ?? null,
                'project_name' => $projects[$projectId]->name ?? null,
                'created_by' => auth()->user()->id
            ];
        })->toArray();
    }

    public function viewValidItems()
    {
        Flux::modal('validDataView')->show();

    }
    public function viewInvalidItems()
    {
        Flux::modal('invalidDataView')->show();

    }

    public function saveValidData()
    {
        $this->invalidResult = []; // To store failed records
        $successCount = 0;
        $totalRecords = count($this->formContracts);

//        dd($this->formContracts);
        collect($this->formContracts)->chunk($this->chunkSize)->each(function ($chunk) use (&$successCount) {
            DB::transaction(function () use ($chunk, &$successCount) {
                foreach ($chunk as $data) {
                    try {
                        Contract::create($data); // Triggers creating, created, saving, saved events
                        $successCount++;
                    } catch (QueryException $e) {

                        $errorCode = $e->errorInfo[1];
                        $errorMessage = match ($errorCode) {
                            1062 => "Duplicate contract code: {$data['code']}.",
                            1452 => "Invalid reference (employee, project, or position) for contract code: {$data['code']}.",
                            default => "Database error for contract code {$data['code']}: {$e->getMessage()}",
                        };
                        $this->invalidResult[] = array_merge($data, ['error_message' => $errorMessage]);
                        Log::error("Contract creation failed", [

                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                        ]);

                    } catch (Exception $e) {

                        $errorMessage = "Unexpected error for contract code {$data['code']}: {$e->getMessage()}";
                        $this->invalidResult[] = array_merge($data, ['error_message' => $errorMessage]);
                        Log::error("Contract creation failed", [

                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                        ]);
                    }
                }
            });
        });

        $failedCount = count($this->invalidResult);
        if ($failedCount > 0) {
            // Export invalid records to a file, similar to handleImport
//            $invalidFilePath = 'imports/invalid_contracts_save_' . now()->format('YmdHis') . '.xlsx';
//            AdvancedImporterHelper::exportInvalidRows($this->invalidResult, $invalidFilePath, 'public');
//            $this->invalidResult['invalid_file_url'] = Storage::disk('public')->url($invalidFilePath);
        }

//        session()->flash('message', "Imported {$successCount} of {$totalRecords} contracts. {$failedCount} failed.");

        return redirect()->route('contracts');
    }

    public function downloadArrayAsExcel(array $data, string $fileName = 'export')
    {
        try {
            // Define export class
            $export = new class($data, $this->contractConfig()['fieldMap']) implements FromArray, WithHeadings {
                protected $data;
                protected $fieldMap;

                public function __construct(array $data, array $fieldMap)
                {
                    $this->data = $data;
                    $this->fieldMap = array_flip($fieldMap); // Reverse map for display headers
                }

                public function array(): array
                {
                    return $this->data;
                }

                public function headings(): array
                {
                    $headers = array_keys($this->fieldMap);
                    if (!empty($this->data) && array_key_exists('error_message', $this->data[0])) {
                        $headers[] = 'Error Message';
                    }
                    return $headers;
                }
            };

            // Sanitize filename and append timestamp
            $fileName = preg_replace('/[^A-Za-z0-9\-_]/', '', $fileName);
            $fileName = "contracts_{$fileName}_" . now()->format('YmdHis') . '.xlsx';
            $filePath = 'exports/' . $fileName;

            // Store the file temporarily
            Excel::store($export, $filePath, 'public');

        // Log success
        Log::info("Excel file generated", ['file' => $filePath]);

        // Redirect to a route that serves the file
        return $this->redirect(route('download.excel', ['file' => $fileName]), navigate: false);
    } catch (Exception $e) {
            Log::error("Excel download failed", [
                'file' => $fileName,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', "Failed to download Excel file: {$e->getMessage()}");
        }
    }
    public function render(): object
    {
        return view('livewire.contract.contract-import-data', [
            'result' => $this->result??null,
            'error' => $this->error??null,
            'contracts' => $this->formContracts,
            'positions' => Position::all(),
            'remunerationTypes' => RemunerationType::detailedList(),
            'employeeCategories' => EmployeeCategory::detailedList(),
            'contractStatuses' => ContractStatus::detailedList(),
            'projects' => Project::all(),

        ]);
    }
}
