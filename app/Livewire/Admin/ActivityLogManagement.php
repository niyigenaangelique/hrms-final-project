<?php

namespace App\Livewire\Admin;
 
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
 
#[Title('TalentFlow Pro | Activity Logs')]
class ActivityLogManagement extends Component
{
    use WithPagination;
 
    public string $search      = '';
    public string $filterType  = '';
    public string $dateFrom    = '';
    public string $dateTo      = '';
 
    public function mount(): void
    {
        $this->dateFrom = now()->subDays(30)->format('Y-m-d');
        $this->dateTo   = now()->format('Y-m-d');
    }
 
    public function updatedSearch(): void    { $this->resetPage(); }
    public function updatedFilterType(): void{ $this->resetPage(); }
 
    public function render()
    {
        $logs = collect();
        $total = 0;
        try {
            $query = DB::table('audit_logs')
                ->when($this->search,     fn($q)=>$q->where('description','like',"%{$this->search}%"))
                ->when($this->filterType, fn($q)=>$q->where('event',$this->filterType))
                ->when($this->dateFrom,   fn($q)=>$q->whereDate('created_at','>=',$this->dateFrom))
                ->when($this->dateTo,     fn($q)=>$q->whereDate('created_at','<=',$this->dateTo))
                ->orderBy('created_at','desc');
            $total = (clone $query)->count();
            $logs  = $query->paginate(20);
        } catch (\Exception) {
            $logs = new \Illuminate\Pagination\LengthAwarePaginator([],0,20);
        }
 
        return view('livewire.admin.activity-log-management', [
            'logs'  => $logs,
            'total' => $total,
        ])->layout('components.layouts.admin');
    }
}