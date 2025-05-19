<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'property_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'total_price',
        'home_address',
        'email',
        'payment_method',
        'payment_status',
        'booking_status',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user who made this booking.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property for this booking.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the room for this booking.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}