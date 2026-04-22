<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'code',
        'first_name',
        'middle_name',
        'last_name',
        'username',
        'email',
        'phone_number',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── Role helpers ─────────────────────────────────────────
    public function isAdmin(): bool     { return $this->role === 'admin'; }
    public function isHrManager(): bool { return $this->role === 'hr_manager'; }
    public function isEmployee(): bool  { return $this->role === 'employee'; }

    public function hasPermission(string $permission): bool
    {
        if ($this->role === 'admin') return true;

        return \DB::table('role_permissions')
            ->where('role', $this->role)
            ->where('permission', $permission)
            ->where('allowed', true)
            ->exists();
    }

    // ── Accessors ─────────────────────────────────────────────
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

    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'admin'      => 'Administrator',
            'hr_manager' => 'HR Manager',
            'employee'   => 'Employee',
            default      => ucfirst($this->role ?? ''),
        };
    }

    // ── Relationships ─────────────────────────────────────────
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'causer_id');
    }
}

