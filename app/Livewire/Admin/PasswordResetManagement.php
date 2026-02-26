<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class PasswordResetManagement extends Component
{
    use WithPagination;

    // Search and Filters
    public $search = '';
    public $statusFilter = '';
    public $dateFilter = '';

    // Form Fields
    public $showCreateResetModal = false;
    public $showDeleteResetModal = false;
    public $selectedResetId;
    public $selectedReset;

    // Form Fields
    public $user_email;
    public $reset_reason;
    
    // View compatibility properties
    public $showCreateModal = false;
    public $createEmail = '';
    public $createReason = '';

    protected $rules = [
        'user_email' => 'required|email|exists:users,email',
        'reset_reason' => 'required|string|max:255',
    ];

    public function mount()
    {
        // Initialize with empty values
    }

    public function render()
    {
        $passwordResets = $this->loadPasswordResets();

        return view('livewire.admin.password-reset-management', [
            'passwordResets' => $passwordResets,
            'resetStats' => $this->getResetStats(),
        ])->layout('components.layouts.admin');
    }

    private function loadPasswordResets()
    {
        $query = PasswordReset::with(['user'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('email', 'like', '%' . $this->search . '%')
                  ->orWhere('token', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('first_name', 'like', '%' . $this->search . '%')
                               ->orWhere('last_name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->statusFilter) {
            if ($this->statusFilter === 'active') {
                $query->whereNull('used_at');
            } elseif ($this->statusFilter === 'used') {
                $query->whereNotNull('used_at');
            } elseif ($this->statusFilter === 'expired') {
                $query->where('created_at', '<', now()->subHours(24));
            }
        }

        if ($this->dateFilter) {
            $query->whereDate('created_at', $this->dateFilter);
        }

        return $query->paginate(20);
    }

    public function openCreateResetModal()
    {
        $this->resetResetForm();
        $this->showCreateResetModal = true;
        $this->showCreateModal = true; // For view compatibility
    }

    public function closeCreateResetModal()
    {
        $this->showCreateResetModal = false;
        $this->showCreateModal = false; // For view compatibility
        $this->resetResetForm();
    }

    public function createPasswordReset()
    {
        $this->validate([
            'createEmail' => 'required|email|exists:users,email',
            'createReason' => 'required|string|max:255',
        ]);

        try {
            PasswordReset::create([
                'email' => $this->createEmail,
                'token' => Str::random(60),
                'reset_reason' => $this->createReason,
                'created_by' => auth()->id(),
            ]);

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'password_reset_created',
                'description' => "Created password reset for {$this->createEmail}",
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'code' => 'PWR-' . str_pad(PasswordReset::count() + 1, 5, '0', STR_PAD_LEFT),
            ]);

            session()->flash('success', 'Password reset created successfully!');
            $this->closeCreateResetModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create password reset: ' . $e->getMessage());
        }
    }

    public function openDeleteResetModal($id)
    {
        $this->selectedResetId = $id;
        $this->selectedReset = PasswordReset::findOrFail($id);
        $this->showDeleteResetModal = true;
    }

    public function closeDeleteResetModal()
    {
        $this->showDeleteResetModal = false;
        $this->selectedResetId = null;
        $this->selectedReset = null;
    }

    public function resetResetForm()
    {
        $this->user_email = '';
        $this->reset_reason = '';
        $this->selectedResetId = null;
        $this->selectedReset = null;
        $this->showCreateResetModal = false;
        $this->showDeleteResetModal = false;
    }

    public function deletePasswordReset()
    {
        $passwordReset = PasswordReset::findOrFail($this->selectedResetId);
        
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'password_reset_deleted',
            'description' => "Deleted password reset for: {$passwordReset->email}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $passwordReset->delete();

        $this->closeDeleteResetModal();
        session()->flash('success', 'Password reset deleted successfully!');
    }

    public function cleanupExpiredResets()
    {
        $expiredResets = PasswordReset::where('created_at', '<', now()->subHours(24))->get();
        $count = $expiredResets->count();
        
        foreach ($expiredResets as $reset) {
            $reset->delete();
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'expired_resets_cleaned',
            'description' => "Cleaned up {$count} expired password resets",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', "{$count} expired password resets cleaned up successfully!");
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->dateFilter = '';
        $this->resetPage();
    }

    public function getResetStats()
    {
        return [
            'total_resets' => PasswordReset::count(),
            'active_resets' => PasswordReset::whereNull('used_at')->where('created_at', '>', now()->subHours(24))->count(),
            'used_resets' => PasswordReset::whereNotNull('used_at')->count(),
            'expired_resets' => PasswordReset::where('created_at', '<', now()->subHours(24))->count(),
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFilter()
    {
        $this->resetPage();
    }
}
