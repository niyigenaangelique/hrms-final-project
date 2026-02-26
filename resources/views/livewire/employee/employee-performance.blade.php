<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">My Performance</h1>
                <p class="text-gray-600 mt-2">Track your performance reviews, goals, and achievements</p>
            </div>
            <div class="flex space-x-3">
                <button wire:click="openSelfEvaluationForm" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Self Evaluation
                </button>
                <button wire:click="openGoalForm" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Goal
                </button>
            </div>
        </div>
    </div>

    <!-- Performance Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Performance Score Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Latest Performance Score</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $performanceReviews->first()?->overall_score ?? 'N/A' }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Goals Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Active Goals</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $goals->where('status', 'active')->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Achievements Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Achievements</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $achievements->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Reviews Section -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Performance Reviews</h2>
            @if($performanceReviews->count() > 0)
                <div class="space-y-4">
                    @foreach($performanceReviews as $review)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-medium text-gray-900">
                                        {{ $review->review_type ?? 'Performance Review' }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        Reviewed by: {{ $review->reviewer?->name ?? 'HR' }} on {{ $review->review_date->format('M d, Y') }}
                                    </p>
                                    <div class="mt-2">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($review->overall_score >= 4.5) bg-green-100 text-green-800
                                            @elseif($review->overall_score >= 3.5) bg-blue-100 text-blue-800
                                            @elseif($review->overall_score >= 2.5) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            Score: {{ $review->overall_score }}/5.0
                                        </span>
                                    </div>
                                </div>
                                <button wire:click="viewReview('{{ $review->id }}')" class="text-blue-600 hover:text-blue-900 text-sm">
                                    View Details
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No performance reviews yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Your performance reviews will appear here.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Goals Section -->
    <div class="bg-white rounded-lg shadow mb-6">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">My Goals</h2>
            @if($goals->count() > 0)
                <div class="space-y-4">
                    @foreach($goals as $goal)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $goal->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $goal->description }}</p>
                                    <div class="mt-2 flex items-center space-x-4">
                                        <span class="text-xs text-gray-500">
                                            Target: {{ $goal->end_date->format('M d, Y') }}
                                        </span>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($goal->status === 'completed') bg-green-100 text-green-800
                                            @elseif($goal->status === 'active') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($goal->status) }}
                                        </span>
                                        @if($goal->progress_percentage)
                                            <span class="text-xs text-gray-500">
                                                Progress: {{ $goal->progress_percentage }}%
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($goal->status === 'active')
                                        <button wire:click="updateGoalStatus('{{ $goal->id }}', 'completed')" 
                                                class="text-green-600 hover:text-green-900 text-sm">
                                            Mark Complete
                                        </button>
                                    @endif
                                    <button wire:click="viewGoal('{{ $goal->id }}')" 
                                            class="text-blue-600 hover:text-blue-900 text-sm">
                                        View
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No goals set yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Start by creating your first goal.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Achievements Section -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Achievements</h2>
            @if($achievements->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($achievements as $achievement)
                        <div class="border border-gray-200 rounded-lg p-4 text-center hover:bg-gray-50">
                            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                            </div>
                            <h3 class="font-medium text-gray-900">{{ $achievement->title }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $achievement->description }}</p>
                            <p class="text-xs text-gray-500 mt-2">
                                {{ $achievement->achieved_date->format('M d, Y') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No achievements yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Your achievements will be displayed here.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Performance Review Details Modal -->
    @if($selectedReview)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Performance Review Details</h3>
                        <button wire:click="closeModals" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Review Information</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Review Type:</span>
                                    <span class="text-sm font-medium">{{ $selectedReview->review_type ?? 'Performance Review' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Review Date:</span>
                                    <span class="text-sm font-medium">{{ $selectedReview->review_date->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Reviewer:</span>
                                    <span class="text-sm font-medium">{{ $selectedReview->reviewer?->name ?? 'HR' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Overall Score:</span>
                                    <span class="text-sm font-bold text-blue-600">{{ $selectedReview->overall_score }}/5.0</span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Performance Areas</h4>
                            <div class="space-y-2">
                                @if($selectedReview->technical_skills)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Technical Skills:</span>
                                        <span class="text-sm font-medium">{{ $selectedReview->technical_skills }}/5</span>
                                    </div>
                                @endif
                                @if($selectedReview->communication)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Communication:</span>
                                        <span class="text-sm font-medium">{{ $selectedReview->communication }}/5</span>
                                    </div>
                                @endif
                                @if($selectedReview->teamwork)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Teamwork:</span>
                                        <span class="text-sm font-medium">{{ $selectedReview->teamwork }}/5</span>
                                    </div>
                                @endif
                                @if($selectedReview->leadership)
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Leadership:</span>
                                        <span class="text-sm font-medium">{{ $selectedReview->leadership }}/5</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($selectedReview->strengths)
                        <div class="mt-6">
                            <h4 class="font-semibold text-gray-900 mb-2">Strengths</h4>
                            <p class="text-sm text-gray-700">{{ $selectedReview->strengths }}</p>
                        </div>
                    @endif

                    @if($selectedReview->areas_for_improvement)
                        <div class="mt-6">
                            <h4 class="font-semibold text-gray-900 mb-2">Areas for Improvement</h4>
                            <p class="text-sm text-gray-700">{{ $selectedReview->areas_for_improvement }}</p>
                        </div>
                    @endif

                    @if($selectedReview->comments)
                        <div class="mt-6">
                            <h4 class="font-semibold text-gray-900 mb-2">Additional Comments</h4>
                            <p class="text-sm text-gray-700">{{ $selectedReview->comments }}</p>
                        </div>
                    @endif

                    <div class="mt-6 pt-4 border-t">
                        <button wire:click="closeModals" class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Goal Details Modal -->
    @if($selectedGoal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Goal Details</h3>
                        <button wire:click="closeModals" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $selectedGoal->title }}</h4>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                @if($selectedGoal->status === 'completed') bg-green-100 text-green-800
                                @elseif($selectedGoal->status === 'active') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($selectedGoal->status) }}
                            </span>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Description</label>
                            <p class="text-gray-900">{{ $selectedGoal->description }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Start Date</label>
                                <p class="text-gray-900">{{ $selectedGoal->start_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Target Date</label>
                                <p class="text-gray-900">{{ $selectedGoal->end_date->format('M d, Y') }}</p>
                            </div>
                            @if($selectedGoal->progress_percentage)
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Progress</label>
                                    <p class="text-gray-900">{{ $selectedGoal->progress_percentage }}%</p>
                                </div>
                            @endif
                            <div>
                                <label class="text-sm font-medium text-gray-600">Created Date</label>
                                <p class="text-gray-900">{{ $selectedGoal->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        @if($selectedGoal->status === 'active')
                            <div class="pt-4 border-t">
                                <button wire:click="updateGoalStatus('{{ $selectedGoal->id }}', 'completed')" 
                                        class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Mark as Completed
                                </button>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t">
                        <button wire:click="closeModals" class="w-full px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Add Goal Modal -->
    @if($showGoalForm)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-2xl shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Create New Goal</h3>
                        <button wire:click="closeModals" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="createGoal">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Goal Title</label>
                                <input wire:model="goalTitle" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter goal title">
                                @error('goalTitle')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea wire:model="goalDescription" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Describe your goal..."></textarea>
                                @error('goalDescription')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Target Date</label>
                                <input wire:model="goalTargetDate" type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('goalTargetDate')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select wire:model="goalStatus" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="active">Active</option>
                                    <option value="on_hold">On Hold</option>
                                </select>
                                @error('goalStatus')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t">
                            <div class="flex justify-end space-x-3">
                                <button type="button" wire:click="closeModals" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Create Goal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Self Evaluation Modal -->
    @if($showSelfEvaluationForm)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-10 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white max-h-screen overflow-y-auto">
                <div class="mt-3">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-medium text-gray-900">Self Performance Evaluation</h3>
                        <button wire:click="closeModals" class="text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="submitSelfEvaluation">
                        <div class="space-y-6">
                            <!-- Evaluation Period -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Evaluation Period</label>
                                <input wire:model="selfEvaluationPeriod" type="month" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                @error('selfEvaluationPeriod')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Performance Areas -->
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-4">Rate Your Performance (1-5 Scale)</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Technical Skills</label>
                                        <div class="flex items-center space-x-2">
                                            <input wire:model="selfTechnicalSkills" type="range" min="1" max="5" class="flex-1">
                                            <span class="w-8 text-center font-semibold">{{ $selfTechnicalSkills }}</span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Communication</label>
                                        <div class="flex items-center space-x-2">
                                            <input wire:model="selfCommunication" type="range" min="1" max="5" class="flex-1">
                                            <span class="w-8 text-center font-semibold">{{ $selfCommunication }}</span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Teamwork</label>
                                        <div class="flex items-center space-x-2">
                                            <input wire:model="selfTeamwork" type="range" min="1" max="5" class="flex-1">
                                            <span class="w-8 text-center font-semibold">{{ $selfTeamwork }}</span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Leadership</label>
                                        <div class="flex items-center space-x-2">
                                            <input wire:model="selfLeadership" type="range" min="1" max="5" class="flex-1">
                                            <span class="w-8 text-center font-semibold">{{ $selfLeadership }}</span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Problem Solving</label>
                                        <div class="flex items-center space-x-2">
                                            <input wire:model="selfProblemSolving" type="range" min="1" max="5" class="flex-1">
                                            <span class="w-8 text-center font-semibold">{{ $selfProblemSolving }}</span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Time Management</label>
                                        <div class="flex items-center space-x-2">
                                            <input wire:model="selfTimeManagement" type="range" min="1" max="5" class="flex-1">
                                            <span class="w-8 text-center font-semibold">{{ $selfTimeManagement }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Text Areas -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Strengths</label>
                                    <textarea wire:model="selfStrengths" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Describe your key strengths and accomplishments..."></textarea>
                                    @error('selfStrengths')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Areas for Improvement</label>
                                    <textarea wire:model="selfAreasForImprovement" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Describe areas where you can improve..."></textarea>
                                    @error('selfAreasForImprovement')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Goals and Objectives</label>
                                    <textarea wire:model="selfGoals" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="What are your professional goals for the next period?"></textarea>
                                    @error('selfGoals')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Additional Comments</label>
                                    <textarea wire:model="selfAdditionalComments" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Any additional comments or feedback..."></textarea>
                                    @error('selfAdditionalComments')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t">
                            <div class="flex justify-end space-x-3">
                                <button type="button" wire:click="closeModals" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    Submit Evaluation
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
