<?php

namespace App\Livewire\Admin;
 
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
 
#[Title('TalentFlow Pro | Active Sessions')]
class ActiveSessionManagement extends Component
{
    public function terminateSession(string $sessionId): void
    {
        try {
            DB::table('sessions')->where('id',$sessionId)->delete();
            session()->flash('success','Session terminated.');
        } catch (\Exception $e) {
            session()->flash('error',$e->getMessage());
        }
    }
 
    public function terminateAll(): void
    {
        try {
            DB::table('sessions')->where('id','!=',session()->getId())->delete();
            session()->flash('success','All other sessions terminated.');
        } catch (\Exception $e) {
            session()->flash('error',$e->getMessage());
        }
    }
 
    public function render()
    {
        $sessions = collect();
        try {
            $sessions = DB::table('sessions')
                ->orderBy('last_activity','desc')
                ->limit(100)
                ->get()
                ->map(function($s) {
                    $s->last_activity_human = Carbon::createFromTimestamp($s->last_activity)->diffForHumans();
                    $s->is_current = $s->id === session()->getId();
                    return $s;
                });
        } catch (\Exception) {}
 
        return view('livewire.admin.active-session-management',[
            'sessions' => $sessions,
        ])->layout('components.layouts.admin');
    }
}