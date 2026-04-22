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
use Illuminate\Support\Facades\Storage;

#[Title('TalentFlow Pro | My Profile')]
class EmployeeProfile extends Component
{
    use WithFileUploads;
    
    public $employee;
    public $activeTab = 'overview';
    public $contracts;
    public $documents;
    public $emergencyContacts;
    public $selectedDocument = null;
    
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
    public $editingContactId = null;
    
    // Edit profile properties
    public $showEditModal = false;
    public $editFirstName;
    public $editLastName;
    public $editEmail;
    public $editPhone;
    public $editAddress;
    public $editCity;
    public $editState;
    public $editCountry;
    public $editNationality;
    public $editNationalId;
    public $editGender;
    public $editBirthDate;
    public $profilePhoto;

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
                    'user_id' => $user->id,
                    'code' => $newCode,
                    'first_name' => $user->name ?? 'First',
                    'last_name' => 'Last',
                    'email' => $user->email,
                    'phone_number' => '',
                    'address' => '',
                    'city' => '',
                    'state' => '',
                    'country' => '',
                    'nationality' => '',
                    'national_id' => '',
                    'gender' => 'male',
                    'birth_date' => now()->subYears(25),
                    'hire_date' => now(),
                    'employment_status' => 'active',
                    'work_schedule' => 'full_time',
                    'salary_currency' => 'RWF',
                    'is_taxable' => true,
                    'rssb_rate' => 5.5,
                    'approval_status' => \App\Enum\ApprovalStatus::Approved,
                    'created_by' => $user->id,
                ]);
            }
        }
        
        // Debug: Log employee data
        \Log::info('Employee loaded for profile: ' . ($this->employee ? $this->employee->full_name : 'NULL'));
        
        $this->loadRelatedData();
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

    public function loadRelatedData()
    {
        $this->contracts = $this->employee->contracts()->with('position')->latest()->get();
        $this->documents = $this->employee->documents()->latest()->get();
        $this->emergencyContacts = $this->employee->emergencyContacts()->get();
    }

    // Document upload methods
    public function uploadDocument()
    {
        $this->validate([
            'documentName' => 'required|string|max:255',
            'documentFile' => 'required|file|max:10240', // 10MB max
        ]);

        $filePath = $this->documentFile->store('documents', 'public');
        
        // Generate unique document code
        $lastCode = Document::withTrashed()->max('code');
        $lastNumber = $lastCode ? (int)str_replace('DOC-', '', $lastCode) : 0;
        $newCode = 'DOC-' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        
        Document::create([
            'employee_id' => $this->employee->id,
            'code' => $newCode,
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

        if ($this->editingContactId) {
            // Update existing contact
            $contact = EmergencyContact::where('employee_id', $this->employee->id)
                ->findOrFail($this->editingContactId);
            
            $contact->update([
                'name' => $this->contactName,
                'relationship' => $this->contactRelationship,
                'phone' => $this->contactPhone,
                'email' => $this->contactEmail,
            ]);
            
            session()->flash('message', 'Emergency contact updated successfully!');
        } else {
            // Create new contact
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
            
            session()->flash('message', 'Emergency contact added successfully!');
        }

        $this->reset(['contactName', 'contactRelationship', 'contactPhone', 'contactEmail', 'showContactModal', 'editingContactId']);
        $this->loadRelatedData();
    }

    public function deleteDocument($documentId)
    {
        $document = Document::where('employee_id', $this->employee->id)->findOrFail($documentId);
        $document->delete();
        
        // Reload documents
        $this->documents = Document::where('employee_id', $this->employee->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        session()->flash('message', 'Document deleted successfully!');
    }

    public function viewDocument($documentId)
    {
        try {
            $document = Document::where('employee_id', $this->employee->id)
                ->findOrFail($documentId);
            
            // Debug: Log the document being viewed
            \Log::info('Viewing document: ' . $documentId . ' - ' . $document->name);
            
            $this->selectedDocument = $document;
            
            // Debug: Log that selectedDocument is set
            \Log::info('selectedDocument set: ' . ($this->selectedDocument ? 'yes' : 'no'));
            
        } catch (\Exception $e) {
            \Log::error('Error viewing document: ' . $e->getMessage());
            session()->flash('error', 'Document not found or access denied.');
        }
    }

    public function downloadDocument($documentId)
    {
        try {
            $document = Document::where('employee_id', $this->employee->id)
                ->findOrFail($documentId);
            
            // Debug: Log the download attempt
            \Log::info('Attempting to download document: ' . $documentId . ' - ' . $document->name);
            
            // Store document ID in session for download route
            session(['download_document_id' => $documentId]);
            
            // Dispatch event to trigger JavaScript download
            $this->dispatch('downloadDocument', documentId: $documentId);
            
            // Debug: Log that event was dispatched
            \Log::info('downloadDocument event dispatched for: ' . $documentId);
            
        } catch (\Exception $e) {
            \Log::error('Document download failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to download document. Please try again.');
        }
    }

    private function convertImageToPdf($imagePath, $originalName, $fileName)
    {
        try {
            // Use DomPDF to convert image to PDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.image-document', [
                'imagePath' => $imagePath,
                'imageName' => $originalName,
                'employee' => $this->employee
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

    private function convertTextToPdf($filePath, $originalName, $fileName, $extension)
    {
        try {
            $content = file_get_contents($filePath);
            
            if ($extension === 'txt' || $extension === 'rtf') {
                // Clean RTF tags if present
                $content = preg_replace('/\\{\\\\[^}]*\\}/', '', $content);
                $content = strip_tags($content);
            }
            
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.text-document', [
                'content' => $content,
                'title' => $originalName,
                'employee' => $this->employee
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

    public function closeDocumentModal()
    {
        $this->selectedDocument = null;
    }

    public function testModal()
    {
        // Create a fake document for testing the modal
        $fakeDocument = new \stdClass();
        $fakeDocument->id = 'test-123';
        $fakeDocument->name = 'Test Document';
        $fakeDocument->file_path = 'test/test.txt';
        $fakeDocument->created_at = now();
        
        $this->selectedDocument = $fakeDocument;
        
        session()->flash('message', 'Test modal opened with fake document');
    }

    public function deleteEmergencyContact($contactId)
    {
        $contact = EmergencyContact::where('employee_id', $this->employee->id)->findOrFail($contactId);
        $contact->delete();
        $this->loadRelatedData();
        session()->flash('message', 'Emergency contact deleted successfully!');
    }

    public function editEmergencyContact($contactId)
    {
        $contact = EmergencyContact::where('employee_id', $this->employee->id)->findOrFail($contactId);
        
        // Set the form fields with the contact data
        $this->contactName = $contact->name;
        $this->contactRelationship = $contact->relationship;
        $this->contactPhone = $contact->phone;
        $this->contactEmail = $contact->email;
        
        // Store the contact ID for updating
        $this->editingContactId = $contactId;
        
        // Show the modal
        $this->showContactModal = true;
    }
    
    // Edit profile methods
    public function openEditModal()
    {
        $this->showEditModal = true;
        $this->editFirstName = $this->employee->first_name;
        $this->editLastName = $this->employee->last_name;
        $this->editEmail = $this->employee->email;
        $this->editPhone = $this->employee->phone_number;
        $this->editAddress = $this->employee->address;
        $this->editCity = $this->employee->city;
        $this->editState = $this->employee->state;
        $this->editCountry = $this->employee->country;
        $this->editNationality = $this->employee->nationality;
        $this->editNationalId = $this->employee->national_id;
        $this->editGender = $this->employee->gender;
        $this->editBirthDate = $this->employee->birth_date ? $this->employee->birth_date->format('Y-m-d') : '';
    }
    
    public function updateProfile()
    {
        \Log::info('updateProfile method called');
        \Log::info('profilePhoto property: ' . ($this->profilePhoto ? 'set' : 'not set'));
        
        try {
            $this->validate([
                'editFirstName' => 'required|string|max:255',
                'editLastName' => 'required|string|max:255',
                'editEmail' => 'required|email|max:255',
                'editPhone' => 'nullable|string|max:20',
                'editAddress' => 'nullable|string|max:255',
                'editCity' => 'nullable|string|max:100',
                'editState' => 'nullable|string|max:100',
                'editCountry' => 'nullable|string|max:100',
                'editNationality' => 'nullable|string|max:100',
                'editNationalId' => 'nullable|string|max:50',
                'editGender' => 'nullable|in:male,female,other',
                'editBirthDate' => 'nullable|date|before:today',
                'profilePhoto' => 'nullable|file|max:1024', // 1MB max to fit within PHP limit
            ]);
            
            \Log::info('Validation passed');

            // Handle profile photo upload
            $photoPath = null;
            if ($this->profilePhoto) {
                try {
                    \Log::info('Profile photo upload starting. File exists: ' . ($this->profilePhoto ? 'Yes' : 'No'));
                    
                    // Delete old photo if exists
                    if ($this->employee->profile_photo) {
                        Storage::disk('public')->delete($this->employee->profile_photo);
                        \Log::info('Old photo deleted');
                    }
                    
                    // Store new photo with explicit path
                    $photoPath = $this->profilePhoto->store('profile-photos', 'public');
                    \Log::info('Profile photo stored at: ' . $photoPath);
                    
                    // Verify file was actually stored
                    if (Storage::disk('public')->exists($photoPath)) {
                        \Log::info('File verified to exist in storage');
                    } else {
                        \Log::error('File does not exist in storage after upload');
                    }
                    
                } catch (\Exception $e) {
                    \Log::error('Profile photo upload failed: ' . $e->getMessage());
                    \Log::error('Exception trace: ' . $e->getTraceAsString());
                    session()->flash('error', 'Photo upload failed: ' . $e->getMessage());
                    return;
                }
            } else {
                \Log::info('No profile photo provided');
            }

            $this->employee->update([
                'first_name' => $this->editFirstName,
                'last_name' => $this->editLastName,
                'email' => $this->editEmail,
                'phone_number' => $this->editPhone,
                'address' => $this->editAddress,
                'city' => $this->editCity,
                'state' => $this->editState,
                'country' => $this->editCountry,
                'nationality' => $this->editNationality,
                'national_id' => $this->editNationalId,
                'gender' => $this->editGender,
                'birth_date' => $this->editBirthDate ? $this->editBirthDate : null,
                'profile_photo' => $photoPath ?? $this->employee->profile_photo,
            ]);

            // Also update the associated user if exists
            if ($this->employee->user) {
                $this->employee->user->update([
                    'first_name' => $this->editFirstName,
                    'last_name' => $this->editLastName,
                    'email' => $this->editEmail,
                    'phone_number' => $this->editPhone,
                ]);
            }

            $this->reset(['showEditModal', 'editFirstName', 'editLastName', 'editEmail', 'editPhone', 
                         'editAddress', 'editCity', 'editState', 'editCountry', 'editNationality', 
                         'editNationalId', 'editGender', 'editBirthDate', 'profilePhoto']);
            
            // Reload employee data
            $this->employee = $this->employee->fresh();
            
            session()->flash('message', 'Profile updated successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors will be displayed automatically
            \Log::error('Validation failed: ' . json_encode($e->errors()));
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error updating profile: ' . $e->getMessage());
            session()->flash('error', 'Error updating profile: ' . $e->getMessage());
        }
    }
    
    // Test method for debugging
    public function testUpload()
    {
        \Log::info('Test upload method called');
        session()->flash('message', 'Test method called successfully!');
    }

    public function render()
    {
        $employmentHistory = $this->getEmploymentHistory();
        
        // Prepare data for the new dashboard-style profile
        $recentActivities = [
            [
                'type' => 'login',
                'description' => 'Logged into system',
                'time' => '2 hours ago'
            ],
            [
                'type' => 'profile',
                'description' => 'Updated profile information',
                'time' => '1 day ago'
            ],
            [
                'type' => 'leave',
                'description' => 'Submitted leave request',
                'time' => '3 days ago'
            ]
        ];
        
        $performanceChartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'data' => [85, 88, 92, 87, 90, 93]
        ];
        
        $leaveChartData = [
            'labels' => ['Approved', 'Pending', 'Rejected'],
            'data' => [3, 1, 0]
        ];
        
        $attendanceChartData = [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            'data' => [1, 1, 1, 0, 1]
        ];
        
        $notifications = collect([]);
        
        // Load leave requests for the dashboard
        $leaveRequests = $this->employee->leaveRequests()->with('leaveType')->latest()->take(5)->get();
        
        return view('livewire.employee.employee-profile', [
            'employmentHistory' => $employmentHistory,
            'recentActivities' => $recentActivities,
            'performanceChartData' => $performanceChartData,
            'leaveChartData' => $leaveChartData,
            'attendanceChartData' => $attendanceChartData,
            'notifications' => $notifications,
            'contracts' => $this->contracts,
            'documents' => $this->documents,
            'emergencyContacts' => $this->emergencyContacts,
            'leaveRequests' => $leaveRequests,
            'attendances' => collect([]) // Empty for now
        ])->layout('components.layouts.employee');
    }
}
