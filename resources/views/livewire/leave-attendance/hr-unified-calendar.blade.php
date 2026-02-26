<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">HR Calendar</h1>
                <p class="text-gray-600 mt-2">View team leave schedules and your personal calendar</p>
            </div>
            @if($hrEmployee)
                <div class="text-right">
                    <p class="text-sm text-gray-500">HR Staff</p>
                    <p class="font-medium text-gray-900">{{ $hrEmployee->first_name }} {{ $hrEmployee->last_name }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- View Toggle -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex space-x-4">
            <button wire:click="switchView('team')" 
                    class="px-4 py-2 rounded-lg font-medium transition-colors
                           @if($activeView === 'team') bg-blue-600 text-white @else bg-gray-100 text-gray-700 hover:bg-gray-200 @endif">
                <i class="fas fa-users mr-2"></i>Team Calendar
            </button>
            <button wire:click="switchView('personal')" 
                    class="px-4 py-2 rounded-lg font-medium transition-colors
                           @if($activeView === 'personal') bg-blue-600 text-white @else bg-gray-100 text-gray-700 hover:bg-gray-200 @endif">
                <i class="fas fa-user mr-2"></i>My Calendar
            </button>
            <button wire:click="switchView('payroll')" 
                    class="px-4 py-2 rounded-lg font-medium transition-colors
                           @if($activeView === 'payroll') bg-blue-600 text-white @else bg-gray-100 text-gray-700 hover:bg-gray-200 @endif">
                <i class="fas fa-dollar-sign mr-2"></i>Payroll Calendar
            </button>
        </div>
    </div>

    <!-- Filters (only show for team view) -->
    @if($activeView === 'team')
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Employee</label>
                    <select wire:model.live="filterEmployee" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Employees</option>
                        @foreach(App\Models\Employee::where('approval_status', 'Approved')->orderBy('first_name')->get() as $employee)
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
                    <button wire:click="loadData" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Calendar -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <!-- Month Navigation -->
            <div class="flex justify-between items-center mb-6">
                <button wire:click="previousMonth" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <h2 class="text-xl font-semibold text-gray-900">
                    {{ $this->getMonthName() }} {{ $currentYear }}
                    @if($activeView === 'team') - Team View 
                    @elseif($activeView === 'personal') - Personal View 
                    @else - Payroll View @endif
                </h2>
                <button wire:click="nextMonth" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>
            </div>

            <!-- Legend -->
            <div class="flex flex-wrap gap-4 mb-6 text-sm">
                @if($activeView === 'team')
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
                @endif
                @if($activeView === 'payroll')
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-blue-100 border border-blue-300 rounded mr-2"></div>
                        <span class="text-gray-600">Pay Period Start</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-orange-100 border border-orange-300 rounded mr-2"></div>
                        <span class="text-gray-600">Pay Period End</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-100 border border-green-300 rounded mr-2"></div>
                        <span class="text-gray-600">Payday!</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-indigo-100 border border-indigo-300 rounded mr-2"></div>
                        <span class="text-gray-600">Payment Processed</span>
                    </div>
                @endif
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
                    if ($activeView === 'team') {
                        $dayLeaveRequests = $this->getTeamLeaveRequestsForDate($day);
                    } elseif ($activeView === 'personal') {
                        $dayLeaveRequests = $this->getPersonalLeaveRequestsForDate($day);
                    } else {
                        $dayLeaveRequests = collect(); // No leaves in payroll view
                    }
                    $dayHolidays = $this->getHolidaysForDate($day);
                    $dayPayrollEvents = $this->getPayrollEventsForDate($day);
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
                                @foreach($dayLeaveRequests->take($activeView === 'team' ? 2 : 3) as $leaveRequest)
                                    <div class="text-xs px-1 py-0.5 rounded truncate
                                        @if($leaveRequest->status === 'approved') bg-green-100 text-green-800
                                        @elseif($leaveRequest->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        @if($activeView === 'team')
                                            {{ $leaveRequest->employee->first_name }} - {{ $leaveRequest->leaveType->name }}
                                        @else
                                            {{ $leaveRequest->leaveType->name }}
                                        @endif
                                    </div>
                                @endforeach
                                @if($dayLeaveRequests->count() > ($activeView === 'team' ? 2 : 3))
                                    <div class="text-xs text-gray-500">+{{ $dayLeaveRequests->count() - ($activeView === 'team' ? 2 : 3) }} more</div>
                                @endif
                            </div>
                        @endif
                        @if($activeView === 'payroll' && $dayPayrollEvents->count() > 0)
                            <div class="mt-1 space-y-1">
                                @foreach($dayPayrollEvents->take(3) as $event)
                                    <div class="text-xs px-1 py-0.5 rounded truncate
                                        @if($event['type'] === 'period_start') bg-blue-100 text-blue-800
                                        @elseif($event['type'] === 'period_end') bg-orange-100 text-orange-800
                                        @elseif($event['type'] === 'payday') bg-green-100 text-green-800
                                        @else bg-indigo-100 text-indigo-800 @endif">
                                        @if($event['type'] === 'payday') 💰 @endif {{ $event['title'] }}
                                    </div>
                                @endforeach
                                @if($dayPayrollEvents->count() > 3)
                                    <div class="text-xs text-gray-500">+{{ $dayPayrollEvents->count() - 3 }} more</div>
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
                if ($activeView === 'team') {
                    $selectedLeaveRequests = $this->getTeamLeaveRequestsForDate($selectedDay);
                } elseif ($activeView === 'personal') {
                    $selectedLeaveRequests = $this->getPersonalLeaveRequestsForDate($selectedDay);
                } else {
                    $selectedLeaveRequests = collect(); // No leaves in payroll view
                }
                $selectedHolidays = $this->getHolidaysForDate($selectedDay);
                $selectedPayrollEvents = $this->getPayrollEventsForDate($selectedDay);
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
                        <h4 class="text-md font-medium text-gray-900 mb-3">
                            @if($activeView === 'team') Team Leave Requests @else Your Leave Requests @endif
                        </h4>
                        <div class="space-y-3">
                            @foreach($selectedLeaveRequests as $leaveRequest)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            @if($activeView === 'team')
                                                <div class="font-medium text-gray-900">
                                                    {{ $leaveRequest->employee->first_name }} {{ $leaveRequest->employee->last_name }}
                                                </div>
                                            @endif
                                            <div class="text-sm text-gray-600 mt-1">
                                                {{ $leaveRequest->leaveType->name }} - {{ $leaveRequest->start_date }} to {{ $leaveRequest->end_date }}
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
                                            @if($activeView === 'team')
                                                <a href="{{ route('leave-attendance.hr-leave-management') }}" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                                    Manage
                                                </a>
                                            @elseif($leaveRequest->status === 'pending')
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

                <!-- Payroll Events -->
                @if($activeView === 'payroll' && $selectedPayrollEvents->count() > 0)
                    <div>
                        <h4 class="text-md font-medium text-gray-900 mb-3">💰 Payroll Events</h4>
                        <div class="space-y-3">
                            @foreach($selectedPayrollEvents as $event)
                                <div class="border rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="font-medium text-gray-900">
                                                @if($event['type'] === 'payday') 💰 @endif {{ $event['title'] }}
                                            </div>
                                            <div class="text-sm text-gray-600 mt-1">
                                                {{ $event['description'] }}
                                            </div>
                                            @if($event['type'] === 'payday' && isset($event['data']->total_amount))
                                                <div class="text-sm text-gray-500 mt-1">
                                                    Total Amount: ${{ number_format($event['data']->total_amount, 2) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full
                                                @if($event['type'] === 'period_start') bg-blue-100 text-blue-800
                                                @elseif($event['type'] === 'period_end') bg-orange-100 text-orange-800
                                                @elseif($event['type'] === 'payday') bg-green-100 text-green-800
                                                @else bg-indigo-100 text-indigo-800 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $event['type'])) }}
                                            </span>
                                            @if($event['type'] === 'payday')
                                                <a href="{{ route('payroll.entries') }}" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                                    View Details
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($selectedHolidays->count() === 0 && $selectedLeaveRequests->count() === 0 && ($activeView !== 'payroll' || $selectedPayrollEvents->count() === 0))
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-calendar-times text-4xl mb-3"></i>
                        <p>
                            @if($activeView === 'team') 
                                No team leaves or holidays for this date
                            @elseif($activeView === 'personal') 
                                No personal leaves or holidays for this date
                            @else 
                                No payroll events or holidays for this date
                            @endif
                        </p>
                        @if($activeView === 'personal')
                            <a href="{{ route('employee.leave.request') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                Request Leave →
                            </a>
                        @elseif($activeView === 'payroll')
                            <a href="{{ route('payroll.dashboard') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">
                                Payroll Dashboard →
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
