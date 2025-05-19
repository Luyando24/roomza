<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Hotel extends Model
{
    protected $fillable = [
        'star_rating',
        'has_restaurant',
        'has_conference_room',
    ];

    protected $casts = [
        'has_restaurant' => 'boolean',
        'has_conference_room' => 'boolean',
    ];

    /**
     * Get the property record for this hotel.
     */
    public function property(): MorphOne
    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}