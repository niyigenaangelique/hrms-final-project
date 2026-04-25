<?php

namespace App\Livewire\LeaveAttendance;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Enum\LeaveStatus;
use App\Enum\ApprovalStatus;
use App\Services\LeaveService;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

#[Title('TalentFlow Pro | HR Leave Management')]
class HrLeaveManagement extends Component
{
    public $leaveRequests;
    public $leaveTypes;
    public $selectedRequest = null;
    public $filterStatus = 'all';
    public $searchTerm = '';
    public $rejectionReason = '';
    public $rejectModalOpen = false;
    public $rejectingRequestId = null;
    public $showBalanceInfo = false;
    public $selectedEmployeeBalance = null;

    public function mount()
    {
        $this->loadLeaveRequests();
        $this->leaveTypes = LeaveType::where('is_active', true)->get();
    }

    public function loadLeaveRequests()
    {
        $query = LeaveRequest::with(['employee', 'leaveType']);

        // Filter by status
        if ($this->filterStatus !== 'all') {
            $query->where('status', $this->filterStatus);
        }

        // Search by employee name or leave type
        if ($this->searchTerm) {
            $query->whereHas('employee', function($q) {
                $q->where('first_name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            })->orWhereHas('leaveType', function($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%');
            });
        }

        $this->leaveRequests = $query->orderBy('created_at', 'desc')->get();
    }

    public function openRejectModal($requestId)
    {
        $this->rejectingRequestId = $requestId;
        $this->rejectModalOpen = true;
        $this->rejectionReason = '';
    }

    public function closeRejectModal()
    {
        $this->rejectModalOpen = false;
        $this->rejectingRequestId = null;
        $this->rejectionReason = '';
    }

    public function confirmReject()
    {
        $this->validate([
            'rejectionReason' => 'required|string|max:500'
        ]);

        try {
            \Log::info('Rejecting leave request: ' . $this->rejectingRequestId);
            $request = LeaveRequest::find($this->rejectingRequestId);
            if ($request) {
                \Log::info('Found request, current status: ' . $request->status->value);
                $request->update([
                    'status' => LeaveStatus::REJECTED->value,
                    'approval_status' => ApprovalStatus::Rejected->value,
                    'rejection_reason' => $this->rejectionReason,
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                ]);
                \Log::info('Request rejected successfully');

                $this->closeRejectModal();
                $this->loadLeaveRequests();
                session()->flash('success', 'Leave request rejected successfully!');
            } else {
                \Log::error('Leave request not found: ' . $this->rejectingRequestId);
                session()->flash('error', 'Leave request not found.');
            }
        } catch (\Exception $e) {
            \Log::error('Leave rejection failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Failed to reject leave request: ' . $e->getMessage());
        }
    }

    public function setSelectedRequest($requestId)
    {
        $this->selectedRequest = $requestId;
        // Now approve the request
        $this->approveRequest($requestId);
    }

    public function approveRequest($requestId)
    {
        try {
            \Log::info('Approving leave request: ' . $requestId);
            $request = LeaveRequest::with(['employee', 'leaveType'])->find($requestId);
            if ($request) {
                \Log::info('Found request, current status: ' . $request->status->value);
                
                // Validate leave request before approval
                $validation = LeaveService::validateLeaveRequest(
                    $request->employee,
                    $request->leaveType,
                    \Carbon\Carbon::parse($request->start_date),
                    \Carbon\Carbon::parse($request->end_date),
                    $request->total_days
                );

                if (!$validation['valid']) {
                    $errorMessage = "Cannot approve leave request:\n" . implode("\n", $validation['errors']);
                    session()->flash('error', $errorMessage);
                    return;
                }

                // Check for warnings
                if (!empty($validation['warnings'])) {
                    $warningMessage = "Warning:\n" . implode("\n", $validation['warnings']);
                    session()->flash('warning', $warningMessage);
                }

                // Approve the request
                $request->update([
                    'status' => LeaveStatus::APPROVED->value,
                    'approval_status' => ApprovalStatus::Approved->value,
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                ]);
                \Log::info('Request approved successfully');

                // Update leave balance
                LeaveService::updateLeaveBalance($request);

                // Check for exceeded limits
                LeaveService::checkLeaveLimitExceeded($request);

                $this->loadLeaveRequests();
                session()->flash('success', 'Leave request approved successfully!');
            } else {
                \Log::error('Leave request not found: ' . $requestId);
                session()->flash('error', 'Leave request not found.');
            }
        } catch (\Exception $e) {
            \Log::error('Leave approval failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Failed to approve leave request: ' . $e->getMessage());
        }
    }

