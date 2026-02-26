<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">HR Leave Management</h1>
                <p class="text-gray-600 mt-2">Approve or reject employee leave requests</p>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Status</label>
                <select wire:model.live="filterStatus" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all">All Requests</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input wire:model.live="searchTerm" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Search by employee name or leave type">
            </div>
        </div>
    </div>

    <!-- Leave Requests Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            @if(session()->has('test'))
                <div class="mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                    {{ session('test') }}
                </div>
            @endif

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

            @if($leaveRequests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Leave Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Days</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($leaveRequests as $request)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $request->employee->first_name }} {{ $request->employee->last_name }}
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $request->employee->code }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $request->leaveType->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $request->start_date->format('M d, Y') }} - {{ $request->end_date->format('M d, Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $request->total_days }} days</div>
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
                                        {{ $request->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button type="button" wire:click="setViewRequest('{{ $request->id }}')" class="text-blue-600 hover:text-blue-900 mr-3">
                                            View
                                        </button>
                                        @if($request->status->value === 'pending')
                                            <button type="button" wire:click="setSelectedRequest('{{ $request->id }}')" class="text-green-600 hover:text-green-900 mr-3">
                                                Approve
                                            </button>
                                            <button type="button" wire:click="openRejectModal('{{ $request->id }}')" class="text-red-600 hover:text-red-900">
                                                Reject
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No leave requests found</p>
            @endif
        </div>
    </div>

    <!-- Request Details Modal -->
    @if($selectedRequest)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Leave Request Details</h3>
                    
                    @php
                        $request = $leaveRequests->where('id', $selectedRequest)->first();
                    @endphp
                    
                    @if($request)
                        <div class="space-y-3">
                            <div>
                                <span class="font-medium">Employee:</span>
                                <span class="ml-2">{{ $request->employee->first_name }} {{ $request->employee->last_name }} ({{ $request->employee->code }})</span>
                            </div>
                            <div>
                                <span class="font-medium">Leave Type:</span>
                                <span class="ml-2">{{ $request->leaveType->name }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Duration:</span>
                                <span class="ml-2">{{ $request->start_date->format('M d, Y') }} - {{ $request->end_date->format('M d, Y') }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Total Days:</span>
                                <span class="ml-2">{{ $request->total_days }} days</span>
                            </div>
                            <div>
                                <span class="font-medium">Reason:</span>
                                <p class="mt-1 text-gray-600">{{ $request->reason }}</p>
                            </div>
                            <div>
                                <span class="font-medium">Status:</span>
                                <span class="ml-2 px-2 py-1 text-xs rounded-full 
                                    @if($request->status->value === 'approved') bg-green-100 text-green-800
                                    @elseif($request->status->value === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($request->status->value === 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($request->status->value) }}
                                </span>
                            </div>
                            
                            @if($request->status->value === 'pending')
                                <div class="mt-4 pt-4 border-t">
                                    <button wire:click="approveRequest({{ $request->id }})" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 mb-2">
                                        Approve Request
                                    </button>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason</label>
                                        <textarea wire:model="rejectionReason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter reason for rejection..."></textarea>
                                        @error('rejectionReason')
                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <button wire:click="rejectRequest" class="w-full bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 mt-2">
                                        Reject Request
                                    </button>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    <div class="mt-4 pt-4 border-t">
                        <button wire:click="closeModal" class="w-full bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Reject Modal -->
    @if($rejectModalOpen)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Leave Request</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason</label>
                        <textarea wire:model="rejectionReason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter reason for rejection..."></textarea>
                        @error('rejectionReason')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="flex justify-end space-x-2">
                        <button wire:click="closeRejectModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                            Cancel
                        </button>
                        <button wire:click="confirmReject" class="px-4 py-2 bg-gray-600 text-red rounded-md hover:bg-gray-700">
                            Reject
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
