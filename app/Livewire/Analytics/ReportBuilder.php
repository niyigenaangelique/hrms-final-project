<?php

namespace App\Livewire\Analytics;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\PerformanceReview;
use App\Models\LeaveRequest;
use App\Models\PayrollEntry;
use App\Models\HRReport;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

#[Title('TalentFlow Pro | HR Reports')]
class ReportBuilder extends Component
{
    public $reportCategory = 'employee'; // employee, attendance, performance, leave, payroll
    public $startDate;
    public $endDate;
    public $selectedDepartment = '';

    public function mount()
    {
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->format('Y-m-d');
    }

    public function generatePdf()
    {
        $data = $this->getReportData();
        
        $pdf = Pdf::loadView('reports.hr-unified-report', [
            'category' => $this->reportCategory,
            'data' => $data,
            'start' => $this->startDate,
            'end' => $this->endDate
        ]);

        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, "HR_Report_{$this->reportCategory}_" . now()->format('Ymd') . ".pdf");
    }

    private function getReportData()
    {
        $query = match($this->reportCategory) {
            'employee' => Employee::with(['departmentAssignment', 'positionAssignment']),
            'attendance' => Attendance::with('employee')->whereBetween('date', [$this->startDate, $this->endDate]),
            'performance' => PerformanceReview::with('employee')->whereBetween('review_date', [$this->startDate, $this->endDate]),
            'leave' => LeaveRequest::with('employee')->whereBetween('start_date', [$this->startDate, $this->endDate]),
            'payroll' => PayrollEntry::with('employee'),
            'skills' => Employee::with(['departmentAssignment'])->whereHas('performanceReviews'),
            default => null,
        };

        if (!$query) return collect();

        if ($this->selectedDepartment) {
            if ($this->reportCategory === 'employee' || $this->reportCategory === 'skills') {
                $query->where('department_id', $this->selectedDepartment);
            } else {
                $query->whereHas('employee', fn($q) => $q->where('department_id', $this->selectedDepartment));
            }
        }

        return $query->get();
    }

    public function render()
    {
        return view('livewire.analytics.report-builder', [
            'previewData' => $this->getReportData()->take(10),
            'departments' => \App\Models\Department::all(),
        ])->layout('components.layouts.app');
    }
}
