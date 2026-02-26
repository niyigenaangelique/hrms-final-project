<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Custom Report Builder</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Create custom HR reports with your preferred metrics and filters</p>
            </div>
            <button
                wire:click="$set('showBuilder', true)"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-12l-4 4M4 4l4 4m-12-8V4m0 0L8 8m4 4l4-4m4-4v12"></path>
                </svg>
                Create New Report
            </button>
        </div>
    </div>

    <!-- Report Builder Modal -->
    @if($showBuilder)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <form wire:submit="generateReport">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Create Custom Report
                            </h3>
                            
                            <div class="space-y-6">
                                <!-- Basic Information -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Report Name</label>
                                        <input
                                            type="text"
                                            wire:model="reportName"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required
                                        />
                                        @error('reportName')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Report Type</label>
                                        <select
                                            wire:model="reportType"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required
                                        >
                                            <option value="dashboard">Dashboard</option>
                                            <option value="turnover">Turnover Analysis</option>
                                            <option value="diversity">Diversity Statistics</option>
                                            <option value="attendance">Attendance Report</option>
                                            <option value="performance">Performance Report</option>
                                            <option value="skill_gap">Skill Gap Analysis</option>
                                            <option value="custom">Custom Report</option>
                                        </select>
                                        @error('reportType')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                        <select
                                            wire:model="reportCategory"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required
                                        >
                                            <option value="hr">HR</option>
                                            <option value="finance">Finance</option>
                                            <option value="operations">Operations</option>
                                            <option value="management">Management</option>
                                        </select>
                                        @error('reportCategory')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                        <textarea
                                            wire:model="reportDescription"
                                            rows="3"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        ></textarea>
                                    </div>
                                </div>

                                <!-- Date Range -->
                                <div class="space-y-4">
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white">Date Range</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Range Type</label>
                                            <select
                                                wire:model.live="dateRangeType"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            >
                                                <option value="custom">Custom Range</option>
                                                <option value="this_week">This Week</option>
                                                <option value="this_month">This Month</option>
                                                <option value="this_quarter">This Quarter</option>
                                                <option value="this_year">This Year</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                                            <input
                                                type="date"
                                                wire:model="startDate"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                required
                                            />
                                            @error('startDate')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">End Date</label>
                                            <input
                                                type="date"
                                                wire:model="endDate"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                required
                                            />
                                            @error('endDate')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Metrics Selection -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Select Metrics</h4>
                                    <div class="space-y-2">
                                        @foreach($availableMetrics as $metric => $label)
                                            <div class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</span>
                                                <button
                                                    wire:click="addMetric('{{ $metric }}')"
                                                    class="px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700"
                                                    @if(in_array($metric, $selectedMetrics))
                                                        disabled
                                                    @endif
                                                >
                                                    @if(in_array($metric, $selectedMetrics))
                                                        ✓ Added
                                                    @else
                                                        Add
                                                    @endif
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Filters -->
                                <div>
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Filters</h4>
                                    <div class="space-y-2">
                                        @foreach($filters as $index => $filter)
                                            <div class="flex items-center space-x-2 p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                                                <select
                                                    wire:model.live="filters.{{ $index }}.type"
                                                    class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                >
                                                    <option value="department">Department</option>
                                                    <option value="position">Position</option>
                                                    <option value="gender">Gender</option>
                                                    <option value="age_group">Age Group</option>
                                                    <option value="employment_type">Employment Type</option>
                                                </select>
                                                <input
                                                    type="text"
                                                    wire:model.live="filters.{{ $index }}.value"
                                                    placeholder="Filter value"
                                                    class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                />
                                                <select
                                                    wire:model.live="filters.{{ $index }}.operator"
                                                    class="border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                >
                                                    <option value="=">=">Greater or equal</option>
                                                    <option value="<">Less than</option>
                                                    <option value="="=">Equal to</option>
                                                    <option value="!=">Not equal to</option>
                                                </select>
                                                <button
                                                    wire:click="removeFilter('{{ $index }}')"
                                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded-md hover:bg-red-700"
                                                >
                                                    Remove
                                                </button>
                                            </div>
                                        @endforeach
                                        <button
                                            wire:click="addFilter('department')"
                                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 dark:bg-gray-700 dark:text-white"
                                        >
                                            Add Filter
                                        </button>
                                    </div>
                                </div>

                                <!-- Display Options -->
                                <div class="space-y-4">
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white">Display Options</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Group By</label>
                                            <select
                                                wire:model="groupBy"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            >
                                                <option value="">No Grouping</option>
                                                <option value="department">Department</option>
                                                <option value="position">Position</option>
                                                <option value="gender">Gender</option>
                                                <option value="age_group">Age Group</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort By</label>
                                            <select
                                                wire:model="sortBy"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            >
                                                <option value="">No Sorting</option>
                                                <option value="name">Name</option>
                                                <option value="date">Date</option>
                                                <option value="score">Score</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sort Order</label>
                                            <select
                                                wire:model="sortOrder"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            >
                                                <option value="asc">Ascending</option>
                                                <option value="desc">Descending</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Chart Type</label>
                                        <select
                                            wire:model="chartType"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        >
                                            <option value="bar">Bar Chart</option>
                                            <option value="line">Line Chart</option>
                                            <option value="pie">Pie Chart</option>
                                            <option value="area">Area Chart</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                Generate Report
                            </button>
                            <button
                                type="button"
                                wire:click="$set('showBuilder', false); resetForm()"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Generated Reports List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Generated Reports</h2>
            <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                View All Reports
            </button>
        </div>

        <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Generated</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            No reports generated yet
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
