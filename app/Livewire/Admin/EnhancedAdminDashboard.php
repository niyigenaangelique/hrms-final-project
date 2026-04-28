<?php
// app/Livewire/Admin/EnhancedDashboard.php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[Title('TalentFlow Pro | Admin Dashboard')]
class EnhancedAdminDashboard extends Component
{
    public function render()
    {
        $totalUsers   = User::count();
        $adminCount   = User::whereIn('role', ['admin', 'super_admin', 'company_admin'])->count();
        $hrCount      = User::where('role', 'like', 'hr%')->count();
        $empCount     = User::where('role', 'like', '%employee%')->count();
        $othersCount  = $totalUsers - ($adminCount + $hrCount + $empCount);

        $recentUsers  = User::orderBy('created_at', 'desc')->limit(5)->get();

        $auditCountToday = 0;
        try { $auditCountToday = DB::table('activity_logs')->whereDate('created_at', today())->count(); } catch (\Exception $e) {}

        $failedLoginsToday = 0;
        try { $failedLoginsToday = DB::table('activity_logs')->where('action', 'failed_login')->whereDate('created_at', today())->count(); } catch (\Exception $e) {}

        $totalLogs = 0;
        try { $totalLogs = DB::table('activity_logs')->count(); } catch (\Exception $e) {}

        $dbSize = 'N/A';
        try {
            $results = DB::select('SELECT SUM(data_length + index_length) / 1024 / 1024 AS size FROM information_schema.TABLES WHERE table_schema = ?', [config('database.connections.mysql.database')]);
            $dbSize = round($results[0]->size ?? 0, 2) . ' MB';
        } catch (\Exception $e) {}

        $recentActivity = collect();
        try {
            $recentActivity = DB::table('activity_logs')
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();
        } catch (\Exception $e) {}

        // Chart Data: Activity in last 7 days
        $activityData = [];
        $activityLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $activityLabels[] = now()->subDays($i)->format('M d');
            $activityData[] = DB::table('activity_logs')->whereDate('created_at', $date)->count();
        }

        return view('livewire.admin.enhanced-admin-dashboard', [
            'admin'             => auth()->user(),
            'totalUsers'        => $totalUsers,
            'adminCount'        => $adminCount,
            'hrCount'           => $hrCount,
            'empCount'          => $empCount,
            'othersCount'       => $othersCount,
            'recentUsers'       => $recentUsers,
            'auditCountToday'   => $auditCountToday,
            'failedLoginsToday' => $failedLoginsToday,
            'totalLogs'         => $totalLogs,
            'dbSize'            => $dbSize,
            'recentActivity'    => $recentActivity,
            'chartLabels'       => $activityLabels,
            'chartData'         => $activityData,
        ])->layout('components.layouts.admin');
    }
}