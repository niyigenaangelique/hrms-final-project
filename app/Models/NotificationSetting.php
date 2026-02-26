<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;

/**
 * class NotificationSetting
 *
 * @property string $id
 * @property string $code
 * @property string $user_id
 * @property string $notification_type
 * @property bool $email_enabled
 * @property bool $sms_enabled
 * @property bool $push_enabled
 * @property bool $in_app_enabled
 * @property string $frequency
 * @property Carbon $last_sent_at
 * @property bool $is_active
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
 * @property-read User $user
 */

class NotificationSetting extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'user_id',
        'notification_type',
        'email_enabled',
        'sms_enabled',
        'push_enabled',
        'in_app_enabled',
        'frequency',
        'last_sent_at',
        'is_active',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'email_enabled' => 'boolean',
            'sms_enabled' => 'boolean',
            'push_enabled' => 'boolean',
            'in_app_enabled' => 'boolean',
            'last_sent_at' => 'datetime',
            'is_active' => 'boolean',
            'approval_status' => ApprovalStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
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

    public function shouldSend(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->frequency === 'never') {
            return false;
        }

        if ($this->frequency === 'immediate') {
            return true;
        }

        if ($this->last_sent_at === null) {
            return true;
        }

        return $this->isFrequencyReached();
    }

    private function isFrequencyReached(): bool
    {
        $now = now();
        $lastSent = $this->last_sent_at;

        switch ($this->frequency) {
            case 'daily':
                return $now->diffInDays($lastSent) >= 1;
            case 'weekly':
                return $now->diffInWeeks($lastSent) >= 1;
            case 'monthly':
                return $now->diffInMonths($lastSent) >= 1;
            case 'quarterly':
                return $now->diffInQuarters($lastSent) >= 1;
            case 'yearly':
                return $now->diffInYears($lastSent) >= 1;
            default:
                return false;
        }
    }

    public function updateLastSent(): void
    {
        $this->last_sent_at = now();
        $this->save();
    }

    public function getEnabledChannels(): array
    {
        $channels = [];
        
        if ($this->email_enabled) $channels[] = 'email';
        if ($this->sms_enabled) $channels[] = 'sms';
        if ($this->push_enabled) $channels[] = 'push';
        if ($this->in_app_enabled) $channels[] = 'in_app';
        
        return $channels;
    }
}
