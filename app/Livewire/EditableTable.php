<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Database\Eloquent\Model;
class EditableTable extends Component
{
    public $modelClass;
    public $items;
    public $columns;
    public $editableFields;
    public $validationRules;
    public $editingId = null;
    public $editingData = [];
    public $emptyRow = [];
    public $selectOptions = [];
    public function mount($modelClass, $columns, $editableFields, $validationRules)
    {
        $this->modelClass = $modelClass;
        $this->columns = $columns;
        $this->editableFields = $editableFields;
        $this->validationRules = $validationRules;
        $this->items = $modelClass::with('role')->get()->map(function ($item) {
            $data = $item->toArray();
            $data['role_id'] = $item->role->name ?? '';
            return $data;
        })->toArray();
        foreach ($editableFields as $field => $config) {
            if (is_array($config) && $config['type'] === 'select' && isset($config['source'])) {
                $source = $config['source'];
                $this->selectOptions[$field] = $source['model']::pluck($source['label'], $source['value'])->toArray();
            }
        }
        $this->addEmptyRow();
    }
    public function addEmptyRow()
    {
        $emptyRow = ['id' => 'new'];
        foreach ($this->editableFields as $field => $config) {
            $emptyRow[$field] = '';
        }
        $this->items[] = $emptyRow;
    }
    public function save($id, $index)
    {
        $data = $this->editingData[$id] ?? [];
        $rules = $this->validationRules;
        if ($id !== 'new') {
            $rules['editingData.' . $id . '.email'] = 'required|email|max:255|unique:users,email,' . $id;
        }
        $this->validate($rules, [], array_map(fn($field) => "editingData.{$id}.{$field}", array_keys($this->editableFields)));
        if ($id === 'new') {
            $this->modelClass::create($data);
        } else {
            $item = $this->modelClass::find($id);
            $item->update($data);
        }
        $this->editingData[$id] = [];
        $this->items = $this->modelClass::all()->toArray();
        $this->addEmptyRow();
    }
    public function updatedEditingData($value, $key)
    {
        [$id, $field] = explode('.', $key);
        if (!isset($this->editingData[$id])) {
            $this->editingData[$id] = [];
        }
        $this->editingData[$id][$field] = $value;
    }
    public function handleBlur($id, $index)
    {
        if ($this->editingData[$id] ?? false) {
            $this->save($id, $index);
        }
    }
    public function handleKeydown($id, $index)
    {
        if ($id === 'new' && $index === count($this->editableFields) - 1) {
            $this->save($id, $index);
        }
    }
    public function render()
    {
        return view('livewire.editable-table');
    }
}
