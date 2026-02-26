<?php

namespace App\Livewire\Project;

use App\Enum\ProjectStatus;
use App\Helpers\FormattedCodeHelper;
use App\Models\Project;
use App\Livewire\Forms\ProjectForm;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormView extends Component
{
    use WithFileUploads;
    public ProjectForm $form;
    public ?string $selectedId = null;
    public bool $idNullWarningModal = false;

    #[On('project-selected')]
    public function handleSelected(array $data = []): void
    {
        $this->selectedId = $data['id'] ?? null;
        if ($project = Project::find($this->selectedId)) {
            $this->form->setData($project);
            Log::info("Project selected with ID: {$this->selectedId}");
        } else {
            Log::warning("Project not found for ID: {$this->selectedId}");
            $this->dispatch('projectNotification', ['message' => 'Selected Project not found.', 'type' => 'error']);
        }
    }
    public function render():object
    {
        return view('livewire.project.form-view',
        [
            'project_statuses' => ProjectStatus::detailedList(),
        ]
        );
    }
    public function mount(?string $id = null): void
    {
        $this->generateCode();
        if ($id && $project = Project::find($id)) {
            $this->selectedId = $id;
            $this->form->setData($project);
        }
    }

    protected function generateCode(): void
    {
        $this->form->code = FormattedCodeHelper::getNextFormattedCode(Project::class, 'SGA', 5);
    }


    #[On('ProjectClosePage')]
    public function handleClosePage(): void
    {
        $this->redirect('/', navigate: true);
    }

    #[On('ProjectNew')]
    public function handleNew(): void
    {
        if ($this->selectedId) {
            $this->selectedId = null;
            $this->form->clearData();
            $this->generateCode();
            $this->dispatch('projectNotification', ['message' => 'Form reset for new user.', 'type' => 'info']);
            $this->redirect('/projects', navigate: true);
        } else {
            $this->generateCode();
        }

        sleep(1);
        Flux::modal('loadingPage')->close();
    }

    public function reloadPage(): void
    {
        $this->dispatch('reload-page');
        $this->redirect('/projects', navigate: true);
    }

    #[On('ProjectCreate')]
    public function handleCreate(): void
    {
        if ($this->selectedId) {
            Flux::toast('Creation of a new Project is not allowed while an existing Project is selected. Please click on New Item button before proceeding.', 'Error', 10000,variant: 'danger',position:"top right");
            Log::info("Unable to create a new Project because an existing Project is currently selected. Selected Project ID: {$this->selectedId}.");
            $this->dispatch('projectNotification', [
                'message' => 'Creation of a new Project is not allowed while an existing Project is selected. Please deselect the current Project before proceeding.',
                'type' => 'error'
            ]);
            return;

        }
        $result = $this->form->storeData();
        if ($result['success']) {

            $this->dispatch('projectNotification', ['message' => $result['message'], 'type' => 'success']);
            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->search = null;
            $this->generateCode();

        } else {

            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->dispatch('projectNotification', ['message' => $result['message'], 'type' => 'error']);
            return;
        }
    }

    #[On('ProjectSave')]
    public function handleSave(): void
    {
        if (!$this->selectedId) {
            Log::info('Cannot save Project because no Project is currently selected.');

            Flux::toast(
                'Cannot update Project because no Project is selected. Please select a Project from the list before attempting to update.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('projectNotification', [
                'message' => 'No Project selected to save. Please select one before proceeding.',
                'type' => 'error'
            ]);


            sleep(1);
            Flux::modal('loadingPage')->close();
            return;
        }

        $result = $this->form->updateData();
        if ($result['success']) {
            $this->form->clearData(); // Clear form data on success
            $this->dispatch('projectNotification', ['message' => $result['message'], 'type' => 'success']);
            $this->redirect('/projects', navigate: true);
        } else {
            $this->dispatch('projectNotification', ['message' => $result['message'], 'type' => 'error']);
        }
    }

    #[On('ProjectDelete')]
    public function handleDelete(): void
    {

        if (!$this->selectedId) {
            Log::info('Cannot delete Project because no Project is currently selected.');

            Flux::toast(
                'Cannot delete Project because no Project is selected. Please select a Project from the list before attempting to delete.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('projectNotification', ['message' => 'No user selected to delete.', 'type' => 'error']);

            sleep(2);
            Flux::modal('loadingPage')->close();
            return;
        }
        sleep(2);
        Flux::modal('loadingPage')->close();
        Flux::modal('DeleteConfirm')->show();

    }

    public function deleteProject(): void
    {
        try{
            Flux::modal('loadingPage')->show();
            $user = Project::find($this->selectedId);
            $user->delete();
            $this->dispatch('projectNotification', ['message' => 'Project deleted successfully', 'type' => 'success']);
            $this->reloadPage();
        }
        catch (Exception $e) {
            $this->dispatch('projectNotification', ['message' => 'Error deleting Project: ' . $e->getMessage(), 'type' => 'error']);
        }
        finally {
            Flux::modal('loadingPage')->close();
        }

    }



    #[On('ProjectCancel')]
    public function handleCancel(): void
    {
        $this->selectedId = null;
        $this->form->clearData();
        $this->generateCode();
        $this->reloadPage();
        sleep(2);
        Flux::modal('loadingPage')->close();
    }
}

