<?php

namespace App\Livewire\Performance;

use App\Models\Employee;
use App\Models\PerformanceReview;
use App\Models\PerformanceReviewItem;
use App\Models\Goal;
use App\Models\Achievement;
use App\Models\KPI;
use App\Models\KPITarget;
use App\Models\Feedback;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[Title('TalentFlow Pro | HR Performance')]
class PerformanceDashboard extends Component
{
    use WithPagination;

    // --- Active section ---
    public string $activeSection = 'dashboard'; // dashboard, evaluation, kpis, feedback, history

    // --- Filters ---
    public string $search = '';
    public string $filterDept = '';
    public int $perPage = 10;

    // --- Selection ---
    public ?string $selectedEmployeeId = null;
    public ?string $selectedReviewId = null;

    // --- Modal state ---
    public bool $showReviewModal = false;
    public bool $showKPIModal = false;
    public bool $showFeedbackModal = false;

    // --- Evaluation Form ---
    public string $evalType = 'Annual Review';
    public string $evalReviewDate = '';
    public string $evalStrengths = '';
    // --- Feedback Form ---
    public string $feedbackGiverId = '';
    public string $feedbackReceiverId = '';
    public string $feedbackRelation = 'Peer';
    public string $feedbackComments = '';
    public int $feedbackRating = 3;
    public string $evalImprovements = '';
    public string $evalComments = '';
    public array $metricScores = [
        'Technical Skills' => 3,
        'Communication' => 3,
        'Teamwork' => 3,
        'Leadership' => 3,
        'Problem Solving' => 3,
        'Time Management' => 3,
    ];

    public float $kpiWeight = 10;

    // --- Goal Form ---
    public bool $showGoalModal = false;
    public string $goalTitle = '';
    public string $goalDescription = '';
    public string $goalDueDate = '';
    public int $goalProgress = 0;
    public string $goalStatus = 'in-progress';
    public ?string $editingGoalId = null;

    public function mount()
    {
        $this->evalReviewDate = now()->format('Y-m-d');
    }

    public function updatedSearch() { $this->resetPage(); }

    public function selectSection($section)
    {
        $this->activeSection = $section;
        $this->resetPage();
    }

    public function viewEmployeeDetails($employeeId)
    {
        $this->selectedEmployeeId = $employeeId;
        $this->activeSection = 'employee_detail';
    }

    public function openEvaluationForm($employeeId)
    {
        $this->selectedEmployeeId = $employeeId;
        $this->showReviewModal = true;
    }

    public function openKPIForm()
    {
        $this->showKPIModal = true;
    }

    public function openFeedbackModal()
    {
        $this->showFeedbackModal = true;
    }

