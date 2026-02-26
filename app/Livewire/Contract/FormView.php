<?php

namespace App\Livewire\Contract;

use App\Enum\ApprovalStatus;
use App\Enum\ContractStatus;
use App\Enum\EmployeeCategory;
use App\Enum\RemunerationType;
use App\Helpers\FormattedCodeHelper;
use App\Models\Contract;
use App\Livewire\Forms\ContractForm;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Project;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormView extends Component
{
    use WithFileUploads;
    public ContractForm $form;
    public ?string $selectedId = null;
    public bool $idNullWarningModal = false;

    #[On('contract-selected')]
    public function handleSelected(array $data = []): void
    {
        $this->selectedId = $data['id'] ?? null;
        if ($contract = Contract::find($this->selectedId)) {
            $this->form->setData($contract);
            Log::info("Contract selected with ID: {$this->selectedId}");
        } else {
            Log::warning("Contract not found for ID: {$this->selectedId}");
            $this->dispatch('contractNotification', ['message' => 'Selected Contract not found.', 'type' => 'error']);
        }
    }
    public function render():object
    {
        return view('livewire.contract.form-view',
        [
            'remuneration_types' => RemunerationType::detailedList(),
            'employee_categories'=>EmployeeCategory::detailedList(),
            'contract_status'=>ContractStatus::detailedList(),
            'approval_status'=>ApprovalStatus::detailedList(),
            'employees' => Employee::all(),
            'positions' => Position::all(),
        ]
        );
    }


    public function mount(?string $id = null): void
    {
        $this->generateCode();
        if ($id && $contract = Contract::find($id)) {
            $this->selectedId = $id;
            $this->form->setData($contract);
        }
    }

    protected function generateCode(): void
    {
        $this->form->code = FormattedCodeHelper::getNextFormattedCode(Contract::class, 'SGA', 5);
    }


    #[On('ContractClosePage')]
    public function handleClosePage(): void
    {
        $this->redirect('/', navigate: true);
    }

    #[On('ContractNew')]
    public function handleNew(): void
    {
        if ($this->selectedId) {
            $this->selectedId = null;
            $this->form->clearData();
            $this->generateCode();
            $this->dispatch('contractNotification', ['message' => 'Form reset for new user.', 'type' => 'info']);
            $this->redirect('/contracts', navigate: true);
        } else {
            $this->generateCode();
        }

        sleep(1);
        Flux::modal('loadingPage')->close();
    }

    public function reloadPage(): void
    {
        $this->dispatch('reload-page');
        $this->redirect('/contracts', navigate: true);
    }

    #[On('ContractCreate')]
    public function handleCreate(): void
    {
        Log::info('FormView::handleCreate - Starting contract creation');
        
        if ($this->selectedId) {
            Log::warning("Unable to create a new Contract because an existing Contract is currently selected. Selected Contract ID: {$this->selectedId}.");
            Flux::toast('Creation of a new Contract is not allowed while an existing Contract is selected. Please click on New Item button before proceeding.', 'Error', 10000,variant: 'danger',position:"top right");
            $this->dispatch('contractNotification', [
                'message' => 'Creation of a new Contract is not allowed while an existing Contract is selected. Please deselect the current Contract before proceeding.',
                'type' => 'error'
            ]);
            return;
        }

        Log::info('FormView::handleCreate - Calling form->storeData()');
        $result = $this->form->storeData();
        
        Log::info('FormView::handleCreate - StoreData result:', $result);
        
        if ($result['success']) {
            Log::info('FormView::handleCreate - Contract created successfully');
            $this->dispatch('contractNotification', ['message' => $result['message'], 'type' => 'success']);
            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->search = null;
            $this->generateCode();

        } else {
            Log::error('FormView::handleCreate - Contract creation failed:', $result);
            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->dispatch('contractNotification', ['message' => $result['message'], 'type' => 'error']);
            return;
        }
    }

    #[On('ContractSave')]
    public function handleSave(): void
    {
        if (!$this->selectedId) {
            Log::info('Cannot save Contract because no Contract is currently selected.');

            Flux::toast(
                'Cannot update Contract because no Contract is selected. Please select a Contract from the list before attempting to update.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('contractNotification', [
                'message' => 'No Contract selected to save. Please select one before proceeding.',
                'type' => 'error'
            ]);


            sleep(1);
            Flux::modal('loadingPage')->close();
            return;
        }

        $result = $this->form->updateData();
        if ($result['success']) {
            $this->form->clearData(); // Clear form data on success
            $this->dispatch('contractNotification', ['message' => $result['message'], 'type' => 'success']);
            $this->redirect('/contracts', navigate: true);
        } else {
            $this->dispatch('contractNotification', ['message' => $result['message'], 'type' => 'error']);
        }
    }

    #[On('ContractDelete')]
    public function handleDelete(): void
    {

        if (!$this->selectedId) {
            Log::info('Cannot delete Contract because no Contract is currently selected.');

            Flux::toast(
                'Cannot delete Contract because no Contract is selected. Please select a Contract from the list before attempting to delete.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('contractNotification', ['message' => 'No user selected to delete.', 'type' => 'error']);

            sleep(2);
            Flux::modal('loadingPage')->close();
            return;
        }
        sleep(2);
        Flux::modal('loadingPage')->close();
        Flux::modal('DeleteConfirm')->show();

    }

    public function deleteContract(): void
    {
        try{
            Flux::modal('loadingPage')->show();
            $user = Contract::find($this->selectedId);
            $user->delete();
            $this->dispatch('contractNotification', ['message' => 'Contract deleted successfully', 'type' => 'success']);
            $this->reloadPage();
        }
        catch (Exception $e) {
            $this->dispatch('contractNotification', ['message' => 'Error deleting Contract: ' . $e->getMessage(), 'type' => 'error']);
        }
        finally {
            Flux::modal('loadingPage')->close();
        }

    }



    #[On('ContractCancel')]
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

