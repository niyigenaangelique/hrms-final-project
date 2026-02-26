<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">My Calendar</h1>
                <p class="text-gray-600 mt-2">View your personal leave schedule and company holidays</p>
            </div>
            @if($hrEmployee)
                <div class="text-right">
                    <p class="text-sm text-gray-500">HR Staff</p>
                    <p class="font-medium text-gray-900">{{ $hrEmployee->first_name }} {{ $hrEmployee->last_name }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Calendar -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <!-- Month Navigation -->
            <div class="flex justify-between items-center mb-6">
                <button wire:click="previousMonth" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <h2 class="text-xl font-semibold text-gray-900">{{ $this->getMonthName() }} {{ $currentYear }}</h2>
                <button wire:click="nextMonth" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
            </div>

            <!-- Legend -->
            <div class="flex flex-wrap gap-4 mb-6 text-sm">
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-green-100 border border-green-300 rounded mr-2"></div>
                    <span class="text-gray-600">Approved Leave</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-yellow-100 border border-yellow-300 rounded mr-2"></div>
                    <span class="text-gray-600">Pending Leave</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-red-100 border border-red-300 rounded mr-2"></div>
                    <span class="text-gray-600">Rejected Leave</span>
                </div>
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-purple-100 border border-purple-300 rounded mr-2"></div>
                    <span class="text-gray-600">Holiday</span>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-7 gap-px bg-gray-200">
                <!-- Weekday Headers -->
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                    <div class="bg-gray-50 p-3 text-center text-sm font-medium text-gray-700">
                        {{ $day }}
                    </div>
                @endforeach

                <!-- Empty Days for Month Start -->
                @for($i = 0; $i < $this->getFirstDayOfMonth(); $i++)
                    <div class="bg-white p-3 h-24"></div>
                @endfor

                <!-- Calendar Days -->
                @for($day = 1; $day <= $this->getDaysInMonth(); $day++)
                    <?php
                    $dayLeaveRequests = $this->getLeaveRequestsForDate($day);
                    $dayHolidays = $this->getHolidaysForDate($day);
                    $isWeekend = $this->isWeekend($day);
                    $isToday = $this->isToday($day);
                    ?>
                    <div class="bg-white p-2 h-24 cursor-pointer hover:bg-gray-50 transition-colors @if($isWeekend) bg-gray-50 @endif @if($isToday) bg-blue-50 @endif"
                         wire:click="selectDate('{{ $currentYear }}-{{ str_pad($currentMonth, 2, '0', STR_PAD_LEFT) }}-{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}')">
                        <div class="text-sm @if($isWeekend) text-gray-500 @else @if($isToday) text-blue-600 font-bold @else text-gray-900 @endif @endif">
                            {{ $day }}
                        </div>
                        @if($dayHolidays->count() > 0)
                            <div class="mt-1 space-y-1">
                                @foreach($dayHolidays as $holiday)
                                    <div class="text-xs px-1 py-0.5 bg-purple-100 text-purple-800 rounded truncate">
                                        🎉 {{ $holiday->name }}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        @if($dayLeaveRequests->count() > 0)
                            <div class="mt-1 space-y-1">
                                @foreach($dayLeaveRequests->take(2) as $leaveRequest)
                                    <div class="text-xs px-1 py-0.5 rounded truncate
                                        @if($leaveRequest->status === 'approved') bg-green-100 text-green-800
                                        @elseif($leaveRequest->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $leaveRequest->leaveType->name }}
                                    </div>
                                @endforeach
                                @if($dayLeaveRequests->count() > 2)
                                    <div class="text-xs text-gray-500">+{{ $dayLeaveRequests->count() - 2 }} more</div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endfor

                <!-- Empty Days for Month End -->
                @php
                $totalCells = $this->getFirstDayOfMonth() + $this->getDaysInMonth();
                $emptyCells = (7 - ($totalCells % 7)) % 7;
                @endphp
                @for($i = 0; $i < $emptyCells; $i++)
                    <div class="bg-white p-3 h-24"></div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Selected Date Details -->
    @if($selectedDate)
        <div class="bg-white rounded-lg shadow mt-6">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">
                    Details for {{ Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
                </h3>
                
                <?php
                $selectedDay = Carbon\Carbon::parse($selectedDate)->day;
                $selectedLeaveRequests = $this->getLeaveRequestsForDate($selectedDay);
                $selectedHolidays = $this->getHolidaysForDate($selectedDay);
                ?>
                
                <!-- Holidays -->
                @if($selectedHolidays->count() > 0)
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-900 mb-3">🎉 Holidays</h4>
                        <div class="space-y-2">
                            @foreach($selectedHolidays as $holiday)
                                <div class="border-l-4 border-purple-400 bg-purple-50 p-3 rounded">
                                    <div class="font-medium text-purple-900">{{ $holiday->name }}</div>
                                    @if($holiday->description)
                                        <div class="text-sm text-purple-700 mt-1">{{ $holiday->description }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Leave Requests -->
                @if($selectedLeaveRequests->count() > 0)
                    <div>
                        <h4 class="text-md font-medium text-gray-900 mb-3">📅 Your Leave Requests</h4>
                        <div class="space-y-3">
                            @foreach($selectedLeaveRequests as $leaveRequest)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-medium text-gray-900">
                                                {{ $leaveRequest->leaveType->name }}
                                            </div>
                                            <div class="text-sm text-gray-600 mt-1">
                                                {{ $leaveRequest->start_date }} to {{ $leaveRequest->end_date }}
                                            </div>
                                            @if($leaveRequest->reason)
                                                <div class="text-sm text-gray-500 mt-1">
                                                    {{ $leaveRequest->reason }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                                @if($leaveRequest->status === 'approved') bg-green-100 text-green-800
                                                @elseif($leaveRequest->status === 'pending') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                                {{ ucfirst($leaveRequest->status) }}
                                            </span>
                                            @if($leaveRequest->status === 'pending')
                                                <a href="{{ route('employee.leave.request') }}" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                                    Edit
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($selectedHolidays->count() === 0 && $selectedLeaveRequests->count() === 0)
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-calendar-times text-4xl mb-3"></i>
                        <p>No holidays or leave requests for this date</p>
                        <a href="{{ route('employee.leave.request') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                            Request Leave →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
