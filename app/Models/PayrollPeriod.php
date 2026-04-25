<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class PayrollPeriod extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name', 'start_date', 'end_date', 'working_days', 'status',
        'total_gross_pay', 'total_net_pay', 'total_deductions', 'total_employer_rssb',
        'notes', 'is_locked', 'created_by', 'approved_by', 'locked_by',
        'approved_at', 'locked_at',
    ];

    protected $casts = [
        'start_date'          => 'date',
        'end_date'            => 'date',
        'is_locked'           => 'boolean',
        'approved_at'         => 'datetime',
        'locked_at'           => 'datetime',
        'total_gross_pay'     => 'decimal:2',
        'total_net_pay'       => 'decimal:2',
        'total_deductions'    => 'decimal:2',
        'total_employer_rssb' => 'decimal:2',
    ];

    /** The new automated computation entries */
    public function computationEntries(): HasMany
    {
        return $this->hasMany(PayrollComputationEntry::class, 'payroll_period_id');
    }

    /** Legacy relation kept for backward compat */
    public function payrollEntries(): HasMany
    {
        return $this->hasMany(PayrollEntry::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function locker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by');
    }

    public function isLocked(): bool
    {
        return $this->is_locked || $this->status === 'locked';
    }

    /**
     * Count working days between start and end.
     * Rwanda Labour Law Article 91 — excludes weekends & gazetted holidays.
     */
    public static function countWorkingDays(Carbon $start, Carbon $end): int
    {
        $days = 0;
        $current = $start->copy();
        $holidays = Holiday::whereYear('date', $start->year)
            ->orWhere('is_recurring', true)
            ->get();

        while ($current->lte($end)) {
            if ($current->isWeekday()) {
                $isHoliday = $holidays->contains(function ($h) use ($current) {
                    return $h->is_recurring
                        ? ($h->date->month === $current->month && $h->date->day === $current->day)
                        : $h->date->format('Y-m-d') === $current->format('Y-m-d');
                });
                if (!$isHoliday) $days++;
            }
            $current->addDay();
        }
        return $days;
    }

    // ── Formatted accessors ───────────────────────────────────────────────
    public function getFormattedTotalGrossPayAttribute(): string
    {
        return number_format($this->total_gross_pay, 0) . ' RWF';
    }

    public function getFormattedTotalNetPayAttribute(): string
    {
        return number_format($this->total_net_pay, 0) . ' RWF';
    }

    public function getFormattedTotalDeductionsAttribute(): string
    {
        return number_format($this->total_deductions, 0) . ' RWF';
    }
}
