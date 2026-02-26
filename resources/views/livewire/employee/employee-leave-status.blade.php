<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Leave Status</h1>
        <p class="text-gray-600 mt-2">Track the status of your leave requests</p>
    </div>

    <!-- Leave Requests List -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            @if($leaveRequests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied On</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($leaveRequests as $request)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $request->leaveType->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $request->start_date?->format('M d, Y') }} - {{ $request->end_date?->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $request->start_date && $request->end_date ? $request->start_date->diffInDays($request->end_date) + 1 : 'N/A' }} days
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($request->status->value === 'approved') bg-green-100 text-green-800
                                            @elseif($request->status->value === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($request->status->value === 'rejected') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($request->status->value) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $request->created_at?->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button wire:click="viewRequest({{ $request->id }})" class="text-blue-600 hover:text-blue-900">
                                            View Details
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No leave requests</h3>
                    <p class="mt-1 text-sm text-gray-500">You haven't submitted any leave requests yet.</p>
                    <div class="mt-6">
                        <a href="{{ route('employee.leave.request') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Request Leave
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Leave Request Details Modal -->
    @if($selectedRequest)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeModal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white" wire:click.stop>
                <div class="mt-3">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Leave Request Details</h3>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="font-medium">Leave Type:</span>
                            <span class="ml-2">{{ $selectedRequest->leaveType->name ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Duration:</span>
                            <span class="ml-2">{{ $selectedRequest->start_date?->format('M d, Y') }} - {{ $selectedRequest->end_date?->format('M d, Y') }}</span>
                        </div>
                        <div>
                            <span class="font-medium">Total Days:</span>
                            <span class="ml-2">{{ $selectedRequest->start_date && $selectedRequest->end_date ? $selectedRequest->start_date->diffInDays($selectedRequest->end_date) + 1 : 'N/A' }} days</span>
                        </div>
                        <div>
                            <span class="font-medium">Reason:</span>
                            <p class="mt-1 text-gray-600">{{ $selectedRequest->reason }}</p>
                        </div>
                        <div>
                            <span class="font-medium">Status:</span>
                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($selectedRequest->status->value === 'approved') bg-green-100 text-green-800
                                @elseif($selectedRequest->status->value === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($selectedRequest->status->value === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($selectedRequest->status->value) }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium">Applied On:</span>
                            <span class="ml-2">{{ $selectedRequest->created_at?->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
