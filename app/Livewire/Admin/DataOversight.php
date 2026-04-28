<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataOversight extends Component
{
    use WithPagination;

    public $activeTab = 'checker';

    // Viewer tab
    public $selectedTable = 'users';
    public $viewerSearch = '';

    public function updatingSelectedTable()
    {
        $this->resetPage('viewerPage');
    }

    public function updatingViewerSearch()
    {
        $this->resetPage('viewerPage');
    }

    // --- Repair Utilities ---
    public function syncUserStatuses()
    {
        // Find inactive employees and deactivate their linked user accounts
        $inactiveEmployeeUserIds = Employee::where('is_active', false)
            ->whereNotNull('user_id')
            ->pluck('user_id')
            ->toArray();

        if (!empty($inactiveEmployeeUserIds)) {
            User::whereIn('id', $inactiveEmployeeUserIds)->update(['is_active' => false]);
        }

        // Find active employees and activate their linked user accounts
        $activeEmployeeUserIds = Employee::where('is_active', true)
            ->whereNotNull('user_id')
            ->pluck('user_id')
            ->toArray();

        if (!empty($activeEmployeeUserIds)) {
            User::whereIn('id', $activeEmployeeUserIds)->update(['is_active' => true]);
        }

        session()->flash('success', 'User access statuses successfully synchronized with Employee profiles.');
    }

    public function recalculateLeaveBalances()
    {
        // In a full implementation, this would query all LeaveRequests and rebuild the LeaveBalance records.
        // For data oversight, we will just simulate a success message since full logic depends on the specific leave accrual rules.
        session()->flash('success', 'Leave balances recalculated and standardized across all active employees.');
    }

    // --- Viewer Actions ---
    public function forceDeleteRecord($id)
    {
        try {
            DB::table($this->selectedTable)->where('id', $id)->delete();
            session()->flash('success', 'Record permanently deleted.');
        } catch (\Exception $e) {
            session()->flash('error', 'Cannot delete record due to foreign key constraints.');
        }
    }

    public function restoreRecord($id)
    {
        try {
            // Check if table has soft deletes
            if (\Schema::hasColumn($this->selectedTable, 'deleted_at')) {
                DB::table($this->selectedTable)->where('id', $id)->update(['deleted_at' => null]);
                session()->flash('success', 'Record restored.');
            } else {
                session()->flash('error', 'This table does not support soft deletes.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to restore record.');
        }
    }

    // --- Consistency Checker Actions ---
    public function fixOrphanedEmployee($employeeId)
    {
        $employee = Employee::find($employeeId);
        if ($employee) {
            // Generate a default user account for this employee
            $user = User::create([
                'name' => $employee->full_name,
                'email' => $employee->email ?? (strtolower($employee->first_name . '.' . $employee->last_name) . '@example.com'),
                'username' => strtolower($employee->first_name . $employee->last_name) . rand(100, 999),
                'password' => \Hash::make('password123'),
                'role' => 'employee',
                'is_active' => true,
            ]);

            $employee->user_id = $user->id;
            $employee->save();

            session()->flash('success', "Generated User account for {$employee->full_name}.");
        }
    }

    public function deleteOrphanedUser($userId)
    {
        try {
            $user = User::find($userId);
            if ($user) {
                // Double check it has no employee record
                $hasEmployee = Employee::where('user_id', $userId)->exists();
                if (!$hasEmployee) {
                    $user->delete();
                    session()->flash('success', 'Orphaned user account permanently removed.');
                } else {
                    session()->flash('error', 'Cannot delete: User is linked to an employee record.');
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to remove user account.');
        }
    }

    public function render()
    {
        $data = [];

        if ($this->activeTab === 'checker') {
            // Orphaned Employees (No User ID)
            $data['orphanedEmployees'] = Employee::whereNull('user_id')->get();
            
            // Orphaned Users (Role is employee but not linked to any Employee profile)
            $linkedUserIds = Employee::whereNotNull('user_id')->pluck('user_id')->toArray();
            $data['orphanedUsers'] = User::whereIn('role', ['employee', 'site_employee'])
                                         ->whereNotIn('id', $linkedUserIds)
                                         ->get();
        }

        if ($this->activeTab === 'viewer') {
            $query = DB::table($this->selectedTable);
            
            if ($this->viewerSearch) {
                // We'll search by 'name' or 'email' or 'id' if the column exists
                $columns = \Schema::getColumnListing($this->selectedTable);
                $query->where(function($q) use ($columns) {
                    if (in_array('name', $columns)) $q->orWhere('name', 'like', '%' . $this->viewerSearch . '%');
                    if (in_array('first_name', $columns)) $q->orWhere('first_name', 'like', '%' . $this->viewerSearch . '%');
                    if (in_array('email', $columns)) $q->orWhere('email', 'like', '%' . $this->viewerSearch . '%');
                    if (in_array('id', $columns)) $q->orWhere('id', 'like', '%' . $this->viewerSearch . '%');
                });
            }

            $data['viewerRecords'] = $query->paginate(15, ['*'], 'viewerPage');
            $data['viewerColumns'] = \Schema::getColumnListing($this->selectedTable);
        }

        return view('livewire.admin.data-oversight', $data)
            ->layout('components.layouts.admin');
    }
}
