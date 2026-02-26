<?php

namespace App\Livewire\Performance;

use App\Models\PerformanceReview;
use App\Models\Goal;
use App\Models\KPITarget;
use App\Models\Feedback;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('ZIBITECH | C-HRMS | Performance Dashboard')]
class PerformanceDashboard extends Component
{
    public $totalEmployees;
    public $activeGoals;
    public $completedGoals;
    public $pendingReviews;
    public $completedReviews;
    public $averagePerformanceScore;
    public $topPerformers;
    public $recentReviews;
    public $goalProgress;
    public $kpiAchievements;
    public $feedbackSummary;

    public function mount()
    {
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $this->totalEmployees = Employee::where('is_active', true)->count();
        
        $this->activeGoals = Goal::where('status', 'active')->count();
        $this->completedGoals = Goal::where('status', 'completed')->count();
        
        $this->pendingReviews = PerformanceReview::where('status', 'pending')->count();
        $this->completedReviews = PerformanceReview::where('status', 'completed')->count();
        
        $this->averagePerformanceScore = PerformanceReview::where('status', 'completed')
            ->avg('overall_score') ?? 0;
        
        $this->topPerformers = $this->getTopPerformers();
        $this->recentReviews = $this->getRecentReviews();
        $this->goalProgress = $this->getGoalProgress();
        $this->kpiAchievements = $this->getKPIAchievements();
        $this->feedbackSummary = $this->getFeedbackSummary();
    }

    private function getTopPerformers()
    {
        return PerformanceReview::with('employee')
            ->where('status', 'completed')
            ->selectRaw('employee_id, AVG(overall_score) as avg_score')
            ->groupBy('employee_id')
            ->orderBy('avg_score', 'desc')
            ->take(5)
            ->get();
    }

    private function getRecentReviews()
    {
        return PerformanceReview::with(['employee', 'reviewer'])
            ->latest('review_date')
            ->take(10)
            ->get();
    }

    private function getGoalProgress()
    {
        return Goal::with('employee')
            ->where('status', 'active')
            ->get()
            ->groupBy(function ($goal) {
                if ($goal->progress_percentage >= 80) return 'on-track';
                if ($goal->progress_percentage >= 50) return 'progressing';
                return 'behind';
            });
    }

    private function getKPIAchievements()
    {
        return KPITarget::with(['kpi', 'employee'])
            ->whereHas('kpi', function ($query) {
                $query->where('is_active', true);
            })
            ->get()
            ->groupBy(function ($target) {
                if ($target->achievement_percentage >= 100) return 'achieved';
                if ($target->achievement_percentage >= 80) return 'on-track';
                return 'below-target';
            });
    }

    private function getFeedbackSummary()
    {
        return Feedback::selectRaw('feedback_type, AVG(rating) as avg_rating, COUNT(*) as count')
            ->groupBy('feedback_type')
            ->get();
    }

    public function render()
    {
        return view('livewire.performance.performance-dashboard');
    }
}
