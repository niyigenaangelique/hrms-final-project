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
        $adminCount   = User::where('role', 'admin')->count();
        $hrCount      = User::where('role', 'hr_manager')->count();
        $empCount     = User::where('role', 'employee')->count();

        $recentUsers  = User::orderBy('created_at', 'desc')->limit(5)->get();

        $payrollTotal = 0;
        $payrollCount = 0;
        try {
            $payrollTotal = DB::table('payroll_entries')->where('approval_status','approved')->sum('total_amount');
            $payrollCount = DB::table('payroll_entries')->count();
        } catch (\Exception) {}

        $payslipCount = 0;
        try { $payslipCount = DB::table('payslip_entries')->count(); } catch (\Exception) {}

        $paymentTotal = 0;
        try { $paymentTotal = DB::table('payment_histories')->where('status','completed')->sum('amount_paid'); } catch (\Exception) {}

        $auditCount = 0;
        try { $auditCount = DB::table('audit_logs')->whereDate('created_at', today())->count(); } catch (\Exception) {}

        $sessionCount = 0;
        try { $sessionCount = DB::table('sessions')->count(); } catch (\Exception) {}

        $recentActivity = collect();
        try {
            $recentActivity = DB::table('audit_logs')
                ->orderBy('created_at', 'desc')
                ->limit(8)
                ->get();
        } catch (\Exception) {}

        return view('livewire.admin.enhanced-admin-dashboard', [
            'totalUsers'    => $totalUsers,
            'adminCount'    => $adminCount,
            'hrCount'       => $hrCount,
            'empCount'      => $empCount,
            'recentUsers'   => $recentUsers,
            'payrollTotal'  => $payrollTotal,
            'payrollCount'  => $payrollCount,
            'payslipCount'  => $payslipCount,
            'paymentTotal'  => $paymentTotal,
            'auditCount'    => $auditCount,
            'sessionCount'  => $sessionCount,
            'recentActivity'=> $recentActivity,
        ])->layout('components.layouts.admin');
    }
}