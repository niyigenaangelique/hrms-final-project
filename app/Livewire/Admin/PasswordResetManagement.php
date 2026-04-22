<?php

namespace App\Livewire\Admin;
 
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
 
#[Title('TalentFlow Pro | Password Resets')]
class PasswordResetManagement extends Component
{
    use WithPagination;
 
    public string  $search        = '';
    public bool    $showModal     = false;
    public ?string $resetUserId   = null;
    public ?User   $resetUser     = null;
    public string  $newPassword   = '';
    public string  $generatedPw   = '';
 
    public function updatedSearch(): void { $this->resetPage(); }
 
    public function openReset(string $id): void
    {
        $this->resetUser    = User::findOrFail($id);
        $this->resetUserId  = $id;
        $this->newPassword  = '';
        $this->generatedPw  = '';
        $this->showModal    = true;
    }
 
    public function closeModal(): void
    {
        $this->showModal   = false;
        $this->resetUser   = null;
        $this->resetUserId = null;
        $this->newPassword = $this->generatedPw = '';
    }
 
    public function generate(): void
    {
        $this->generatedPw = Str::random(12);
        $this->newPassword = $this->generatedPw;
    }
 
    public function doReset(): void
    {
        if (!$this->resetUserId || strlen($this->newPassword) < 6) {
            session()->flash('error','Password must be at least 6 characters.');
            return;
        }
        try {
            User::findOrFail($this->resetUserId)->update(['password'=>Hash::make($this->newPassword)]);
            $this->generatedPw = $this->newPassword;
            session()->flash('success','Password reset successfully.');
        } catch (\Exception $e) {
            session()->flash('error',$e->getMessage());
        }
    }
 
    public function render()
    {
        $users = User::when($this->search, fn($q)=>$q->where(fn($q2)=>
                $q2->where('first_name','like',"%{$this->search}%")
                   ->orWhere('last_name','like',"%{$this->search}%")
                   ->orWhere('email','like',"%{$this->search}%")
            ))
            ->orderBy('first_name')
            ->paginate(15);
 
        return view('livewire.admin.password-reset-management',[
            'users' => $users,
        ])->layout('components.layouts.admin');
    }
}