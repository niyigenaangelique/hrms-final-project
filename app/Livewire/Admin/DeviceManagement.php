<?php

namespace App\Livewire\Admin;

use App\Models\Device;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;

#[Title('SGA | C-HRMS | Device Management')]
#[Layout('components.layouts.admin')]
class DeviceManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';

    // Modal
    public $showModal = false;
    public $editingId = null;

    // Form fields
    public $name = '';
    public $ip_address = '';
    public $mac_address = '';
    public $location = '';
    public $project_id = '';
    public $status = 'offline';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        if ($id) {
            $device = Device::findOrFail($id);
            $this->editingId = $device->id;
            $this->name = $device->name;
            $this->ip_address = $device->ip_address;
            $this->mac_address = $device->mac_address;
            $this->location = $device->location;
            $this->project_id = $device->project_id;
            $this->status = $device->status ?? 'offline';
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->editingId = null;
        $this->name = '';
        $this->ip_address = '';
        $this->mac_address = '';
        $this->location = '';
        $this->project_id = '';
        $this->status = 'offline';
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'ip_address' => 'required|ip',
            'mac_address' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'project_id' => 'required|exists:projects,id',
            'status' => 'required|in:online,offline,unknown',
        ]);

        $data = [
            'name' => $this->name,
            'ip_address' => $this->ip_address,
            'mac_address' => $this->mac_address,
            'location' => $this->location,
            'project_id' => $this->project_id,
            'status' => $this->status,
        ];

        if (!$this->editingId) {
            $data['code'] = 'DEV-' . Str::upper(Str::random(6));
        }

        if ($this->editingId) {
            Device::findOrFail($this->editingId)->update($data);
            session()->flash('success', 'Device updated successfully.');
        } else {
            Device::create($data);
            session()->flash('success', 'Device added successfully.');
        }

        $this->closeModal();
    }

    public function delete($id)
    {
        Device::findOrFail($id)->delete();
        session()->flash('success', 'Device deleted successfully.');
    }

    public function render()
    {
        $query = Device::with('project');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('ip_address', 'like', '%' . $this->search . '%')
                  ->orWhere('location', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $devices = $query->orderBy('name')->paginate(15);
        $projects = Project::orderBy('name')->get();

        return view('livewire.admin.device-management', [
            'devices' => $devices,
            'projects' => $projects,
        ]);
    }
}
