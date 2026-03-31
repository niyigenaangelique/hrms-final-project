<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Employee;
use App\Services\ContractPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractDownloadController extends Controller
{
    public function download(Request $request, $contractId = null)
    {
        try {
            // Get the authenticated user
            $user = Auth::user();
            $employee = Employee::where('user_id', $user->id)->first();
            
            if (!$employee) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['error' => 'Employee not found.'], 404);
                }
                return redirect()->back()->with('error', 'Employee not found.');
            }

            // Get contract ID from different sources
            if ($contractId) {
                // From URL parameter (GET request)
                $contractIdToUse = $contractId;
            } else {
                // From session (POST request)
                $contractIdToUse = session('download_contract_id');
                session()->forget('download_contract_id');
            }
            
            if (!$contractIdToUse) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['error' => 'Contract not specified.'], 400);
                }
                return redirect()->back()->with('error', 'Contract not specified.');
            }

            // Find the contract with relationships
            $contract = Contract::where('employee_id', $employee->id)
                ->with(['employee', 'position'])
                ->find($contractIdToUse);
            
            if (!$contract) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['error' => 'Contract not found or access denied.'], 404);
                }
                return redirect()->back()->with('error', 'Contract not found or access denied.');
            }

            // Generate PDF
            $pdfService = new ContractPdfService();
            $cleanData = $pdfService->cleanDataForPdf([
                'contract' => $contract,
                'employee' => $contract->employee,
                'orgName' => 'ZIBITECH',
                'docTitle' => 'Employment Contract',
                'showSalary' => true,
                'showPayment' => true,
                'showSignatures' => true
            ]);
            
            $pdf = Pdf::loadView('pdf.contract', $cleanData);
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOption(['defaultFont' => 'DM Sans']);
            
            // Generate clean filename
            $filename = 'contract_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $contract->code) . '_' . now()->format('Y-m-d') . '.pdf';
            
            // Return PDF download with proper headers
            return $pdf->stream($filename);
            
        } catch (\Exception $e) {
            \Log::error('Contract download failed: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // Return JSON error for AJAX requests
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Failed to download contract. Please try again.',
                    'details' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
            
            // Return redirect for regular requests
            return redirect()->back()->with('error', 'Failed to download contract. Please try again.');
        }
    }
}
