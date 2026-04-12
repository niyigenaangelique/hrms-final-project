<?php

namespace App\Livewire\Performance;

use App\Models\Employee;
use App\Models\PerformanceReview;
use App\Models\PerformanceReviewItem;
use App\Models\Goal;
use App\Models\Achievement;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[Title('TalentFlow Pro | HR Performance')]
class HRPerformanceManager extends Component
{
    use WithPagination;

    // ── Active section ──────────────────────────────────────
    public string $activeSection = 'dashboard';

    // ── Filters ─────────────────────────────────────────────
    public string $search           = '';
    public string $filterDept       = '';
    public string $filterReviewType = '';
    public string $filterRating     = '';
    public string $filterStatus     = '';
    public int    $perPage          = 15;

    // ── Selected records ────────────────────────────────────
    public ?int $viewingEmployeeId = null;
    public ?int $viewingReviewId   = null;

    // ── Modal state ─────────────────────────────────────────
    public bool $showEvalModal   = false;
    public bool $showViewModal   = false;
    public bool $showDeleteModal = false;
    public ?int $deletingId      = null;
    public ?int $editingId       = null;

    // ══ EVALUATION FORM FIELDS ═══════════════════════════════
    public string $evalCode             = '';
    public string $evalEmployeeId       = '';
    public string $evalType             = 'Annual Review';
    public string $evalPeriodStart      = '';
    public string $evalPeriodEnd        = '';
    public string $evalReviewDate       = '';
    public string $evalStatus           = 'completed';
    public string $evalOverallRating    = 'good';
    public string $evalApprovalStatus   = 'draft';
    public string $evalStrengths        = '';
    public string $evalAreasForImprove  = '';
    public string $evalDevelopmentPlan  = '';
    public string $evalEmployeeComments = '';

    // ── Per-metric scores ────────────────────────────────────
    public int $metricTechnical    = 3;
    public int $metricCommunication= 3;
    public int $metricTeamwork     = 3;
    public int $metricLeadership   = 3;
    public int $metricProblemSolving = 3;
    public int $metricTimeManagement = 3;

    const REVIEW_TYPES = [
        'Annual Review'    => 'Annual Review',
        'Mid-Year Review'  => 'Mid-Year Review',
        'Quarterly Review' => 'Quarterly Review',
        'Probation Review' => 'Probation Review',
        'Self Evaluation'  => 'Self Evaluation',
        'Peer Review'      => 'Peer Review',
    ];

    const RATINGS = [
        'excellent'         => 'Excellent',
        'good'              => 'Good',
        'satisfactory'      => 'Satisfactory',
        'needs_improvement' => 'Needs Improvement',
        'unsatisfactory'    => 'Unsatisfactory',
    ];

    const APPROVAL_STATUSES = [
        'draft'    => 'Draft',
        'pending'  => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ];

    const METRICS = [
        'metricTechnical'     => 'Technical Skills',
        'metricCommunication' => 'Communication',
        'metricTeamwork'      => 'Teamwork',
        'metricLeadership'    => 'Leadership',
        'metricProblemSolving'=> 'Problem Solving',
        'metricTimeManagement'=> 'Time Management',
    ];

    // ── Lifecycle ────────────────────────────────────────────
    public function mount(): void
    {
        $this->evalReviewDate  = now()->format('Y-m-d');
        $this->evalPeriodStart = now()->startOfMonth()->format('Y-m-d');
        $this->evalPeriodEnd   = now()->endOfMonth()->format('Y-m-d');
    }

    public function updatedSearch(): void           { $this->resetPage(); }
    public function updatedFilterDept(): void        { $this->resetPage(); }
    public function updatedFilterReviewType(): void  { $this->resetPage(); }
    public function updatedFilterRating(): void      { $this->resetPage(); }
    public function updatedFilterStatus(): void      { $this->resetPage(); }

