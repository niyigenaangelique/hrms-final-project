<?php

namespace App\Livewire\Admin;

use App\Models\LeaveType;
use App\Models\SystemSetting;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;

#[Title('SGA | C-HRMS | Company Policy')]
#[Layout('components.layouts.admin')]
class CompanyPolicy extends Component
{
    use WithPagination;

    public $activeTab = 'general';

    // General Policies
    public $grace_period = 15;
    public $ot_multiplier = 1.5;

    // Leave Types Modal
    public $showLeaveModal = false;
    public $editingLeaveId = null;

    // Leave Type form fields
    public $leave_name = '';
    public $leave_default_days = 0;
    public $leave_is_paid = true;
    public $leave_requires_approval = true;
    public $leave_is_active = true;

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $this->grace_period = SystemSetting::getSetting('attendance_grace_period', 15);
        $this->ot_multiplier = SystemSetting::getSetting('overtime_multiplier', 1.5);
    }

    public function saveSettings()
    {
        SystemSetting::setSetting('attendance_grace_period', $this->grace_period, 'integer', 'attendance');
        SystemSetting::setSetting('overtime_multiplier', $this->ot_multiplier, 'string', 'payroll');
        
        session()->flash('success', 'General policies updated successfully.');
    }

    public function openLeaveModal($id = null)
    {
        $this->resetLeaveForm();
        if ($id) {
            $leave = LeaveType::findOrFail($id);
            $this->editingLeaveId = $leave->id;
            $this->leave_name = $leave->name;
            $this->leave_default_days = $leave->default_days;
            $this->leave_is_paid = $leave->is_paid;
            $this->leave_requires_approval = $leave->requires_approval;
            $this->leave_is_active = $leave->is_active;
        }
        $this->showLeaveModal = true;
    }

    public function closeLeaveModal()
    {
        $this->showLeaveModal = false;
        $this->resetLeaveForm();
    }

    private function resetLeaveForm()
    {
        $this->editingLeaveId = null;
        $this->leave_name = '';
        $this->leave_default_days = 0;
        $this->leave_is_paid = true;
        $this->leave_requires_approval = true;
        $this->leave_is_active = true;
        $this->resetValidation();
    }

    public function saveLeaveType()
    {
        $this->validate([
            'leave_name' => 'required|string|max:255',
            'leave_default_days' => 'required|integer|min:0',
            'leave_is_paid' => 'boolean',
            'leave_requires_approval' => 'boolean',
            'leave_is_active' => 'boolean',
        ]);

        $data = [
            'name' => $this->leave_name,
            'default_days' => $this->leave_default_days,
            'is_paid' => $this->leave_is_paid,
            'requires_approval' => $this->leave_requires_approval,
            'is_active' => $this->leave_is_active,
        ];

        if (!$this->editingLeaveId) {
            $data['code'] = Str::slug($this->leave_name) . '-' . Str::random(4);
        }

        if ($this->editingLeaveId) {
            LeaveType::findOrFail($this->editingLeaveId)->update($data);
            session()->flash('success', 'Leave type updated successfully.');
        } else {
            LeaveType::create($data);
            session()->flash('success', 'Leave type created successfully.');
        }

        $this->closeLeaveModal();
    }

    public function deleteLeaveType($id)
    {
        LeaveType::findOrFail($id)->delete();
        session()->flash('success', 'Leave type deleted successfully.');
    }

    public function render()
    {
        $leaveTypes = LeaveType::orderBy('name')->get();

        return view('livewire.admin.company-policy', [
            'leaveTypes' => $leaveTypes,
        ]);
    }
}