    public function saveEvaluation()
    {
        $this->validate([
            'evalType' => 'required',
            'evalReviewDate' => 'required|date',
            'evalStrengths' => 'required',
            'evalImprovements' => 'required',
        ]);

        DB::beginTransaction();
        try {
            // Generate code
            $lastReview = PerformanceReview::orderBy('created_at', 'desc')->first();
            $lastCodeNum = $lastReview ? intval(substr($lastReview->code, -4)) : 0;
            $newCode = 'PERF-' . str_pad($lastCodeNum + 1, 4, '0', STR_PAD_LEFT);

            $overallScore = array_sum($this->metricScores) / count($this->metricScores);

            $review = PerformanceReview::create([
                'code' => $newCode,
                'employee_id' => $this->selectedEmployeeId,
                'reviewer_id' => auth()->user()->employee?->id ?? auth()->id(),
                'type' => $this->evalType,
                'review_date' => $this->evalReviewDate,
                'overall_score' => $overallScore,
                'overall_rating' => $this->scoreToRating($overallScore),
                'strengths' => $this->evalStrengths,
                'areas_for_improvement' => $this->evalImprovements,
                'employee_comments' => $this->evalComments,
                'status' => 'completed',
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
                'created_by' => auth()->id(),
            ]);

            foreach ($this->metricScores as $criteria => $score) {
                PerformanceReviewItem::create([
                    'code' => 'ITEM-' . uniqid(),
                    'performance_review_id' => $review->id,
                    'criteria' => $criteria,
                    'score' => $score,
                    'rating' => $this->scoreToRating($score),
                    'weight' => 1,
                    'created_by' => auth()->id(),
                ]);
            }

            DB::commit();
            $this->showReviewModal = false;
            session()->flash('success', 'Performance review submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }

    private function scoreToRating($score)
    {
        if ($score >= 4.5) return 'excellent';
        if ($score >= 3.5) return 'good';
        if ($score >= 2.5) return 'satisfactory';
        return 'needs_improvement';
    }

    public function saveFeedback()
    {
        $this->validate([
            'feedbackReceiverId' => 'required',
            'feedbackComments' => 'required',
        ]);

        Feedback::create([
            'code' => 'FB-' . uniqid(),
            'giver_id' => auth()->user()->employee?->id ?? auth()->id(),
            'receiver_id' => $this->feedbackReceiverId,
            'feedback_type' => '360-degree',
            'relationship' => $this->feedbackRelation,
            'rating' => $this->feedbackRating,
            'comments' => $this->feedbackComments,
            'status' => 'completed',
            'feedback_date' => now(),
            'approval_status' => \App\Enum\ApprovalStatus::Approved,
            'created_by' => auth()->id(),
        ]);

        $this->showFeedbackModal = false;
        session()->flash('success', 'Feedback submitted successfully.');
    }

    public function saveKPI()
    {
        $this->validate([
            'kpiName' => 'required|string|max:255',
            'kpiTarget' => 'required|numeric',
        ]);

        KPI::create([
            'code' => 'KPI-' . str_pad(KPI::count() + 1, 4, '0', STR_PAD_LEFT),
            'name' => $this->kpiName,
            'description' => $this->kpiDescription,
            'category' => $this->kpiCategory,
            'measurement_unit' => $this->kpiUnit,
            'target_value' => $this->kpiTarget,
            'weight_percentage' => $this->kpiWeight,
            'is_active' => true,
            'approval_status' => \App\Enum\ApprovalStatus::Approved,
            'created_by' => auth()->id(),
        ]);

        $this->showKPIModal = false;
        session()->flash('success', 'KPI created successfully.');
    }

    public function openGoalModal()
    {
        $this->resetGoalForm();
        $this->showGoalModal = true;
    }

    public function saveGoal()
    {
        $this->validate([
            'goalTitle' => 'required|string|max:255',
            'goalDueDate' => 'required|date',
        ]);

        $data = [
            'code' => 'GOAL-' . uniqid(),
            'employee_id' => $this->selectedEmployeeId ?? auth()->user()->employee?->id,
            'title' => $this->goalTitle,
            'description' => $this->goalDescription,
            'start_date' => now(),
            'end_date' => $this->goalDueDate,
            'target_value' => 100,
            'current_value' => $this->goalProgress,
            'status' => $this->goalStatus,
            'created_by' => auth()->id(),
        ];

        if ($this->editingGoalId) {
            Goal::find($this->editingGoalId)->update($data);
        } else {
            Goal::create($data);
        }

        $this->showGoalModal = false;
        session()->flash('success', 'Goal saved successfully.');
    }

    private function resetGoalForm()
    {
        $this->goalTitle = '';
        $this->goalDescription = '';
        $this->goalDueDate = now()->addMonths(3)->format('Y-m-d');
        $this->goalProgress = 0;
        $this->goalStatus = 'in-progress';
        $this->editingGoalId = null;
    }

    public function initiateSelfAssessment()
    {
        $this->selectedEmployeeId = auth()->user()->employee?->id;
        if (!$this->selectedEmployeeId) {
            session()->flash('error', 'Employee record not found for current user.');
            return;
        }
        $this->evalType = 'Self Assessment';
        $this->showReviewModal = true;
    }

    public function render()
    {
        $stats = [
            'total_employees' => Employee::count(),
            'pending_reviews' => PerformanceReview::where('status', 'pending')->count(),
            'avg_performance' => round(PerformanceReview::avg('overall_score') ?? 0, 1),
            'completed_goals' => Goal::where('status', 'completed')->count(),
        ];

        $employees = Employee::with(['department', 'position'])
            ->when($this->search, function($q) {
                $q->where('first_name', 'like', "%{$this->search}%")
                  ->orWhere('last_name', 'like', "%{$this->search}%");
            })
            ->when($this->filterDept, function($q) {
                $q->where('department_id', $this->filterDept);
            })
            ->paginate($this->perPage);

        $recentReviews = PerformanceReview::with(['employee', 'reviewer'])
            ->orderBy('review_date', 'desc')
            ->take(5)
            ->get();

        $kpis = KPI::orderBy('name')->get();
        
        $kpiSummaries = $kpis->map(function($kpi) {
            // In a real system, we would calculate current values from targets/results
            // For now, we'll simulate current values
            $currentValue = rand($kpi->target_value * 0.7, $kpi->target_value * 1.2);
            $onTarget = $currentValue >= $kpi->target_value;
            return [
                'name' => $kpi->name,
                'target' => $kpi->target_value,
                'current' => $currentValue,
                'unit' => $kpi->measurement_unit === 'percentage' ? '%' : '',
                'onTarget' => $onTarget,
                'trend' => rand(0, 1) ? 'up' : 'down',
            ];
        });

        $selectedEmployee = null;
        if ($this->selectedEmployeeId) {
            $selectedEmployee = Employee::with(['performanceReviews.items', 'goals', 'achievements', 'department', 'position'])
                ->find($this->selectedEmployeeId);
        }

        return view('livewire.performance.performance-dashboard', [
            'stats' => $stats,
            'kpiSummaries' => $kpiSummaries,
            'employees' => $employees,
            'allEmployees' => Employee::orderBy('first_name')->get(),
            'recentReviews' => $recentReviews,
            'kpis' => $kpis,
            'goals' => Goal::with('employee')->where('status', '!=', 'completed')->latest()->take(10)->get(),
            'performanceTrend' => PerformanceReview::select(DB::raw('DATE_FORMAT(review_date, "%M") as month'), DB::raw('AVG(overall_score) as avg_score'))
                ->groupBy('month')
                ->orderByRaw('MIN(review_date)')
                ->get(),
            'departments' => Department::all(),
            'selectedEmployee' => $selectedEmployee,
        ])->layout('components.layouts.app');
    }
}