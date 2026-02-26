<?php

namespace App\Livewire\Device;

use App\Helpers\FormattedCodeHelper;
use App\Models\Device;
use App\Livewire\Forms\DeviceForm;
use App\Models\Project;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormView extends Component
{
    use WithFileUploads;
    public DeviceForm $form;
    public ?string $selectedId = null;
    public bool $idNullWarningModal = false;

    #[On('device-selected')]
    public function handleSelected(array $data = []): void
    {
        $this->selectedId = $data['id'] ?? null;
        if ($device = Device::find($this->selectedId)) {
            $this->form->setData($device);
            Log::info("Device selected with ID: {$this->selectedId}");
        } else {
            Log::warning("Device not found for ID: {$this->selectedId}");
            $this->dispatch('deviceNotification', ['message' => 'Selected Device not found.', 'type' => 'error']);
        }
    }
    public function render():object
    {
        return view('livewire.device.form-view',
        [
            'projects' => Project::all(),
        ]
        );
    }
    public function mount(?string $id = null): void
    {
        $this->generateCode();
        if ($id && $device = Device::find($id)) {
            $this->selectedId = $id;
            $this->form->setData($device);
        }
    }

    protected function generateCode(): void
    {
        $this->form->code = FormattedCodeHelper::getNextFormattedCode(Device::class, 'SGA', 5);
    }


    #[On('DeviceClosePage')]
    public function handleClosePage(): void
    {
        $this->redirect('/', navigate: true);
    }

    #[On('DeviceNew')]
    public function handleNew(): void
    {
        if ($this->selectedId) {
            $this->selectedId = null;
            $this->form->clearData();
            $this->generateCode();
            $this->dispatch('deviceNotification', ['message' => 'Form reset for new user.', 'type' => 'info']);
            $this->redirect('/devices', navigate: true);
        } else {
            $this->generateCode();
        }

        sleep(1);
        Flux::modal('loadingPage')->close();
    }

    public function reloadPage(): void
    {
        $this->dispatch('reload-page');
        $this->redirect('/devices', navigate: true);
    }

    #[On('DeviceCreate')]
    public function handleCreate(): void
    {
        if ($this->selectedId) {
            Flux::toast('Creation of a new Device is not allowed while an existing Device is selected. Please click on New Item button before proceeding.', 'Error', 10000,variant: 'danger',position:"top right");
            Log::info("Unable to create a new Device because an existing Device is currently selected. Selected Device ID: {$this->selectedId}.");
            $this->dispatch('deviceNotification', [
                'message' => 'Creation of a new Device is not allowed while an existing Device is selected. Please deselect the current Device before proceeding.',
                'type' => 'error'
            ]);
            return;

        }
        $result = $this->form->storeData();
        if ($result['success']) {

            $this->dispatch('deviceNotification', ['message' => $result['message'], 'type' => 'success']);
            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->search = null;
            $this->generateCode();

        } else {

            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->dispatch('deviceNotification', ['message' => $result['message'], 'type' => 'error']);
            return;
        }
    }

    #[On('DeviceSave')]
    public function handleSave(): void
    {
        if (!$this->selectedId) {
            Log::info('Cannot save Device because no Device is currently selected.');

            Flux::toast(
                'Cannot update Device because no Device is selected. Please select a Device from the list before attempting to update.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('deviceNotification', [
                'message' => 'No Device selected to save. Please select one before proceeding.',
                'type' => 'error'
            ]);


            sleep(1);
            Flux::modal('loadingPage')->close();
            return;
        }

        $result = $this->form->updateData();
        if ($result['success']) {
            $this->form->clearData(); // Clear form data on success
            $this->dispatch('deviceNotification', ['message' => $result['message'], 'type' => 'success']);
            $this->redirect('/devices', navigate: true);
        } else {
            $this->dispatch('deviceNotification', ['message' => $result['message'], 'type' => 'error']);
        }
    }

    #[On('DeviceDelete')]
    public function handleDelete(): void
    {

        if (!$this->selectedId) {
            Log::info('Cannot delete Device because no Device is currently selected.');

            Flux::toast(
                'Cannot delete Device because no Device is selected. Please select a Device from the list before attempting to delete.',
                'Error',
                10000,
                variant: 'danger',
                position: 'top right'
            );

            $this->dispatch('deviceNotification', ['message' => 'No user selected to delete.', 'type' => 'error']);

            sleep(2);
            Flux::modal('loadingPage')->close();
            return;
        }
        sleep(2);
        Flux::modal('loadingPage')->close();
        Flux::modal('DeleteConfirm')->show();

    }

    public function deleteDevice(): void
    {
        try{
            Flux::modal('loadingPage')->show();
            $user = Device::find($this->selectedId);
            $user->delete();
            $this->dispatch('deviceNotification', ['message' => 'Device deleted successfully', 'type' => 'success']);
            $this->reloadPage();
        }
        catch (Exception $e) {
            $this->dispatch('deviceNotification', ['message' => 'Error deleting Device: ' . $e->getMessage(), 'type' => 'error']);
        }
        finally {
            Flux::modal('loadingPage')->close();
        }

    }



    #[On('DeviceCancel')]
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

