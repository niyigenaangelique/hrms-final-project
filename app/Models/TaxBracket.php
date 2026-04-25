<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TaxBracket extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'min_income',
        'max_income',
        'rate',
        'fixed_amount',
        'is_active',
    ];

    protected $casts = [
        'min_income' => 'decimal:2',
        'max_income' => 'decimal:2',
        'rate' => 'decimal:2',
        'fixed_amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFormattedRateAttribute()
    {
        return ($this->rate * 100) . '%';
    }

    public function getFormattedMinIncomeAttribute()
    {
        return number_format($this->min_income, 0) . ' RWF';
    }

    public function getFormattedMaxIncomeAttribute()
    {
        return $this->max_income ? number_format($this->max_income, 0) . ' RWF' : '∞';
    }

    public function getFormattedFixedAmountAttribute()
    {
        return number_format($this->fixed_amount, 0) . ' RWF';
    }
}
