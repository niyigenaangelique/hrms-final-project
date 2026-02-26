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
 * Class NotificationTemplate
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $type
 * @property string $channel
 * @property string $subject
 * @property string $content
 * @property array $variables
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
 */

class NotificationTemplate extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'type',
        'channel',
        'subject',
        'content',
        'variables',
        'is_active',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
            'variables' => 'array',
            'is_active' => 'boolean',
            'approval_status' => ApprovalStatus::class,
        ];
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

    public function renderContent(array $data = []): string
    {
        $content = $this->content;
        $subject = $this->subject;

        foreach ($this->variables as $variable) {
            $placeholder = "{{" . $variable . "}}";
            $value = $data[$variable] ?? '';
            $content = str_replace($placeholder, $value, $content);
            $subject = str_replace($placeholder, $value, $subject);
        }

        return $content;
    }

    public function renderSubject(array $data = []): string
    {
        $subject = $this->subject;

        foreach ($this->variables as $variable) {
            $placeholder = "{{" . $variable . "}}";
            $value = $data[$variable] ?? '';
            $subject = str_replace($placeholder, $value, $subject);
        }

        return $subject;
    }
}
