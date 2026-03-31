<?php

namespace App\Services;

use App\Models\Contract;
use App\Models\Employee;
use Illuminate\Support\Facades\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class ContractPdfService
{
    public function generateContractPdf(Contract $contract): string
    {
        // Get employee data
        $employee = Employee::find($contract->employee_id);
        
        // Generate PDF using Laravel DomPDF facade
        $pdf = Pdf::loadView('pdf.contract', [
            'contract' => $contract,
            'employee' => $employee,
            'orgName' => 'ZIBITECH',
            'docTitle' => 'Employment Contract',
            'showSalary' => true,
            'showPayment' => true,
            'showSignatures' => true
        ]);
        
        // Configure PDF options
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption(['defaultFont' => 'DM Sans']);
        
        // Generate filename
        $filename = 'contract_' . $contract->code . '_' . now()->format('Y-m-d') . '.pdf';
        
        // Store the PDF
        $path = 'contracts/' . $filename;
        \Storage::disk('public')->put($path, $pdf->output());
        
        return $path;
    }
    
    public function downloadContract(Contract $contract)
    {
        try {
            // Get employee data with proper encoding
            $employee = Employee::find($contract->employee_id);
            
            // Clean and encode data to prevent UTF-8 issues
            $cleanData = $this->cleanDataForPdf([
                'contract' => $contract,
                'employee' => $employee,
                'orgName' => 'ZIBITECH',
                'docTitle' => 'Employment Contract',
                'showSalary' => true,
                'showPayment' => true,
                'showSignatures' => true
            ]);
            
            // Generate PDF using Laravel DomPDF facade
            $pdf = Pdf::loadView('pdf.contract', $cleanData);
            
            // Configure PDF options
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOption(['defaultFont' => 'DM Sans']);
            
            // Generate clean filename
            $filename = 'contract_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $contract->code) . '_' . now()->format('Y-m-d') . '.pdf';
            
            // Return PDF download response
            return $pdf->download($filename);
            
        } catch (\Exception $e) {
            \Log::error('PDF generation failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to generate PDF. Please try again.');
            return redirect()->back();
        }
    }

    public function cleanDataForPdf($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'cleanDataForPdf'], $data);
        } elseif (is_object($data)) {
            // Handle model objects - we don't modify them directly
            return $data;
        } elseif (is_string($data)) {
            // Clean string data to prevent UTF-8 issues
            return mb_convert_encoding($data, 'UTF-8', 'UTF-8');
        }
        
        return $data;
    }
}
