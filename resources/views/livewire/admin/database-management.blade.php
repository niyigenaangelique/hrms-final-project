<div>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Database Management</h1>
        <p class="text-gray-600 mt-2">Manage database operations and maintenance</p>
    </div>

    <!-- Database Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="text-sm font-medium text-gray-500">Total Tables</div>
                <div class="text-2xl font-bold text-gray-900">{{ $dbStats['total_tables'] ?? 0 }}</div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="text-sm font-medium text-gray-500">Database Size</div>
                <div class="text-2xl font-bold text-gray-900">{{ $dbStats['database_size'] ?? '0 MB' }}</div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="text-sm font-medium text-gray-500">Connections</div>
                <div class="text-2xl font-bold text-gray-900">{{ $dbStats['active_connections'] ?? 0 }}</div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="text-sm font-medium text-gray-500">Last Backup</div>
                <div class="text-2xl font-bold text-gray-900">{{ $dbStats['last_backup'] ?? 'Never' }}</div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mb-6">
        <div class="flex space-x-3">
            <button wire:click="createBackup" 
                    class="px-4 py-2 bg-white text-black rounded hover:bg-blue-50 hover:border-blue-300 border border-transparent">
                Create Backup
            </button>
            <button wire:click="optimizeDatabase" 
                    class="px-4 py-2 bg-white text-black rounded hover:bg-blue-50 hover:border-blue-300 border border-transparent">
                Optimize Database
            </button>
            <button wire:click="repairDatabase" 
                    class="px-4 py-2 bg-white text-black rounded hover:bg-blue-50 hover:border-blue-300 border border-transparent">
                Repair Database
            </button>
            <button wire:click="refreshTableList" 
                    class="px-4 py-2 bg-white text-black rounded hover:bg-blue-50 hover:border-blue-300 border border-transparent">
                Refresh Tables
            </button>
        </div>
    </div>

    <!-- Tables List -->
    <div class="bg-white shadow overflow-hidden rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Database Tables</h3>
        </div>
        <div class="border-t border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Table Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rows</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Size</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Engine</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tables as $table)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $table['name'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ number_format($table['rows']) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $table['size'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $table['engine'] ?? 'Unknown' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <button wire:click="viewTableStructure({{ $table['name'] }})" 
                                        class="text-black hover:text-blue-600">
                                    Structure
                                </button>
                                <button wire:click="optimizeTable({{ $table['name'] }})" 
                                        class="text-black hover:text-blue-600">
                                    Optimize
                                </button>
                                <button wire:click="repairTable({{ $table['name'] }})" 
                                        class="text-black hover:text-blue-600">
                                    Repair
                                </button>
                                <button wire:click="truncateTable({{ $table['name'] }})" 
                                        class="text-black hover:text-blue-600"
                                        onclick="return confirm('Are you sure you want to truncate this table?')">
                                    Truncate
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No tables found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Query Executor -->
    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Query Executor</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">SQL Query</label>
                <textarea wire:model="customQuery" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm font-mono text-sm"
                          placeholder="SELECT * FROM users LIMIT 10;"></textarea>
                @error('customQuery') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div class="flex space-x-3">
                <button wire:click="executeQuery" 
                        class="px-4 py-2 bg-white text-black rounded hover:bg-blue-50 hover:border-blue-300 border border-transparent">
                    Execute Query
                </button>
                <button wire:click="clearQuery" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-black hover:bg-blue-50 hover:border-blue-300">
                    Clear
                </button>
            </div>
        </div>

        <!-- Query Results -->
        @if($queryResults && count($queryResults) > 0)
            <div class="mt-6">
                <h4 class="text-md font-medium text-gray-900 mb-2">Query Results ({{ count($queryResults) }} rows)</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @if(isset($queryResults[0]) && is_array($queryResults[0]))
                                    @foreach(array_keys($queryResults[0]) as $column)
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            {{ $column }}
                                        </th>
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($queryResults as $row)
                                <tr>
                                    @foreach($row as $value)
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ is_null($value) ? 'NULL' : $value }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if($queryError)
            <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                {{ $queryError }}
            </div>
        @endif
    </div>

    <!-- Backup List -->
    <div class="bg-white shadow rounded-lg p-6 mt-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Backups</h3>
        <div class="space-y-2">
            @forelse($backups as $backup)
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded">
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ $backup['name'] }}</div>
                        <div class="text-sm text-gray-500">{{ $backup['size'] }} - {{ $backup['created_at'] }}</div>
                    </div>
                    <div class="space-x-2">
                        <button wire:click="downloadBackup({{ $backup['name'] }})" 
                                class="text-black hover:text-blue-600 text-sm">
                            Download
                        </button>
                        <button wire:click="restoreBackup({{ $backup['name'] }})" 
                                class="text-black hover:text-blue-600 text-sm">
                            Restore
                        </button>
                        <button wire:click="deleteBackup({{ $backup['name'] }})" 
                                class="text-black hover:text-blue-600 text-sm"
                                onclick="return confirm('Are you sure you want to delete this backup?')">
                            Delete
                        </button>
                    </div>
                </div>
            @empty
                <div class="text-center text-sm text-gray-500 py-4">No backups found</div>
            @endforelse
        </div>
    </div>

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
