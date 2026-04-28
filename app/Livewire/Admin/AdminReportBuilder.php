<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\ActivityLog;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

#[Title('TalentFlow Pro | Admin Reports')]
class AdminReportBuilder extends Component
{
    public $reportCategory = 'users'; // users, security, activity, governance
    public $startDate;
    public $endDate;
    public $limit = 50;

    public function mount()
    {
        $this->startDate = now()->subDays(30)->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function generatePdf()
    {
        $category = $this->reportCategory;
        $data = $this->getReportData();
        $start = $this->startDate;
        $end = $this->endDate;

        return response()->streamDownload(function() use ($category, $data, $start, $end) {
            echo Pdf::loadView('reports.admin-audit-report', [
                'category' => $category,
                'data' => $data,
                'start' => $start,
                'end' => $end
            ])->output();
        }, "Admin_Audit_Report_{$this->reportCategory}_" . now()->format('Ymd') . ".pdf");
    }

    private function getReportData()
    {
        return match($this->reportCategory) {
            'users' => User::orderBy('created_at', 'desc')->get(),
            'security' => ActivityLog::whereIn('action', ['failed_login', 'password_reset', 'login'])
                ->whereBetween('created_at', [$this->startDate, $this->endDate])
                ->orderBy('created_at', 'desc')
                ->limit($this->limit)
                ->get(),
            'activity' => ActivityLog::whereBetween('created_at', [$this->startDate, $this->endDate])
                ->orderBy('created_at', 'desc')
                ->limit($this->limit)
                ->get(),
            'governance' => DB::table('role_permissions')->get(),
            default => collect(),
        };
    }

    public function render()
    {
        return view('livewire.admin.admin-report-builder', [
            'previewData' => $this->getReportData()->take(10),
        ])->layout('components.layouts.admin');
    }
}
