<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Access Control & Logs</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Manage user access, permissions, and system security</p>
            </div>
            <div class="flex space-x-3">
                <button
                    wire:click="$set('showUserManagement', true)"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                >
                    Add User
                </button>
                <button
                    wire:click="$set('showRoleManagement', true)"
                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700"
                >
                    Add Role
                </button>
                <button
                    wire:click="$set('showSecuritySettings', true)"
                    class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700"
                >
                    Security Settings
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button
                    wire:click="setActiveTab('dashboard')"
                    class="{{ $activeTab === 'dashboard' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                           whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Dashboard
                </button>
                <button
                    wire:click="setActiveTab('activity_logs')"
                    class="{{ $activeTab === 'activity_logs' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                           whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Activity Logs
                </button>
                <button
                    wire:click="setActiveTab('users')"
                    class="{{ $activeTab === 'users' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                           whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Users
                </button>
                <button
                    wire:click="setActiveTab('roles')"
                    class="{{ $activeTab === 'roles' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                           whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Roles
                </button>
                <button
                    wire:click="setActiveTab('permissions')"
                    class="{{ $activeTab === 'permissions' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                           whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Permissions
                </button>
                <button
                    wire:click="setActiveTab('security')"
                    class="{{ $activeTab === 'security' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} 
                           whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                >
                    Security
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            <!-- Dashboard Tab -->
            @if($activeTab === 'dashboard')
                <div class="space-y-6">
                    <!-- Security Stats Overview -->
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $securityStats['total_users'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Users</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                {{ $securityStats['active_users'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Active Users</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                {{ $securityStats['total_roles'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Roles</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                {{ $securityStats['total_permissions'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Permissions</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                {{ $securityStats['successful_logins'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Successful Logins</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600 dark:text-red-400">
                                {{ $securityStats['failed_logins'] }}
                            </div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Failed Logins</div>
                        </div>
                    </div>

                    <!-- Recent Activities and Top Stats -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Activities</h3>
                            <div class="space-y-2">
                                @foreach($recentActivities as $activity)
                                    <div class="flex items-center justify-between p-2 border border-gray-200 dark:border-gray-700 rounded">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 rounded-full bg-{{ $activity->getActionColor() }}-500"></div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $activity->description }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $activity->user->name ?? 'System' }} • {{ $activity->created_at->format('M d, Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100">
                                            {{ ucfirst($activity->action) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Top Modules</h3>
                            <div class="space-y-2">
                                @foreach($topModules as $module)
                                    <div class="flex items-center justify-between p-2 border border-gray-200 dark:border-gray-700 rounded">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ ucfirst($module->module) }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $module->count }} activities
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Login Success Rate -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Login Success Rate</h3>
                        <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-8 relative overflow-hidden">
                            <div class="bg-green-500 h-full flex items-center justify-center text-white text-sm font-medium"
                                 style="width: {{ $securityStats['login_success_rate'] }}%">
                                {{ $securityStats['login_success_rate'] }}%
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Activity Logs Tab -->
            @if($activeTab === 'activity_logs')
                <div class="space-y-6">
                    <!-- Filters -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <input
                                type="text"
                                wire:model.live="searchTerm"
                                placeholder="Search activities..."
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            />
                        </div>
                        <div>
                            <select
                                wire:model.live="filterModule"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="all">All Modules</option>
                                <option value="authentication">Authentication</option>
                                <option value="user_management">User Management</option>
                                <option value="role_management">Role Management</option>
                                <option value="employee">Employee</option>
                                <option value="payroll">Payroll</option>
                                <option value="leave">Leave</option>
                            </select>
                        </div>
                        <div>
                            <select
                                wire:model.live="filterAction"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="all">All Actions</option>
                                <option value="login">Login</option>
                                <option value="logout">Logout</option>
                                <option value="failed_login">Failed Login</option>
                                <option value="create">Create</option>
                                <option value="update">Update</option>
                                <option value="delete">Delete</option>
                            </select>
                        </div>
                        <div>
                            <select
                                wire:model.live="filterDateRange"
                                class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                            >
                                <option value="today">Today</option>
                                <option value="7days">Last 7 Days</option>
                                <option value="30days">Last 30 Days</option>
                                <option value="90days">Last 90 Days</option>
                            </select>
                        </div>
                    </div>

                    <!-- Activity Logs List -->
                    <div class="space-y-4">
                        @foreach($activityLogs as $log)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-3 h-3 rounded-full bg-{{ $log->getActionColor() }}-500"></div>
                                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                {{ $log->description }}
                                            </h4>
                                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $log->getActionColor() }}-100 text-{{ $log->getActionColor() }}-800 dark:bg-{{ $log->getActionColor() }}-800 dark:text-{{ $log->getActionColor() }}-100">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-400 mt-1">
                                            Module: {{ ucfirst($log->module) }}
                                        </p>
                                        <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500 dark:text-gray-400">
                                            <span>User: {{ $log->user->name ?? 'System' }}</span>
                                            <span>IP: {{ $log->ip_address }}</span>
                                            <span>{{ $log->created_at->format('M d, Y H:i:s') }}</span>
                                        </div>
                                        @if($log->old_values || $log->new_values)
                                            <div class="mt-3 p-3 bg-gray-50 dark:bg-gray-700 rounded">
                                                <div class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Changes:</div>
                                                @if($log->old_values)
                                                    <div class="text-xs text-red-600 dark:text-red-400">
                                                        Before: {{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}
                                                    </div>
                                                @endif
                                                @if($log->new_values)
                                                    <div class="text-xs text-green-600 dark:text-green-400 mt-1">
                                                        After: {{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($activityLogs->hasPages())
                        <div class="flex justify-center mt-6">
                            {{ $activityLogs->links() }}
                        </div>
                    @endif
                </div>
            @endif

            <!-- Users Tab -->
            @if($activeTab === 'users')
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($users as $user)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $user->name }}
                                    </h4>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($user->is_active) bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100
                                        @else bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100
                                        @endif">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    {{ $user->email }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    Role: {{ $user->user_role }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        Joined: {{ $user->created_at->format('M d, Y') }}
                                    </span>
                                    <div class="flex space-x-2">
                                        <button
                                            wire:click="editUser('{{ $user->id }}')"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            wire:click="deleteUser('{{ $user->id }}')"
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
                    @if($users->hasPages())
                        <div class="flex justify-center mt-6">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            @endif

            <!-- Roles Tab -->
            @if($activeTab === 'roles')
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($roles as $role)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $role->name }}
                                    </h4>
                                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100">
                                        {{ $role->users_count }} users
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    {{ $role->description }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    User Role: {{ $role->user_role }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $role->permissions->count() }} permissions
                                    </span>
                                    <div class="flex space-x-2">
                                        <button
                                            wire:click="editRole('{{ $role->id }}')"
                                            class="text-blue-600 hover:text-blue-800 dark:text-blue-400"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            wire:click="deleteRole('{{ $role->id }}')"
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

            <!-- Permissions Tab -->
            @if($activeTab === 'permissions')
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($permissions as $permission)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ $permission->name }}
                                    </h4>
                                    <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800 dark:bg-purple-800 dark:text-purple-100">
                                        {{ $permission->module }}
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    {{ $permission->description }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $permission->resource }} • {{ $permission->action }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Security Tab -->
            @if($activeTab === 'security')
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($securitySettings as $setting)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ ucwords(str_replace('_', ' ', $setting->key)) }}
                                    </h4>
                                    <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100">
                                        {{ $setting->type }}
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">
                                    {{ $setting->description }}
                                </p>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $setting->value }}
                                    </span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $setting->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- User Management Modal -->
    @if($showUserManagement)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit="selectedUser ? 'updateUser' : 'createUser'">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                {{ $selectedUser ? 'Edit User' : 'Create User' }}
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                                    <input
                                        type="text"
                                        wire:model="userName"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <input
                                        type="email"
                                        wire:model="userEmail"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role</label>
                                    <select
                                        wire:model="userRole"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required
                                    >
                                        @foreach(\App\Enum\UserRole::cases() as $role)
                                            <option value="{{ $role->value }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @if(!$selectedUser)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                                        <input
                                            type="password"
                                            wire:model="userPassword"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            required
                                        />
                                    </div>
                                @endif

                                <div class="flex items-center">
                                    <input
                                        type="checkbox"
                                        wire:model="userIsActive"
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    />
                                    <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">Active</label>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                {{ $selectedUser ? 'Update' : 'Create' }}
                            </button>
                            <button
                                type="button"
                                wire:click="$set('showUserManagement', false); resetUserForm()"
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

    <!-- Role Management Modal -->
    @if($showRoleManagement)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit="selectedRole ? 'updateRole' : 'createRole'">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                {{ $selectedRole ? 'Edit Role' : 'Create Role' }}
                            </h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Role Name</label>
                                    <input
                                        type="text"
                                        wire:model="roleName"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <textarea
                                        wire:model="roleDescription"
                                        rows="3"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    ></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">User Role</label>
                                    <select
                                        wire:model="roleUserRole"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                        required
                                    >
                                        @foreach(\App\Enum\UserRole::cases() as $role)
                                            <option value="{{ $role->value }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                type="submit"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                            >
                                {{ $selectedRole ? 'Update' : 'Create' }}
                            </button>
                            <button
                                type="button"
                                wire:click="$set('showRoleManagement', false); resetRoleForm()"
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
