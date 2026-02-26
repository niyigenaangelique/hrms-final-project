<?php

namespace App\Livewire\Analytics;

use App\Models\Employee;
use App\Models\Contract;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use App\Models\PerformanceReview;
use App\Models\HRMetric;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('ZIBITECH | C-HRMS | Analytics Dashboard')]
class AnalyticsDashboard extends Component
{
    public $selectedPeriod = 'month';
    public $startDate;
    public $endDate;
    public $metrics;
    public $turnoverRate;
    public $diversityStats;
    public $skillGapAnalysis;
    public $attendanceStats;
    public $performanceStats;
    public $leaveStats;

    public function mount()
    {
        $this->setDateRange();
        $this->loadAnalyticsData();
    }

    public function updatedSelectedPeriod()
    {
        $this->setDateRange();
        $this->loadAnalyticsData();
    }

    private function setDateRange()
    {
        switch ($this->selectedPeriod) {
            case 'week':
                $this->startDate = now()->startOfWeek();
                $this->endDate = now()->endOfWeek();
                break;
            case 'month':
                $this->startDate = now()->startOfMonth();
                $this->endDate = now()->endOfMonth();
                break;
            case 'quarter':
                $this->startDate = now()->startOfQuarter();
                $this->endDate = now()->endOfQuarter();
                break;
            case 'year':
                $this->startDate = now()->startOfYear();
                $this->endDate = now()->endOfYear();
                break;
            default:
                $this->startDate = now()->startOfMonth();
                $this->endDate = now()->endOfMonth();
        }
    }

    public function loadAnalyticsData()
    {
        $this->metrics = $this->getHRMetrics();
        $this->turnoverRate = $this->calculateTurnoverRate();
        $this->diversityStats = $this->getDiversityStatistics();
        $this->skillGapAnalysis = $this->analyzeSkillGaps();
        $this->attendanceStats = $this->getAttendanceStatistics();
        $this->performanceStats = $this->getPerformanceStatistics();
        $this->leaveStats = $this->getLeaveStatistics();
    }

    private function getHRMetrics()
    {
        return [
            'total_employees' => Employee::where('is_active', true)->count(),
            'new_hires' => Employee::whereBetween('join_date', [$this->startDate, $this->endDate])->count(),
            'active_contracts' => Contract::where('status', 'active')->count(),
            'avg_tenure' => $this->calculateAverageTenure(),
            'training_hours' => $this->getTrainingHours(),
            'recruitment_cost' => $this->getRecruitmentCost(),
        ];
    }

    private function calculateTurnoverRate()
    {
        $totalEmployees = Employee::where('is_active', true)->count();
        $separatedEmployees = Employee::where('status', 'separated')
            ->whereBetween('updated_at', [$this->startDate, $this->endDate])
            ->count();

        return [
            'rate' => $totalEmployees > 0 ? round(($separatedEmployees / $totalEmployees) * 100, 2) : 0,
            'total_separated' => $separatedEmployees,
            'total_employees' => $totalEmployees,
            'period' => $this->selectedPeriod,
        ];
    }

    private function getDiversityStatistics()
    {
        $employees = Employee::where('is_active', true)->get();
        
        return [
            'gender_distribution' => $employees->groupBy('gender')->map->count(),
            'age_groups' => $this->getAgeGroups($employees),
            'nationality_distribution' => $employees->groupBy('nationality')->map->count(),
            'department_diversity' => $this->getDepartmentDiversity($employees),
        ];
    }

    private function analyzeSkillGaps()
    {
        $skills = [
            'Technical Skills' => $this->getTechnicalSkillGaps(),
            'Soft Skills' => $this->getSoftSkillGaps(),
            'Leadership Skills' => $this->getLeadershipSkillGaps(),
        ];

        return [
            'overall_gap_score' => $this->calculateOverallSkillGap($skills),
            'critical_gaps' => $this->identifyCriticalGaps($skills),
            'training_recommendations' => $this->getTrainingRecommendations($skills),
        ];
    }

    private function getAttendanceStatistics()
    {
        $totalDays = $this->startDate->diffInDays($this->endDate);
        $totalEmployees = Employee::where('is_active', true)->count();
        
        $attendances = Attendance::whereBetween('date', [$this->startDate, $this->endDate])
            ->where('status', 'Approved')
            ->get();

        return [
            'attendance_rate' => $totalEmployees > 0 ? round(($attendances->count() / ($totalEmployees * $totalDays)) * 100, 2) : 0,
            'absenteeism_rate' => $this->calculateAbsenteeismRate(),
            'late_arrivals' => $this->getLateArrivals(),
            'early_departures' => $this->getEarlyDepartures(),
        ];
    }

    private function getPerformanceStatistics()
    {
        $reviews = PerformanceReview::whereBetween('review_date', [$this->startDate, $this->endDate])
            ->where('status', 'completed')
            ->get();

        return [
            'average_score' => $reviews->avg('overall_score') ?? 0,
            'performance_distribution' => $this->getPerformanceDistribution($reviews),
            'top_performers' => $this->getTopPerformers($reviews),
            'improvement_needed' => $this->getEmployeesNeedingImprovement($reviews),
        ];
    }

