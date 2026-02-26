<?php

namespace App\Livewire\PayslipEntry;

use App\Helpers\FormattedCodeHelper;
use App\Models\PayslipEntry;
use App\Livewire\Forms\PayslipEntryForm;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormView extends Component
{
    use WithFileUploads;
    public PayslipEntryForm $form;
    public ?string $selectedId = null;
    public bool $idNullWarningModal = false;

    #[On('payslipEntry-selected')]
    public function handleSelected(array $data = []): void
    {
        $this->selectedId = $data['id'] ?? null;
        if ($payslipEntry = PayslipEntry::find($this->selectedId)) {
            $this->form->setData($payslipEntry);
            Log::info("PayslipEntry selected with ID: {$this->selectedId}");
        } else {
            Log::warning("PayslipEntry not found for ID: {$this->selectedId}");
            $this->dispatch('payslip_entryNotification', ['message' => 'Selected PayslipEntry not found.', 'type' => 'error']);
        }
    }
    public function render():object
    {
        return view('livewire.payslip-entry.form-view',
        []
        );
    }
    public function mount(?string $id = null): void
    {
        $this->generateCode();
        if ($id && $payslipEntry = PayslipEntry::find($id)) {
            $this->selectedId = $id;
            $this->form->setData($payslipEntry);
        }
    }

    protected function generateCode(): void
    {
        $this->form->code = FormattedCodeHelper::getNextFormattedCode(PayslipEntry::class, 'SGA', 5);
    }


    #[On('PayslipEntryClosePage')]
    public function handleClosePage(): void
    {
        $this->redirect('/', navigate: true);
    }

    #[On('PayslipEntryNew')]
    public function handleNew(): void
    {
        if ($this->selectedId) {
            $this->selectedId = null;
            $this->form->clearData();
            $this->generateCode();
            $this->dispatch('payslip_entryNotification', ['message' => 'Form reset for new user.', 'type' => 'info']);
            $this->redirect('/payslipEntries', navigate: true);
        } else {
            $this->generateCode();
        }

        sleep(1);
        Flux::modal('loadingPage')->close();
    }

    public function reloadPage(): void
    {
        $this->dispatch('reload-page');
        $this->redirect('/payslipEntries', navigate: true);
    }

    #[On('PayslipEntryCreate')]
    public function handleCreate(): void
    {
        if ($this->selectedId) {
            Flux::toast('Creation of a new PayslipEntry is not allowed while an existing PayslipEntry is selected. Please click on New Item button before proceeding.', 'Error', 10000,variant: 'danger',position:"top right");
            Log::info("Unable to create a new PayslipEntry because an existing PayslipEntry is currently selected. Selected PayslipEntry ID: {$this->selectedId}.");
            $this->dispatch('payslip_entryNotification', [
                'message' => 'Creation of a new PayslipEntry is not allowed while an existing PayslipEntry is selected. Please deselect the current PayslipEntry before proceeding.',
                'type' => 'error'
            ]);
            return;

        }
        $result = $this->form->storeData();
        if ($result['success']) {

            $this->dispatch('payslip_entryNotification', ['message' => $result['message'], 'type' => 'success']);
            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->search = null;
            $this->generateCode();

        } else {

            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->dispatch('payslip_entryNotification', ['message' => $result['message'], 'type' => 'error']);
            return;
        }
    }

    #[On('PayslipEntrySave')]
    public function handleSave(): void
    {
        if (!$this->selectedId) {
            Log::info('Cannot save PayslipEntry because no PayslipEntry is currently selected.');

            Flux::toast(
                'Cannot update PayslipEntry because no PayslipEntry is selected. Please select a PayslipEntry from the list before attempting to update.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('payslip_entryNotification', [
                'message' => 'No PayslipEntry selected to save. Please select one before proceeding.',
                'type' => 'error'
            ]);


            sleep(1);
            Flux::modal('loadingPage')->close();
            return;
        }

        $result = $this->form->updateData();
        if ($result['success']) {
            $this->form->clearData(); // Clear form data on success
            $this->dispatch('payslip_entryNotification', ['message' => $result['message'], 'type' => 'success']);
            $this->redirect('/payslipEntries', navigate: true);
        } else {
            $this->dispatch('payslip_entryNotification', ['message' => $result['message'], 'type' => 'error']);
        }
    }

    #[On('PayslipEntryDelete')]
    public function handleDelete(): void
    {

        if (!$this->selectedId) {
            Log::info('Cannot delete PayslipEntry because no PayslipEntry is currently selected.');

            Flux::toast(
                'Cannot delete PayslipEntry because no PayslipEntry is selected. Please select a PayslipEntry from the list before attempting to delete.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('payslip_entryNotification', ['message' => 'No user selected to delete.', 'type' => 'error']);

            sleep(2);
            Flux::modal('loadingPage')->close();
            return;
        }
        sleep(2);
        Flux::modal('loadingPage')->close();
        Flux::modal('DeleteConfirm')->show();

    }

    public function deletePayslipEntry(): void
    {
        try{
            Flux::modal('loadingPage')->show();
            $user = PayslipEntry::find($this->selectedId);
            $user->delete();
            $this->dispatch('payslip_entryNotification', ['message' => 'PayslipEntry deleted successfully', 'type' => 'success']);
            $this->reloadPage();
        }
        catch (Exception $e) {
            $this->dispatch('payslip_entryNotification', ['message' => 'Error deleting PayslipEntry: ' . $e->getMessage(), 'type' => 'error']);
        }
        finally {
            Flux::modal('loadingPage')->close();
        }

    }



    #[On('PayslipEntryCancel')]
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

