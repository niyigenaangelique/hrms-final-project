<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Messages</h1>
                <p class="text-gray-600 mt-2">Communicate with HR team</p>
            </div>
            @if($unreadCount > 0)
                <div class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                    {{ $unreadCount }} unread
                </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Send Message -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Send Message</h3>
                
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

                <form wire:submit="sendMessage">
                    <div class="space-y-4">
                        <!-- HR User Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Send To</label>
                            <select wire:model="selectedHrUser" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select HR Personnel</option>
                                @foreach($hrUsers as $hrUser)
                                    <option value="{{ $hrUser->id }}">{{ $hrUser->first_name }} {{ $hrUser->last_name }} ({{ $hrUser->role->value }})</option>
                                @endforeach
                            </select>
                            @error('selectedHrUser')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <input type="text" wire:model="subject" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter message subject...">
                            @error('subject')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea wire:model="messageContent" rows="6" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message here..."></textarea>
                            @error('messageContent')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-black font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Send Message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Messages List -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Message History</h3>
                
                @if($messageList->count() > 0)
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        @foreach($messageList as $message)
                            <div class="border border-gray-200 rounded-lg p-4 {{ $message->receiver_id === Auth::id() && !$message->is_read ? 'bg-blue-50 border-blue-300' : '' }}">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-{{ $message->sender_id === Auth::id() ? 'green' : 'blue' }}-100 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-{{ $message->sender_id === Auth::id() ? 'green' : 'blue' }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                @if($message->sender_id === Auth::id())
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                                @else
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                @endif
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">
                                                {{ $message->sender_id === Auth::id() ? 'You' : $message->sender->first_name . ' ' . $message->sender->last_name }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $message->receiver_id === Auth::id() ? 'To: ' . $message->receiver->first_name : 'To: You' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">{{ $message->created_at->format('M d, Y H:i') }}</p>
                                        @if($message->receiver_id === Auth::id() && !$message->is_read)
                                            <button wire:click="markAsRead({{ $message->id }})" class="text-xs text-blue-600 hover:text-blue-800 mt-1">
                                                Mark as read
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                
                                <p class="font-medium text-gray-900 mb-1">{{ $message->subject }}</p>
                                <p class="text-sm text-gray-600">{{ $message->message }}</p>
                                
                                <div class="mt-2 flex items-center">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($message->status === 'sent') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($message->status) }}
                                    </span>
                                    @if($message->receiver_id === Auth::id() && !$message->is_read)
                                        <span class="ml-2 px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                            New
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No messages</h3>
                        <p class="mt-1 text-sm text-gray-500">Start a conversation with HR team.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
