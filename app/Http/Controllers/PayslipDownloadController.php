<?php

namespace App\Http\Controllers;

use App\Models\PayslipEntry;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PayslipDownloadController extends Controller
{
    public function download(Request $request, $entryId)
    {
        try {
            $user = Auth::user();
            $employee = Employee::where('user_id', $user->id)->first();
            
            if (!$employee) {
                return redirect()->back()->with('error', 'Employee record not found.');
            }

            $payslip = PayslipEntry::with(['payrollEntry', 'payrollMonth'])
                ->whereHas('payrollEntry', function($q) use ($employee) {
                    $q->where('employee_id', $employee->id);
                })
                ->findOrFail($entryId);

            $data = [
                'payslip' => $payslip,
                'employee' => $employee,
                'payrollEntry' => $payslip->payrollEntry,
                'month' => $payslip->payrollMonth,
                'orgName' => 'ZIBITECH',
                'generatedAt' => now()->format('F d, Y H:i'),
            ];

            $pdf = Pdf::loadView('pdf.payslip', $data);
            $pdf->setPaper('A4', 'portrait');
            
            $filename = 'payslip_' . ($payslip->payrollMonth->name ?? 'period') . '_' . $employee->code . '.pdf';
            $filename = str_replace(' ', '_', $filename);
            
            return $pdf->stream($filename);

        } catch (\Exception $e) {
            \Log::error('Payslip download failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate payslip PDF.');
        }
    }
}
