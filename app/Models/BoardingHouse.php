<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class BoardingHouse extends Model
{
    protected $fillable = [
        'nearby_school',
        'max_students',
        'current_students',
        'gender_policy',
        'shared_rooms',
        'room_capacity',
        'rules',
    ];

    protected $casts = [
        'shared_rooms' => 'boolean',
    ];

    /**
     * Get the property record for this boarding house.
     */
    public function property(): MorphOne
    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}