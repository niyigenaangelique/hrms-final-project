<?php

namespace App\Livewire\LeaveAttendance;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('SGA | C-HRMS | ManageLeavesAttendances')]

class ManageLeavesAttendance extends Component
{
    use WithPagination;
    public $messageText = '';
    public $selectedUserId = null;
    public $selectedConversation = null;
    public $conversationMessages = null;
    public $activeSection = 'overview';
    
    // Leave balance properties
    public $leaveTab = 'balance';
    public $balEmpId = null;
    public $balYear;
    public $balEmployee = null;
    public $empLeaveData = null;
    public $totalUsedAll = 0;
    public $totalRemAll = 0;
    public $annualCap = 30; // Default value
    
    // Annual leave cap will be calculated dynamically per employee

    #[On('manage_leaves_attendanceNotification')]
    public function handleNotification(): void
    {
    }

    public function mount()
    {
        $this->balYear = now()->year;
        $this->balEmpId = request('bal_emp');
        $this->leaveTab = request('leave_tab', 'balance');
        $this->activeSection = request('section', 'leaves'); // Default to leaves section
        
        // Auto-select first conversation if available
        $this->loadInitialConversation();
        
        // Load leave balance data if employee is selected
        if ($this->balEmpId) {
            $this->loadLeaveBalanceData();
        }
    }

    public function loadInitialConversation()
    {
        $firstMsg = \App\Models\Message::where(fn($q) => $q->where('sender_id', auth()->id())->orWhere('receiver_id', auth()->id()))
            ->orderBy('created_at', 'desc')->first();
            
        if ($firstMsg) {
            $pid = $firstMsg->sender_id === auth()->id() ? $firstMsg->receiver_id : $firstMsg->sender_id;
            $this->selectedConversation = $pid;
            $this->loadConversationMessages($pid);
        }
    }

    public function switchSection($section)
    {
        $this->activeSection = $section;
        $this->dispatch('sectionChanged', section: $section);
    }

    public function selectConversation($personId)
    {
        $this->activeSection = 'communication';
        $this->selectedConversation = $personId;
        $this->loadConversationMessages($personId);
        $this->dispatch('sectionChanged', section: 'communication');
    }

