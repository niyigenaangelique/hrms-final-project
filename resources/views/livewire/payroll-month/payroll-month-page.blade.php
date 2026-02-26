<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Payroll Months</h1>
                <p class="text-gray-600 mt-2">Manage payroll periods and generate entries</p>
            </div>
            <div class="flex space-x-4">
                <button wire:click="createMonth" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Create Month
                </button>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session()->has('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Payroll Months Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @forelse(App\Models\PayrollMonth::withCount('payrollEntries')->orderBy('start_date', 'desc')->get() as $month)
            <div class="bg-white rounded-lg shadow p-6 cursor-pointer hover:shadow-lg transition-shadow">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $month->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $month->description }}</p>
                    </div>
                    <div class="flex space-x-2">
                        @if($month->is_locked)
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                <i class="fas fa-lock mr-1"></i>Locked
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                <i class="fas fa-unlock mr-1"></i>Active
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Period:</span>
                        <span class="font-medium text-gray-900">
                            {{ Carbon\Carbon::parse($month->start_date)->format('M d') }} - 
                            {{ Carbon\Carbon::parse($month->end_date)->format('M d, Y') }}
                        </span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Code:</span>
                        <span class="font-medium text-gray-900">{{ $month->code }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Entries:</span>
                        <span class="font-medium text-gray-900">{{ $month->payroll_entries_count }}</span>
                    </div>
                </div>
                
                <div class="flex space-x-2 mt-4">
                    <button wire:click="editMonth('{{ $month->id }}')" 
                            class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </button>
                    <button wire:click="deleteMonth('{{ $month->id }}')" 
                            class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-1"></i>Delete
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-calendar-times text-4xl mb-4 text-gray-400"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No payroll months found</h3>
                <p class="text-gray-500">Create your first payroll period to get started.</p>
                <button wire:click="createMonth" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Create First Month
                </button>
            </div>
        @endforelse
    </div>
</div>
