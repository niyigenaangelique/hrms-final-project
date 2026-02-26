<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    @if($employee->profile_photo)
                        <img src="{{ asset('storage/' . $employee->profile_photo) }}" 
                             alt="{{ $employee->full_name }}" 
                             class="h-16 w-16 rounded-full object-cover">
                    @else
                        <div class="h-16 w-16 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                            <span class="text-xl font-semibold text-gray-600 dark:text-gray-300">
                                {{ substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1) }}
                            </span>
                        </div>
                    @endif
                    <div class="absolute bottom-0 right-0">
                        <button class="bg-blue-600 text-white rounded-full p-1 hover:bg-blue-700">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $employee->full_name }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ $employee->position->name ?? 'No Position' }} • {{ $employee->department->name ?? 'No Department' }}
                    </p>
                    <div class="flex items-center space-x-4 mt-1">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Employee ID: {{ $employee->employee_number ?? $employee->code }}
                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            Joined: {{ $employee->join_date ? $employee->join_date->format('M d, Y') : 'Not specified' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex space-x-3">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Edit Profile
                </button>
                <button class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50 dark:border-gray-600 dark:text-white">
                    Export Profile
                </button>
            </div>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="space-y-6">
        <!-- Personal Information Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Personal Information -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Personal Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">First Name</label>
                            <p class="text-gray-900 dark:text-white">{{ $employee->first_name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Name</label>
                            <p class="text-gray-900 dark:text-white">{{ $employee->last_name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Gender</label>
                            <p class="text-gray-900 dark:text-white">{{ ucfirst($employee->gender) }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth</label>
                            <p class="text-gray-900 dark:text-white">{{ $employee->birth_date?->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Nationality</label>
                            <p class="text-gray-900 dark:text-white">{{ $employee->nationality }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">National ID</label>
                            <p class="text-gray-900 dark:text-white">{{ $employee->national_id }}</p>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Information</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                            <p class="text-gray-900 dark:text-white">{{ $employee->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</label>
                            <p class="text-gray-900 dark:text-white">{{ $employee->phone_number }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</label>
                            <p class="text-gray-900 dark:text-white">{{ $employee->address ?? 'Not specified' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Emergency Contact</label>
                            <p class="text-gray-900 dark:text-white">{{ $employee->emergency_contact ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
