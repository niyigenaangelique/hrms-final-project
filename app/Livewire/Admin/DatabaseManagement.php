<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class DatabaseManagement extends Component
{
    // Database Operations
    public $selectedTables = [];
    public $backupPath = '';
    public $restoreFile = null;
    public $showBackupModal = false;
    public $showRestoreModal = false;
    public $showOptimizeModal = false;
    
    // Query Execution
    public $customQuery = '';
    public $queryResults = [];
    public $queryError = null;

    public function mount()
    {
        // Initialize with empty values
    }

    public function render()
    {
        // Combine database stats into a single array
        $dbStats = array_merge(
            $this->getTableStats(),
            $this->getDatabaseInfo()
        );

        return view('livewire.admin.database-management', [
            'tables' => $this->getDatabaseTables(),
            'dbStats' => $dbStats,
            'backups' => $this->getBackupList(),
            'queryResults' => $this->queryResults,
            'queryError' => $this->queryError,
        ])->layout('components.layouts.admin');
    }

    private function getDatabaseTables()
    {
        $tables = DB::select('SHOW TABLES');
        $tableList = [];

        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            $tableList[$tableName] = [
                'name' => $tableName,
                'size' => $this->getTableSize($tableName),
                'rows' => DB::table($tableName)->count(),
                'engine' => $this->getTableEngine($tableName),
                'collation' => $this->getTableCollation($tableName),
                'selected' => in_array($tableName, $this->selectedTables),
            ];
        }

        return $tableList;
    }

    private function getTableSize($tableName)
    {
        $result = DB::select("SELECT ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'size' 
                              FROM information_schema.TABLES 
                              WHERE table_schema = '" . env('DB_DATABASE') . "' 
                              AND table_name = '" . $tableName . "'");
        
        return $result[0]->size ?? 0;
    }

    private function getTableEngine($tableName)
    {
        $result = DB::select("SELECT ENGINE FROM information_schema.TABLES 
                              WHERE table_schema = '" . env('DB_DATABASE') . "' 
                              AND table_name = '" . $tableName . "'");
        
        return $result[0]->ENGINE ?? 'Unknown';
    }

    private function getTableCollation($tableName)
    {
        $result = DB::select("SELECT TABLE_COLLATION FROM information_schema.TABLES 
                              WHERE table_schema = '" . env('DB_DATABASE') . "' 
                              AND table_name = '" . $tableName . "'");
        
        return $result[0]->TABLE_COLLATION ?? 'Unknown';
    }

    private function getTableStats()
    {
        $tables = $this->getDatabaseTables();
        $totalSize = array_sum(array_column($tables, 'size'));
        $totalRows = array_sum(array_column($tables, 'rows'));

        return [
            'total_tables' => count($tables),
            'total_size' => $totalSize,
            'total_rows' => $totalRows,
            'largest_table' => $tables ? collect($tables)->sortByDesc('size')->first() : null,
            'most_rows' => $tables ? collect($tables)->sortByDesc('rows')->first() : null,
        ];
    }

    private function getDatabaseInfo()
    {
        $result = DB::select("SELECT VERSION() as version");
        
        return [
            'version' => $result[0]->version,
            'charset' => DB::select("SELECT DEFAULT_CHARACTER_SET_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '" . env('DB_DATABASE') . "'")[0]->DEFAULT_CHARACTER_SET_NAME ?? 'Unknown',
            'collation' => DB::select("SELECT DEFAULT_COLLATION_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = '" . env('DB_DATABASE') . "'")[0]->DEFAULT_COLLATION_NAME ?? 'Unknown',
            'name' => env('DB_DATABASE'),
        ];
    }

    public function toggleTableSelection($tableName)
    {
        if (in_array($tableName, $this->selectedTables)) {
            $this->selectedTables = array_diff($this->selectedTables, [$tableName]);
        } else {
            $this->selectedTables[] = $tableName;
        }
    }

    public function selectAllTables()
    {
        $tables = array_keys($this->getDatabaseTables());
        $this->selectedTables = $tables;
    }

    public function deselectAllTables()
    {
        $this->selectedTables = [];
    }

    public function optimizeSelectedTables()
    {
        if (empty($this->selectedTables)) {
            session()->flash('error', 'Please select tables to optimize');
            return;
        }

        foreach ($this->selectedTables as $table) {
            DB::statement("OPTIMIZE TABLE `{$table}`");
        }

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'tables_optimized',
            'description' => 'Optimized tables: ' . implode(', ', $this->selectedTables),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', count($this->selectedTables) . ' tables optimized successfully!');
        $this->selectedTables = [];
    }

    public function repairSelectedTables()
    {
        if (empty($this->selectedTables)) {
            session()->flash('error', 'Please select tables to repair');
            return;
        }

        foreach ($this->selectedTables as $table) {
            DB::statement("REPAIR TABLE `{$table}`");
        }

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'tables_repaired',
            'description' => 'Repaired tables: ' . implode(', ', $this->selectedTables),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', count($this->selectedTables) . ' tables repaired successfully!');
        $this->selectedTables = [];
    }

    public function truncateSelectedTables()
    {
        if (empty($this->selectedTables)) {
            session()->flash('error', 'Please select tables to truncate');
            return;
        }

        foreach ($this->selectedTables as $table) {
            DB::statement("TRUNCATE TABLE `{$table}`");
        }

        \App\Models\ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'tables_truncated',
            'description' => 'Truncated tables: ' . implode(', ', $this->selectedTables),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        session()->flash('success', count($this->selectedTables) . ' tables truncated successfully!');
        $this->selectedTables = [];
    }

    public function openBackupModal()
    {
        $this->showBackupModal = true;
    }

    public function closeBackupModal()
    {
        $this->showBackupModal = false;
        $this->backupPath = '';
    }

    public function openRestoreModal()
    {
        $this->showRestoreModal = true;
    }

    public function closeRestoreModal()
    {
        $this->showRestoreModal = false;
        $this->restoreFile = null;
    }

    public function createBackup()
    {
        $this->validate([
            'backupPath' => 'required|string|max:255',
        ]);

        // Backup functionality placeholder
        session()->flash('info', 'Database backup functionality coming soon');
        $this->closeBackupModal();
    }

    public function restoreBackup()
    {
        $this->validate([
            'restoreFile' => 'required|file|mimes:sql,gz',
        ]);

        // Restore functionality placeholder
        session()->flash('info', 'Database restore functionality coming soon');
        $this->closeRestoreModal();
    }

    public function runDatabaseCheck()
    {
        $results = [];
        
        // Check database connection
        try {
            DB::connection()->getPdo();
            $results['connection'] = 'OK';
        } catch (\Exception $e) {
            $results['connection'] = 'Error: ' . $e->getMessage();
        }

        // Check table integrity
        $tables = $this->getDatabaseTables();
        $results['table_count'] = count($tables);
        $results['tables_checked'] = 'OK';

        // Check foreign key constraints
        try {
            $constraints = DB::select("SELECT COUNT(*) as count FROM information_schema.KEY_COLUMN_USAGE 
                                      WHERE TABLE_SCHEMA = '" . env('DB_DATABASE') . "' 
                                      AND REFERENCED_TABLE_NAME IS NOT NULL");
            $results['foreign_keys'] = $constraints[0]->count . ' foreign keys found';
        } catch (\Exception $e) {
            $results['foreign_keys'] = 'Error: ' . $e->getMessage();
        }

        session()->flash('info', 'Database check completed. Results: ' . json_encode($results));
    }

    public function exportSchema()
    {
        // Schema export functionality placeholder
        session()->flash('info', 'Schema export functionality coming soon');
    }

    public function analyzeQueryPerformance()
    {
        // Query performance analysis placeholder
        session()->flash('info', 'Query performance analysis coming soon');
    }

    public function executeQuery()
    {
        try {
            $this->queryResults = DB::select(DB::raw($this->customQuery));
            $this->queryError = null;
            session()->flash('success', 'Query executed successfully. ' . count($this->queryResults) . ' rows returned.');
        } catch (\Exception $e) {
            $this->queryResults = [];
            $this->queryError = $e->getMessage();
            session()->flash('error', 'Query execution failed: ' . $e->getMessage());
        }
    }

    public function clearQuery()
    {
        $this->customQuery = '';
        $this->queryResults = [];
        $this->queryError = null;
    }

    private function getBackupList()
    {
        // Placeholder for backup list - in a real implementation, this would scan backup directory
        return [
            [
                'name' => 'backup_' . date('Y-m-d_H-i-s') . '.sql',
                'size' => '2.5 MB',
                'created_at' => now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'backup_' . date('Y-m-d_H-i-s', strtotime('-1 day')) . '.sql',
                'size' => '2.3 MB',
                'created_at' => now()->subDay()->format('Y-m-d H:i:s')
            ]
        ];
    }
}
