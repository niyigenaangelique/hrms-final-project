<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\PerformanceReview;
use App\Models\Goal;
use App\Models\Achievement;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('TalentFlow Pro | My Performance')]
class EmployeePerformance extends Component
{
    public $employee;
    public $performanceReviews;
    public $goals;
    public $achievements;
    public $selectedReview = null;
    public $selectedGoal = null;
    public $showGoalForm = false;
    public $goalTitle = '';
    public $goalDescription = '';
    public $goalTargetDate = '';
    public $goalStatus = 'active';
    public $activeSection = 'overview';
    
    // Self performance evaluation properties
    public $showSelfEvaluationForm = false;
    public $selfEvaluationPeriod = '';
    public $selfTechnicalSkills = 3;
    public $selfCommunication = 3;
    public $selfTeamwork = 3;
    public $selfLeadership = 3;
    public $selfProblemSolving = 3;
    public $selfTimeManagement = 3;
    public $selfStrengths = '';
    public $selfAreasForImprovement = '';
    public $selfGoals = '';
    public $selfAdditionalComments = '';

    public function mount()
    {
        $user = Auth::user();
        $this->employee = Employee::where('user_id', $user->id)
            ->with(['position', 'department'])
            ->first();

        if (!$this->employee) {
            // Smart Link: Check by email
            $this->employee = Employee::where('email', $user->email)
                ->with(['position', 'department'])
                ->first();
                
            if ($this->employee) {
                // Link found employee to current user
                $this->employee->update(['user_id' => $user->id]);
            } else {
                // Create if still not found
                $this->createEmployeeRecord($user);
            }
        }
        
        if ($this->employee) {
            $this->loadPerformanceData();
        }
    }
    
