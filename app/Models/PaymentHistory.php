<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
use App\Enum\PaymentStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class PaymentHistory
 *
 * @property string $id
 * @property string $code
 * @property string $payroll_entry_id
 * @property string $payslip_entry_id
 * @property string $employee_id
 * @property string $payment_method
 * @property string $transaction_reference
 * @property string $amount_paid
 * @property string $currency
 * @property Carbon|null $payment_date
 * @property string $bank_name
 * @property string $account_number
 * @property string $cheque_number
 * @property string $notes
 * @property PaymentStatus $status
 * @property string $created_by
 * @property string $updated_by
 * @property string $deleted_by
 * @property ApprovalStatus $approval_status
 *
 * @property Carbon|null $deleted_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property-read User|null $creator
 * @property-read User|null $updater
 * @property-read User|null $deleter
 * @property-read PayrollEntry $payrollEntry
 * @property-read PayslipEntry $payslipEntry
 * @property-read Employee $employee
 */

class PaymentHistory extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'payroll_entry_id',
        'payslip_entry_id',
        'employee_id',
        'payment_method',
        'transaction_reference',
        'amount_paid',
        'currency',
        'payment_date',
        'bank_name',
        'account_number',
        'cheque_number',
        'notes',
        'status',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'amount_paid' => 'decimal:2',
            'payment_date' => 'date',
            'status' => PaymentStatus::class,
            'approval_status' => ApprovalStatus::class,
        ];
    }

    public function payrollEntry(): BelongsTo
    {
        return $this->belongsTo(PayrollEntry::class);
    }

    public function payslipEntry(): BelongsTo
    {
        return $this->belongsTo(PayslipEntry::class);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
