<?php

namespace App\Livewire\Forms;


use App\Enum\ApprovalStatus;
use App\Enum\ProjectStatus;
use App\Models\Project;
use DateTime;
use Exception;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class ProjectForm extends Form {

    public ?Project $project = null;
    public ?string $id = null;
    public ?string $code = null;
    public ?string $name = null;
    public ?string $description = null;
    public ProjectStatus $status = ProjectStatus::NotStarted;
    public ?Carbon $start_date = null;
    public ?Carbon $end_date = null;
    public ?string $address = null;
    public ?string $city = null;
    public ?string $state = null;
    public ?string $country = null;
    public ?string $manager_id = null;
    public ApprovalStatus|null $approval_status = ApprovalStatus::NotApplicable;
    public ?bool $is_locked = false;
    public ?string $locked_by = null;
    public ?string $created_by = null;
    public ?string $updated_by = null;
    public ?string $deleted_by = null;

    protected array $fillableData = [
        'code',
        'name',
        'description',
        'status',
        'approval_status',
        'start_date',
        'end_date',
        'address',
        'city',
        'state',
        'country',
        'manager_id',
        'is_locked',
        'locked_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /** @return array<string, array<int, string>> */
    public function rules(): array {
        return [
            'code' => ['nullable','string','max:255',Rule::unique('projects', 'code')->ignore($this->id),],
            'name' => ['required','string','max:255'],
            'description' => ['nullable','string'],
            'status' => ['required'],
            'start_date' => ['nullable','date'],
            'end_date' => ['nullable','date','after:start_date'],
            'manager_id' => ['nullable','string','max:255',Rule::exists('users', 'id')],


        ];
    }

    /** @return array<string, string> */
    public function messages(): array {
        return [
            'code.required' => 'Code is required',
            'name.required' => 'Name is required',
            'status.required' => 'Status is required',
            'start_date.date' => 'Start date must be a valid date',
            'end_date.date' => 'End date must be a valid date',
            'end_date.after' => 'End date must be after start date',
            'manager_id.exists' => 'Manager ID does not exist',
            'code.unique' => 'Code must be unique',
            'code.max' => 'Code must not exceed 255 characters',
            'name.max' => 'Name must not exceed 255 characters',
            'description.max' => 'Description must not exceed 255 characters',
            'address.max' => 'Address must not exceed 255 characters',
        ];
    }

    public function setData(Project $project): void {
        $this->project = $project;
        $this->id = $project->id;
        $this->code = $project->code;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->status = $project->status;
        $this->approval_status = $project->approval_status;
        $this->start_date = $project->start_date;
        $this->end_date = $project->end_date;
        $this->address = $project->address;
        $this->city = $project->city;
        $this->state = $project->state;
        $this->country = $project->country;
        $this->manager_id = $project->manager_id;
        $this->is_locked = $project->is_locked;
        $this->locked_by = $project->locked_by;
        $this->created_by = $project->created_by;
        $this->updated_by = $project->updated_by;
        $this->deleted_by = $project->deleted_by;
    }

    protected array $backupData = [];

    public function backupFormData(): void {
        $this->backupData = $this->only($this->fillableData);
    }

    public function restoreFormData(): void {
        foreach ($this->backupData as $key => $value) {
            $this->$key = $value;
        }
    }

    public function storeData(): array {
        try {
            $this->validate();
            $excludeFields = [];
            $this->fillableData = array_diff($this->fillableData, $excludeFields);
            $this->fillableData = array_values($this->fillableData);

            if(!$this->approval_status)
                $this->approval_status=ApprovalStatus::NotApplicable;
            if (!$this->is_locked)
                $this->is_locked = false;

            $this->backupFormData(); // Backup before operation
            $project = Project::create($this->only($this->fillableData));

            $this->clearData();
            return [
                'success' => true,
                'project' => $project,
                'message' => 'Project created successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Project creation failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to create project: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'project' => null,
                'message' => 'Failed to create project: ' . $e->getMessage(),
            ];
        }
    }



    public function updateData(): array
    {
        try {
            $this->validate();
            $this->backupFormData(); // Backup before operation
            $excludeFields = [];
            $this->fillableData = array_diff($this->fillableData, $excludeFields);
            $this->fillableData = array_values($this->fillableData);
            $this->project->update($this->only($this->fillableData));
            $this->clearData();
            return [
                'success' => true,
                'project' => $this->project,
                'message' => 'Project updated successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Project update failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'project' => null,
                'message' => 'Failed to update project: ' . $e->getMessage(),
            ];
        }
    }

    public function clearData(): void
    {
        $this->reset();
        $this->project = null; // Ensure project is reset
    }
}
