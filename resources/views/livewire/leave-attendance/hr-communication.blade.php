<div class="p-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">HR Communication</h1>
                <p class="text-gray-600 mt-2">Communicate with employees</p>
            </div>
            @if($unreadCount > 0)
                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $unreadCount }} unread message{{ $unreadCount > 1 ? 's' : '' }}
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
                        <!-- Employee Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Send To</label>
                            <select wire:model="selectedEmployee" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->code }})</option>
                                @endforeach
                            </select>
                            @error('selectedEmployee')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <input wire:model="subject" type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter message subject">
                            @error('subject')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea wire:model="messageContent" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Type your message here..."></textarea>
                            @error('messageContent')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-black py-2 px-4 rounded-md hover:bg-blue-700 transition-colors">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Message History -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Message History</h3>
                
                @if($messageList->count() > 0)
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        @foreach($messageList as $message)
                            <div class="border rounded-lg p-4 @if(!$message->is_read && $message->receiver_id === auth()->id()) bg-blue-50 @endif">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">
                                            @if($message->sender_id === auth()->id())
                                                To: {{ $message->receiver->first_name }} {{ $message->receiver->last_name }}
                                            @else
                                                From: {{ $message->sender->first_name }} {{ $message->sender->last_name }}
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-600">{{ $message->subject }}</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-gray-500">{{ $message->created_at->format('M d, Y H:i') }}</div>
                                        @if(!$message->is_read && $message->receiver_id === auth()->id())
                                            <button wire:click="markAsRead({{ $message->id }})" class="text-xs text-blue-600 hover:text-blue-800 mt-1">
                                                Mark as read
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-sm text-gray-700">{{ $message->message }}</div>
                                <div class="mt-2">
                                    <span class="text-xs px-2 py-1 rounded-full 
                                        @if($message->status === 'sent') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($message->status) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No messages found</p>
                @endif
            </div>
        </div>
    </div>
</div>
