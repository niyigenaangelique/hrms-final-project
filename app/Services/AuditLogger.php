<?php
// ═══════════════════════════════════════════════════════════════════════════
// FILE 1 — app/Models/AuditLog.php
// ═══════════════════════════════════════════════════════════════════════════
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class AuditLog extends Model
{
    use HasUuids;

    protected $table = 'audit_logs';

    protected $fillable = [
        'causer_type',
        'causer_id',
        'event',
        'subject_type',
        'subject_id',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    // ── Relationships ────────────────────────────────────────
    public function causer()
    {
        return $this->morphTo();
    }

    public function subject()
    {
        return $this->morphTo();
    }

    // ── Scopes ───────────────────────────────────────────────
    public function scopeForEvent($query, string $event)
    {
        return $query->where('event', $event);
    }

    public function scopeByUser($query, string $userId)
    {
        return $query->where('causer_id', $userId);
    }

    public function scopeForSubject($query, string $type, string $id)
    {
        return $query->where('subject_type', $type)->where('subject_id', $id);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // ── Helpers ──────────────────────────────────────────────
    public function getEventColorAttribute(): string
    {
        return match(true) {
            str_contains($this->event, 'create') => 'green',
            str_contains($this->event, 'update') => 'blue',
            str_contains($this->event, 'delete') => 'red',
            str_contains($this->event, 'login')  => 'purple',
            str_contains($this->event, 'logout') => 'amber',
            default                              => 'gray',
        };
    }
}


// ═══════════════════════════════════════════════════════════════════════════
// FILE 2 — app/Services/AuditLogger.php
// Usage:  AuditLogger::log('create', 'Created payroll entry PE-00001', $subject, ['old'=>..,'new'=>..])
//         AuditLogger::login()
//         AuditLogger::logout()
// ═══════════════════════════════════════════════════════════════════════════
namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditLogger
{
    /**
     * Write a generic audit log entry.
     *
     * @param  string      $event       e.g. 'create', 'update', 'delete', 'login', 'custom'
     * @param  string      $description Human-readable sentence
     * @param  Model|null  $subject     The Eloquent model that was affected (optional)
     * @param  array       $properties  Extra data — old/new values, metadata, etc.
     */
    public static function log(
        string $event,
        string $description,
        ?Model $subject = null,
        array  $properties = []
    ): void {
        try {
            $user = Auth::user();

            AuditLog::create([
                'causer_type'  => $user ? get_class($user) : null,
                'causer_id'    => $user?->id,
                'event'        => $event,
                'subject_type' => $subject ? get_class($subject) : null,
                'subject_id'   => $subject?->getKey(),
                'description'  => $description,
                'properties'   => array_merge($properties, [
                    'ip'         => Request::ip(),
                    'user_agent' => substr(Request::userAgent() ?? '', 0, 255),
                ]),
                'ip_address'   => Request::ip(),
                'user_agent'   => substr(Request::userAgent() ?? '', 0, 500),
            ]);
        } catch (\Throwable) {
            // Never let audit logging crash the application
        }
    }

    /** Shortcut for login events */
    public static function login(?string $userId = null): void
    {
        $uid  = $userId ?? Auth::id();
        $user = $uid ? \App\Models\User::find($uid) : null;
        $name = $user ? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) : 'Unknown';

        static::log('login', "User \"{$name}\" logged in.", $user);
    }

    /** Shortcut for logout events */
    public static function logout(): void
    {
        $user = Auth::user();
        $name = $user ? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) : 'Unknown';

        static::log('logout', "User \"{$name}\" logged out.", $user);
    }

    /** Log a model creation */
    public static function created(Model $model, string $description = ''): void
    {
        $desc = $description ?: class_basename($model) . ' #' . $model->getKey() . ' created.';
        static::log('create', $desc, $model, ['new' => $model->getAttributes()]);
    }

    /** Log a model update */
    public static function updated(Model $model, array $oldValues = [], string $description = ''): void
    {
        $desc = $description ?: class_basename($model) . ' #' . $model->getKey() . ' updated.';
        static::log('update', $desc, $model, ['old' => $oldValues, 'new' => $model->getChanges()]);
    }

    /** Log a model deletion */
    public static function deleted(Model $model, string $description = ''): void
    {
        $desc = $description ?: class_basename($model) . ' #' . $model->getKey() . ' deleted.';
        static::log('delete', $desc, $model, ['snapshot' => $model->getAttributes()]);
    }
}


// ═══════════════════════════════════════════════════════════════════════════
// FILE 3 — Additions to app/Models/User.php
// Add these to your existing User model
// ═══════════════════════════════════════════════════════════════════════════
/*
Add to $fillable:
    'code', 'first_name', 'middle_name', 'last_name',
    'username', 'phone_number', 'role',

Add these methods to the User class:

    // ── Role helpers ──────────────────────────────────────────
    public function isAdmin(): bool      { return $this->role === 'admin'; }
    public function isHrManager(): bool  { return $this->role === 'hr_manager'; }
    public function isEmployee(): bool   { return $this->role === 'employee'; }

    public function hasPermission(string $permission): bool
    {
        // Load from role_permissions table
        return \DB::table('role_permissions')
            ->where('role', $this->role)
            ->where('permission', $permission)
            ->where('allowed', true)
            ->exists();
    }

    public function getFullNameAttribute(): string
    {
        return trim(
            ($this->first_name ?? '') . ' ' .
            ($this->middle_name ? $this->middle_name . ' ' : '') .
            ($this->last_name ?? '')
        );
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(
            substr($this->first_name ?? '', 0, 1) .
            substr($this->last_name  ?? '', 0, 1)
        );
    }

    // ── Relationships ─────────────────────────────────────────
    public function auditLogs()
    {
        return $this->hasMany(\App\Models\AuditLog::class, 'causer_id');
    }
*/
