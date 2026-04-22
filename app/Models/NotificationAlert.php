<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationAlert extends Model
{
    protected $fillable = ['name','trigger','channel','priority','days_before','is_active'];
    protected $casts    = ['is_active' => 'boolean', 'days_before' => 'integer'];
}