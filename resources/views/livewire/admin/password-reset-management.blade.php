<div>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Password Resets</h1>
        <p class="text-gray-600 mt-2">Manage password reset requests and create manual resets</p>
    </div>

    <!-- Action Buttons -->
    <div class="mb-6">
        <div class="flex space-x-3">
            <button wire:click="openCreateResetModal" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                Create Reset
            </button>
            <button wire:click="cleanupExpiredResets" 
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                Cleanup Expired
            </button>
            <button wire:click="exportResets" 
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Export
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" wire:model.live.debounce.250ms="search" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                       placeholder="Search by email...">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model.live.debounce.250ms="statusFilter" 
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="used">Used</option>
                    <option value="expired">Expired</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Clear Filters</label>
                <button wire:click="clearFilters" 
                        class="mt-1 px-4 py-2 border border-gray-300 rounded-md">
                    Clear
                </button>
            </div>
        </div>
    </div>

    <!-- Password Resets Table -->
    <div class="bg-white shadow overflow-hidden rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Expires</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($passwordResets as $reset)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $reset->email }}</div>
                            <div class="text-sm text-gray-500">{{ $reset->reset_reason ?? 'User request' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($reset->used_at) bg-green-100 text-green-800
                                @elseif($reset->created_at && $reset->created_at->lt(now()->subHours(24))) bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ $reset->used_at ? 'Used' : ($reset->created_at && $reset->created_at->lt(now()->subHours(24)) ? 'Expired' : 'Active') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $reset->created_at ? $reset->created_at->format('M d, Y H:i') : 'Unknown' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $reset->created_at ? $reset->created_at->addHours(24)->format('M d, Y H:i') : 'Unknown' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            @if(!$reset->used_at)
                                <button wire:click="deleteReset({{ $reset->email }})" class="text-red-600 hover:text-red-900">Delete</button>
                            @else
                                <span class="text-gray-400">Completed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No password resets found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        @if($passwordResets->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                <div class="text-sm text-gray-700">
                    Showing {{ $passwordResets->firstItem() }} to {{ $passwordResets->lastItem() }} of {{ $passwordResets->total() }} results
                </div>
                {{ $passwordResets->links() }}
            </div>
        @endif
    </div>

    <!-- Create Reset Modal -->
    @if($showCreateModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Create Password Reset</h3>
                    <div class="mt-2">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" wire:model="createEmail" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                   placeholder="user@example.com">
                            @error('createEmail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Reason</label>
                            <select wire:model="createReason" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="User request">User request</option>
                                <option value="Admin reset">Admin reset</option>
                                <option value="Security policy">Security policy</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-4">
                        <button wire:click="closeCreateResetModal" 
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700">
                            Cancel
                        </button>
                        <button wire:click="createPasswordReset" 
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                            Create Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Success Message -->
    @if(session()->has('success'))
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50">
            {{ session('success') }}
        </div>
    @endif

    <!-- Error Message -->
    @if(session()->has('error'))
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50">
            {{ session('error') }}
        </div>
    @endif
</div>
