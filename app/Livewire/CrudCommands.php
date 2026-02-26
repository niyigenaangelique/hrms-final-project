<?php

namespace App\Livewire;

use Flux\Flux;
use Livewire\Component;

/*
 * @property  $modelType
 */
class CrudCommands extends Component
{
    public string $modelType;
    public array $invisibleButtons = [];
    public array $disabledButtons = [];

    public bool $showConfirmModal = false;

    /**
     * Dispatch a close page event.
     */
    public function dispatchClosePage(): void
    {
        $this->dispatch($this->modelType . 'ClosePage');
    }

    /**
     * Dispatch a new record event.
     */
    public function dispatchNew(): void
    {
        Flux::modal('loadingPage')->show();
        $this->dispatch($this->modelType . 'New');
    }

    /**
     * Dispatch a creation record event.
     */
    public function dispatchCreate(): void
    {
        Flux::modal('loadingPage')->show();
        $this->dispatch($this->modelType . 'Create');
    }

    /**
     * Dispatch a save record event.
     */
    public function dispatchSave(): void
    {
        Flux::modal('loadingPage')->show();
        $this->dispatch($this->modelType . 'Save');
    }

    /**
     * Dispatch a cancel action event.
     */
    public function dispatchCancel(): void
    {
        Flux::modal('loadingPage')->show();
        $this->dispatch($this->modelType . 'Cancel');
    }

    /**
     * Dispatch a delete record event.
     */
    public function dispatchDelete(): void
    {
        Flux::modal('loadingPage')->show();
        $this->showConfirmModal = true;
        $this->dispatch($this->modelType . 'Delete');
    }

    /**
     * Dispatch an export records event.
     */
    public function dispatchExport(): void
    {
        Flux::modal('loadingPage')->show();
        $this->dispatch($this->modelType . 'Export');
    }

    /**
     * Dispatch an import records event.
     */
    public function dispatchImport(): void
    {
        Flux::modal('loadingPage')->show();
        $this->dispatch($this->modelType . 'Import');
    }

    /**
     * Dispatch an authorization event.
     */
    public function dispatchAuthorization(): void
    {
        Flux::modal('loadingPage')->show();
        $this->dispatch($this->modelType . 'Authorization');
    }

    /**
     * Dispatch an authentication event.
     */
    public function dispatchAuthentication(): void
    {
        Flux::modal('loadingPage')->show();
        $this->dispatch($this->modelType . 'Authentication');
    }

    /**
     * Dispatch a print list event.
     */
    public function dispatchPrintList(): void
    {
        $this->dispatch($this->modelType . 'PrintList');
    }

    /**
     * Dispatch a bulk import event.
     */
    public function dispatchBulkImport(): void
    {
        $this->dispatch($this->modelType . 'BulkImport');
    }

    /**
     * Dispatch a bulk export event.
     */
    public function dispatchBulkExport(): void
    {
        $this->dispatch($this->modelType . 'BulkExport');
    }

    /**
     * Render the component's view.
     */
    public function render(): object
    {
        return view('livewire.crud-commands');
    }
}
