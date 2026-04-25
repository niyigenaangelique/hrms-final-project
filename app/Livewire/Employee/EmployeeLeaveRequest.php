<?php

namespace App\Livewire\Employee;

use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\Employee;
use App\Enum\LeaveStatus;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('TalentFlow Pro | Request Leave')]
class EmployeeLeaveRequest extends Component
{
    use WithFileUploads;

    const ANNUAL_LEAVE_CAP = 30;

    public $leaveTypes;
    public $employee;
    public $leaveRequests;
    public $selectedRequest;
    public $leave_type_id;
    public $start_date;
    public $end_date;
    public $reason;
    public $attachment;

    protected $rules = [
        'leave_type_id' => 'required|exists:leave_types,id',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after_or_equal:start_date',
        'reason' => 'required|string|max:500',
        'attachment' => 'nullable|file|max:5120', // Max 5MB
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->employee = Employee::where('user_id', $user->id)->first();
        
        if (!$this->employee) {
            // Get the highest existing employee code number
            $lastEmployee = Employee::orderBy('id', 'desc')->first();
            $lastCode = $lastEmployee ? intval(substr($lastEmployee->code, -4)) : 0;
            $newCode = 'EMP-' . str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);
            
            $this->employee = Employee::create([
                'code' => $newCode,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'user_id' => $user->id,
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
            ]);
        }

        $this->leaveTypes = LeaveType::where('is_active', true)->get();
        $this->loadLeaveRequests();
    }

    public function submit()
    {
        $this->validate();

        try {
            $startDate = \Carbon\Carbon::parse($this->start_date);
            $endDate = \Carbon\Carbon::parse($this->end_date);
            $totalDays = $startDate->diffInDays($endDate) + 1;
            
            $lt = LeaveType::find($this->leave_type_id);
            
            // 1. Gender validation
            $empGender = strtolower($this->employee->gender ?? '');
            $restriction = strtolower($lt->gender_restriction ?? '');
            if (!empty($restriction) && !empty($empGender) && $restriction !== $empGender) {
                $this->addError('leave_type_id', 'This leave type is restricted to ' . $restriction . ' employees.');
                return;
            }

            // 2. Attachment validation
            if ($lt->requires_medical_document && !$this->attachment) {
                $this->addError('attachment', 'A medical document is required for this leave type.');
                return;
            }

            // 3. Days Balance validation
            $name = strtolower($lt->name ?? '');
            $isAnnualPool = $lt->deduct_from_annual || str_contains($name, 'annual') || str_contains($name, 'vacation');
            
            if ($isAnnualPool) {
                $usedAnnual = LeaveRequest::with('leaveType')->where('employee_id', $this->employee->id)
                    ->where('status', '!=', LeaveStatus::REJECTED)
                    ->whereYear('start_date', now()->year)
                    ->get()
                    ->filter(function($r) {
                        $n = strtolower($r->leaveType?->name ?? '');
                        return ($r->leaveType?->deduct_from_annual) || str_contains($n, 'annual') || str_contains($n, 'vacation');
                    })
                    ->sum(function ($r) {
                        if (!empty($r->total_days) && $r->total_days > 0) return (int) $r->total_days;
                        return \Carbon\Carbon::parse($r->start_date)->diffInDays(\Carbon\Carbon::parse($r->end_date)) + 1;
                    });
                    
                if ($usedAnnual + $totalDays > self::ANNUAL_LEAVE_CAP) {
                    $this->addError('end_date', 'This request exceeds your ' . self::ANNUAL_LEAVE_CAP . '-day annual leave limit. You have ' . max(0, self::ANNUAL_LEAVE_CAP - $usedAnnual) . ' days remaining.');
                    return;
                }
            } else {
                $maxDays = $lt->max_days_per_year ?: $lt->default_days;
                if ($maxDays > 0) {
                    $usedType = LeaveRequest::where('employee_id', $this->employee->id)
                        ->where('leave_type_id', $lt->id)
                        ->where('status', '!=', LeaveStatus::REJECTED)
                        ->whereYear('start_date', now()->year)
                        ->get()
                        ->sum(function ($r) {
                            if (!empty($r->total_days) && $r->total_days > 0) return (int) $r->total_days;
                            return \Carbon\Carbon::parse($r->start_date)->diffInDays(\Carbon\Carbon::parse($r->end_date)) + 1;
                        });
                        
                    if ($usedType + $totalDays > $maxDays) {
                        $this->addError('end_date', 'This request exceeds the limit for ' . $lt->name . '. You have ' . max(0, $maxDays - $usedType) . ' days remaining.');
                        return;
                    }
                }
            }

            // 4. Departmental restriction: only one per dept on Annual/Vacation/Personal at a time
            $restrictedNames = ['annual', 'vacation', 'personal'];
            $ltNameLower = strtolower($lt->name ?? '');
            $isRestricted = false;
            foreach ($restrictedNames as $rn) {
                if (str_contains($ltNameLower, $rn)) { $isRestricted = true; break; }
            }

            if ($isRestricted && $this->employee->department_id) {
                $deptConflict = LeaveRequest::where('employee_id', '!=', $this->employee->id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->where('start_date', '<=', $endDate->format('Y-m-d'))
                    ->where('end_date', '>=', $startDate->format('Y-m-d'))
                    ->whereHas('employee', fn($q) => $q->where('department_id', $this->employee->department_id))
                    ->whereHas('leaveType', function($q) use ($restrictedNames) {
                        $q->where(function($sub) use ($restrictedNames) {
                            foreach ($restrictedNames as $rn) {
                                $sub->orWhere('name', 'like', "%$rn%");
                            }
                        });
                    })
                    ->exists();

                if ($deptConflict) {
                    $this->addError('leave_type_id', 'Departmental Limit Reached: Another employee in your department is already on ' . $lt->name . ' during this period. Only one person per department may take Annual, Vacation, or Personal leave at a time.');
                    return;
                }
            }
            $attachmentPath = null;
            if ($this->attachment) {
                $attachmentPath = $this->attachment->store('leave-attachments', 'public');
            }

            // Generate leave request code
            $code = 'LR-' . str_pad(LeaveRequest::count() + 1, 4, '0', STR_PAD_LEFT);

            LeaveRequest::create([
                'code' => $code,
                'employee_id' => $this->employee->id,
                'leave_type_id' => $this->leave_type_id,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'total_days' => $totalDays,
                'reason' => $this->reason,
                'attachment_path' => $attachmentPath,
                'status' => LeaveStatus::PENDING,
                'approval_status' => \App\Enum\ApprovalStatus::Pending,
                'created_by' => Auth::id(),
            ]);

            $this->reset(['leave_type_id', 'start_date', 'end_date', 'reason', 'attachment']);
            
            session()->flash('success', 'Leave request submitted successfully!');
            $this->loadLeaveRequests(); // Reload leave requests to show new one
            
        } catch (\Exception $e) {
            \Log::error('Leave request submission failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to submit leave request. Please try again.');
        }
    }

    public function loadLeaveRequests()
    {
        $this->leaveRequests = LeaveRequest::with('leaveType')
            ->where('employee_id', $this->employee->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function viewRequest($requestId)
    {
        $this->selectedRequest = LeaveRequest::with('leaveType')
            ->where('employee_id', $this->employee->id)
            ->find($requestId);
    }

    public function closeModal()
    {
        $this->selectedRequest = null;
    }

    public function render()
    {
        return view('livewire.employee.employee-leave-request')
            ->layout('components.layouts.employee');
    }
}
