<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class WorkSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'date',
        'recurring_type', // 'none', 'weekly', 'monthly'
        'recurring_until', // date when recurring ends
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'date',
        'recurring_until' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scopes
    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    public function scopeForWeek($query, $year, $week)
    {
        return $query->whereRaw('YEAR(date) = ? AND WEEK(date, 1) = ?', [$year, $week]);
    }

    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('date', $year)->whereMonth('date', $month);
    }

    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('recurring_until')
              ->orWhere('recurring_until', '>=', now());
        });
    }

    // Helper methods
    public function isRecurring()
    {
        return in_array($this->recurring_type, ['weekly', 'monthly']);
    }

    public function getDurationAttribute()
    {
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        return $start->diffInMinutes($end) . ' minutes';
    }

    public function getTimeRangeAttribute()
    {
        return Carbon::parse($this->start_time)->format('H:i') . ' - ' . 
               Carbon::parse($this->end_time)->format('H:i');
    }
}
