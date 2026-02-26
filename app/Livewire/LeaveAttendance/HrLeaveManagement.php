<?php

namespace App\Livewire\LeaveAttendance;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Enum\LeaveStatus;
use App\Enum\ApprovalStatus;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

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
            $request = LeaveRequest::find($requestId);
            if ($request) {
                \Log::info('Found request, current status: ' . $request->status->value);
                $request->update([
                    'status' => LeaveStatus::APPROVED->value,
                    'approval_status' => ApprovalStatus::Approved->value,
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                ]);
                \Log::info('Request approved successfully');

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
