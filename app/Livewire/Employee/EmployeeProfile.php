<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\Contract;
use App\Models\Document;
use App\Models\EmergencyContact;
use Livewire\WithFileUploads;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Auth;

#[Title('TalentFlow Pro | My Profile')]
class EmployeeProfile extends Component
{
    use WithFileUploads;
    
    public $employee;
    public $activeTab = 'overview';
    public $contracts;
    public $documents;
    public $emergencyContacts;
    
    // Document upload properties
    public $documentName;
    public $documentFile;
    public $showDocumentModal = false;
    
    // Emergency contact properties
    public $contactName;
    public $contactRelationship;
    public $contactPhone;
    public $contactEmail;
    public $showContactModal = false;

    public function mount($employeeId = null)
    {
        if ($employeeId) {
            // Admin viewing employee profile
            $this->employee = Employee::with([
                'contracts',
                'documents',
                'position',
                'department'
            ])->findOrFail($employeeId);
        } else {
            // Employee viewing their own profile
            $user = Auth::user();
            $this->employee = Employee::where('user_id', $user->id)->first();
            
            if (!$this->employee) {
                // Create employee if not exists
                // Get the highest existing employee code number
            $lastEmployee = Employee::orderBy('id', 'desc')->first();
            $lastCode = $lastEmployee ? intval(substr($lastEmployee->code, -4)) : 0;
            $newCode = 'EMP-' . str_pad($lastCode + 1, 4, '0', STR_PAD_LEFT);
            
            $this->employee = Employee::create([
                'code' => $newCode,
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone_number' => $user->phone_number,
                    'user_id' => $user->id,
                    'approval_status' => \App\Enum\ApprovalStatus::Approved,
                ]);
            }
        }
        
        $this->loadRelatedData();
    }

    public function loadRelatedData()
    {
        $this->contracts = $this->employee->contracts()->latest()->get();
        $this->documents = $this->employee->documents()->latest()->get();
        $this->emergencyContacts = $this->employee->emergencyContacts()->get();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function getEmploymentHistory()
    {
        return $this->employee->contracts()
            ->with('position')
            ->orderBy('start_date', 'desc')
            ->get()
            ->map(function ($contract) {
                return [
                    'title' => $contract->position->name ?? 'Position',
                    'company' => 'ZIBITECH',
                    'period' => $contract->start_date->format('M Y') . ' - ' . 
                              ($contract->end_date ? $contract->end_date->format('M Y') : 'Present'),
                    'type' => $contract->contract_type ?? 'Full-time',
                    'description' => $contract->job_description ?? 'Employee role and responsibilities'
                ];
            });
    }

    // Document upload methods
    public function uploadDocument()
    {
        $this->validate([
            'documentName' => 'required|string|max:255',
            'documentFile' => 'required|file|max:10240', // 10MB max
        ]);

        $filePath = $this->documentFile->store('documents', 'public');
        
        Document::create([
            'employee_id' => $this->employee->id,
            'code' => 'DOC-' . str_pad(Document::query()->count() + 1, 3, '0', STR_PAD_LEFT),
            'name' => $this->documentName,
            'type' => $this->documentFile->getClientOriginalExtension(),
            'category' => 'General',
            'file_path' => $filePath,
            'description' => 'Uploaded by employee',
            'is_active' => true,
            'approval_status' => \App\Enum\ApprovalStatus::Approved,
            'created_by' => $this->employee->user_id,
        ]);

        $this->reset(['documentName', 'documentFile', 'showDocumentModal']);
        $this->loadRelatedData();
        
        session()->flash('message', 'Document uploaded successfully!');
    }

    // Emergency contact methods
    public function addEmergencyContact()
    {
        $this->validate([
            'contactName' => 'required|string|max:255',
            'contactRelationship' => 'required|string|max:255',
            'contactPhone' => 'required|string|max:20',
            'contactEmail' => 'nullable|email|max:255',
        ]);

        EmergencyContact::create([
            'employee_id' => $this->employee->id,
            'code' => 'EC-' . str_pad(EmergencyContact::query()->count() + 1, 3, '0', STR_PAD_LEFT),
            'name' => $this->contactName,
            'relationship' => $this->contactRelationship,
            'phone' => $this->contactPhone,
            'email' => $this->contactEmail,
            'address' => '',
            'is_primary' => false,
            'approval_status' => \App\Enum\ApprovalStatus::Approved,
            'created_by' => $this->employee->user_id,
        ]);

        $this->reset(['contactName', 'contactRelationship', 'contactPhone', 'contactEmail', 'showContactModal']);
        $this->loadRelatedData();
        
        session()->flash('message', 'Emergency contact added successfully!');
    }

    public function deleteDocument($documentId)
    {
        $document = Document::where('employee_id', $this->employee->id)->findOrFail($documentId);
        $document->delete();
        $this->loadRelatedData();
        session()->flash('message', 'Document deleted successfully!');
    }

    public function deleteEmergencyContact($contactId)
    {
        $contact = EmergencyContact::where('employee_id', $this->employee->id)->findOrFail($contactId);
        $contact->delete();
        $this->loadRelatedData();
        session()->flash('message', 'Emergency contact deleted successfully!');
    }

    public function render()
    {
        return view('livewire.employee.employee-profile')
            ->layout('components.layouts.employee');
    }
}
