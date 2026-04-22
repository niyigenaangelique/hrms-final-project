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
    protected $fillable = ['key','value'];
    public static function get(string $key, $default = null): mixed {
        return static::where('key',$key)->value('value') ?? $default;
    }
}