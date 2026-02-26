<?php

namespace App\Models;

use App\Enum\ApprovalStatus;
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
 * class SecuritySetting
 *
 * @property string $id
 * @property string $code
 * @property string $key
 * @property string $value
 * @property string $description
 * @property string $type
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

class SecuritySetting extends Model
{
    use HasApiTokens, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'key',
        'value',
        'description',
        'type',
        'is_active',
        'approval_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected function casts(): array
    {
        return [
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

    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)
            ->where('is_active', true)
            ->first();
        
        return $setting ? $setting->value : $default;
    }

    public static function setValue($key, $value, $description = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'code' => 'SEC-' . uniqid(),
                'value' => $value,
                'description' => $description,
                'type' => 'string',
                'is_active' => true,
                'approval_status' => ApprovalStatus::Initiated,
                'updated_by' => auth()->id(),
                'created_by' => auth()->id(),
            ]
        );
    }

    public static function getBoolean($key, $default = false)
    {
        $value = self::getValue($key, $default);
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public static function getInteger($key, $default = 0)
    {
        $value = self::getValue($key, $default);
        return (int) $value;
    }

    public static function getArray($key, $default = [])
    {
        $value = self::getValue($key, $default);
        return is_array($value) ? $value : json_decode($value, true) ?? $default;
    }

    public static function getSecuritySettings()
    {
        return self::where('is_active', true)
            ->get()
            ->pluck('value', 'key')
            ->toArray();
    }

    public static function getLoginSettings()
    {
        return [
            'max_login_attempts' => self::getInteger('max_login_attempts', 5),
            'lockout_duration' => self::getInteger('lockout_duration', 15), // minutes
            'password_min_length' => self::getInteger('password_min_length', 8),
            'password_require_uppercase' => self::getBoolean('password_require_uppercase', true),
            'password_require_lowercase' => self::getBoolean('password_require_lowercase', true),
            'password_require_numbers' => self::getBoolean('password_require_numbers', true),
            'password_require_symbols' => self::getBoolean('password_require_symbols', true),
            'session_timeout' => self::getInteger('session_timeout', 120), // minutes
            'enable_two_factor' => self::getBoolean('enable_two_factor', false),
        ];
    }

    public static function getPrivacySettings()
    {
        return [
            'data_retention_days' => self::getInteger('data_retention_days', 365),
            'log_retention_days' => self::getInteger('log_retention_days', 90),
            'enable_anonymous_usage' => self::getBoolean('enable_anonymous_usage', false),
            'enable_data_export' => self::getBoolean('enable_data_export', true),
            'enable_account_deletion' => self::getBoolean('enable_account_deletion', true),
            'cookie_consent_required' => self::getBoolean('cookie_consent_required', true),
        ];
    }

    public static function getMonitoringSettings()
    {
        return [
            'enable_failed_login_alerts' => self::getBoolean('enable_failed_login_alerts', true),
            'failed_login_threshold' => self::getInteger('failed_login_threshold', 3),
            'enable_suspicious_activity_alerts' => self::getBoolean('enable_suspicious_activity_alerts', true),
            'enable_admin_activity_logging' => self::getBoolean('enable_admin_activity_logging', true),
            'enable_api_logging' => self::getBoolean('enable_api_logging', true),
        ];
    }
}
