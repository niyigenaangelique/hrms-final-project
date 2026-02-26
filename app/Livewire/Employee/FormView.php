<?php

namespace App\Livewire\Employee;

use App\Helpers\FormattedCodeHelper;
use App\Models\Employee;
use App\Livewire\Forms\EmployeeForm;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormView extends Component
{
    use WithFileUploads;
    public EmployeeForm $form;
    public ?string $selectedId = null;
    public bool $idNullWarningModal = false;

    #[On('employee-selected')]
    public function handleSelected(array $data = []): void
    {
        $this->selectedId = $data['id'] ?? null;
        if ($employee = Employee::find($this->selectedId)) {
            $this->form->setData($employee);
            Log::info("Employee selected with ID: {$this->selectedId}");
        } else {
            Log::warning("Employee not found for ID: {$this->selectedId}");
            $this->dispatch('employeeNotification', ['message' => 'Selected Employee not found.', 'type' => 'error']);
        }
    }
    public function render():object
    {
        return view('livewire.employee.form-view', [
            'banks' => \App\Models\Bank::orderBy('name')->get(),
        ]);
    }
    public function mount(?string $id = null): void
    {
        $this->generateCode();
        if ($id && $employee = Employee::find($id)) {
            $this->selectedId = $id;
            $this->form->setData($employee);
        }
    }

    protected function generateCode(): void
    {
        $this->form->code = FormattedCodeHelper::getNextFormattedCode(Employee::class, 'SGA', 5);
    }


    #[On('EmployeeClosePage')]
    public function handleClosePage(): void
    {
        $this->redirect('/', navigate: true);
    }

    #[On('EmployeeNew')]
    public function handleNew(): void
    {
        if ($this->selectedId) {
            $this->selectedId = null;
            $this->form->clearData();
            $this->generateCode();
            $this->dispatch('employeeNotification', ['message' => 'Form reset for new user.', 'type' => 'info']);
            $this->redirect('/employees', navigate: true);
        } else {
            $this->generateCode();
        }

        sleep(1);
        Flux::modal('loadingPage')->close();
    }

    public function reloadPage(): void
    {
        $this->dispatch('reload-page');
        $this->redirect('/employees', navigate: true);
    }

    #[On('EmployeeCreate')]
    public function handleCreate(): void
    {
        if ($this->selectedId) {
            Flux::toast('Creation of a new Employee is not allowed while an existing Employee is selected. Please click on New Item button before proceeding.', 'Error', 10000,variant: 'danger',position:"top right");
            Log::info("Unable to create a new Employee because an existing Employee is currently selected. Selected Employee ID: {$this->selectedId}.");
            $this->dispatch('employeeNotification', [
                'message' => 'Creation of a new Employee is not allowed while an existing Employee is selected. Please deselect the current Employee before proceeding.',
                'type' => 'error'
            ]);
            return;

        }
        $result = $this->form->storeData();
        if ($result['success']) {

            $this->dispatch('employeeNotification', ['message' => $result['message'], 'type' => 'success']);
            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->search = null;
            $this->generateCode();

        } else {

            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->dispatch('employeeNotification', ['message' => $result['message'], 'type' => 'error']);
            return;
        }
    }

    #[On('EmployeeSave')]
    public function handleSave(): void
    {
        if (!$this->selectedId) {
            Log::info('Cannot save Employee because no Employee is currently selected.');

            Flux::toast(
                'Cannot update Employee because no Employee is selected. Please select a Employee from the list before attempting to update.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('employeeNotification', [
                'message' => 'No Employee selected to save. Please select one before proceeding.',
                'type' => 'error'
            ]);


            sleep(1);
            Flux::modal('loadingPage')->close();
            return;
        }

        $result = $this->form->updateData();
        if ($result['success']) {
            $this->form->clearData(); // Clear form data on success
            $this->dispatch('employeeNotification', ['message' => $result['message'], 'type' => 'success']);
            $this->redirect('/employees', navigate: true);
        } else {
            $this->dispatch('employeeNotification', ['message' => $result['message'], 'type' => 'error']);
        }
    }

    #[On('EmployeeDelete')]
    public function handleDelete(): void
    {

        if (!$this->selectedId) {
            Log::info('Cannot delete Employee because no Employee is currently selected.');

            Flux::toast(
                'Cannot delete Employee because no Employee is selected. Please select a Employee from the list before attempting to delete.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('employeeNotification', ['message' => 'No user selected to delete.', 'type' => 'error']);

            sleep(2);
            Flux::modal('loadingPage')->close();
            return;
        }
        sleep(2);
        Flux::modal('loadingPage')->close();
        Flux::modal('DeleteConfirm')->show();

    }

    public function deleteEmployee(): void
    {
        try{
            Flux::modal('loadingPage')->show();
            $user = Employee::find($this->selectedId);
            $user->delete();
            $this->dispatch('employeeNotification', ['message' => 'Employee deleted successfully', 'type' => 'success']);
            $this->reloadPage();
        }
        catch (Exception $e) {
            $this->dispatch('employeeNotification', ['message' => 'Error deleting Employee: ' . $e->getMessage(), 'type' => 'error']);
        }
        finally {
            Flux::modal('loadingPage')->close();
        }

    }



    #[On('EmployeeCancel')]
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

