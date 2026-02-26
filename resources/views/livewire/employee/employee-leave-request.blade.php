<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Request Leave</h1>
        <p class="text-gray-600 mt-2">Submit your leave request for approval</p>
    </div>

    <!-- Leave Request Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            @if(session()->has('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session()->has('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <form wire:submit="submit">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Leave Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Leave Type</label>
                        <select wire:model="leave_type_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Leave Type</option>
                            @foreach($leaveTypes as $leaveType)
                                <option value="{{ $leaveType->id }}">{{ $leaveType->name }}</option>
                            @endforeach
                        </select>
                        @error('leave_type_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                        <input type="date" wire:model="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('start_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                        <input type="date" wire:model="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('end_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Reason -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
                        <textarea wire:model="reason" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Please provide a reason for your leave request..."></textarea>
                        @error('reason')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full md:w-auto px-6 py-2 bg-blue-600 text-black font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Submit Leave Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Leave Balance Info -->
    <div class="bg-white rounded-lg shadow mt-6">
        <div class="p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Leave Balance Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($leaveTypes as $leaveType)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900">{{ $leaveType->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $leaveType->description }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            @if($leaveType->requires_approval) Requires approval @else Auto-approved @endif
                            @if($leaveType->allow_carry_forward) • Can carry forward {{ $leaveType->max_carry_forward_days }} days @endif
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
