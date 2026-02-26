<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
 * Class Employee
 *
 * @property string $id
 * @property string $code
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $gender
 * @property Carbon|null $birth_date
 * @property string $nationality
 * @property string $national_id
 * @property string $passport_number
 * @property string $rss_number
 * @property Carbon|null $join_date
 * @property string $phone_number
 * @property string $email
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $country
 *
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

class Employee extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'employee_number',
        'first_name',
        'last_name',
        'middle_name',
        'gender',
        'birth_date',
        'nationality',
        'national_id',
        'passport_number',
        'rss_number',
        'join_date',
        'phone_number',
        'email',
        'basic_salary',
        'daily_rate',
        'hourly_rate',
        'salary_currency',
        'payment_method',
        'bank_name',
        'bank_account_number',
        'bank_branch',
        'mobile_money_provider',
        'mobile_money_number',
        'salary_effective_date',
        'is_taxable',
        'rssb_rate',
        'pension_rate',
        'address',
        'city',
        'state',
        'country',
        'profile_photo',
        'position_id',
        'department_id',
        'user_id',
        'is_active',
        'is_locked',
        'approval_status',
        'locked_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'datetime',
            'join_date' => 'datetime',
            'salary_effective_date' => 'datetime',
            'is_active' => 'boolean',
            'is_locked' => 'boolean',
            'is_taxable' => 'boolean',
            'approval_status' => ApprovalStatus::class,
            'basic_salary' => 'decimal:2',
            'daily_rate' => 'decimal:2',
            'hourly_rate' => 'decimal:2',
            'rssb_rate' => 'decimal:2',
            'pension_rate' => 'decimal:2',
        ];
    }

    protected $hidden = [

    ];

    /**
     * @param $query
     * @param string $code
     * @return Builder
     * usage:
     *  <pre>
     * Employee::code('emp-1')->first();
     *  </pre>
     */
    public function scopeCode($query, string $code): Builder
    {
        return $query->where('code', $code);
    }


    /**
     * Get the employee's full name, with middle name if available.
     *
     * Usage:
     * <pre>
     * $employee = Employee::factory()->create();
     * $employee->full_name; // "John Doe" or "John M Doe"
     * </pre>
     */

    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    /**
     * Get the user associated with the employee.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
    public function bankInfos(): HasMany
    {
        return $this->hasMany(BankInfo::class);
    }

    public function banks(): HasManyThrough
    {
        return $this->hasManyThrough(Bank::class, BankInfo::class);
    }

    public function positions(): HasManyThrough
    {
        return $this->hasManyThrough(Position::class, Contract::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function leaveBalances(): HasMany
    {
        return $this->hasMany(LeaveBalance::class);
    }

    public function payrollEntries(): HasMany
    {
        return $this->hasMany(PayrollEntry::class);
    }

    public function kpiTargets(): HasMany
    {
        return $this->hasMany(KPITarget::class);
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    public function managedGoals(): HasMany
    {
        return $this->hasMany(Goal::class, 'manager_id');
    }

    public function performanceReviews(): HasMany
    {
        return $this->hasMany(PerformanceReview::class, 'employee_id');
    }

    public function conductedReviews(): HasMany
    {
        return $this->hasMany(PerformanceReview::class, 'reviewer_id');
    }

    public function givenFeedback(): HasMany
    {
        return $this->hasMany(Feedback::class, 'giver_id');
    }

    public function receivedFeedback(): HasMany
    {
        return $this->hasMany(Feedback::class, 'receiver_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(EmergencyContact::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
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
     * Calculate daily rate from basic salary
     */
    public function calculateDailyRate(): float
    {
        if ($this->basic_salary) {
            return $this->basic_salary / 22; // Assuming 22 working days per month
        }
        return 0;
    }

    /**
     * Calculate hourly rate from daily rate
     */
    public function calculateHourlyRate(): float
    {
        if ($this->daily_rate) {
            return $this->daily_rate / 8; // 8 working hours per day
        }
        return 0;
    }

    /**
     * Set daily and hourly rates based on basic salary
     */
    public function setRatesFromBasicSalary(): void
    {
        if ($this->basic_salary) {
            $this->daily_rate = $this->calculateDailyRate();
            $this->hourly_rate = $this->calculateHourlyRate();
        }
    }

    /**
     * Get formatted basic salary
     */
    public function getFormattedBasicSalaryAttribute(): string
    {
        return number_format($this->basic_salary ?? 0, 2);
    }

    /**
     * Get payment details as array
     */
    public function getPaymentDetailsAttribute(): array
    {
        return [
            'method' => $this->payment_method,
            'bank_name' => $this->bank_name,
            'bank_account_number' => $this->bank_account_number,
            'bank_branch' => $this->bank_branch,
            'mobile_money_provider' => $this->mobile_money_provider,
            'mobile_money_number' => $this->mobile_money_number,
        ];
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
