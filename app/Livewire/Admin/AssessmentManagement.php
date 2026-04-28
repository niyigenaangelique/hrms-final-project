<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Assessment;
use Illuminate\Support\Str;

class AssessmentManagement extends Component
{
    use WithPagination;

    public $showModal = false;
    public $assessmentId = null;
    public $title = '';
    public $description = '';
    public $time_limit_minutes = 30;
    public $passing_score = 70;

    public $search = '';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'time_limit_minutes' => 'required|integer|min:1',
        'passing_score' => 'required|numeric|min:0|max:100',
    ];

    public function mount()
    {
        $this->loadAssessments();
    }

    public function loadAssessments()
    {
        // No action needed; data is fetched in render()
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        if ($id) {
            $assessment = Assessment::findOrFail($id);
            $this->assessmentId = $assessment->id;
            $this->title = $assessment->title;
            $this->description = $assessment->description;
            $this->time_limit_minutes = $assessment->time_limit_minutes;
            $this->passing_score = $assessment->passing_score;
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->assessmentId = null;
        $this->title = '';
        $this->description = '';
        $this->time_limit_minutes = 30;
        $this->passing_score = 70;
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();
        if ($this->assessmentId) {
            $assessment = Assessment::findOrFail($this->assessmentId);
            $assessment->update([
                'title' => $this->title,
                'description' => $this->description,
                'time_limit_minutes' => $this->time_limit_minutes,
                'passing_score' => $this->passing_score,
            ]);
            session()->flash('success', 'Assessment updated successfully');
        } else {
            Assessment::create([
                'title' => $this->title,
                'description' => $this->description,
                'time_limit_minutes' => $this->time_limit_minutes,
                'passing_score' => $this->passing_score,
                'created_by' => auth()->user()->email ?? 'system',
            ]);
            session()->flash('success', 'Assessment created successfully');
        }
        $this->closeModal();
    }

    public function delete($id)
    {
        Assessment::findOrFail($id)->delete();
        session()->flash('success', 'Assessment deleted');
    }

    public function render()
    {
        $assessments = Assessment::where('title', 'like', "%{$this->search}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.admin.assessment-management', ['assessments' => $assessments])
            ->layout('components.layouts.admin');
    }
}
?>
