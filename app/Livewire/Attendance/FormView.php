<?php

namespace App\Livewire\Attendance;

use App\Helpers\FormattedCodeHelper;
use App\Models\Attendance;
use App\Livewire\Forms\AttendanceForm;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormView extends Component
{
    use WithFileUploads;
    public AttendanceForm $form;
    public ?string $selectedId = null;
    public bool $idNullWarningModal = false;

    #[On('attendance-selected')]
    public function handleSelected(array $data = []): void
    {
        $this->selectedId = $data['id'] ?? null;
        if ($attendance = Attendance::find($this->selectedId)) {
            $this->form->setData($attendance);
            Log::info("Attendance selected with ID: {$this->selectedId}");
        } else {
            Log::warning("Attendance not found for ID: {$this->selectedId}");
            $this->dispatch('attendanceNotification', ['message' => 'Selected Attendance not found.', 'type' => 'error']);
        }
    }
    public function render():object
    {
        return view('livewire.attendance.form-view',
        []
        );
    }
    public function mount(?string $id = null): void
    {
        $this->generateCode();
        if ($id && $attendance = Attendance::find($id)) {
            $this->selectedId = $id;
            $this->form->setData($attendance);
        }
    }

    protected function generateCode(): void
    {
        $this->form->code = FormattedCodeHelper::getNextFormattedCode(Attendance::class, 'SGA', 5);
    }


    #[On('AttendanceClosePage')]
    public function handleClosePage(): void
    {
        $this->redirect('/', navigate: true);
    }

    #[On('AttendanceNew')]
    public function handleNew(): void
    {
        if ($this->selectedId) {
            $this->selectedId = null;
            $this->form->clearData();
            $this->generateCode();
            $this->dispatch('attendanceNotification', ['message' => 'Form reset for new user.', 'type' => 'info']);
            $this->redirect('/attendances', navigate: true);
        } else {
            $this->generateCode();
        }

        sleep(1);
        Flux::modal('loadingPage')->close();
    }

    public function reloadPage(): void
    {
        $this->dispatch('reload-page');
        $this->redirect('/attendances', navigate: true);
    }

    #[On('AttendanceCreate')]
    public function handleCreate(): void
    {
        if ($this->selectedId) {
            Flux::toast('Creation of a new Attendance is not allowed while an existing Attendance is selected. Please click on New Item button before proceeding.', 'Error', 10000,variant: 'danger',position:"top right");
            Log::info("Unable to create a new Attendance because an existing Attendance is currently selected. Selected Attendance ID: {$this->selectedId}.");
            $this->dispatch('attendanceNotification', [
                'message' => 'Creation of a new Attendance is not allowed while an existing Attendance is selected. Please deselect the current Attendance before proceeding.',
                'type' => 'error'
            ]);
            return;

        }
        $result = $this->form->storeData();
        if ($result['success']) {

            $this->dispatch('attendanceNotification', ['message' => $result['message'], 'type' => 'success']);
            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->search = null;
            $this->generateCode();

        } else {

            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->dispatch('attendanceNotification', ['message' => $result['message'], 'type' => 'error']);
            return;
        }
    }

    #[On('AttendanceSave')]
    public function handleSave(): void
    {
        if (!$this->selectedId) {
            Log::info('Cannot save Attendance because no Attendance is currently selected.');

            Flux::toast(
                'Cannot update Attendance because no Attendance is selected. Please select a Attendance from the list before attempting to update.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('attendanceNotification', [
                'message' => 'No Attendance selected to save. Please select one before proceeding.',
                'type' => 'error'
            ]);


            sleep(1);
            Flux::modal('loadingPage')->close();
            return;
        }

        $result = $this->form->updateData();
        if ($result['success']) {
            $this->form->clearData(); // Clear form data on success
            $this->dispatch('attendanceNotification', ['message' => $result['message'], 'type' => 'success']);
            $this->redirect('/attendances', navigate: true);
        } else {
            $this->dispatch('attendanceNotification', ['message' => $result['message'], 'type' => 'error']);
        }
    }

    #[On('AttendanceDelete')]
    public function handleDelete(): void
    {

        if (!$this->selectedId) {
            Log::info('Cannot delete Attendance because no Attendance is currently selected.');

            Flux::toast(
                'Cannot delete Attendance because no Attendance is selected. Please select a Attendance from the list before attempting to delete.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('attendanceNotification', ['message' => 'No user selected to delete.', 'type' => 'error']);

            sleep(2);
            Flux::modal('loadingPage')->close();
            return;
        }
        sleep(2);
        Flux::modal('loadingPage')->close();
        Flux::modal('DeleteConfirm')->show();

    }

    public function deleteAttendance(): void
    {
        try{
            Flux::modal('loadingPage')->show();
            $user = Attendance::find($this->selectedId);
            $user->delete();
            $this->dispatch('attendanceNotification', ['message' => 'Attendance deleted successfully', 'type' => 'success']);
            $this->reloadPage();
        }
        catch (Exception $e) {
            $this->dispatch('attendanceNotification', ['message' => 'Error deleting Attendance: ' . $e->getMessage(), 'type' => 'error']);
        }
        finally {
            Flux::modal('loadingPage')->close();
        }

    }



    #[On('AttendanceCancel')]
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

