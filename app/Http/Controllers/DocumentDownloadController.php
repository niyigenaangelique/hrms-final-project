<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Employee;
use App\Services\ContractPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentDownloadController extends Controller
{
    public function download(Request $request, $documentId = null)
    {
        try {
            // Get the authenticated user
            $user = Auth::user();
            $employee = Employee::where('user_id', $user->id)->first();
            
            if (!$employee) {
                return redirect()->back()->with('error', 'Employee not found.');
            }

            // Get document ID from different sources
            if ($documentId) {
                // From URL parameter (GET request)
                $documentIdToUse = $documentId;
            } else {
                // From session (POST request)
                $documentIdToUse = session('download_document_id');
                session()->forget('download_document_id');
            }
            
            if (!$documentIdToUse) {
                return redirect()->back()->with('error', 'Document not specified.');
            }

            // Find the document
            $document = Document::where('employee_id', $employee->id)
                ->findOrFail($documentIdToUse);
            
            $filePath = storage_path('app/public/' . $document->file_path);
            
            if (!file_exists($filePath)) {
                return redirect()->back()->with('error', 'File not found.');
            }

            // Get file extension and determine if it's convertible to PDF
            $extension = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));
            $fileName = pathinfo($document->file_path, PATHINFO_FILENAME);
            
            // If it's already a PDF, download directly
            if ($extension === 'pdf') {
                return response()->download($filePath, $document->name);
            }
            
            // For other file types, try to convert to PDF or download as-is
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
                // Convert image to PDF
                return $this->convertImageToPdf($filePath, $document->name, $fileName, $employee);
            } elseif (in_array($extension, ['doc', 'docx', 'txt', 'rtf'])) {
                // For text documents, try to create a simple PDF
                return $this->convertTextToPdf($filePath, $document->name, $fileName, $extension, $employee);
            } else {
                // For other file types, download as-is
                return response()->download($filePath, $document->name);
            }
            
        } catch (\Exception $e) {
            \Log::error('Document download failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to download document. Please try again.');
        }
    }

    private function convertImageToPdf($imagePath, $originalName, $fileName, $employee)
    {
        try {
            // Use DomPDF to convert image to PDF
            $pdf = Pdf::loadView('pdf.image-document', [
                'imagePath' => $imagePath,
                'imageName' => $originalName,
                'employee' => $employee
            ]);
            
            $pdf->setPaper('A4', 'portrait');
            $pdfFilename = $fileName . '.pdf';
            
            return $pdf->download($pdfFilename);
        } catch (\Exception $e) {
            \Log::error('Image to PDF conversion failed: ' . $e->getMessage());
            // Fallback to original image download
            return response()->download($imagePath, $originalName);
        }
    }

    private function convertTextToPdf($filePath, $originalName, $fileName, $extension, $employee)
    {
        try {
            $content = file_get_contents($filePath);
            
            if ($extension === 'txt' || $extension === 'rtf') {
                // Clean RTF tags if present
                $content = preg_replace('/\\{\\\\[^}]*\\}/', '', $content);
                $content = strip_tags($content);
            }
            
            $pdf = Pdf::loadView('pdf.text-document', [
                'content' => $content,
                'title' => $originalName,
                'employee' => $employee
            ]);
            
            $pdf->setPaper('A4', 'portrait');
            $pdfFilename = $fileName . '.pdf';
            
            return $pdf->download($pdfFilename);
        } catch (\Exception $e) {
            \Log::error('Text to PDF conversion failed: ' . $e->getMessage());
            // Fallback to original file download
            return response()->download($filePath, $originalName);
        }
    }
}
