<?php

namespace App\Livewire\Admin;

use App\Models\SystemSetting;
use App\Models\TaxBracket;
use App\Models\Holiday;
use Livewire\Component;
use Livewire\WithPagination;

class SystemConfigurationManagement extends Component
{
    use WithPagination;

    public $activeTab = 'company_info';

    // ── Company Info Form ─────────────────────────────
    public $company_name = '';
    public $company_email = '';
    public $company_phone = '';
    public $company_address = '';
    
    // ── Payroll & Statutory Settings ──────────────────
    public $rssb_employer_rate = 5.0; // percentage
    public $rssb_employee_rate = 3.0; // percentage
    public $maternity_employer_rate = 0.3; // percentage
    
    // ── Working Days Settings ─────────────────────────
    public $work_monday = true;
    public $work_tuesday = true;
    public $work_wednesday = true;
    public $work_thursday = true;
    public $work_friday = true;
    public $work_saturday = false;
    public $work_sunday = false;

    // ── Modals & Actions ──────────────────────────────
    public $showTaxModal = false;
    public $editingTaxId = null;
    public $tax_min_income;
    public $tax_max_income;
    public $tax_rate;
    public $tax_fixed_amount;
    public $tax_is_active = true;

    public $showHolidayModal = false;
    public $editingHolidayId = null;
    public $holiday_name;
    public $holiday_date;
    public $holiday_is_recurring = false;
    
    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // Company Info
        $this->company_name = SystemSetting::getSetting('company_name', 'My Company');
        $this->company_email = SystemSetting::getSetting('company_email', '');
        $this->company_phone = SystemSetting::getSetting('company_phone', '');
        $this->company_address = SystemSetting::getSetting('company_address', '');
        
        // Payroll
        $this->rssb_employer_rate = SystemSetting::getSetting('rssb_employer_rate', 5.0);
        $this->rssb_employee_rate = SystemSetting::getSetting('rssb_employee_rate', 3.0);
        $this->maternity_employer_rate = SystemSetting::getSetting('maternity_employer_rate', 0.3);

        // Working Days
        $days = SystemSetting::getSetting('working_days', [
            'monday' => true, 'tuesday' => true, 'wednesday' => true,
            'thursday' => true, 'friday' => true, 'saturday' => false, 'sunday' => false
        ]);
        