    // ── Overall score computed from metrics ─────────────────
    public function getComputedScoreProperty(): float
    {
        return round((
            $this->metricTechnical     +
            $this->metricCommunication +
            $this->metricTeamwork      +
            $this->metricLeadership    +
            $this->metricProblemSolving+
            $this->metricTimeManagement
        ) / 6, 2);
    }

    private function scoreToRating(float $score): string
    {
        if ($score >= 4.5) return 'excellent';
        if ($score >= 3.5) return 'good';
        if ($score >= 2.5) return 'satisfactory';
        if ($score >= 1.5) return 'needs_improvement';
        return 'unsatisfactory';
    }

    // ── Auto-generate code ───────────────────────────────────
    private function generateCode(): string
    {
        $last = PerformanceReview::orderBy('id', 'desc')->first();
        $n    = $last ? ((int) preg_replace('/\D/', '', $last->code ?? '0')) + 1 : 1;
        return 'PERF-' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    private function generateItemCode(): string
    {
        $last = PerformanceReviewItem::orderBy('id', 'desc')->first();
        $n    = $last ? ((int) preg_replace('/\D/', '', $last->code ?? '0')) + 1 : 1;
        $code = 'ITEM-' . str_pad($n, 4, '0', STR_PAD_LEFT);
        while (PerformanceReviewItem::where('code', $code)->exists()) {
            $n++;
            $code = 'ITEM-' . str_pad($n, 4, '0', STR_PAD_LEFT);
        }
        return $code;
    }

    // ── Open / close ─────────────────────────────────────────
    public function openCreateEval(?int $employeeId = null): void
    {
        $this->resetEvalForm();
        $this->evalCode       = $this->generateCode();
        $this->evalEmployeeId = $employeeId ? (string) $employeeId : '';
        $this->showEvalModal  = true;
    }

    public function openEditEval(int $reviewId): void
    {
        $r = PerformanceReview::with('items')->findOrFail($reviewId);
        $this->editingId            = $reviewId;
        $this->evalCode             = $r->code ?? '';
        $this->evalEmployeeId       = (string) ($r->employee_id ?? '');
        $this->evalType             = $r->type ?? 'Annual Review';
        $this->evalPeriodStart      = $r->review_period_start ? Carbon::parse($r->review_period_start)->format('Y-m-d') : '';
        $this->evalPeriodEnd        = $r->review_period_end   ? Carbon::parse($r->review_period_end)->format('Y-m-d')   : '';
        $this->evalReviewDate       = $r->review_date         ? Carbon::parse($r->review_date)->format('Y-m-d')         : '';
        $this->evalStatus           = $r->status ?? 'completed';
        $this->evalOverallRating    = $r->overall_rating instanceof \BackedEnum ? $r->overall_rating->value : ($r->overall_rating ?? 'good');
        $this->evalApprovalStatus   = $r->approval_status instanceof \BackedEnum ? $r->approval_status->value : ($r->approval_status ?? 'draft');
        $this->evalStrengths        = $r->strengths ?? '';
        $this->evalAreasForImprove  = $r->areas_for_improvement ?? '';
        $this->evalDevelopmentPlan  = $r->development_plan ?? '';
        $this->evalEmployeeComments = $r->employee_comments ?? '';

        // Load per-metric scores
        $map = [
            'Technical Skills'  => 'metricTechnical',
            'Communication'     => 'metricCommunication',
            'Teamwork'          => 'metricTeamwork',
            'Leadership'        => 'metricLeadership',
            'Problem Solving'   => 'metricProblemSolving',
            'Time Management'   => 'metricTimeManagement',
        ];
        foreach ($r->items ?? [] as $item) {
            $prop = $map[$item->criteria] ?? null;
            if ($prop) $this->$prop = (int) $item->score;
        }

        $this->showEvalModal = true;
    }

    public function openViewReview(int $reviewId): void
    {
        $this->viewingReviewId = $reviewId;
        $this->showViewModal   = true;
    }

    public function openViewEmployee(int $employeeId): void
    {
        $this->viewingEmployeeId = $employeeId;
        $this->activeSection     = 'employee_detail';
    }

    public function backToList(): void
    {
        $this->viewingEmployeeId = null;
        $this->activeSection     = 'employees';
    }

    public function closeModals(): void
    {
        $this->showEvalModal   = false;
        $this->showViewModal   = false;
        $this->showDeleteModal = false;
        $this->deletingId      = null;
        $this->viewingReviewId = null;
        $this->resetEvalForm();
    }

    public function confirmDelete(int $id): void
    {
        $this->deletingId      = $id;
        $this->showDeleteModal = true;
    }

    // ── Save evaluation ──────────────────────────────────────
    public function saveEvaluation(): void
    {
        $this->validate([
            'evalEmployeeId'    => 'required|exists:employees,id',
            'evalType'          => 'required|string',
            'evalPeriodStart'   => 'required|date',
            'evalPeriodEnd'     => 'required|date|after_or_equal:evalPeriodStart',
            'evalReviewDate'    => 'required|date',
            'evalStrengths'     => 'required|string|max:2000',
            'evalAreasForImprove' => 'required|string|max:2000',
            'evalDevelopmentPlan' => 'nullable|string|max:2000',
            'evalEmployeeComments'=> 'nullable|string|max:2000',
            'metricTechnical'    => 'required|integer|min:1|max:5',
            'metricCommunication'=> 'required|integer|min:1|max:5',
            'metricTeamwork'     => 'required|integer|min:1|max:5',
            'metricLeadership'   => 'required|integer|min:1|max:5',
            'metricProblemSolving'  => 'required|integer|min:1|max:5',
            'metricTimeManagement'  => 'required|integer|min:1|max:5',
        ]);

        $overallScore  = $this->computedScore;
        $overallRating = $this->scoreToRating($overallScore);

        DB::beginTransaction();
        try {
            $data = [
                'employee_id'         => $this->evalEmployeeId,
                'reviewer_id'         => Auth::user()->employee?->id ?? Auth::id(),
                'type'                => $this->evalType,
                'review_period_start' => $this->evalPeriodStart,
                'review_period_end'   => $this->evalPeriodEnd,
                'review_date'         => $this->evalReviewDate,
                'overall_score'       => $overallScore,
                'overall_rating'      => $overallRating,
                'status'              => $this->evalStatus,
                'approval_status'     => $this->evalApprovalStatus,
                'strengths'           => $this->evalStrengths,
                'areas_for_improvement' => $this->evalAreasForImprove,
                'development_plan'    => $this->evalDevelopmentPlan,
                'employee_comments'   => $this->evalEmployeeComments,
                'created_by'          => Auth::id(),
            ];

            if ($this->editingId) {
                $review = PerformanceReview::findOrFail($this->editingId);
                $review->update($data);
                $review->items()->delete();
                $msg = 'Evaluation updated successfully.';
            } else {
                $data['code'] = $this->evalCode;
                $review = PerformanceReview::create($data);
                $msg = 'Evaluation created successfully.';
            }

            // Save metric items
            foreach (self::METRICS as $prop => $label) {
                PerformanceReviewItem::create([
                    'code'                 => $this->generateItemCode(),
                    'performance_review_id'=> $review->id,
                    'criteria'             => $label,
                    'score'                => $this->$prop,
                    'rating'               => $this->scoreToRating($this->$prop),
                    'weight'               => 1,
                    'comments'             => '',
                    'approval_status'      => $this->evalApprovalStatus,
                    'created_by'           => Auth::id(),
                ]);
            }

            DB::commit();
            $this->closeModals();
            session()->flash('success', $msg);
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Save failed: ' . $e->getMessage());
        }
    }

    // ── Delete ───────────────────────────────────────────────
    public function deleteReview(): void
    {
        try {
            $r = PerformanceReview::findOrFail($this->deletingId);
            $r->items()->delete();
            $r->delete();
            $this->closeModals();
            session()->flash('success', 'Review deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Delete failed: ' . $e->getMessage());
            $this->closeModals();
        }
    }

    // ── Approve / Reject ─────────────────────────────────────
    public function approveReview(int $id): void
    {
        try {
            PerformanceReview::findOrFail($id)->update(['approval_status' => 'approved']);
            session()->flash('success', 'Review approved.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function rejectReview(int $id): void
    {
        try {
            PerformanceReview::findOrFail($id)->update(['approval_status' => 'rejected']);
            session()->flash('success', 'Review rejected.');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    // ── Reset ────────────────────────────────────────────────
    private function resetEvalForm(): void
    {
        $this->editingId            = null;
        $this->evalCode             = '';
        $this->evalEmployeeId       = '';
        $this->evalType             = 'Annual Review';
        $this->evalPeriodStart      = now()->startOfMonth()->format('Y-m-d');
        $this->evalPeriodEnd        = now()->endOfMonth()->format('Y-m-d');
        $this->evalReviewDate       = now()->format('Y-m-d');
        $this->evalStatus           = 'completed';
        $this->evalOverallRating    = 'good';
        $this->evalApprovalStatus   = 'draft';
        $this->evalStrengths        = '';
        $this->evalAreasForImprove  = '';
        $this->evalDevelopmentPlan  = '';
        $this->evalEmployeeComments = '';
        $this->metricTechnical      = 3;
        $this->metricCommunication  = 3;
        $this->metricTeamwork       = 3;
        $this->metricLeadership     = 3;
        $this->metricProblemSolving = 3;
        $this->metricTimeManagement = 3;
        $this->resetValidation();
    }

    // ── Render ───────────────────────────────────────────────
    public function render()
    {
        // ── Dashboard stats ──────────────────────────────────
        $totalEmployees    = 0;
        $totalReviews      = 0;
        $pendingReviews    = 0;
        $avgScore          = 0;
        $selfEvalCount     = 0;
        $approvedReviews   = 0;

        try { $totalEmployees  = Employee::count(); } catch (\Exception $e) {}
        try { $totalReviews    = PerformanceReview::count(); } catch (\Exception $e) {}
        try { $pendingReviews  = PerformanceReview::where('approval_status','pending')->count(); } catch (\Exception $e) {}
        try { $avgScore        = round(PerformanceReview::avg('overall_score') ?? 0, 2); } catch (\Exception $e) {}
        try { $selfEvalCount   = PerformanceReview::where('type','Self Evaluation')->count(); } catch (\Exception $e) {}
        try { $approvedReviews = PerformanceReview::where('approval_status','approved')->count(); } catch (\Exception $e) {}

        // ── Recent reviews for dashboard ─────────────────────
        $recentReviews = collect();
        try {
            $recentReviews = PerformanceReview::with(['employee', 'reviewer'])
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();
        } catch (\Exception $e) {}

        // ── Reviews list (paginated) ─────────────────────────
        $reviews = collect();
        try {
            $query = PerformanceReview::with(['employee.department', 'reviewer'])
                ->when($this->search, fn($q) => $q->where(function ($q2) {
                    $q2->where('code', 'like', "%{$this->search}%")
                       ->orWhereHas('employee', fn($q3) =>
                           $q3->where('first_name', 'like', "%{$this->search}%")
                              ->orWhere('last_name',  'like', "%{$this->search}%")
                       );
                }))
                ->when($this->filterReviewType, fn($q) => $q->where('type', $this->filterReviewType))
                ->when($this->filterRating,     fn($q) => $q->where('overall_rating', $this->filterRating))
                ->when($this->filterStatus,     fn($q) => $q->where('approval_status', $this->filterStatus))
                ->when($this->filterDept, fn($q) => $q->whereHas('employee.department', fn($q2) =>
                    $q2->where('id', $this->filterDept)
                ))
                ->orderBy('review_date', 'desc');

            $reviews = $query->paginate($this->perPage)->withQueryString();
        } catch (\Exception $e) {}

        // ── Employees list ───────────────────────────────────
        $employees = collect();
        try {
            $empQuery = Employee::with(['department', 'position'])
                ->withCount('performanceReviews')
                ->when($this->search, fn($q) => $q->where(function ($q2) {
                    $q2->where('first_name', 'like', "%{$this->search}%")
                       ->orWhere('last_name',  'like', "%{$this->search}%")
                       ->orWhere('code',       'like', "%{$this->search}%");
                }))
                ->when($this->filterDept, fn($q) => $q->where('department_id', $this->filterDept))
                ->orderBy('first_name');

            $employees = $empQuery->paginate($this->perPage)->withQueryString();
        } catch (\Exception $e) {}

        // ── Employee detail ──────────────────────────────────
        $selectedEmployee        = null;
        $employeeReviews         = collect();
        $employeeGoals           = collect();
        $employeeSelfEvals       = collect();

        if ($this->viewingEmployeeId) {
            try {
                $selectedEmployee  = Employee::with(['department','position'])->find($this->viewingEmployeeId);
                $employeeReviews   = PerformanceReview::with(['reviewer','items'])
                    ->where('employee_id', $this->viewingEmployeeId)
                    ->orderBy('review_date','desc')->get();
                $employeeGoals     = Goal::where('employee_id', $this->viewingEmployeeId)
                    ->orderBy('created_at','desc')->get();
                $employeeSelfEvals = PerformanceReview::with('items')
                    ->where('employee_id', $this->viewingEmployeeId)
                    ->where('type', 'Self Evaluation')
                    ->orderBy('review_date','desc')->get();
            } catch (\Exception $e) {}
        }

        // ── Viewing review detail ────────────────────────────
        $viewingReview = null;
        if ($this->viewingReviewId) {
            try {
                $viewingReview = PerformanceReview::with(['employee.department','reviewer','items'])
                    ->find($this->viewingReviewId);
            } catch (\Exception $e) {}
        }

        // ── Departments for filter ────────────────────────────
        $departments = collect();
        try { $departments = \App\Models\Department::orderBy('name')->get(['id','name']); } catch (\Exception $e) {}

        // ── Employee list for eval form ───────────────────────
        $employeeList = collect();
        try { $employeeList = Employee::orderBy('first_name')->get(['id','first_name','last_name','code']); } catch (\Exception $e) {}

        return view('livewire.hr.hr-performance', [
            'totalEmployees'   => $totalEmployees,
            'totalReviews'     => $totalReviews,
            'pendingReviews'   => $pendingReviews,
            'avgScore'         => $avgScore,
            'selfEvalCount'    => $selfEvalCount,
            'approvedReviews'  => $approvedReviews,
            'recentReviews'    => $recentReviews,
            'reviews'          => $reviews,
            'employees'        => $employees,
            'selectedEmployee' => $selectedEmployee,
            'employeeReviews'  => $employeeReviews,
            'employeeGoals'    => $employeeGoals,
            'employeeSelfEvals'=> $employeeSelfEvals,
            'viewingReview'    => $viewingReview,
            'departments'      => $departments,
            'employeeList'     => $employeeList,
            'reviewTypes'      => self::REVIEW_TYPES,
            'ratings'          => self::RATINGS,
            'approvalStatuses' => self::APPROVAL_STATUSES,
            'metrics'          => self::METRICS,
        ])->layout('components.layouts.app');
    }

    // Add __invoke method for routing
    public function __invoke()
    {
        return $this->render();
    }
}

// Alias class for routing compatibility
class PerformanceDashboard extends Component
{
    use WithPagination;

    // ── Active section ──────────────────────────────────────
    public string $activeSection = 'dashboard';

    // ── Filters ─────────────────────────────────────────────
    public string $search           = '';
    public string $filterDept       = '';
    public string $filterReviewType = '';
    public string $filterRating     = '';
    public string $filterStatus     = '';
    public int    $perPage          = 15;

    // ── Selected records ────────────────────────────────────
    public ?int $viewingEmployeeId = null;
    public ?int $viewingReviewId   = null;

    // ── Modal state ─────────────────────────────────────────
    public bool $showEvalModal   = false;
    public bool $showViewModal   = false;
    public bool $showDeleteModal = false;
    public ?int $deletingId      = null;
    public ?int $editingId       = null;

    // ══ EVALUATION FORM FIELDS ═══════════════════════════════
    public string $evalCode             = '';
    public string $evalEmployeeId       = '';
    public string $evalType             = 'Annual Review';
    public string $evalPeriodStart      = '';
    public string $evalPeriodEnd        = '';
    public string $evalOverallRating    = '';
    public string $evalStrengths        = '';
    public string $evalAreasForImprovement = '';
    public string $evalGoals            = '';
    public string $evalComments         = '';
    public string $evalStatus          = 'pending';

    // Add __invoke method for routing compatibility
    public function __invoke()
    {
        return $this->render();
    }

    public function render()
    {
        // ── Dashboard stats ──────────────────────────────────
        $totalEmployees    = 0;
        $totalReviews      = 0;
        $pendingReviews    = 0;
        $avgScore          = 0;
        $selfEvalCount     = 0;
        $approvedReviews   = 0;

        try { $totalEmployees  = Employee::count(); } catch (\Exception $e) {}
        try { $totalReviews    = PerformanceReview::count(); } catch (\Exception $e) {}
        try { $pendingReviews  = PerformanceReview::where('approval_status','pending')->count(); } catch (\Exception $e) {}
        try { $avgScore        = round(PerformanceReview::avg('overall_score') ?? 0, 2); } catch (\Exception $e) {}
        try { $selfEvalCount   = PerformanceReview::where('type','Self Evaluation')->count(); } catch (\Exception $e) {}
        try { $approvedReviews = PerformanceReview::where('approval_status','approved')->count(); } catch (\Exception $e) {}

        // ── Recent reviews for dashboard ─────────────────────
        $recentReviews = collect();
        try {
            $recentReviews = PerformanceReview::with(['employee', 'reviewer'])
                ->orderBy('created_at', 'desc')
                ->take(8)
                ->get();
        } catch (\Exception $e) {}

        // ── Additional data for sections ─────────────────────────────
        $employeeList = collect();
        $reviews = collect();
        $viewingReview = null;
        $employeeReviews = collect();
        $employeeGoals = collect();
        $employeeSelfEvals = collect();
        $departments = collect();
        try { 
            $employeeList = Employee::orderBy('first_name')->get(['id','first_name','last_name','code']); 
            $reviews = PerformanceReview::with(['employee', 'reviewer'])->orderBy('created_at', 'desc')->take(50)->get();
        } catch (\Exception $e) {}

        return view('livewire.performance.performance-dashboard', [
            'activeSection' => $this->activeSection,
            'totalEmployees'   => $totalEmployees,
            'totalReviews'     => $totalReviews,
            'pendingReviews'   => $pendingReviews,
            'avgScore'         => $avgScore,
            'selfEvalCount'    => $selfEvalCount,
            'approvedReviews'  => $approvedReviews,
            'recentReviews'    => $recentReviews,
            'employeeList'     => $employeeList,
            'reviews'          => $reviews,
            'viewingReview'    => $viewingReview,
            'employeeReviews'  => $employeeReviews,
            'employeeGoals'    => $employeeGoals,
            'employeeSelfEvals'=> $employeeSelfEvals,
            'departments'      => $departments,
            'showEvalModal'   => $this->showEvalModal,
            'showViewModal'   => $this->showViewModal,
            'showDeleteModal' => $this->showDeleteModal,
            'editingId'       => $this->editingId,
            'deletingId'      => $this->deletingId,
        ])->layout('components.layouts.app');
    }
}