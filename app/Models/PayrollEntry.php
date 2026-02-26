<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
use App\Enum\AttendanceStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 *
 * Class PayrollEntry
 *
 * @property string $id
 * @property string $code
 * @property string $payroll_month_id
 * @property string $employee_id
 *
 * @property string $daily_rate
 * @property string $work_days
 * @property string $work_days_pay
 *
 * @property string $overtime_hour_rate
 * @property string $overtime_hours_worked
 * @property string $overtime_total_amount
 *
 * @property string $total_amount
 * @property AttendanceStatus|null $status
 *
 * @property string $is_locked *
 * @property string $created_by
 * @property string $updated_by
 * @property string $locked_by
 * @property string $deleted_by
 * @property ApprovalStatus $approval_status
 *
 * @property-read Collection|Comment[] $comments
 * @property-read Collection|Note[] $notes
 *
 * @property Carbon|null $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read User|null $locker
 * @property-read User|null $deleter
 *
 * @method static updateOrCreate(array $attributes, array $values)
 * @method static create(array $attributes)
 * @method static update(array $attributes)
 * @method static where(string $column, $value)
 * @method static latest(string $column = 'created_at')
 * @method static find($id)
 *
 */

class PayrollEntry extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'payroll_month_id',
        'employee_id',

        'daily_rate',
        'work_days',
        'work_days_pay',

        'overtime_hour_rate',
        'overtime_hours_worked',
        'overtime_total_amount',

        'total_amount',

        'status',
        'approval_status',
        'is_locked',

        'locked_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'daily_rate' => 'decimal:2',
            'work_days' => 'decimal:2',
            'work_days_pay' => 'decimal:2',
            'overtime_hour_rate' => 'decimal:2',
            'overtime_hours_worked' => 'decimal:2',
            'overtime_total_amount' => 'decimal:2',
            'total_amount' => 'decimal:2',

            'is_locked' => 'boolean',
            'status' => AttendanceStatus::class,
            'approval_status' => ApprovalStatus::class,
        ];
    }

    protected $hidden = [

    ];

    // Relationships
    public function payrollMonth(): BelongsTo
    {
        return $this->belongsTo(PayrollMonth::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function payslipEntry(): HasOne
    {
        return $this->hasOne(PayslipEntry::class);
    }

    public function deductionEntries(): HasMany
    {
        return $this->hasMany(DeductionEntry::class);
    }

    public function benefitEntries(): HasMany
    {
        return $this->hasMany(BenefitEntry::class);
    }

    public function paymentHistories(): HasMany
    {
        return $this->hasMany(PaymentHistory::class);
    }


    /**
     * Notes associated with this record as a notable entity.
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
    }

    /**
     * Comments associated with this record as a commentable entity.
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * Relationships
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function locker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by');
    }
    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

}