        $this->work_monday = $days['monday'] ?? true;
        $this->work_tuesday = $days['tuesday'] ?? true;
        $this->work_wednesday = $days['wednesday'] ?? true;
        $this->work_thursday = $days['thursday'] ?? true;
        $this->work_friday = $days['friday'] ?? true;
        $this->work_saturday = $days['saturday'] ?? false;
        $this->work_sunday = $days['sunday'] ?? false;
    }

    public function saveSettings()
    {
        // Save Company Info
        SystemSetting::setSetting('company_name', $this->company_name, 'string', 'company');
        SystemSetting::setSetting('company_email', $this->company_email, 'string', 'company');
        SystemSetting::setSetting('company_phone', $this->company_phone, 'string', 'company');
        SystemSetting::setSetting('company_address', $this->company_address, 'string', 'company');
        
        // Save Payroll
        SystemSetting::setSetting('rssb_employer_rate', $this->rssb_employer_rate, 'string', 'payroll');
        SystemSetting::setSetting('rssb_employee_rate', $this->rssb_employee_rate, 'string', 'payroll');
        SystemSetting::setSetting('maternity_employer_rate', $this->maternity_employer_rate, 'string', 'payroll');

        // Save Working Days
        SystemSetting::setSetting('working_days', [
            'monday' => clone $this->work_monday, // Force boolean clone not strictly necessary, just mapping
            'monday' => (bool)$this->work_monday,
            'tuesday' => (bool)$this->work_tuesday,
            'wednesday' => (bool)$this->work_wednesday,
            'thursday' => (bool)$this->work_thursday,
            'friday' => (bool)$this->work_friday,
            'saturday' => (bool)$this->work_saturday,
            'sunday' => (bool)$this->work_sunday,
        ], 'json', 'general');

        session()->flash('success', 'System configuration saved successfully.');
    }

    // ── Tax Brackets ──────────────────────────────────────────────
    public function openTaxModal($id = null)
    {
        $this->resetTaxForm();
        if ($id) {
            $tax = TaxBracket::findOrFail($id);
            $this->editingTaxId = $tax->id;
            $this->tax_min_income = $tax->min_income;
            $this->tax_max_income = $tax->max_income;
            $this->tax_rate = $tax->rate;
            $this->tax_fixed_amount = $tax->fixed_amount;
            $this->tax_is_active = $tax->is_active;
        }
        $this->showTaxModal = true;
    }

    public function closeTaxModal()
    {
        $this->showTaxModal = false;
        $this->resetTaxForm();
    }

    private function resetTaxForm()
    {
        $this->editingTaxId = null;
        $this->tax_min_income = null;
        $this->tax_max_income = null;
        $this->tax_rate = null;
        $this->tax_fixed_amount = 0;
        $this->tax_is_active = true;
        $this->resetValidation();
    }

    public function saveTaxBracket()
    {
        try {
            $this->validate([
                'tax_min_income' => 'required|numeric|min:0',
                'tax_max_income' => 'nullable|numeric|min:0',
                'tax_rate' => 'required|numeric|min:0|max:100',
                'tax_fixed_amount' => 'required|numeric|min:0',
            ]);

            $data = [
                'min_income' => (float)$this->tax_min_income,
                'max_income' => $this->tax_max_income ? (float)$this->tax_max_income : null,
                'rate' => (float)$this->tax_rate,
                'fixed_amount' => (float)$this->tax_fixed_amount,
                'is_active' => (bool)$this->tax_is_active,
            ];

            if ($this->editingTaxId) {
                $bracket = TaxBracket::find($this->editingTaxId);
                if ($bracket) {
                    $bracket->update($data);
                    session()->flash('success', 'Tax bracket updated successfully.');
                } else {
                    session()->flash('error', 'Tax bracket not found.');
                }
            } else {
                TaxBracket::create($data);
                session()->flash('success', 'Tax bracket created successfully.');
            }

            $this->closeTaxModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Tax bracket save failed: ' . $e->getMessage());
            session()->flash('error', 'Critical Error: ' . $e->getMessage());
        }
    }

    public function deleteTaxBracket($id)
    {
        TaxBracket::findOrFail($id)->delete();
        session()->flash('success', 'Tax bracket deleted.');
    }

    // ── Public Holidays ───────────────────────────────────────────
    public function openHolidayModal($id = null)
    {
        $this->resetHolidayForm();
        if ($id) {
            $holiday = Holiday::findOrFail($id);
            $this->editingHolidayId = $holiday->id;
            $this->holiday_name = $holiday->name;
            $this->holiday_date = $holiday->date ? $holiday->date->format('Y-m-d') : null;
            $this->holiday_is_recurring = $holiday->is_recurring;
        }
        $this->showHolidayModal = true;
    }

    public function closeHolidayModal()
    {
        $this->showHolidayModal = false;
        $this->resetHolidayForm();
    }

    private function resetHolidayForm()
    {
        $this->editingHolidayId = null;
        $this->holiday_name = '';
        $this->holiday_date = '';
        $this->holiday_is_recurring = false;
        $this->resetValidation();
    }

    public function saveHoliday()
    {
        $this->validate([
            'holiday_name' => 'required|string|max:255',
            'holiday_date' => 'required|date',
        ]);

        $data = [
            'name' => $this->holiday_name,
            'date' => $this->holiday_date,
            'is_recurring' => $this->holiday_is_recurring,
            'code' => \Str::slug($this->holiday_name) . '-' . \Str::random(4),
        ];

        if ($this->editingHolidayId) {
            Holiday::findOrFail($this->editingHolidayId)->update($data);
            session()->flash('success', 'Holiday updated.');
        } else {
            Holiday::create($data);
            session()->flash('success', 'Holiday created.');
        }

        $this->closeHolidayModal();
    }

    public function deleteHoliday($id)
    {
        Holiday::findOrFail($id)->delete();
        session()->flash('success', 'Holiday deleted.');
    }

    public function render()
    {
        $taxBrackets = TaxBracket::orderBy('min_income', 'asc')->get();
        $holidays = Holiday::orderBy('date', 'desc')->get();

        return view('livewire.admin.system-configuration-management', [
            'taxBrackets' => $taxBrackets,
            'holidays' => $holidays,
        ])->layout('components.layouts.admin');
    }
}