    public function loadConversationMessages($personId)
    {
        $this->conversationMessages = \App\Models\Message::with(['sender', 'receiver'])
            ->where(function($query) use ($personId) {
                $query->where(function($q) use ($personId) {
                    $q->where('sender_id', auth()->id())->where('receiver_id', $personId);
                })->orWhere(function($q) use ($personId) {
                    $q->where('sender_id', $personId)->where('receiver_id', auth()->id());
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark all messages in this conversation as read
        \App\Models\Message::where('receiver_id', auth()->id())
            ->where('sender_id', $personId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'updated_by' => auth()->id()
            ]);
            
        $this->dispatch('chatUpdated');
    }

    public function sendMessage()
    {
        if (!$this->selectedConversation) return;

        $this->validate([
            'messageText' => 'required|string|max:1000',
        ]);

        \App\Models\Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedConversation,
            'subject' => 'HR Communication',
            'message' => $this->messageText,
            'status' => 'sent',
            'is_read' => false,
            'created_by' => auth()->id(),
        ]);

        $this->messageText = '';
        $this->activeSection = 'communication';
        $this->loadConversationMessages($this->selectedConversation);
        $this->dispatch('sectionChanged', section: 'communication');
    }

    public function loadLeaveBalanceData()
    {
        if (!$this->balEmpId) return;
        
        $this->balEmployee = \App\Models\Employee::find($this->balEmpId);
        if (!$this->balEmployee) return;
        
        // Get all leave balances for this employee
        $currentYear = $this->balYear;
        $allLeaveTypes = \App\Models\LeaveType::where('is_active', true)->get();
        
        $this->empLeaveData = collect();
        $this->totalUsedAll = 0;
        $this->totalRemAll = 0;
        
        foreach ($allLeaveTypes as $leaveType) {
            // Check gender eligibility
            $isEligible = true;
            if ($leaveType->gender_restriction) {
                if ($leaveType->gender_restriction === 'male' && strtolower($this->balEmployee->gender) !== 'male') {
                    $isEligible = false;
                }
                if ($leaveType->gender_restriction === 'female' && strtolower($this->balEmployee->gender) !== 'female') {
                    $isEligible = false;
                }
            }
            
            if (!$isEligible) continue;
            
            // Get or create balance
            $balance = \App\Models\LeaveBalance::where('employee_id', $this->balEmpId)
                ->where('leave_type_id', $leaveType->id)
                ->where('year', $currentYear)
                ->first();
                
            if (!$balance) {
                $totalDays = $leaveType->default_days ?? 0;
                $balance = \App\Models\LeaveBalance::create([
                    'code' => 'LB-' . $this->balEmployee->code . '-' . $leaveType->code . '-' . $currentYear,
                    'employee_id' => $this->balEmpId,
                    'leave_type_id' => $leaveType->id,
                    'total_days' => $totalDays,
                    'used_days' => 0,
                    'balance_days' => $totalDays,
                    'carried_forward_days' => 0,
                    'year' => $currentYear,
                    'created_by' => auth()->id(),
                ]);
            }
            
            // Get leave requests for this type
            $requests = \App\Models\LeaveRequest::where('employee_id', $this->balEmpId)
                ->where('leave_type_id', $leaveType->id)
                ->whereYear('start_date', $currentYear)
                ->orderBy('start_date', 'desc')
                ->get();
            
            $usedDays = $requests->where('status', \App\Enum\LeaveStatus::APPROVED->value)->sum('total_days');
            
                        
            // For Vacation leave, also get Annual leave requests since Vacation uses Annual balance
            if ($leaveType->code === 'VACATION') {
                $annualRequests = \App\Models\LeaveRequest::where('employee_id', $this->balEmpId)
                    ->where('leave_type_id', function($query) {
                        $query->select('id')->from('leave_types')->where('code', 'ANNUAL')->where('is_active', true);
                    })
                    ->whereYear('start_date', $currentYear)
                    ->where('status', \App\Enum\LeaveStatus::APPROVED->value)
                    ->orderBy('start_date', 'desc')
                    ->get();
                $usedDays += $annualRequests->sum('total_days');
            }
            
            // For unlimited leave types, set remaining as null first
            if (in_array($leaveType->code, ['SICK', 'BEREAVEMENT'])) {
                $totalDays = null;
                $remainingDays = null;
            } else {
                // Calculate remaining days correctly
                if ($leaveType->code === 'VACATION') {
                    // Vacation uses Annual leave balance
                    $annualBalance = \App\Models\LeaveBalance::where('employee_id', $this->balEmpId)
                        ->where('leave_type_id', function($query) {
                            $query->select('id')->from('leave_types')->where('code', 'ANNUAL')->where('is_active', true);
                        })
                        ->where('year', $currentYear)
                        ->first();
                    
                    $totalDays = $annualBalance ? ($annualBalance->total_days ?? 0) : 30;
                    $remainingDays = $annualBalance ? ($annualBalance->balance_days ?? $totalDays) : $totalDays;
                } else {
                    $totalDays = $balance ? ($balance->total_days ?? 0) : ($leaveType->default_days ?? 0);
                    // Calculate remaining dynamically: total - used
                    $remainingDays = $totalDays - $usedDays;
                }
            }
            
            $this->empLeaveData->push([
                'type' => $leaveType,
                'balance' => $balance,
                'requests' => $requests,
                'used' => $usedDays,
                'remaining' => $remainingDays,
                'total_days' => $totalDays,
                'max_days_per_year' => $leaveType->max_days_per_year,
                'requires_medical_document' => $leaveType->requires_medical_document,
                'auto_approve' => $leaveType->auto_approve,
            ]);
            
            // Annual and Personal leave both count toward the annual entitlement totals
            if (in_array($leaveType->code, ['ANNUAL', 'PERSONAL'])) {
                $this->totalUsedAll += $usedDays;
                $this->totalRemAll += $remainingDays;
            }
        }
        
        // Set the annual cap for this employee
        $this->annualCap = $this->getAnnualCap();
    }

    /**
     * Get annual leave cap for the selected employee
     * Returns the total_days from ANNUAL leave balance or defaults to 30
     */
    public function getAnnualCap()
    {
        if (!$this->balEmpId) return 30;
        
        $annualLeaveType = \App\Models\LeaveType::where('code', 'ANNUAL')
            ->where('is_active', true)
            ->first();
            
        if (!$annualLeaveType) return 30;
        
        $annualBalance = \App\Models\LeaveBalance::where('employee_id', $this->balEmpId)
            ->where('leave_type_id', $annualLeaveType->id)
            ->where('year', $this->balYear)
            ->first();
            
        return $annualBalance ? ($annualBalance->total_days ?? 30) : 30;
    }

    public function updatedBalEmpId()
    {
        $this->loadLeaveBalanceData();
    }

    public function updatedBalYear()
    {
        $this->loadLeaveBalanceData();
    }

    public function approveLeave($id)
    {
        $leaveRequest = \App\Models\LeaveRequest::with('employee')->find($id);
        if ($leaveRequest && $leaveRequest->status === \App\Enum\LeaveStatus::PENDING) {
            $leaveRequest->update([
                'status' => \App\Enum\LeaveStatus::APPROVED->value,
                'approval_status' => \App\Enum\ApprovalStatus::Approved->value,
                'approved_by' => auth()->id(),
                'approved_at' => now(),
                'updated_by' => auth()->id()
            ]);

            // Update leave balance
            try {
                \App\Services\LeaveService::updateLeaveBalance($leaveRequest);
            } catch (\Exception $e) {
                \Log::error('Failed to update leave balance: ' . $e->getMessage());
            }

            // Notify employee
            if ($leaveRequest->employee && $leaveRequest->employee->user_id) {
                \App\Models\Message::create([
                    'sender_id' => auth()->id(),
                    'receiver_id' => $leaveRequest->employee->user_id,
                    'subject' => 'Leave Request Approved',
                    'message' => 'Hello ' . $leaveRequest->employee->first_name . ', your leave request for ' . $leaveRequest->leaveType->name . ' from ' . $leaveRequest->start_date->format('M d, Y') . ' to ' . $leaveRequest->end_date->format('M d, Y') . ' has been approved.',
                    'status' => 'sent',
                    'is_read' => false,
                    'created_by' => auth()->id(),
                ]);
            }

            $this->dispatch('show-message', 'Leave request approved successfully.');
        }
    }

    public function rejectLeave($id)
    {
        $leaveRequest = \App\Models\LeaveRequest::with('employee')->find($id);
        if ($leaveRequest && $leaveRequest->status === \App\Enum\LeaveStatus::PENDING) {
            $leaveRequest->update([
                'status' => \App\Enum\LeaveStatus::REJECTED->value,
                'approval_status' => \App\Enum\ApprovalStatus::Rejected->value,
                'rejected_by' => auth()->id(),
                'rejected_at' => now(),
                'updated_by' => auth()->id()
            ]);

            // Notify employee
            if ($leaveRequest->employee && $leaveRequest->employee->user_id) {
                \App\Models\Message::create([
                    'sender_id' => auth()->id(),
                    'receiver_id' => $leaveRequest->employee->user_id,
                    'subject' => 'Leave Request Rejected',
                    'message' => 'Hello ' . $leaveRequest->employee->first_name . ', your leave request for ' . $leaveRequest->leaveType->name . ' from ' . $leaveRequest->start_date->format('M d, Y') . ' to ' . $leaveRequest->end_date->format('M d, Y') . ' has been rejected.',
                    'status' => 'sent',
                    'is_read' => false,
                    'created_by' => auth()->id(),
                ]);
            }

            $this->dispatch('show-message', 'Leave request rejected and employee notified.');
        }
    }

    public function render()
    {
        $msgList = \App\Models\Message::with(['sender', 'receiver'])
            ->where(fn($q) => $q->where('sender_id', auth()->id())->orWhere('receiver_id', auth()->id()))
            ->orderBy('created_at', 'desc')->get();
            
        $msgUnread = $msgList->where('receiver_id', auth()->id())->where('is_read', false)->count();
        
        $hrUsers = \App\Models\Employee::whereNotNull('user_id')
            ->where('user_id', '!=', auth()->id())
            ->orderBy('first_name')->get();

        $allEmployees = \App\Models\Employee::orderBy('first_name')->get();

        return view('livewire.leave-attendance.manage-leaves-attendance', [
            'msgList' => $msgList,
            'msgUnread' => $msgUnread,
            'hrUsers' => $hrUsers,
            'allEmployees' => $allEmployees,
        ])->layout('components.layouts.app');
    }

    // Pagination methods
    public function gotoPage($page, $pageName = 'page')
    {
        $this->setPage($page, $pageName);
    }

    public function nextPage($pageName = 'page')
    {
        $this->setPage($this->getPage($pageName) + 1, $pageName);
    }

    public function previousPage($pageName = 'page')
    {
        $this->setPage($this->getPage($pageName) - 1, $pageName);
    }
}