    public function createEmployeeRecord($user)
    {
        try {
            // Generate unique employee code
            $lastEmployee = Employee::orderBy('created_at', 'desc')->first();
            $lastCode = $lastEmployee ? intval(substr($lastEmployee->code, -4)) : 0;
            $newCode = 'EMP-' . str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);
            
            // Ensure code is unique
            while (Employee::where('code', $newCode)->exists()) {
                $lastCode++;
                $newCode = 'EMP-' . str_pad($lastCode, 4, '0', STR_PAD_LEFT);
            }
            
            $this->employee = Employee::create([
                'code' => $newCode,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'user_id' => $user->id,
                'approval_status' => \App\Enum\ApprovalStatus::Approved,
            ])->load(['position', 'department']);
            
            $this->loadPerformanceData();
        } catch (\Exception $e) {
            \Log::error('Failed to create employee record: ' . $e->getMessage());
            session()->flash('error', 'Unable to initialize employee profile. Please contact HR.');
        }
    }

    public function loadPerformanceData()
    {
        $this->performanceReviews = PerformanceReview::where('employee_id', $this->employee->id)
            ->with(['reviewer'])
            ->orderBy('review_date', 'desc')
            ->get();

        $this->goals = Goal::where('employee_id', $this->employee->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $this->achievements = Achievement::where('employee_id', $this->employee->id)
            ->orderBy('achieved_date', 'desc')
            ->get();
    }

    public function testClick()
    {
        session()->flash('success', 'Test button clicked! Livewire is working.');
    }

    public function viewReview($reviewId = null)
    {
        if ($reviewId) {
            // Specific review requested
            $this->selectedReview = PerformanceReview::with(['reviewer', 'items'])
                ->find($reviewId);
                
            if ($this->selectedReview) {
                session()->flash('success', 'Review opened: ' . $this->selectedReview->type);
            } else {
                session()->flash('error', 'Review not found.');
            }
        } else {
            // No specific review, show first available
            if ($this->performanceReviews && $this->performanceReviews->count() > 0) {
                $firstReview = $this->performanceReviews->first();
                $this->selectedReview = PerformanceReview::with(['reviewer', 'items'])
                    ->find($firstReview->id);
                    
                if ($this->selectedReview) {
                    session()->flash('success', 'Review opened: ' . $this->selectedReview->type);
                } else {
                    session()->flash('error', 'Failed to load review details.');
                }
            } else {
                session()->flash('error', 'No reviews available to view.');
            }
        }
    }

    public function viewGoal($goalId)
    {
        $this->selectedGoal = Goal::find($goalId);
        
        if ($this->selectedGoal) {
            session()->flash('success', 'Goal opened: ' . $this->selectedGoal->title);
        } else {
            session()->flash('error', 'Goal not found.');
        }
    }

    public function closeModals()
    {
        $this->selectedReview = null;
        $this->selectedGoal = null;
        $this->showGoalForm = false;
        $this->showSelfEvaluationForm = false;
        $this->reset([
            'goalTitle', 'goalDescription', 'goalTargetDate', 'goalStatus',
            'selfEvaluationPeriod', 'selfTechnicalSkills', 'selfCommunication', 
            'selfTeamwork', 'selfLeadership', 'selfProblemSolving', 'selfTimeManagement',
            'selfStrengths', 'selfAreasForImprovement', 'selfGoals', 'selfAdditionalComments'
        ]);
    }

    public function openGoalForm()
    {
        $this->showGoalForm = true;
        $this->goalTargetDate = now()->addMonths(3)->format('Y-m-d');
    }
    
    public function openSelfEvaluationForm()
    {
        $this->showSelfEvaluationForm = true;
        $this->selfEvaluationPeriod = now()->format('Y-m') . '-01';
    }

    public function createGoal()
    {
        $this->validate([
            'goalTitle' => 'required|string|max:255',
            'goalDescription' => 'required|string|max:1000',
            'goalTargetDate' => 'required|date|after:today',
            'goalStatus' => 'required|in:active,completed,on_hold',
        ]);

        try {
            // Generate goal code
            $lastGoal = Goal::orderBy('created_at', 'desc')->first();
            $lastCode = $lastGoal ? intval(substr($lastGoal->code, -4)) : 0;
            $newCode = 'GOAL-' . str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);

            Goal::create([
                'code' => $newCode,
                'employee_id' => $this->employee->id,
                'manager_id' => $this->employee->manager_id ?? $this->employee->id, // Use manager or self if no manager
                'title' => $this->goalTitle,
                'description' => $this->goalDescription,
                'category' => 'personal', // Default category for self-created goals
                'priority' => 'medium', // Default priority
                'start_date' => now(),
                'end_date' => $this->goalTargetDate,
                'status' => $this->goalStatus,
                'progress_percentage' => 0,
                'approval_status' => \App\Enum\ApprovalStatus::Initiated,
                'created_by' => Auth::id(),
            ]);

            $this->loadPerformanceData();
            $this->closeModals();
            session()->flash('success', 'Goal created successfully!');
        } catch (\Exception $e) {
            \Log::error('Goal creation failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to create goal. Please try again.');
        }
    }

    public function updateGoalStatus($goalId, $status)
    {
        try {
            $goal = Goal::where('employee_id', $this->employee->id)->find($goalId);
            if ($goal) {
                if ($status === 'completed') {
                    $goal->markCompleted();
                } else {
                    $goal->update(['status' => $status]);
                }
                $this->loadPerformanceData();
                session()->flash('success', 'Goal status updated successfully!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update goal status.');
        }
    }
    
    public function submitSelfEvaluation()
    {
        // Check if employee exists
        if (!$this->employee) {
            session()->flash('error', 'Employee profile not found. Please contact HR.');
            return;
        }
        
        $this->validate([
            'selfEvaluationPeriod' => 'required|date',
            'selfTechnicalSkills' => 'required|numeric|min:1|max:5',
            'selfCommunication' => 'required|numeric|min:1|max:5',
            'selfTeamwork' => 'required|numeric|min:1|max:5',
            'selfLeadership' => 'required|numeric|min:1|max:5',
            'selfProblemSolving' => 'required|numeric|min:1|max:5',
            'selfTimeManagement' => 'required|numeric|min:1|max:5',
            'selfStrengths' => 'required|string|max:1000',
            'selfAreasForImprovement' => 'required|string|max:1000',
            'selfGoals' => 'required|string|max:1000',
            'selfAdditionalComments' => 'nullable|string|max:1000',
        ]);

        try {
            // Generate performance review code
            $lastReview = PerformanceReview::orderBy('created_at', 'desc')->first();
            $lastCode = 0;
            if ($lastReview && !empty($lastReview->code)) {
                // Extract numeric part from code (handle formats like PERF-0001, PERF-1234, etc.)
                $codeParts = explode('-', $lastReview->code);
                if (count($codeParts) >= 2) {
                    $numericPart = end($codeParts);
                    $lastCode = is_numeric($numericPart) ? intval($numericPart) : 0;
                }
            }
            $newCode = 'PERF-' . str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);
            
            // Ensure code is unique
            while (PerformanceReview::where('code', $newCode)->exists()) {
                $lastCode++;
                $newCode = 'PERF-' . str_pad($lastCode, 4, '0', STR_PAD_LEFT);
            }

            // Calculate overall score
            $overallScore = (
                $this->selfTechnicalSkills + 
                $this->selfCommunication + 
                $this->selfTeamwork + 
                $this->selfLeadership + 
                $this->selfProblemSolving + 
                $this->selfTimeManagement
            ) / 6;

            // Determine overall rating based on score
            if ($overallScore >= 4.5) {
                $overallRating = 'excellent';
            } elseif ($overallScore >= 3.5) {
                $overallRating = 'good';
            } elseif ($overallScore >= 2.5) {
                $overallRating = 'satisfactory';
            } else {
                $overallRating = 'needs_improvement';
            }

            // Create performance review
            $review = PerformanceReview::create([
                'code' => $newCode,
                'employee_id' => $this->employee->id,
                'reviewer_id' => $this->employee->id, // Self-review
                'review_period_start' => $this->selfEvaluationPeriod,
                'review_period_end' => $this->selfEvaluationPeriod,
                'type' => 'Self Evaluation',
                'overall_rating' => $overallRating,
                'overall_score' => $overallScore,
                'strengths' => $this->selfStrengths,
                'areas_for_improvement' => $this->selfAreasForImprovement,
                'development_plan' => $this->selfGoals,
                'employee_comments' => $this->selfAdditionalComments,
                'status' => 'completed',
                'review_date' => now(),
                'approval_status' => \App\Enum\ApprovalStatus::Initiated,
                'created_by' => Auth::id(),
            ]);

            // Create performance review items for each metric
            $metrics = [
                'Technical Skills' => $this->selfTechnicalSkills,
                'Communication' => $this->selfCommunication,
                'Teamwork' => $this->selfTeamwork,
                'Leadership' => $this->selfLeadership,
                'Problem Solving' => $this->selfProblemSolving,
                'Time Management' => $this->selfTimeManagement,
            ];

            foreach ($metrics as $criteria => $score) {
                // Generate item code
                $lastItem = \App\Models\PerformanceReviewItem::orderBy('created_at', 'desc')->first();
                $lastItemCode = 0;
                if ($lastItem && !empty($lastItem->code)) {
                    // Extract numeric part from code (handle formats like ITEM-0001, ITEM-1234, etc.)
                    $codeParts = explode('-', $lastItem->code);
                    if (count($codeParts) >= 2) {
                        $numericPart = end($codeParts);
                        $lastItemCode = is_numeric($numericPart) ? intval($numericPart) : 0;
                    }
                }
                $newItemCode = 'ITEM-' . str_pad($lastItemCode + 1, 4, '0', STR_PAD_LEFT);
                
                // Ensure code is unique
                while (\App\Models\PerformanceReviewItem::where('code', $newItemCode)->exists()) {
                    $lastItemCode++;
                    $newItemCode = 'ITEM-' . str_pad($lastItemCode, 4, '0', STR_PAD_LEFT);
                }

                \App\Models\PerformanceReviewItem::create([
                    'code' => $newItemCode,
                    'performance_review_id' => $review->id,
                    'criteria' => $criteria,
                    'rating' => $score >= 4 ? 'excellent' : ($score >= 3 ? 'good' : ($score >= 2 ? 'satisfactory' : 'needs_improvement')),
                    'score' => $score,
                    'weight' => 1, // Equal weight for all metrics
                    'comments' => 'Self-rated performance',
                    'approval_status' => \App\Enum\ApprovalStatus::Initiated,
                    'created_by' => Auth::id(),
                ]);
            }

            $this->loadPerformanceData();
            $this->closeModals();
            session()->flash('success', 'Self evaluation submitted successfully!');
        } catch (\Exception $e) {
            \Log::error('Self evaluation submission failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            session()->flash('error', 'Failed to submit self evaluation: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.employee.employee-performance')
            ->layout('components.layouts.employee');
    }
}
