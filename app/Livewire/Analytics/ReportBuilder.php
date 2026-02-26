<?php

namespace App\Livewire\Analytics;

use App\Models\HRReport;
use App\Models\Employee;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;

#[Title('ZIBITECH | C-HRMS | Report Builder')]
class ReportBuilder extends Component
{
    use WithFileUploads;

    public $showBuilder = false;
    public $reportName;
    public $reportDescription;
    public $reportType;
    public $reportCategory;
    public $selectedMetrics = [];
    public $filters = [];
    public $dateRangeType = 'custom';
    public $startDate;
    public $endDate;
    public $groupBy;
    public $sortBy;
    public $sortOrder = 'desc';
    public $chartType = 'bar';
    public $reportData;

    protected $rules = [
        'reportName' => 'required|string|max:255',
        'reportDescription' => 'nullable|string|max:1000',
        'reportType' => 'required|in:dashboard,turnover,diversity,attendance,performance,skill_gap,custom',
        'reportCategory' => 'required|in:hr,finance,operations,management',
        'startDate' => 'required|date',
        'endDate' => 'required|date|after_or_equal:startDate',
        'groupBy' => 'nullable|string',
        'sortBy' => 'nullable|string',
    ];

    public function mount()
    {
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reportName = '';
        $this->reportDescription = '';
        $this->reportType = 'dashboard';
        $this->reportCategory = 'hr';
        $this->selectedMetrics = [];
        $this->filters = [];
        $this->dateRangeType = 'custom';
        $this->startDate = now()->startOfMonth()->format('Y-m-d');
        $this->endDate = now()->endOfMonth()->format('Y-m-d');
        $this->groupBy = '';
        $this->sortBy = '';
        $this->sortOrder = 'desc';
        $this->chartType = 'bar';
        $this->reportData = [];
    }

    public function addMetric($metric)
    {
        if (!in_array($metric, $this->selectedMetrics)) {
            $this->selectedMetrics[] = $metric;
        }
    }

    public function removeMetric($metric)
    {
        $this->selectedMetrics = array_diff($this->selectedMetrics, [$metric]);
    }

    public function addFilter($filterType)
    {
        $this->filters[] = [
            'type' => $filterType,
            'value' => '',
            'operator' => '=',
        ];
    }

    public function removeFilter($index)
    {
        unset($this->filters[$index]);
        $this->filters = array_values($this->filters);
    }

    public function updateFilter($index, $value)
    {
        if (isset($this->filters[$index])) {
            $this->filters[$index]['value'] = $value;
        }
    }

    public function generateReport()
    {
        $this->validate();

        // Generate report data based on type and selected metrics
        $this->reportData = $this->generateReportData();

        // Create report record
        $report = HRReport::create([
            'code' => 'RPT-' . uniqid(),
            'name' => $this->reportName,
            'description' => $this->reportDescription,
            'type' => $this->reportType,
            'category' => $this->reportCategory,
            'filters' => $this->filters,
            'metrics' => $this->selectedMetrics,
            'status' => 'generated',
            'generated_at' => now(),
            'approval_status' => \App\Enum\ApprovalStatus::Initiated,
            'created_by' => auth()->id(),
        ]);

        $this->dispatch('showNotification', 'Report generated successfully', 'success');
        $this->showBuilder = false;
    }

    private function generateReportData()
    {
        $data = [];

        switch ($this->reportType) {
            case 'dashboard':
                $data = $this->generateDashboardData();
                break;
            case 'turnover':
                $data = $this->generateTurnoverData();
                break;
            case 'diversity':
                $data = $this->generateDiversityData();
                break;
            case 'attendance':
                $data = $this->generateAttendanceData();
                break;
            case 'performance':
                $data = $this->generatePerformanceData();
                break;
            case 'skill_gap':
                $data = $this->generateSkillGapData();
                break;
            case 'custom':
                $data = $this->generateCustomData();
                break;
            default:
                $data = $this->generateDashboardData();
        }

        return $data;
    }

    private function generateDashboardData()
    {
        return [
            'total_employees' => Employee::where('is_active', true)->count(),
            'new_hires' => Employee::whereBetween('join_date', [$this->startDate, $this->endDate])->count(),
            'active_contracts' => \App\Models\Contract::where('status', 'active')->count(),
            'avg_tenure' => Employee::where('is_active', true)->avg('join_date')->diffInDays(now()) / 365,
        ];
    }

    private function generateTurnoverData()
    {
        $totalEmployees = Employee::where('is_active', true)->count();
        $separatedEmployees = Employee::where('status', 'separated')
            ->whereBetween('updated_at', [$this->startDate, $this->endDate])
            ->count();

        return [
            'turnover_rate' => $totalEmployees > 0 ? round(($separatedEmployees / $totalEmployees) * 100, 2) : 0,
            'total_separated' => $separatedEmployees,
            'total_employees' => $totalEmployees,
        ];
    }

    private function generateDiversityData()
    {
        $employees = Employee::where('is_active', true)->get();
        
        return [
            'gender_distribution' => $employees->groupBy('gender')->map->count(),
            'age_groups' => $this->getAgeGroups($employees),
            'nationality_distribution' => $employees->groupBy('nationality')->map->count(),
            'department_distribution' => $employees->groupBy('department_id')->map->count(),
            'job_title_distribution' => $employees->groupBy('job_title')->map->count(),
        ];
    }

