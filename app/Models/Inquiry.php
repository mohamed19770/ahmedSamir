<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 'type', 'status', 'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    public function scopeByType($query, string $type) { return $query->where('type', $type); }
    public function scopeByStatus($query, string $status) { return $query->where('status', $status); }
    public function scopeUnread($query) { return $query->where('status', 'new'); }
}