    public function rejectRequest()
    {
        $this->validate([
            'rejectionReason' => 'required|string|max:500'
        ]);

        try {
            \Log::info('Rejecting leave request: ' . $this->selectedRequest);
            $request = LeaveRequest::find($this->selectedRequest);
            if ($request) {
                \Log::info('Found request, current status: ' . $request->status);
                $request->update([
                    'status' => LeaveStatus::REJECTED->value,
                    'approval_status' => ApprovalStatus::Rejected->value,
                    'rejection_reason' => $this->rejectionReason,
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                ]);
                \Log::info('Request rejected successfully');

                $this->selectedRequest = null;
                $this->rejectionReason = '';
                $this->loadLeaveRequests();
                session()->flash('success', 'Leave request rejected successfully!');
            } else {
                \Log::error('Leave request not found: ' . $this->selectedRequest);
            }
        } catch (\Exception $e) {
            \Log::error('Leave rejection failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Failed to reject leave request: ' . $e->getMessage());
        }
    }

    public function setViewRequest($requestId)
    {
        session()->flash('success', 'View button clicked for request: ' . $requestId);
        $this->selectedRequest = $requestId;
        $this->rejectionReason = '';
    }

    public function viewRequest($requestId)
    {
        session()->flash('success', 'View button clicked for request: ' . $requestId);
        $this->selectedRequest = $requestId;
        $this->rejectionReason = '';
    }

    public function closeModal()
    {
        $this->selectedRequest = null;
        $this->rejectionReason = '';
    }

    public function showEmployeeBalance($employeeId)
    {
        $employee = Employee::find($employeeId);
        if ($employee) {
            $this->selectedEmployeeBalance = [
                'employee' => $employee,
                'balances' => []
            ];

            // Get ALL active leave types
            $allLeaveTypes = \App\Models\LeaveType::where('is_active', true)->get();
            $currentYear = \Carbon\Carbon::now()->year;

            foreach ($allLeaveTypes as $leaveType) {
                // Check if employee is eligible for this leave type (gender restriction)
                $isEligible = true;
                if ($leaveType->gender_restriction) {
                    if ($leaveType->gender_restriction === 'male' && strtolower($employee->gender) !== 'male') {
                        $isEligible = false;
                    }
                    if ($leaveType->gender_restriction === 'female' && strtolower($employee->gender) !== 'female') {
                        $isEligible = false;
                    }
                }

                // Get or create balance for this leave type
                $balance = \App\Models\LeaveBalance::where('employee_id', $employeeId)
                    ->where('leave_type_id', $leaveType->id)
                    ->where('year', $currentYear)
                    ->first();

                if (!$balance && $isEligible) {
                    // Create balance if not exists and employee is eligible
                    $totalDays = $leaveType->default_days ?? 0;
                    $balance = \App\Models\LeaveBalance::create([
                        'employee_id' => $employeeId,
                        'leave_type_id' => $leaveType->id,
                        'code' => 'BAL-' . $employee->code . '-' . $leaveType->id . '-' . $currentYear,
                        'total_days' => $totalDays,
                        'used_days' => 0,
                        'balance_days' => $totalDays,
                        'carried_forward_days' => 0,
                        'year' => $currentYear,
                        'created_by' => \Illuminate\Support\Facades\Auth::id() ?? 1,
                    ]);
                }

                // Calculate used days for this year
                $usedDays = \App\Models\LeaveRequest::where('employee_id', $employeeId)
                    ->where('leave_type_id', $leaveType->id)
                    ->where('status', \App\Enum\LeaveStatus::APPROVED->value)
                    ->whereYear('start_date', $currentYear)
                    ->sum('total_days');

                // Prepare balance data
                $balanceData = [
                    'leave_type' => $leaveType->name,
                    'total_days' => $balance ? $balance->total_days : ($leaveType->default_days ?? 0),
                    'used_days' => $usedDays,
                    'balance_days' => $balance ? $balance->balance_days : (($leaveType->default_days ?? 0) - $usedDays),
                    'carried_forward' => $balance ? $balance->carried_forward_days : 0,
                    'max_days_per_year' => $leaveType->max_days_per_year,
                    'requires_medical_document' => $leaveType->requires_medical_document,
                    'auto_approve' => $leaveType->auto_approve,
                    'is_eligible' => $isEligible,
                ];

                // Always add to balances array (even if not eligible, show with note)
                $this->selectedEmployeeBalance['balances'][] = $balanceData;
            }

            // Sort by leave type name
            usort($this->selectedEmployeeBalance['balances'], function($a, $b) {
                return strcmp($a['leave_type'], $b['leave_type']);
            });

            $this->showBalanceInfo = true;
        }
    }

    public function closeBalanceInfo()
    {
        $this->showBalanceInfo = false;
        $this->selectedEmployeeBalance = null;
    }

    public function updatedFilterStatus()
    {
        $this->loadLeaveRequests();
    }

    public function updatedSearchTerm()
    {
        $this->loadLeaveRequests();
    }

    public function render()
    {
        return view('livewire.leave-attendance.hr-leave-management');
    }
}
