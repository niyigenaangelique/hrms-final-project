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
 * Class NotificationLog
 *
 * @property string $id
 * @property string $code
 * @property string $notification_template_id
 * @property string $recipient_type
 * @property string $recipient_id
 * @property string $channel
 * @property string $subject
 * @property string $content
 * @property string $status
 * @property string $priority
 * @property Carbon $scheduled_at
 * @property Carbon $sent_at
 * @property string $delivery_status
 * @property string $error_message
 * @property array $metadata
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
 * @property-read NotificationTemplate $template
 * @property-read Model $recipient
 */

class NotificationLog extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'notification_template_id',
        'recipient_type',
        'recipient_id',
        'channel',
        'subject',
        'content',
        'status',
        'priority',
        'scheduled_at',
        'sent_at',
        'delivery_status',
        'error_message',
        'metadata',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'sent_at' => 'datetime',
            'metadata' => 'array',
            'approval_status' => ApprovalStatus::class,
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(NotificationTemplate::class);
    }

    public function getRecipientTypeAttribute($value)
    {
        // Handle cases where recipient_type might be stored as array or has incorrect format
        if (is_array($value)) {
            $value = $value[0] ?? $value;
        }
        
        // Handle JSON encoded values
        if (is_string($value) && str_starts_with($value, '[')) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $value = $decoded[0] ?? $value;
            }
        }
        
        // Ensure proper case
        return match(strtolower($value)) {
            'user' => 'User',
            'employee' => 'Employee',
            default => $value,
        };
    }

    public function getSafeRecipient()
    {
        try {
            $recipientType = $this->recipient_type;
            $recipientId = $this->recipient_id;
            
            // Handle cases where recipient_type might be stored as array or has incorrect format
            if (is_array($recipientType)) {
                $recipientType = $recipientType[0] ?? $recipientType;
            }
            
            // Handle JSON encoded values
            if (is_string($recipientType) && str_starts_with($recipientType, '[')) {
                $decoded = json_decode($recipientType, true);
                if (is_array($decoded)) {
                    $recipientType = $decoded[0] ?? $recipientType;
                }
            }
            
            // Normalize the type
            $recipientType = strtolower($recipientType);
            
            // Load the recipient manually based on type
            switch ($recipientType) {
                case 'user':
                    return \App\Models\User::find($recipientId);
                case 'employee':
                    return \App\Models\Employee::find($recipientId);
                default:
                    return null;
            }
        } catch (\Exception $e) {
            // Return null if there's an issue loading the recipient
            return null;
        }
    }

    public function recipient()
    {
        return $this->morphTo('recipient', [
            'user' => \App\Models\User::class,
            'employee' => \App\Models\Employee::class,
            'User' => \App\Models\User::class,
            'Employee' => \App\Models\Employee::class,
        ]);
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

    public function markAsSent(): void
    {
        $this->status = 'sent';
        $this->sent_at = now();
        $this->delivery_status = 'delivered';
        $this->save();
    }

    public function markAsFailed(string $errorMessage): void
    {
        $this->status = 'failed';
        $this->delivery_status = 'failed';
        $this->error_message = $errorMessage;
        $this->save();
    }

    public function markAsScheduled(Carbon $scheduledAt): void
    {
        $this->status = 'scheduled';
        $this->scheduled_at = $scheduledAt;
        $this->save();
    }

    public function isDelivered(): bool
    {
        return $this->delivery_status === 'delivered';
    }

    public function isFailed(): bool
    {
        return $this->delivery_status === 'failed';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }
}
