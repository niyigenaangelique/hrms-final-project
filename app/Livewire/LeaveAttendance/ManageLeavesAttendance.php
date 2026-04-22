<?php

namespace App\Livewire\LeaveAttendance;

use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('SGA | C-HRMS | ManageLeavesAttendances')]

class ManageLeavesAttendance extends Component
{
    public $messageText = '';
    public $selectedUserId = null;
    public $selectedConversation = null;
    public $conversationMessages = null;
    public $activeSection = 'overview';

    #[On('manage_leaves_attendanceNotification')]
    public function handleNotification(): void
    {
    }

    public function mount()
    {
        // Auto-select first conversation if available
        $this->loadInitialConversation();
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

    public function render()
    {
        $msgList = \App\Models\Message::with(['sender', 'receiver'])
            ->where(fn($q) => $q->where('sender_id', auth()->id())->orWhere('receiver_id', auth()->id()))
            ->orderBy('created_at', 'desc')->get();
            
        $msgUnread = $msgList->where('receiver_id', auth()->id())->where('is_read', false)->count();
        
        $hrUsers = \App\Models\Employee::whereNotNull('user_id')
            ->where('user_id', '!=', auth()->id())
            ->orderBy('first_name')->get();

        return view('livewire.leave-attendance.manage-leaves-attendance', [
            'msgList' => $msgList,
            'msgUnread' => $msgUnread,
            'hrUsers' => $hrUsers,
        ])->layout('components.layouts.app');
    }
}
