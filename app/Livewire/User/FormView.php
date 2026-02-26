<?php

namespace App\Livewire\User;

use App\Enum\RecordStatus;
use App\Enum\UserRole;
use App\Helpers\FormattedCodeHelper;
use App\Livewire\Forms\UserForm;
use App\Models\RecordStatusInTable;
use App\Models\User;
use Exception;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class FormView extends Component
{
    use WithFileUploads;
    public UserForm $form;
    public ?string $selectedId = null;
    public bool $idNullWarningModal = false;

    #[On('user-selected')]
    public function handleSelected(array $data = []): void
    {
        $this->selectedId = $data['id'] ?? null;
        if ($user = User::find($this->selectedId)) {
            $this->form->setData($user);
            Log::info("User selected with ID: {$this->selectedId}");
        } else {
            Log::warning("User not found for ID: {$this->selectedId}");
            $this->dispatch('userNotification', ['message' => 'Selected user not found.', 'type' => 'error']);
        }
    }

    public function render(): object
    {
        return view('livewire.user.form-view', [
            'userRoles' => UserRole::detailedList(),
        ]);
    }

    public function mount(?string $id = null): void
    {
        $this->generateCode();
        if ($id && $user = User::find($id)) {
            $this->selectedId = $id;
            $this->form->setData($user);
        }
    }

    protected function generateCode(): void
    {
        $this->form->code = FormattedCodeHelper::getNextFormattedCode(User::class, 'SGA', 5);
    }

    #[On('UserClosePage')]
    public function handleClosePage(): void
    {
        $this->redirect('/', navigate: true);
    }

    #[On('UserNew')]
    public function handleNew(): void
    {
        if ($this->selectedId) {
            $this->selectedId = null;
            $this->form->clearData();
            $this->generateCode();
            $this->dispatch('userNotification', ['message' => 'Form reset for new user.', 'type' => 'info']);
            $this->redirect('/users', navigate: true);
        } else {
            $this->generateCode();
        }

        sleep(1);
        Flux::modal('loadingPage')->close();
    }

    public function reloadPage(): void
    {
        $this->dispatch('reload-page');
        $this->redirect('/users', navigate: true);
    }

    #[On('UserCreate')]
    public function handleCreate(): void
    {
        if ($this->selectedId) {
            Log::info("Cannot create new user while user is selected: ID {$this->selectedId}");
            $this->dispatch('userNotification', ['message' => 'Cannot create new user while a user is selected.', 'type' => 'error']);
            return;
        }
        $result = $this->form->storeData();
        if ($result['success']) {

            $this->reloadPage();
            $this->selectedId = $result['user']->id; // Set new user as selected
            $this->search = null;
            $this->generateCode();
        } else {

            sleep(1);
            Flux::modal('loadingPage')->close();
            $this->dispatch('userNotification', ['message' => $result['message'], 'type' => 'error']);
            return;
        }
    }

    #[On('UserSave')]
    public function handleSave(): void
    {
        if (!$this->selectedId) {
            Log::info('Cannot save user while no user is selected');
            Flux::toast('Cannot update user while no user is selected. Please select a user from the list to update.', 'Error', 10000,variant: 'danger',position:"top right");
            $this->dispatch('userNotification', ['message' => 'No user selected to save.', 'type' => 'error']);

            sleep(1);
            Flux::modal('loadingPage')->close();
            return;
        }

        $result = $this->form->updateData();
        if ($result['success']) {
            $this->form->clearData(); // Clear form data on success
            $this->dispatch('userNotification', ['message' => $result['message'], 'type' => 'success']);
            $this->redirect('/users', navigate: true);
        } else {
            $this->dispatch('userNotification', ['message' => $result['message'], 'type' => 'error']);
        }
    }

    public function changePassword(): void
    {
        if (!$this->selectedId) {
            Log::info('Cannot change password while no user is selected');
            $this->dispatch('userNotification', ['message' => 'No user selected to change password.', 'type' => 'error']);
            $this->idNullWarningModal = true; // Show modal
            return;
        }

        $result = $this->form->changePassword();
        if ($result['success']) {
            $this->form->clearData(); // Clear form data on success
            $this->selectedId = null;
            $this->generateCode();
            $this->dispatch('userNotification', ['message' => $result['message'], 'type' => 'success']);
//            $this->redirect('/users', navigate: true);
        } else {
            $this->dispatch('userNotification', ['message' => $result['message'], 'type' => 'error']);
        }
    }
    #[On('UserDelete')]
    public function handleDelete(): void
    {

        if (!$this->selectedId) {
            Log::info('Cannot delete user while no user is selected');
            Flux::toast('Cannot delete user while no user is selected. Please select a user from the list to delete.', 'Error', 10000,variant: 'danger',position:"top right");
            $this->dispatch('userNotification', ['message' => 'No user selected to delete.', 'type' => 'error']);

            sleep(2);
            Flux::modal('loadingPage')->close();
            return;
        }
        sleep(2);
        Flux::modal('loadingPage')->close();
        Flux::modal('DeleteConfirm')->show();

    }

    public function deleteUser(): void
    {
        try{
            Flux::modal('loadingPage')->show();
            $user = User::find($this->selectedId);
            $user->delete();
            $this->dispatch('userNotification', ['message' => 'User deleted successfully', 'type' => 'success']);
            $this->reloadPage();
        }
        catch (Exception $e) {
            $this->dispatch('userNotification', ['message' => 'Error deleting user: ' . $e->getMessage(), 'type' => 'error']);
        }
        finally {
            Flux::modal('loadingPage')->close();
        }

    }



    #[On('UserCancel')]
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
