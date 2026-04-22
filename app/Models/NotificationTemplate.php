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
    protected $fillable = ['name','type','channel','subject','body','is_active'];
    protected $casts    = ['is_active' => 'boolean'];
}