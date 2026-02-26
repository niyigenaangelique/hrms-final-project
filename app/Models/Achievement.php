<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
use App\Helpers\FormattedCodeHelper;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Achievement extends Model
{
    use HasUuids, SoftDeletes, Notifiable;

    protected $fillable = [
        'code',
        'employee_id',
        'title',
        'description',
        'achieved_date',
        'type',
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
            'achieved_date' => 'date',
            'is_locked' => 'boolean',
            'approval_status' => ApprovalStatus::class,
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Achievement $achievement) {
            if (is_null($achievement->code)) {
                $achievement->code = FormattedCodeHelper::getNextFormattedCode(Achievement::class, 'ACH', 5);
            }
        });
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

    public function locker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by');
    }

    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
