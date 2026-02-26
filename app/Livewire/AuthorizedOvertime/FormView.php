<?php

namespace App\Livewire\AuthorizedOvertime;

use App\Helpers\FormattedCodeHelper;
use App\Models\AuthorizedOvertime;
use App\Livewire\Forms\AuthorizedOvertimeForm;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormView extends Component
{
    use WithFileUploads;
    public AuthorizedOvertimeForm $form;
    public ?string $selectedId = null;
    public bool $idNullWarningModal = false;

    #[On('authorizedOvertime-selected')]
    public function handleSelected(array $data = []): void
    {
        $this->selectedId = $data['id'] ?? null;
        if ($authorizedOvertime = AuthorizedOvertime::find($this->selectedId)) {
            $this->form->setData($authorizedOvertime);
            Log::info("AuthorizedOvertime selected with ID: {$this->selectedId}");
        } else {
            Log::warning("AuthorizedOvertime not found for ID: {$this->selectedId}");
            $this->dispatch('authorized_overtimeNotification', ['message' => 'Selected AuthorizedOvertime not found.', 'type' => 'error']);
        }
    }
    public function render():object
    {
        return view('livewire.authorized-overtime.form-view',
        []
        );
    }
    public function mount(?string $id = null): void
    {
        $this->generateCode();
        if ($id && $authorizedOvertime = AuthorizedOvertime::find($id)) {
            $this->selectedId = $id;
            $this->form->setData($authorizedOvertime);
        }
    }

    protected function generateCode(): void
    {
        $this->form->code = FormattedCodeHelper::getNextFormattedCode(AuthorizedOvertime::class, 'SGA', 5);
    }


    #[On('AuthorizedOvertimeClosePage')]
    public function handleClosePage(): void
    {
        $this->redirect('/', navigate: true);
    }

    #[On('AuthorizedOvertimeNew')]
    public function handleNew(): void
    {
        if ($this->selectedId) {
            $this->selectedId = null;
            $this->form->clearData();
            $this->generateCode();
            $this->dispatch('authorized_overtimeNotification', ['message' => 'Form reset for new user.', 'type' => 'info']);
            $this->redirect('/authorizedOvertimes', navigate: true);
        } else {
            $this->generateCode();
        }

        sleep(1);
        Flux::modal('loadingPage')->close();
    }

    public function reloadPage(): void
    {
        $this->dispatch('reload-page');
        $this->redirect('/authorizedOvertimes', navigate: true);
    }

    #[On('AuthorizedOvertimeCreate')]
    public function handleCreate(): void
    {
        if ($this->selectedId) {
            Flux::toast('Creation of a new AuthorizedOvertime is not allowed while an existing AuthorizedOvertime is selected. Please click on New Item button before proceeding.', 'Error', 10000,variant: 'danger',position:"top right");
            Log::info("Unable to create a new AuthorizedOvertime because an existing AuthorizedOvertime is currently selected. Selected AuthorizedOvertime ID: {$this->selectedId}.");
            $this->dispatch('authorized_overtimeNotification', [
                'message' => 'Creation of a new AuthorizedOvertime is not allowed while an existing AuthorizedOvertime is selected. Please deselect the current AuthorizedOvertime before proceeding.',
                'type' => 'error'
            ]);
            return;

        }
        $result = $this->form->storeData();
        if ($result['success']) {

            $this->dispatch('authorized_overtimeNotification', ['message' => $result['message'], 'type' => 'success']);
            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->search = null;
            $this->generateCode();

        } else {

            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->dispatch('authorized_overtimeNotification', ['message' => $result['message'], 'type' => 'error']);
            return;
        }
    }

    #[On('AuthorizedOvertimeSave')]
    public function handleSave(): void
    {
        if (!$this->selectedId) {
            Log::info('Cannot save AuthorizedOvertime because no AuthorizedOvertime is currently selected.');

            Flux::toast(
                'Cannot update AuthorizedOvertime because no AuthorizedOvertime is selected. Please select a AuthorizedOvertime from the list before attempting to update.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('authorized_overtimeNotification', [
                'message' => 'No AuthorizedOvertime selected to save. Please select one before proceeding.',
                'type' => 'error'
            ]);


            sleep(1);
            Flux::modal('loadingPage')->close();
            return;
        }

        $result = $this->form->updateData();
        if ($result['success']) {
            $this->form->clearData(); // Clear form data on success
            $this->dispatch('authorized_overtimeNotification', ['message' => $result['message'], 'type' => 'success']);
            $this->redirect('/authorizedOvertimes', navigate: true);
        } else {
            $this->dispatch('authorized_overtimeNotification', ['message' => $result['message'], 'type' => 'error']);
        }
    }

    #[On('AuthorizedOvertimeDelete')]
    public function handleDelete(): void
    {

        if (!$this->selectedId) {
            Log::info('Cannot delete AuthorizedOvertime because no AuthorizedOvertime is currently selected.');

            Flux::toast(
                'Cannot delete AuthorizedOvertime because no AuthorizedOvertime is selected. Please select a AuthorizedOvertime from the list before attempting to delete.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('authorized_overtimeNotification', ['message' => 'No user selected to delete.', 'type' => 'error']);

            sleep(2);
            Flux::modal('loadingPage')->close();
            return;
        }
        sleep(2);
        Flux::modal('loadingPage')->close();
        Flux::modal('DeleteConfirm')->show();

    }

    public function deleteAuthorizedOvertime(): void
    {
        try{
            Flux::modal('loadingPage')->show();
            $user = AuthorizedOvertime::find($this->selectedId);
            $user->delete();
            $this->dispatch('authorized_overtimeNotification', ['message' => 'AuthorizedOvertime deleted successfully', 'type' => 'success']);
            $this->reloadPage();
        }
        catch (Exception $e) {
            $this->dispatch('authorized_overtimeNotification', ['message' => 'Error deleting AuthorizedOvertime: ' . $e->getMessage(), 'type' => 'error']);
        }
        finally {
            Flux::modal('loadingPage')->close();
        }

    }



    #[On('AuthorizedOvertimeCancel')]
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

