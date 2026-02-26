<?php

namespace App\Livewire\Bank;

use App\Helpers\FormattedCodeHelper;
use App\Models\Bank;
use App\Livewire\Forms\BankForm;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormView extends Component
{
    use WithFileUploads;
    public BankForm $form;
    public ?string $selectedId = null;
    public bool $idNullWarningModal = false;

    #[On('bank-selected')]
    public function handleSelected(array $data = []): void
    {
        $this->selectedId = $data['id'] ?? null;
        if ($bank = Bank::find($this->selectedId)) {
            $this->form->setData($bank);
            Log::info("Bank selected with ID: {$this->selectedId}");
        } else {
            Log::warning("Bank not found for ID: {$this->selectedId}");
            $this->dispatch('bankNotification', ['message' => 'Selected Bank not found.', 'type' => 'error']);
        }
    }
    public function render():object
    {
        return view('livewire.bank.form-view',
        []
        );
    }
    public function mount(?string $id = null): void
    {
        $this->generateCode();
        if ($id && $bank = Bank::find($id)) {
            $this->selectedId = $id;
            $this->form->setData($bank);
        }
    }

    protected function generateCode(): void
    {
        $this->form->code = FormattedCodeHelper::getNextFormattedCode(Bank::class, 'SGA', 5);
    }


    #[On('BankClosePage')]
    public function handleClosePage(): void
    {
        $this->redirect('/', navigate: true);
    }

    #[On('BankNew')]
    public function handleNew(): void
    {
        if ($this->selectedId) {
            $this->selectedId = null;
            $this->form->clearData();
            $this->generateCode();
            $this->dispatch('bankNotification', ['message' => 'Form reset for new user.', 'type' => 'info']);
            $this->redirect('/banks', navigate: true);
        } else {
            $this->generateCode();
        }

        sleep(1);
        Flux::modal('loadingPage')->close();
    }

    public function reloadPage(): void
    {
        $this->dispatch('reload-page');
        $this->redirect('/banks', navigate: true);
    }

    #[On('BankCreate')]
    public function handleCreate(): void
    {
        if ($this->selectedId) {
            Flux::toast('Creation of a new Bank is not allowed while an existing Bank is selected. Please click on New Item button before proceeding.', 'Error', 10000,variant: 'danger',position:"top right");
            Log::info("Unable to create a new Bank because an existing Bank is currently selected. Selected Bank ID: {$this->selectedId}.");
            $this->dispatch('bankNotification', [
                'message' => 'Creation of a new Bank is not allowed while an existing Bank is selected. Please deselect the current Bank before proceeding.',
                'type' => 'error'
            ]);
            return;

        }
        $result = $this->form->storeData();
        if ($result['success']) {

            $this->dispatch('bankNotification', ['message' => $result['message'], 'type' => 'success']);
            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->search = null;
            $this->generateCode();

        } else {

            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->dispatch('bankNotification', ['message' => $result['message'], 'type' => 'error']);
            return;
        }
    }

    #[On('BankSave')]
    public function handleSave(): void
    {
        if (!$this->selectedId) {
            Log::info('Cannot save Bank because no Bank is currently selected.');

            Flux::toast(
                'Cannot update Bank because no Bank is selected. Please select a Bank from the list before attempting to update.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('bankNotification', [
                'message' => 'No Bank selected to save. Please select one before proceeding.',
                'type' => 'error'
            ]);


            sleep(1);
            Flux::modal('loadingPage')->close();
            return;
        }

        $result = $this->form->updateData();
        if ($result['success']) {
            $this->form->clearData(); // Clear form data on success
            $this->dispatch('bankNotification', ['message' => $result['message'], 'type' => 'success']);
            $this->redirect('/banks', navigate: true);
        } else {
            $this->dispatch('bankNotification', ['message' => $result['message'], 'type' => 'error']);
        }
    }

    #[On('BankDelete')]
    public function handleDelete(): void
    {

        if (!$this->selectedId) {
            Log::info('Cannot delete Bank because no Bank is currently selected.');

            Flux::toast(
                'Cannot delete Bank because no Bank is selected. Please select a Bank from the list before attempting to delete.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('bankNotification', ['message' => 'No user selected to delete.', 'type' => 'error']);

            sleep(2);
            Flux::modal('loadingPage')->close();
            return;
        }
        sleep(2);
        Flux::modal('loadingPage')->close();
        Flux::modal('DeleteConfirm')->show();

    }

    public function deleteBank(): void
    {
        try{
            Flux::modal('loadingPage')->show();
            $user = Bank::find($this->selectedId);
            $user->delete();
            $this->dispatch('bankNotification', ['message' => 'Bank deleted successfully', 'type' => 'success']);
            $this->reloadPage();
        }
        catch (Exception $e) {
            $this->dispatch('bankNotification', ['message' => 'Error deleting Bank: ' . $e->getMessage(), 'type' => 'error']);
        }
        finally {
            Flux::modal('loadingPage')->close();
        }

    }



    #[On('BankCancel')]
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

