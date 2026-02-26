<?php

namespace App\Livewire\Employee;

use App\Models\Message;
use App\Models\User;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('TalentFlow Pro | Messages')]
class EmployeeCommunication extends Component
{
    public $employee;
    public $messageList;
    public $hrUsers;
    public $selectedHrUser = null;
    public $subject = '';
    public $messageContent = '';
    public $unreadCount = 0;

    protected $rules = [
        'selectedHrUser' => 'required|exists:users,id',
        'subject' => 'required|string|max:255',
        'messageContent' => 'required|string|max:1000',
    ];

    protected $validationAttributes = [
        'selectedHrUser' => 'HR personnel',
        'subject' => 'subject',
        'messageContent' => 'message',
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

        $this->loadHrUsers();
        $this->loadMessages();
    }

    public function loadHrUsers()
    {
        $this->hrUsers = User::whereIn('role', ['HRManager', 'SuperAdmin', 'CompanyAdmin'])
            ->get();
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
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $this->selectedHrUser,
                'subject' => $this->subject,
                'message' => $this->messageContent,
                'status' => 'sent',
                'is_read' => false,
                'created_by' => Auth::id(),
            ]);

            $this->reset(['subject', 'messageContent', 'selectedHrUser']);
            $this->loadMessages();
            
            session()->flash('success', 'Message sent successfully!');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to send message. Please try again.');
        }
    }

    public function markAsRead($messageId)
    {
        $message = Message::where('id', $messageId)
            ->where('receiver_id', Auth::id())
            ->first();

        if ($message && !$message->is_read) {
            $message->update([
                'is_read' => true,
                'updated_by' => Auth::id(),
            ]);
            $this->loadMessages();
        }
    }

    public function render()
    {
        return view('livewire.employee.employee-communication')
            ->layout('components.layouts.employee');
    }
}
