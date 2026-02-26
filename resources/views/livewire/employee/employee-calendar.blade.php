<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">My Calendar</h1>
                <p class="text-gray-600 mt-2">View your personal calendar with leave requests and holidays</p>
            </div>
            <div class="flex items-center space-x-4">
                <button wire:click="previousMonth" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <div class="text-lg font-medium text-gray-900">
                    {{ \Carbon\Carbon::create($this->currentYear, $this->currentMonth)->format('F Y') }}
                </div>
                <button wire:click="nextMonth" class="px-3 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Calendar -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <!-- Weekday Headers -->
            <div class="grid grid-cols-7 gap-2 mb-4">
                <div class="text-center text-sm font-medium text-gray-700 py-2">Sun</div>
                <div class="text-center text-sm font-medium text-gray-700 py-2">Mon</div>
                <div class="text-center text-sm font-medium text-gray-700 py-2">Tue</div>
                <div class="text-center text-sm font-medium text-gray-700 py-2">Wed</div>
                <div class="text-center text-sm font-medium text-gray-700 py-2">Thu</div>
                <div class="text-center text-sm font-medium text-gray-700 py-2">Fri</div>
                <div class="text-center text-sm font-medium text-gray-700 py-2">Sat</div>
            </div>

            <!-- Calendar Days -->
            <div class="grid grid-cols-7 gap-2">
                @foreach($calendarDays as $day)
                    <div class="border rounded-lg p-2 min-h-[100px] 
                        @if(!$day['isCurrentMonth']) bg-gray-50 border-gray-200
                        @elseif($day['isToday']) bg-blue-50 border-blue-300
                        @elseif($day['isWeekend']) bg-red-50 border-red-200
                        @else bg-white border-gray-300
                        @endif">
                        
                        <div class="text-sm font-medium 
                            @if(!$day['isCurrentMonth']) text-gray-400
                            @elseif($day['isToday']) text-blue-600
                            @elseif($day['isWeekend']) text-red-600
                            @else text-gray-900
                            @endif">
                            {{ $day['date'] }}
                        </div>

                        <!-- Leave Requests -->
                        @if(count($day['leaveRequests']) > 0)
                            <div class="mt-1 space-y-1">
                                @foreach($day['leaveRequests'] as $leaveRequest)
                                    <div class="text-xs bg-yellow-100 text-yellow-800 px-1 py-0.5 rounded truncate" title="{{ $leaveRequest->leaveType->name }}">
                                        {{ $leaveRequest->leaveType->name }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
 
                        <!-- Holidays -->
                        @if(count($day['holidays']) > 0)
                            <div class="mt-1 space-y-1">
                                @foreach($day['holidays'] as $holiday)
                                    <div class="text-xs bg-green-100 text-green-800 px-1 py-0.5 rounded truncate" title="{{ $holiday->name }}">
                                        {{ $holiday->name }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Legend -->
            <div class="mt-6 flex flex-wrap gap-4 text-sm">
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-blue-50 border border-blue-300 rounded mr-2"></div>
                    <span class="text-gray-700">Today</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-red-50 border border-red-200 rounded mr-2"></div>
                    <span class="text-gray-700">Weekend</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-yellow-100 text-yellow-800 rounded mr-2"></div>
                    <span class="text-gray-700">Leave</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-green-100 text-green-800 rounded mr-2"></div>
                    <span class="text-gray-700">Holiday</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Leave Requests -->
    <div class="bg-white rounded-lg shadow mt-6">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Leave Requests</h3>
            
            @if($this->leaveRequests->count() > 0)
                <div class="space-y-3">
                    @foreach($this->leaveRequests->sortBy('start_date')->take(5) as $leaveRequest)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900">{{ $leaveRequest->leaveType->name }}</p>
                                <p class="text-sm text-gray-600">
                                    {{ $leaveRequest->start_date->format('M d, Y') }} - {{ $leaveRequest->end_date->format('M d, Y') }}
                                    ({{ $leaveRequest->total_days }} days)
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($leaveRequest->status->value === 'approved') bg-green-100 text-green-800
                                @elseif($leaveRequest->status->value === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($leaveRequest->status->value === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($leaveRequest->status->value) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No upcoming leave requests for this month</p>
            @endif
        </div>
    </div>
</div>
