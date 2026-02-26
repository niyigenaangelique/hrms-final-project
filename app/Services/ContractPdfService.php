<?php

namespace App\Services;

use App\Models\Contract;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ContractPdfService
{
    public function generateContractPdf(Contract $contract): string
    {
        // Generate HTML content
        $html = view('pdf.contract', [
            'contract' => $contract->load(['employee', 'position'])
        ])->render();
        
        // Generate filename
        $filename = 'contract_' . $contract->code . '_' . now()->format('Y-m-d') . '.html';
        
        // Store the HTML as PDF (simplified approach)
        $path = 'contracts/' . $filename;
        Storage::disk('public')->put($path, $html);
        
        return $path;
    }
    
    public function downloadContract(Contract $contract)
    {
        $path = $this->generateContractPdf($contract);
        
        // For now, we'll download as HTML file (can be converted to PDF later)
        return Response::download(
            storage_path('app/public/' . $path),
            'contract_' . $contract->code . '.html',
            ['Content-Type' => 'text/html']
        );
    }
}
