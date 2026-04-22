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
        \Log::info('HrCommunication mounting...');
        $this->loadEmployees();
        $this->loadMessages();
        \Log::info('Employees loaded: ' . $this->employees->count());
        \Log::info('Messages loaded: ' . $this->messageList->count());
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
        // Simple test - flash message to see if method is called
        session()->flash('info', 'sendMessage method was called!');
        
        \Log::info('sendMessage called with data: ', [
            'selectedEmployee' => $this->selectedEmployee,
            'subject' => $this->subject,
            'messageContent' => $this->messageContent,
            'auth_id' => Auth::id()
        ]);

        // Temporarily disable validation for testing
        // $this->validate();

        try {
            // Get the employee to find their user
            $employee = Employee::find($this->selectedEmployee);
            \Log::info('Employee found: ', ['employee' => $employee]);
            
            if (!$employee) {
                session()->flash('error', 'Employee not found.');
                return;
            }

            $user = User::where('email', $employee->email)->first();
            \Log::info('User found: ', ['user' => $user]);

            if (!$user) {
                session()->flash('error', 'Employee user account not found.');
                return;
            }

            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $user->id,
                'subject' => $this->subject,
                'message' => $this->messageContent,
                'status' => 'sent',
                'is_read' => false,
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
                'created_by' => Auth::id(),
            ]);

            \Log::info('Message created: ', ['message_id' => $message->id]);

            $this->reset(['selectedEmployee', 'subject', 'messageContent']);
            $this->loadMessages();
            
            session()->flash('success', 'Message sent successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Message sending failed: ' . $e->getMessage());
            \Log::error('Exception trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Failed to send message: ' . $e->getMessage());
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
