<?php

namespace App\Livewire\Forms;


use App\Enum\ApprovalStatus;
use App\Enum\DeviceStatus;
use App\Models\Device;
use App\Rules\IpWithOptionalPort;
use DateTime;
use Exception;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class DeviceForm extends Form {

    public ?Device $device = null;
    public ?string $id = null;
    public ?string $code = null;
    public ?string $name = null;
    public ?string $description = null;
    public ?string $model = null;
    public ?string $serial_number = null;
    public ?string $ip_address = "192.168.0.20:8080";
    public ?string $mac_address = null;
    public ?string $location = null;
    public DeviceStatus|null $status = DeviceStatus::Unknown;
    public ?DateTime $last_seen_at = null;
    public ?DateTime $last_sync_at = null;
    public ?string $project_id = null;
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
        'model',
        'serial_number',
        'ip_address',
        'mac_address',
        'location',
        'status',
        'last_seen_at',
        'last_sync_at',
        'project_id',
        'approval_status',
        'is_locked',
        'locked_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    /** @return array<string, array<int, string>> */
    public function rules(): array {
        return [
            'code' => ['nullable','string','max:255',Rule::unique('devices', 'code')->ignore($this->id),],
            'name' => ['required','string','max:255'],
            'project_id' => ['required','string','max:255',Rule::exists('projects', 'id')],
            'ip_address' => ['nullable', 'regex:/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}' .
                '(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(:\d{1,5})?$/'],
            'mac_address' => ['nullable', 'mac_address'],
            'last_seen_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'last_sync_at' => ['nullable', 'date_format:Y-m-d H:i:s'],

        ];
    }

    /** @return array<string, string> */
    public function messages(): array {
        return [
            'code.unique' => 'The code has already been taken.',
            'name.required' => 'The name field is required.',
            'name.max' => 'The name must not be greater than 255 characters.',
            'project_id.required' => 'The project field is required.',
            'project_id.exists' => 'The selected project does not exist.',
            'ip_address.ip_with_optional_port' => 'The ip address must be a valid IP address.',
            'mac_address.mac_address' => 'The mac address must be a valid MAC address.',
            'last_seen_at.date_format' => 'The last seen at field must be a valid date.',
            'last_sync_at.date_format' => 'The last sync at field must be a valid date.',
        ];
    }

    public function setData(Device $device): void {
        $this->device = $device;
        $this->id = $device->id;
        $this->code = $device->code;
        $this->name = $device->name;
        $this->description = $device->description;
        $this->model = $device->model;
        $this->serial_number = $device->serial_number;
        $this->ip_address = $device->ip_address;
        $this->mac_address = $device->mac_address;
        $this->location = $device->location;
        $this->status = $device->status;
        $this->last_seen_at = $device->last_seen_at;
        $this->last_sync_at = $device->last_sync_at;
        $this->project_id = $device->project_id;
        $this->approval_status = $device->approval_status;
        $this->is_locked = $device->is_locked;
        $this->locked_by = $device->locked_by;
        $this->created_by = $device->created_by;
        $this->updated_by = $device->updated_by;
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

            $this->backupFormData(); // Backup before operation
            $device = Device::create($this->only($this->fillableData));

            $this->clearData();
            return [
                'success' => true,
                'device' => $device,
                'message' => 'Device created successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Device creation failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to create device: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'device' => null,
                'message' => 'Failed to create device: ' . $e->getMessage(),
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
            $this->device->update($this->only($this->fillableData));
            $this->clearData();
            return [
                'success' => true,
                'device' => $this->device,
                'message' => 'Device updated successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Device update failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'device' => null,
                'message' => 'Failed to update device: ' . $e->getMessage(),
            ];
        }
    }

    public function clearData(): void
    {
        $this->reset();
        $this->device = null; // Ensure device is reset
    }
}
