<?php

namespace App\Livewire\LeaveAttendance;

use App\Models\Message;
use App\Models\User;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('TalentFlow Pro | HR Communication')]
class HrCommunication extends Component
{
    public $messageList;
    public $employees;
    public $selectedEmployee = null;
    public $subject = '';
    public $messageContent = '';
    public $unreadCount = 0;

    protected $rules = [
        'selectedEmployee' => 'required|exists:employees,id',
        'subject' => 'required|string|max:255',
        'messageContent' => 'required|string|max:1000',
    ];

    protected function validationAttributes()
    {
        return [
            'selectedEmployee' => 'employee',
            'subject' => 'subject',
            'messageContent' => 'message content',
        ];
    }

    public function mount()
    {
        $this->loadEmployees();
        $this->loadMessages();
    }

    public function loadEmployees()
    {
        $this->employees = Employee::where('approval_status', 'Approved')->get();
    }

    public function loadMessages()
    {
        $this->messageList = Message::with(['sender', 'receiver'])
            ->where(function($query) {
                $query->where('sender_id', Auth::id())
                      ->orWhere('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $this->unreadCount = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    public function sendMessage()
    {
        $this->validate();

        try {
            // Get the employee to find their user
            $employee = Employee::find($this->selectedEmployee);
            $user = User::where('email', $employee->email)->first();

            if (!$user) {
                session()->flash('error', 'Employee user account not found.');
                return;
            }

            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $user->id,
                'subject' => $this->subject,
                'message' => $this->messageContent,
                'status' => 'sent',
                'is_read' => false,
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
                'created_by' => Auth::id(),
            ]);

            $this->reset(['selectedEmployee', 'subject', 'messageContent']);
            $this->loadMessages();
            
            session()->flash('success', 'Message sent successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Message sending failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to send message. Please try again.');
        }
    }

    public function markAsRead($messageId)
    {
        $message = Message::find($messageId);
        if ($message && $message->receiver_id === Auth::id()) {
            $message->update(['is_read' => true]);
            $this->loadMessages();
        }
    }

    public function render()
    {
        return view('livewire.leave-attendance.hr-communication')
            ->layout('components.layouts.app');
    }
}
