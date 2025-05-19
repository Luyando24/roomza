<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'property_id',
        'name',
        'description',
        'price_per_night',
        'capacity',
        'amenities',
        'images',
        'is_available',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'amenities' => 'array',
        'images' => 'array',
        'is_available' => 'boolean',
    ];

    /**
     * Get the property this room belongs to.
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the bookings for this room.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}