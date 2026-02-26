<?php

namespace App\Livewire\Forms;


use App\Models\Bank;
use DateTime;
use Exception;
use Flux\Flux;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Form;

class BankForm extends Form {

    public ?Bank $bank = null;
    public ?string $id = null;
    public ?string $code = null;
    public ?string $name = null;
    public ?string $city = 'Kigali';
    public ?string $country = 'Rwanda';
    public ?string $swift_code = null;

    protected array $fillableData = [
        'code',
        'name',
        'city',
        'country',
        'swift_code',
    ];

    /** @return array<string, array<int, string>> */
    public function rules(): array {
        return [
            'code' => ['required','string','max:255',Rule::unique('banks', 'code')->ignore($this->id),],
            'name' => ['required','string','max:255'],
            'city' => ['required','string','max:255'],
            'country' => ['required','string','max:255'],
            'swift_code' => ['nullable','string','max:255'],

        ];
    }

    /** @return array<string, string> */
    public function messages(): array {
        return [];
    }

    public function setData(Bank $bank): void {
        $this->bank = $bank;
        $this->id = $bank->id;
        $this->code = $bank->code;
        $this->name = $bank->name;
        $this->city = $bank->city;
        $this->country = $bank->country;
        $this->swift_code = $bank->swift_code;
    }

    protected array $backupData = [];

    public function backupFormData(): void {
        $this->backupData = $this->only($this->fillableData);
    }

    public function restoreFormData(): void {
        foreach ($this->backupData as $key => $value) {
            $this->$key = $value;
        }
    }

    public function storeData(): array {
        try {
            $this->validate();
            $excludeFields = [];
            $this->fillableData = array_diff($this->fillableData, $excludeFields);
            $this->fillableData = array_values($this->fillableData);

            $this->backupFormData(); // Backup before operation
            $bank = Bank::create($this->only($this->fillableData));

            $this->clearData();
            return [
                'success' => true,
                'bank' => $bank,
                'message' => 'Bank created successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Bank creation failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Failed to create bank: ' . $e->getMessage());
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'bank' => null,
                'message' => 'Failed to create bank: ' . $e->getMessage(),
            ];
        }
    }



    public function updateData(): array
    {
        try {
            $this->validate();
            $this->backupFormData(); // Backup before operation
            $excludeFields = [];
            $this->fillableData = array_diff($this->fillableData, $excludeFields);
            $this->fillableData = array_values($this->fillableData);
            $this->bank->update($this->only($this->fillableData));
            $this->clearData();
            return [
                'success' => true,
                'bank' => $this->bank,
                'message' => 'Bank updated successfully',
            ];
        } catch (ValidationException $e) {
            Flux::modal('loadingPage')->close();
            return $this->validate();
        } catch (Exception $e) {
            Log::error('Bank update failed: ' . $e->getMessage(), [
                'input' => $this->only($this->fillableData),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->restoreFormData(); // Restore on failure

            Flux::modal('loadingPage')->close();
            return [
                'success' => false,
                'errors' => [],
                'bank' => null,
                'message' => 'Failed to update bank: ' . $e->getMessage(),
            ];
        }
    }

    public function clearData(): void
    {
        $this->reset();
        $this->bank = null; // Ensure bank is reset
    }
}
