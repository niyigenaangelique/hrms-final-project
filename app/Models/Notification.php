<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
 
class Notification extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id','title','body','type','channel','priority','is_read',
        'read_at','status','scheduled_at','sent_at','sent_by','metadata','action_url',
    ];
 
    protected $casts = [
        'is_read'      => 'boolean',
        'read_at'      => 'datetime',
        'scheduled_at' => 'datetime',
        'sent_at'      => 'datetime',
        'metadata'     => 'array',
    ];
 
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function sender(): BelongsTo { return $this->belongsTo(User::class, 'sent_by'); }
 
    // Scopes
    public function scopeUnread($q)    { return $q->where('is_read', false); }
    public function scopeSent($q)      { return $q->where('status', 'sent'); }
    public function scopeScheduled($q) { return $q->where('status', 'scheduled'); }
    public function scopeForUser($q, $userId) { return $q->where('user_id', $userId); }
}
