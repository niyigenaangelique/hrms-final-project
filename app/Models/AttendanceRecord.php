<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttendanceRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attendances';
    
    protected $fillable = [
        'code',
        'employee_id',
        'date',
        'check_in',
        'check_out',
        'device_id',
        'check_in_method',
        'check_out_method',
        'status',
        'approval_status',
        'is_locked',
        'locked_by',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'is_locked' => 'boolean',
        'approval_status' => 'string',
        'check_in_method' => 'string',
        'check_out_method' => 'string',
        'status' => 'string',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function lockedBy()
    {
        return $this->belongsTo(User::class, 'locked_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Helper method to check if attendance is present
    public function isPresent()
    {
        return in_array($this->status, ['present', 'Entered', 'On Time']);
    }

    // Helper method to check if attendance is absent
    public function isAbsent()
    {
        return in_array($this->status, ['absent', 'Absent', 'Leave']);
    }

    // Helper method to get work duration in minutes
    public function getWorkDurationMinutes()
    {
        if ($this->check_in && $this->check_out) {
            return $this->check_in->diffInMinutes($this->check_out);
        }
        return 0;
    }

    // Helper method to get work duration in hours
    public function getWorkDurationHours()
    {
        return round($this->getWorkDurationMinutes() / 60, 2);
    }
}
