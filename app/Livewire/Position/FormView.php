<?php

namespace App\Livewire\Position;

use App\Helpers\FormattedCodeHelper;
use App\Models\Position;
use App\Livewire\Forms\PositionForm;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormView extends Component
{
    use WithFileUploads;
    public PositionForm $form;
    public ?string $selectedId = null;
    public bool $idNullWarningModal = false;

    #[On('position-selected')]
    public function handleSelected(array $data = []): void
    {
        $this->selectedId = $data['id'] ?? null;
        if ($position = Position::find($this->selectedId)) {
            $this->form->setData($position);
            Log::info("Position selected with ID: {$this->selectedId}");
        } else {
            Log::warning("Position not found for ID: {$this->selectedId}");
            $this->dispatch('positionNotification', ['message' => 'Selected Position not found.', 'type' => 'error']);
        }
    }
    public function render():object
    {
        return view('livewire.position.form-view',
        []
        );
    }
    public function mount(?string $id = null): void
    {
        $this->generateCode();
        if ($id && $position = Position::find($id)) {
            $this->selectedId = $id;
            $this->form->setData($position);
        }
    }

    protected function generateCode(): void
    {
        $this->form->code = FormattedCodeHelper::getNextFormattedCode(Position::class, 'SGA', 5);
    }


    #[On('PositionClosePage')]
    public function handleClosePage(): void
    {
        $this->redirect('/', navigate: true);
    }

    #[On('PositionNew')]
    public function handleNew(): void
    {
        if ($this->selectedId) {
            $this->selectedId = null;
            $this->form->clearData();
            $this->generateCode();
            $this->dispatch('positionNotification', ['message' => 'Form reset for new user.', 'type' => 'info']);
            $this->redirect('/positions', navigate: true);
        } else {
            $this->generateCode();
        }

        sleep(1);
        Flux::modal('loadingPage')->close();
    }

    public function reloadPage(): void
    {
        $this->dispatch('reload-page');
        $this->redirect('/positions', navigate: true);
    }

    #[On('PositionCreate')]
    public function handleCreate(): void
    {
        if ($this->selectedId) {
            Flux::toast('Creation of a new Position is not allowed while an existing Position is selected. Please click on New Item button before proceeding.', 'Error', 10000,variant: 'danger',position:"top right");
            Log::info("Unable to create a new Position because an existing Position is currently selected. Selected Position ID: {$this->selectedId}.");
            $this->dispatch('positionNotification', [
                'message' => 'Creation of a new Position is not allowed while an existing Position is selected. Please deselect the current Position before proceeding.',
                'type' => 'error'
            ]);
            return;

        }
        $result = $this->form->storeData();
        if ($result['success']) {

            $this->dispatch('positionNotification', ['message' => $result['message'], 'type' => 'success']);
            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->search = null;
            $this->generateCode();

        } else {

            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->dispatch('positionNotification', ['message' => $result['message'], 'type' => 'error']);
            return;
        }
    }

    #[On('PositionSave')]
    public function handleSave(): void
    {
        if (!$this->selectedId) {
            Log::info('Cannot save Position because no Position is currently selected.');

            Flux::toast(
                'Cannot update Position because no Position is selected. Please select a Position from the list before attempting to update.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('positionNotification', [
                'message' => 'No Position selected to save. Please select one before proceeding.',
                'type' => 'error'
            ]);


            sleep(1);
            Flux::modal('loadingPage')->close();
            return;
        }

        $result = $this->form->updateData();
        if ($result['success']) {
            $this->form->clearData(); // Clear form data on success
            $this->dispatch('positionNotification', ['message' => $result['message'], 'type' => 'success']);
            $this->redirect('/positions', navigate: true);
        } else {
            $this->dispatch('positionNotification', ['message' => $result['message'], 'type' => 'error']);
        }
    }

    #[On('PositionDelete')]
    public function handleDelete(): void
    {

        if (!$this->selectedId) {
            Log::info('Cannot delete Position because no Position is currently selected.');

            Flux::toast(
                'Cannot delete Position because no Position is selected. Please select a Position from the list before attempting to delete.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('positionNotification', ['message' => 'No user selected to delete.', 'type' => 'error']);

            sleep(2);
            Flux::modal('loadingPage')->close();
            return;
        }
        sleep(2);
        Flux::modal('loadingPage')->close();
        Flux::modal('DeleteConfirm')->show();

    }

    public function deletePosition(): void
    {
        try{
            Flux::modal('loadingPage')->show();
            $user = Position::find($this->selectedId);
            $user->delete();
            $this->dispatch('positionNotification', ['message' => 'Position deleted successfully', 'type' => 'success']);
            $this->reloadPage();
        }
        catch (Exception $e) {
            $this->dispatch('positionNotification', ['message' => 'Error deleting Position: ' . $e->getMessage(), 'type' => 'error']);
        }
        finally {
            Flux::modal('loadingPage')->close();
        }

    }



    #[On('PositionCancel')]
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