    private function getLeaveStatistics()
    {
        $leaves = LeaveRequest::whereBetween('start_date', [$this->startDate, $this->endDate])
            ->get();

        return [
            'total_leave_requests' => $leaves->count(),
            'approved_leaves' => $leaves->where('status', 'approved')->count(),
            'pending_leaves' => $leaves->where('status', 'pending')->count(),
            'leave_by_type' => $leaves->groupBy('leave_type_id')->map->count(),
            'average_leave_days' => $leaves->avg('total_days') ?? 0,
        ];
    }

    // Helper methods for calculations
    private function calculateAverageTenure(): float
    {
        return Employee::where('is_active', true)
            ->avg('join_date')
            ->diffInDays(now()) / 365;
    }

    private function getTrainingHours(): int
    {
        // Placeholder for training hours calculation
        return 0;
    }

    private function getRecruitmentCost(): float
    {
        // Placeholder for recruitment cost calculation
        return 0.0;
    }

    private function getAgeGroups($employees): array
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

    private function getDepartmentDiversity($employees): array
    {
        return $employees->groupBy('department_id')->map(function ($deptEmployees) {
            $genders = $deptEmployees->groupBy('gender')->map->count();
            $total = $deptEmployees->count();
            
            return [
                'total' => $total,
                'diversity_score' => $this->calculateDiversityScore($genders, $total),
                'gender_distribution' => $genders,
            ];
        });
    }

    private function calculateDiversityScore($distribution, $total): float
    {
        if ($total === 0) return 0;
        
        $perfectBalance = $total / count($distribution);
        $deviation = 0;
        
        foreach ($distribution as $count) {
            $deviation += abs($count - $perfectBalance);
        }
        
        return max(0, 100 - ($deviation / $total) * 100);
    }

    private function calculateAbsenteeismRate(): float
    {
        // Placeholder for absenteeism calculation
        return 2.5;
    }

    private function getLateArrivals(): int
    {
        return Attendance::whereBetween('date', [$this->startDate, $this->endDate])
            ->where('check_in', '>', '09:00:00')
            ->count();
    }

    private function getEarlyDepartures(): int
    {
        return Attendance::whereBetween('date', [$this->startDate, $this->endDate])
            ->where('check_out', '<', '17:00:00')
            ->count();
    }

    private function getPerformanceDistribution($reviews): array
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

    private function getTopPerformers($reviews): array
    {
        return $reviews->sortByDesc('overall_score')
            ->take(10)
            ->map(function ($review) {
                return [
                    'name' => $review->employee->full_name,
                    'score' => $review->overall_score,
                    'department' => $review->employee->department->name ?? 'N/A',
                ];
            })
            ->toArray();
    }

    private function getEmployeesNeedingImprovement($reviews): array
    {
        return $reviews->where('overall_score', '<', 2.5)
            ->map(function ($review) {
                return [
                    'name' => $review->employee->full_name,
                    'score' => $review->overall_score,
                    'department' => $review->employee->department->name ?? 'N/A',
                ];
            })
            ->toArray();
    }

    // Additional helper methods for skill analysis
    private function getTechnicalSkillGaps(): array
    {
        return [
            'programming' => ['current' => 70, 'required' => 85, 'gap' => 15],
            'database' => ['current' => 60, 'required' => 80, 'gap' => 20],
            'cloud' => ['current' => 50, 'required' => 75, 'gap' => 25],
        ];
    }

    private function getSoftSkillGaps(): array
    {
        return [
            'communication' => ['current' => 75, 'required' => 85, 'gap' => 10],
            'leadership' => ['current' => 60, 'required' => 80, 'gap' => 20],
            'teamwork' => ['current' => 80, 'required' => 90, 'gap' => 10],
        ];
    }

    private function getLeadershipSkillGaps(): array
    {
        return [
            'strategic_thinking' => ['current' => 55, 'required' => 80, 'gap' => 25],
            'decision_making' => ['current' => 65, 'required' => 85, 'gap' => 20],
            'change_management' => ['current' => 50, 'required' => 75, 'gap' => 25],
        ];
    }

    private function calculateOverallSkillGap($skills): float
    {
        $totalGap = 0;
        $totalSkills = 0;

        foreach ($skills as $category => $skillData) {
            foreach ($skillData as $skill) {
                $totalGap += $skill['gap'];
                $totalSkills++;
            }
        }

        return $totalSkills > 0 ? round($totalGap / $totalSkills, 2) : 0;
    }

    private function identifyCriticalGaps($skills): array
    {
        $criticalGaps = [];

        foreach ($skills as $category => $skillData) {
            foreach ($skillData as $skillName => $data) {
                if ($data['gap'] > 20) {
                    $criticalGaps[] = [
                        'category' => $category,
                        'skill' => $skillName,
                        'gap_percentage' => $data['gap'],
                        'priority' => 'high',
                    ];
                }
            }
        }

        return $criticalGaps;
    }

    private function getTrainingRecommendations($skills): array
    {
        return [
            'technical_training' => [
                'title' => 'Advanced Programming Course',
                'target' => 'Technical Skills',
                'duration' => '8 weeks',
                'priority' => 'high',
            ],
            'leadership_development' => [
                'title' => 'Leadership Excellence Program',
                'target' => 'Leadership Skills',
                'duration' => '12 weeks',
                'priority' => 'medium',
            ],
            'communication_workshop' => [
                'title' => 'Effective Communication Workshop',
                'target' => 'Soft Skills',
                'duration' => '2 days',
                'priority' => 'medium',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.analytics.analytics-dashboard');
    }
}
