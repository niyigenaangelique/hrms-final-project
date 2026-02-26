<?php

namespace App\Livewire\PayrollMonth;

use App\Helpers\FormattedCodeHelper;
use App\Models\PayrollMonth;
use App\Livewire\Forms\PayrollMonthForm;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormView extends Component
{
    use WithFileUploads;
    public PayrollMonthForm $form;
    public ?string $selectedId = null;
    public bool $idNullWarningModal = false;

    #[On('payrollMonth-selected')]
    public function handleSelected(array $data = []): void
    {
        $this->selectedId = $data['id'] ?? null;
        if ($payrollMonth = PayrollMonth::find($this->selectedId)) {
            $this->form->setData($payrollMonth);
            Log::info("PayrollMonth selected with ID: {$this->selectedId}");
        } else {
            Log::warning("PayrollMonth not found for ID: {$this->selectedId}");
            $this->dispatch('payroll_monthNotification', ['message' => 'Selected PayrollMonth not found.', 'type' => 'error']);
        }
    }
    public function render():object
    {
        return view('livewire.payroll-month.form-view',
        []
        );
    }
    public function mount(?string $id = null): void
    {
        $this->generateCode();
        if ($id && $payrollMonth = PayrollMonth::find($id)) {
            $this->selectedId = $id;
            $this->form->setData($payrollMonth);
        }
    }

    protected function generateCode(): void
    {
        $this->form->code = FormattedCodeHelper::getNextFormattedCode(PayrollMonth::class, 'SGA', 5);
    }


    #[On('PayrollMonthClosePage')]
    public function handleClosePage(): void
    {
        $this->redirect('/', navigate: true);
    }

    #[On('PayrollMonthNew')]
    public function handleNew(): void
    {
        if ($this->selectedId) {
            $this->selectedId = null;
            $this->form->clearData();
            $this->generateCode();
            $this->dispatch('payroll_monthNotification', ['message' => 'Form reset for new user.', 'type' => 'info']);
            $this->redirect('/payrollMonths', navigate: true);
        } else {
            $this->generateCode();
        }

        sleep(1);
        Flux::modal('loadingPage')->close();
    }

    public function reloadPage(): void
    {
        $this->dispatch('reload-page');
        $this->redirect('/payrollMonths', navigate: true);
    }

    #[On('PayrollMonthCreate')]
    public function handleCreate(): void
    {
        if ($this->selectedId) {
            Flux::toast('Creation of a new PayrollMonth is not allowed while an existing PayrollMonth is selected. Please click on New Item button before proceeding.', 'Error', 10000,variant: 'danger',position:"top right");
            Log::info("Unable to create a new PayrollMonth because an existing PayrollMonth is currently selected. Selected PayrollMonth ID: {$this->selectedId}.");
            $this->dispatch('payroll_monthNotification', [
                'message' => 'Creation of a new PayrollMonth is not allowed while an existing PayrollMonth is selected. Please deselect the current PayrollMonth before proceeding.',
                'type' => 'error'
            ]);
            return;

        }
        $result = $this->form->storeData();
        if ($result['success']) {

            $this->dispatch('payroll_monthNotification', ['message' => $result['message'], 'type' => 'success']);
            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->search = null;
            $this->generateCode();

        } else {

            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->dispatch('payroll_monthNotification', ['message' => $result['message'], 'type' => 'error']);
            return;
        }
    }

    #[On('PayrollMonthSave')]
    public function handleSave(): void
    {
        if (!$this->selectedId) {
            Log::info('Cannot save PayrollMonth because no PayrollMonth is currently selected.');

            Flux::toast(
                'Cannot update PayrollMonth because no PayrollMonth is selected. Please select a PayrollMonth from the list before attempting to update.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('payroll_monthNotification', [
                'message' => 'No PayrollMonth selected to save. Please select one before proceeding.',
                'type' => 'error'
            ]);


            sleep(1);
            Flux::modal('loadingPage')->close();
            return;
        }

        $result = $this->form->updateData();
        if ($result['success']) {
            $this->form->clearData(); // Clear form data on success
            $this->dispatch('payroll_monthNotification', ['message' => $result['message'], 'type' => 'success']);
            $this->redirect('/payrollMonths', navigate: true);
        } else {
            $this->dispatch('payroll_monthNotification', ['message' => $result['message'], 'type' => 'error']);
        }
    }

    #[On('PayrollMonthDelete')]
    public function handleDelete(): void
    {

        if (!$this->selectedId) {
            Log::info('Cannot delete PayrollMonth because no PayrollMonth is currently selected.');

            Flux::toast(
                'Cannot delete PayrollMonth because no PayrollMonth is selected. Please select a PayrollMonth from the list before attempting to delete.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('payroll_monthNotification', ['message' => 'No user selected to delete.', 'type' => 'error']);

            sleep(2);
            Flux::modal('loadingPage')->close();
            return;
        }
        sleep(2);
        Flux::modal('loadingPage')->close();
        Flux::modal('DeleteConfirm')->show();

    }

    public function deletePayrollMonth(): void
    {
        try{
            Flux::modal('loadingPage')->show();
            $user = PayrollMonth::find($this->selectedId);
            $user->delete();
            $this->dispatch('payroll_monthNotification', ['message' => 'PayrollMonth deleted successfully', 'type' => 'success']);
            $this->reloadPage();
        }
        catch (Exception $e) {
            $this->dispatch('payroll_monthNotification', ['message' => 'Error deleting PayrollMonth: ' . $e->getMessage(), 'type' => 'error']);
        }
        finally {
            Flux::modal('loadingPage')->close();
        }

    }



    #[On('PayrollMonthCancel')]
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

