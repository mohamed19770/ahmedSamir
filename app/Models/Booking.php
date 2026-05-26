<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    protected $fillable = [
        'user_id', 'package_id', 'activity_id', 'booking_number', 'guest_name',
        'guest_email', 'guest_phone', 'guests_count', 'check_in_date', 'check_out_date',
        'special_requests', 'total_price', 'currency', 'status', 'payment_status',
        'payment_method', 'notes',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = 'D2G-' . strtoupper(Str::random(8));
            }
            $booking->status = $booking->status ?? 'pending';
            $booking->payment_status = $booking->payment_status ?? 'pending';
            $booking->currency = $booking->currency ?? 'USD';
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(TourismPackage::class, 'package_id');
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }
}
