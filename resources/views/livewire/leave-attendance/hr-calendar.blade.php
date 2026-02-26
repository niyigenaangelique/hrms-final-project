<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">HR Calendar</h1>
                <p class="text-gray-600 mt-2">View and manage employee leave schedules</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Employee</label>
                <select wire:model.live="filterEmployee" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">All Employees</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Status</label>
                <select wire:model.live="filterStatus" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="flex items-end">
                <button wire:click="loadLeaveRequests" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
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
                    $isWeekend = $this->isWeekend($day);
                    $isToday = $this->isToday($day);
                    ?>
                    <div class="bg-white p-2 h-24 cursor-pointer hover:bg-gray-50 transition-colors @if($isWeekend) bg-gray-50 @endif @if($isToday) bg-blue-50 @endif"
                         wire:click="selectDate('{{ $currentYear }}-{{ str_pad($currentMonth, 2, '0', STR_PAD_LEFT) }}-{{ str_pad($day, 2, '0', STR_PAD_LEFT) }}')">
                        <div class="text-sm @if($isWeekend) text-gray-500 @else @if($isToday) text-blue-600 font-bold @else text-gray-900 @endif @endif">
                            {{ $day }}
                        </div>
                        @if($dayLeaveRequests->count() > 0)
                            <div class="mt-1 space-y-1">
                                @foreach($dayLeaveRequests->take(2) as $leaveRequest)
                                    <div class="text-xs px-1 py-0.5 rounded truncate
                                        @if($leaveRequest->status === 'approved') bg-green-100 text-green-800
                                        @elseif($leaveRequest->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $leaveRequest->employee->first_name }} - {{ $leaveRequest->leaveType->name }}
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
                    Leave Requests for {{ Carbon\Carbon::parse($selectedDate)->format('F j, Y') }}
                </h3>
                
                <?php
                $selectedDay = Carbon\Carbon::parse($selectedDate)->day;
                $selectedLeaveRequests = $this->getLeaveRequestsForDate($selectedDay);
                ?>
                
                @if($selectedLeaveRequests->count() > 0)
                    <div class="space-y-4">
                        @foreach($selectedLeaveRequests as $leaveRequest)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <div class="font-medium text-gray-900">
                                            {{ $leaveRequest->employee->first_name }} {{ $leaveRequest->employee->last_name }}
                                        </div>
                                        <div class="text-sm text-gray-600 mt-1">
                                            {{ $leaveRequest->leaveType->name }} - {{ $leaveRequest->start_date }} to {{ $leaveRequest->end_date }}
                                        </div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            {{ $leaveRequest->reason }}
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($leaveRequest->status === 'approved') bg-green-100 text-green-800
                                            @elseif($leaveRequest->status === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($leaveRequest->status) }}
                                        </span>
                                        <a href="{{ route('leave-attendance.hr-leave-management') }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            Manage
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-calendar-times text-4xl mb-3"></i>
                        <p>No leave requests for this date</p>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
