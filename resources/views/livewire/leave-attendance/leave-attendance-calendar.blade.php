<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Leave & Attendance Calendar</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">View attendance and leave schedules</p>
            </div>
            <div class="flex space-x-3">
                <select
                    wire:model.live="selectedEmployee"
                    class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
                    <option value="">All Employees</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                    @endforeach
                </select>
                <button
                    wire:click="toggleTeamView"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
                    {{ $showTeamView ? 'Personal View' : 'Team View' }}
                </button>
                <button
                    wire:click="toggleViewMode"
                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                >
                    {{ $viewMode === 'month' ? 'Week View' : 'Month View' }}
                </button>
            </div>
        </div>
    </div>

    <!-- Calendar Navigation -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-4">
                <button
                    wire:click="previousMonth"
                    class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md"
                >
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ \Carbon\Carbon::create($currentYear, $currentMonth, 1)->format('F Y') }}
                </h2>
                <button
                    wire:click="nextMonth"
                    class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md"
                >
                    <svg class="h-5 w-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            <button
                wire:click="goToToday"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium"
            >
                Today
            </button>
        </div>

        <!-- Calendar Grid -->
        <div class="calendar">
            <!-- Days of Week Header -->
            <div class="grid grid-cols-7 gap-px bg-gray-200 dark:bg-gray-700">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="bg-gray-50 dark:bg-gray-800 p-3 text-center text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $day }}
                    </div>
                @endforeach
            </div>

            <!-- Calendar Days -->
            <div class="grid grid-cols-7 gap-px bg-gray-200 dark:bg-gray-700">
                @foreach($calendarData as $week)
                    @foreach($week as $day)
                        @if($day === null)
                            <div class="bg-white dark:bg-gray-800 p-3 min-h-[100px]"></div>
                        @else
                            <div class="bg-white dark:bg-gray-800 p-3 min-h-[100px] @if($day['isToday']) ring-2 ring-blue-500 @endif @if($day['isWeekend']) bg-gray-50 dark:bg-gray-700 @endif">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-sm font-medium @if($day['isToday']) text-blue-600 dark:text-blue-400 @else text-gray-900 dark:text-white @endif">
                                        {{ $day['day'] }}
                                    </span>
                                    @if($day['events']->count() > 0)
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $day['events']->count() }}</span>
                                    @endif
                                </div>
                                
                                <div class="space-y-1">
                                    @foreach($day['events']->take(3) as $event)
                                        <div class="text-xs p-1 rounded cursor-pointer hover:opacity-80"
                                             style="background-color: {{ $event['color'] }}20; color: {{ $event['color'] }};">
                                            @if($event['type'] === 'attendance')
                                                <div class="flex items-center">
                                                    <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $event['employee'] }}
                                                </div>
                                            @elseif($event['type'] === 'leave')
                                                <div class="flex items-center">
                                                    <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    {{ $event['employee'] }}
                                                </div>
                                            @elseif($event['type'] === 'holiday')
                                                <div class="flex items-center">
                                                    <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    {{ $event['title'] }}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    
                                    @if($day['events']->count() > 3)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            +{{ $day['events']->count() - 3 }} more
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

    <!-- Legend -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Legend</h3>
        <div class="flex flex-wrap gap-4">
            <div class="flex items-center">
                <div class="w-4 h-4 bg-green-200 rounded mr-2"></div>
                <span class="text-sm text-gray-700 dark:text-gray-300">Present</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-yellow-200 rounded mr-2"></div>
                <span class="text-sm text-gray-700 dark:text-gray-300">Pending Attendance</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-blue-200 rounded mr-2"></div>
                <span class="text-sm text-gray-700 dark:text-gray-300">Approved Leave</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-orange-200 rounded mr-2"></div>
                <span class="text-sm text-gray-700 dark:text-gray-300">Pending Leave</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 bg-red-200 rounded mr-2"></div>
                <span class="text-sm text-gray-700 dark:text-gray-300">Holiday</span>
            </div>
        </div>
    </div>

    <!-- Event Details Modal (if needed) -->
    @if(isset($this->selectedDate))
        <div x-data="{ show: true }" x-show="show" style="display: none;">
            <div class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>

                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Events for {{ $this->selectedDate }}
                            </h3>
                            
                            <div class="space-y-3">
                                @foreach($this->events->where('date', $this->selectedDate) as $event)
                                    <div class="border-l-4 pl-4 py-2" style="border-color: {{ $event['color'] }};">
                                        <div class="font-medium text-gray-900">{{ $event['title'] }}</div>
                                        @if($event['type'] === 'attendance')
                                            <div class="text-sm text-gray-600">
                                                {{ $event['employee'] }} - {{ $event['check_in'] ?? 'No check-in' }}
                                            </div>
                                        @elseif($event['type'] === 'leave')
                                            <div class="text-sm text-gray-600">
                                                {{ $event['employee'] }} - {{ $event['status'] }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="button"
                                onclick="window.dispatchEvent(new CustomEvent('closeEventDetails'))"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.addEventListener('closeEventDetails', () => {
                Livewire.find('{{ $this->id }}').set('selectedDate', null);
            });
        </script>
    @endif
</div>
