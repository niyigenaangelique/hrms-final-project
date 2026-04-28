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
        'is_active',
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
            'is_active'         => 'boolean',
        ];
    }

    // ── Role constants ───────────────────────────────────────
    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_HR_MANAGER = 'hr_manager';
    public const ROLE_HR_ADMIN = 'hr_admin';
    public const ROLE_HR_OFFICER = 'hr_officer';
    public const ROLE_HR_CLARK = 'hr_clark';
    public const ROLE_PAYROLL_OFFICER = 'payroll_officer';
    public const ROLE_COMPANY_ADMIN = 'company_admin';
    public const ROLE_DATA_MASTER = 'data_master';
    public const ROLE_COMPANY_DATA_MASTER = 'company_data_master';
    public const ROLE_OPERATIONS_MANAGER = 'operations_manager';
    public const ROLE_FINANCE_ADMIN = 'finance_admin';
    public const ROLE_FINANCE_MANAGER = 'finance_manager';
    public const ROLE_FINANCE_OFFICER = 'finance_officer';
    public const ROLE_SITE_SUPERVISOR = 'site_supervisor';
    public const ROLE_SITE_ADMIN = 'site_admin';
    public const ROLE_SITE_MANAGER = 'site_manager';
    public const ROLE_PROJECT_MANAGER = 'project_manager';
    public const ROLE_LEADERSHIP_TEAM_MEMBER = 'leadership_team_member';
    public const ROLE_EMPLOYEE = 'employee';
    public const ROLE_SITE_EMPLOYEE = 'site_employee';

    public const ROLES = [
        self::ROLE_ADMIN                  => 'System Admin',
        self::ROLE_HR_MANAGER             => 'HR Manager',
        self::ROLE_EMPLOYEE               => 'Standard Employee',
    ];

    // ── Role helpers ─────────────────────────────────────────
    public function isAdmin(): bool     { return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_SUPER_ADMIN]); }
    public function isHrManager(): bool { return $this->role === self::ROLE_HR_MANAGER; }
    public function isEmployee(): bool  { return in_array($this->role, [self::ROLE_EMPLOYEE, self::ROLE_SITE_EMPLOYEE]); }

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
        return self::ROLES[$this->role] ?? ucfirst(str_replace('_', ' ', $this->role ?? ''));
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

