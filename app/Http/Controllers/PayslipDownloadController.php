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

            $payslip = PayslipEntry::findOrFail($entryId);

            // Security check
            if ($payslip->payroll_computation_entry_id) {
                $computation = \App\Models\PayrollComputationEntry::with(['payrollPeriod', 'payrollMonth'])->findOrFail($payslip->payroll_computation_entry_id);
                if ($computation->employee_id !== $employee->id) abort(403);
            } else if ($payslip->payroll_entry_id) {
                $oldEntry = \App\Models\PayrollEntry::findOrFail($payslip->payroll_entry_id);
                if ($oldEntry->employee_id !== $employee->id) abort(403);
            } else {
                abort(404, 'Payroll record not linked to this payslip.');
            }

            $data = [
                'payslip' => $payslip,
                'employee' => $employee,
                'computation' => $payslip->payroll_computation_entry_id ? \App\Models\PayrollComputationEntry::find($payslip->payroll_computation_entry_id) : null,
                'payrollEntry' => $payslip->payroll_entry_id ? \App\Models\PayrollEntry::find($payslip->payroll_entry_id) : null,
                'orgName' => 'ZIBITECH',
                'generatedAt' => now()->format('F d, Y H:i'),
            ];

            $pdf = Pdf::loadView('pdf.payslip', $data);
            $pdf->setPaper('A4', 'portrait');
            
            $filename = 'payslip_' . now()->format('M_Y') . '_' . $employee->code . '.pdf';
            
            return $pdf->stream($filename);

        } catch (\Exception $e) {
            \Log::error('Payslip download failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to generate: ' . $e->getMessage());
        }
    }
}