    private function generateAttendanceData()
    {
        $attendances = \App\Models\Attendance::whereBetween('date', [$this->startDate, $this->endDate])
            ->get();

        return [
            'total_days' => $this->startDate->diffInDays($this->endDate),
            'present_days' => $attendances->where('status', 'Approved')->count(),
            'absent_days' => $attendances->where('status', '!=', 'Approved')->count(),
            'late_arrivals' => $attendances->where('check_in', '>', '09:00:00')->count(),
            'early_departures' => $attendances->where('check_out', '<', '17:00:00')->count(),
        ];
    }

    private function generatePerformanceData()
    {
        $reviews = \App\Models\PerformanceReview::whereBetween('review_date', [$this->startDate, $this->endDate])
            ->where('status', 'completed')
            ->get();

        return [
            'total_reviews' => $reviews->count(),
            'average_score' => $reviews->avg('overall_score'),
            'performance_distribution' => $this->getPerformanceDistribution($reviews),
            'top_performers' => $reviews->sortByDesc('overall_score')->take(10)->values(),
        ];
    }

    private function generateSkillGapData()
    {
        return [
            'technical_skills' => [
                'programming' => ['current' => 70, 'required' => 85, 'gap' => 15],
                'database' => ['current' => 60, 'required' => 80, 'gap' => 20],
            ],
            'soft_skills' => [
                'communication' => ['current' => 75, 'required' => 85, 'gap' => 10],
                'leadership' => ['current' => 60, 'required' => 80, 'gap' => 20],
            ],
        ];
    }

    private function generateCustomData()
    {
        // Generate data based on selected metrics
        $data = [];

        foreach ($this->selectedMetrics as $metric) {
            switch ($metric) {
                case 'employee_count':
                    $data[$metric] = Employee::where('is_active', true)->count();
                    break;
                case 'new_hires':
                    $data[$metric] = Employee::whereBetween('join_date', [$this->startDate, $this->endDate])->count();
                    break;
                case 'turnover_rate':
                    $data[$metric] = $this->calculateTurnoverRate();
                    break;
                // Add more custom metrics as needed
            }
        }

        return $data;
    }

    private function calculateTurnoverRate()
    {
        $totalEmployees = Employee::where('is_active', true)->count();
        $separatedEmployees = Employee::where('status', 'separated')
            ->whereBetween('updated_at', [$this->startDate, $this->endDate])
            ->count();

        return $totalEmployees > 0 ? round(($separatedEmployees / $totalEmployees) * 100, 2) : 0;
    }

    private function getAgeGroups($employees)
    {
        return $employees->groupBy(function ($employee) {
            $age = $employee->birth_date ? $employee->birth_date->age : 0;
            if ($age < 25) return '18-24';
            if ($age < 35) return '25-34';
            if ($age < 45) return '35-44';
            if ($age < 55) return '45-54';
            return '55+';
        })->map->count();
    }

    private function getPerformanceDistribution($reviews)
    {
        $distribution = [
            'excellent' => 0,
            'good' => 0,
            'satisfactory' => 0,
            'needs_improvement' => 0,
        ];

        foreach ($reviews as $review) {
            $score = $review->overall_score;
            if ($score >= 4.5) $distribution['excellent']++;
            elseif ($score >= 3.5) $distribution['good']++;
            elseif ($score >= 2.5) $distribution['satisfactory']++;
            else $distribution['needs_improvement']++;
        }

        return $distribution;
    }

    public function getAvailableMetrics()
    {
        return [
            'employee_count' => 'Employee Count',
            'new_hires' => 'New Hires',
            'turnover_rate' => 'Turnover Rate',
            'attendance_rate' => 'Attendance Rate',
            'performance_score' => 'Performance Score',
            'leave_days' => 'Leave Days',
            'training_hours' => 'Training Hours',
            'recruitment_cost' => 'Recruitment Cost',
        ];
    }

    public function exportReport()
    {
        if (!$this->reportData) {
            $this->generateReport();
        }

        // Generate CSV export
        $filename = $this->reportName . '_' . now()->format('Y-m-d') . '.csv';
        $headers = [];
        $rows = [];

        // Extract headers from data
        if (!empty($this->reportData)) {
            $firstRow = $this->reportData[array_key_first($this->reportData)];
            if (is_array($firstRow)) {
                $headers = array_keys($firstRow);
            } else {
                $headers = ['Metric', 'Value'];
            }
        }

        // Convert data to rows
        foreach ($this->reportData as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subKey => $subValue) {
                    $rows[] = [$key . ' - ' . $subKey, $subValue];
                }
            } else {
                $rows[] = [$key, $value];
            }
        }

        $csv = implode(',', $headers) . "\n";
        foreach ($rows as $row) {
            $csv .= implode(',', $row) . "\n";
        }

        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, $filename);
    }

    public function render()
    {
        return view('livewire.analytics.report-builder', [
            'availableMetrics' => $this->getAvailableMetrics(),
        ]);
    }
}
