<?php

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

