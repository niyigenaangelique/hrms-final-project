<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Notification Center</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Manage notifications, templates, and alerts</p>
            </div>
            <div class="flex space-x-3">
                <button
                    wire:click="sendTestNotification"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 dark:bg-gray-700 dark:text-white"
                >
                    Send Test
                </button>
                <button
                    wire:click="$set('showAlertConfig', true)"
                    class="px-4 py-2 bg-yellow-600 text-white rounded-md hover:bg-yellow-700"
                >
                    Create Alert
                </button>
                <button
                    wire:click="$set('showTemplateEditor', true)"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                >
                    New Template
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button
                    wire:click="setActiveTab('notifications')"
                    class="{{ $activeTab === 'notifications' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                           whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Notifications
                </button>
                <button
                    wire:click="setActiveTab('templates')"
                    class="{{ $activeTab === 'templates' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                           whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Templates
                </button>
                <button
                    wire:click="setActiveTab('settings')"
                    class="{{ $activeTab === 'settings' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                           whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Settings
                </button>
                <button
                    wire:click="setActiveTab('analytics')"
                    class="{{ $activeTab === 'analytics' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                           whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Analytics
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Notifications Tab -->
            @if($activeTab === 'notifications')
                <div class="space-y-6">
                    <!-- Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <input
                                type="text"
                                wire:model.live="searchTerm"
                                placeholder="Search notifications..."
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            />
                        </div>
                        <div>
                            <select
                                wire:model.live="filterStatus"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="all">All Status</option>
                                <option value="sent">Sent</option>
                                <option value="failed">Failed</option>
                                <option value="pending">Pending</option>
                                <option value="scheduled">Scheduled</option>
                            </select>
                        </div>
                        <div>
                            <select
                                wire:model.live="filterChannel"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="all">All Channels</option>
                                <option value="email">Email</option>
                                <option value="sms">SMS</option>
                                <option value="push">Push</option>
                                <option value="in_app">In-App</option>
                            </select>
                        </div>
                        <div>
                            <select
                                wire:model.live="filterPriority"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="all">All Priority</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>

                    <!-- Notifications List -->
                    <div class="space-y-4">
                        @foreach($notifications as $notification)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $notification->subject }}
                                            </h4>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($notification->priority === 'urgent') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                                @elseif($notification->priority === 'high') bg-orange-100 text-orange-800 dark:bg-orange-800 dark:text-orange-100
                                                @elseif($notification->priority === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100
                                                @endif">
                                                {{ ucfirst($notification->priority) }}
                                            </span>
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                @if($notification->status === 'sent') bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                                @elseif($notification->status === 'failed') bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                                @elseif($notification->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100
                                                @else bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100
                                                @endif">
                                                {{ ucfirst($notification->status) }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                                            {{ Str::limit($notification->content, 100) }}
                                        </p>
                                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500 dark:text-gray-400">
                                            <span>Channel: {{ ucfirst($notification->channel) }}</span>
                                            <span>Recipient: {{ $notification->getSafeRecipient()?->name ?? 'Unknown' }}</span>
                                            <span>{{ $notification->created_at->format('M d, Y H:i') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2 ml-4">
                                        <button
                                            wire:click="markNotificationAsRead('{{ $notification->id }}')"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                        >
                                            Mark Read
                                        </button>
                                        @if($notification->status === 'failed')
                                            <button
                                                wire:click="resendNotification('{{ $notification->id }}')"
                                                class="text-green-600 hover:text-green-800 dark:text-green-400"
                                            >
                                                Resend
                                            </button>
                                        @endif
                                        <button
                                            wire:click="deleteNotification('{{ $notification->id }}')"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($notifications->hasPages())
                        <div class="flex justify-center mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @endif
                </div>
            @endif

            <!-- Templates Tab -->
            @if($activeTab === 'templates')
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($templates as $template)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $template->name }}
                                    </h4>
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                        {{ ucfirst($template->channel) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    {{ Str::limit($template->content, 80) }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        Type: {{ $template->type }}
                                    </span>
                                    <div class="flex space-x-2">
                                        <button
                                            wire:click="editTemplate('{{ $template->id }}')"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            wire:click="deleteTemplate('{{ $template->id }}')"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Settings Tab -->
            @if($activeTab === 'settings')
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach(['pay_date_reminders', 'contract_expiry', 'holiday_announcements', 'leave_requests', 'performance_reviews'] as $type)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                                    {{ ucwords(str_replace('_', ' ', $type)) }}
                                </h4>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Email</span>
                                        <input
                                            type="checkbox"
                                            wire:model.live="notificationSettings.{{ $type }}.email_enabled"
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        />
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">SMS</span>
                                        <input
                                            type="checkbox"
                                            wire:model.live="notificationSettings.{{ $type }}.sms_enabled"
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        />
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Push</span>
                                        <input
                                            type="checkbox"
                                            wire:model.live="notificationSettings.{{ $type }}.push_enabled"
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        />
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">In-App</span>
                                        <input
                                            type="checkbox"
                                            wire:model.live="notificationSettings.{{ $type }}.in_app_enabled"
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                        />
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-700 dark:text-gray-300">Frequency</label>
                                        <select
                                            wire:model.live="notificationSettings.{{ $type }}.frequency"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        >
                                            <option value="immediate">Immediate</option>
                                            <option value="daily">Daily</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="never">Never</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-end">
                        <button
                            wire:click="updateNotificationSettings"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                        >
                            Save Settings
                        </button>
                    </div>
                </div>
            @endif

            <!-- Analytics Tab -->
            @if($activeTab === 'analytics')
                <div class="space-y-6">
                    <!-- Stats Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $stats['total'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                {{ $stats['sent'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Sent</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600 dark:text-red-400">
                                {{ $stats['failed'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Failed</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                                {{ $stats['pending'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Pending</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                {{ $stats['delivery_rate'] }}%
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Delivery Rate</div>
                        </div>
                    </div>

                    <!-- Recent and Upcoming -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Notifications</h3>
                            <div class="space-y-2">
                                @foreach($recentNotifications as $notification)
                                    <div class="flex items-center justify-between p-2 border border-gray-200 dark:border-gray-700 rounded">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $notification->subject }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $notification->sent_at->format('M d, Y H:i') }}
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100">
                                            {{ $notification->channel }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Scheduled Notifications</h3>
                            <div class="space-y-2">
                                @foreach($upcomingNotifications as $notification)
                                    <div class="flex items-center justify-between p-2 border border-gray-200 dark:border-gray-700 rounded">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $notification->subject }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $notification->scheduled_at->format('M d, Y H:i') }}
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                            {{ $notification->channel }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Template Editor Modal -->
    @if($showTemplateEditor)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <form wire:submit="selectedTemplate ? 'updateTemplate' : 'createTemplate'">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                {{ $selectedTemplate ? 'Edit Template' : 'Create Template' }}
                            </h3>
                            
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Template Name</label>
                                        <input
                                            type="text"
                                            wire:model="templateName"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required
                                        />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                                        <input
                                            type="text"
                                            wire:model="templateType"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Channel</label>
                                    <select
                                        wire:model="templateChannel"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required
                                    >
                                        <option value="email">Email</option>
                                        <option value="sms">SMS</option>
                                        <option value="push">Push</option>
                                        <option value="in_app">In-App</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                                    <input
                                        type="text"
                                        wire:model="templateSubject"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Content</label>
                                    <textarea
                                        wire:model="templateContent"
                                        rows="6"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="Use {{variable_name}} for dynamic content"
                                        required
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                {{ $selectedTemplate ? 'Update' : 'Create' }}
                            </button>
                            <button
                                type="button"
                                wire:click="$set('showTemplateEditor', false); resetTemplateForm()"
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

    <!-- Alert Configuration Modal -->
    @if($showAlertConfig)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form wire:submit="createAlert">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                Create Alert
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alert Type</label>
                                    <input
                                        type="text"
                                        wire:model="alertType"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        placeholder="e.g., System Maintenance, Holiday Announcement"
                                        required
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                                    <textarea
                                        wire:model="alertMessage"
                                        rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required
                                    ></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Channels</label>
                                    <div class="space-y-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="alertChannel" value="email" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Email</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="alertChannel" value="sms" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">SMS</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="alertChannel" value="push" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Push</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="alertChannel" value="in_app" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">In-App</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                Create Alert
                            </button>
                            <button
                                type="button"
                                wire:click="$set('showAlertConfig', false); resetAlertForm()"
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
</div>
