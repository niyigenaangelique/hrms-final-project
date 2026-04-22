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
    public $availableUsers;
    public $selectedUser = null;
    public $subject = '';
    public $messageContent = '';
    public $unreadCount = 0;
    public $selectedConversation = null;
    public $conversationMessages = null;

    protected $rules = [
        'messageContent' => 'required|string|max:1000',
    ];

    protected $validationAttributes = [
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

        $this->loadAvailableUsers();
        $this->loadMessages();
        
        // Auto-select first conversation if available
        if ($this->messageList->count() > 0) {
            $firstPerson = $this->messageList->first()->sender_id === Auth::id() 
                ? $this->messageList->first()->receiver_id 
                : $this->messageList->first()->sender_id;
            $this->selectConversation($firstPerson);
        }
    }

    public function loadAvailableUsers()
    {
        // Load all users that employees can message: HR staff, admins, and other employees
        $this->availableUsers = User::where(function($query) {
                $query->whereIn('role', ['admin', 'hr_manager', 'super_admin'])
                      ->orWhere('role', 'employee');
            })
            ->where('id', '!=', Auth::id()) // Don't include current user
            ->orderByRaw("CASE WHEN role IN ('admin', 'hr_manager', 'super_admin') THEN 0 ELSE 1 END")
            ->orderBy('first_name')
            ->orderBy('last_name')
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

        // Debug: Check if conversation is selected
        if (!$this->selectedConversation) {
            session()->flash('error', 'Please select a person to message first. SelectedConversation: ' . ($this->selectedConversation ?? 'null'));
            return;
        }

        try {
            Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $this->selectedConversation,
                'subject' => 'Message', // Default subject
                'message' => $this->messageContent,
                'status' => 'sent',
                'is_read' => false,
                'created_by' => Auth::id(),
            ]);

            $this->reset(['messageContent']);
            $this->loadMessages();
            $this->loadConversationMessages($this->selectedConversation);
            
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

    public function selectConversation($personId)
    {
        // Debug: Log the selection
        \Log::info('selectConversation called with personId: ' . $personId);
        $this->selectedConversation = $personId;
        \Log::info('selectedConversation set to: ' . $this->selectedConversation);
        $this->loadConversationMessages($personId);
        
        // Close the users drawer after selection
        $this->dispatch('closeUsersDrawer');
    }

    public function loadConversationMessages($personId)
    {
        $this->conversationMessages = Message::with(['sender', 'receiver'])
            ->where(function($query) use ($personId) {
                $query->where(function($q) use ($personId) {
                    $q->where('sender_id', Auth::id())
                      ->where('receiver_id', $personId);
                })->orWhere(function($q) use ($personId) {
                    $q->where('sender_id', $personId)
                      ->where('receiver_id', Auth::id());
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark all messages in this conversation as read
        Message::where('receiver_id', Auth::id())
            ->where('sender_id', $personId)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'updated_by' => Auth::id(),
            ]);

        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.employee.employee-communication')
            ->layout('components.layouts.employee');
    }
}
