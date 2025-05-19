<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Lodge extends Model
{
    protected $fillable = [
        'has_meeting_hall',
    ];

    protected $casts = [
        'has_meeting_hall' => 'boolean',
    ];

    /**
     * Get the property record for this lodge.
     */
    public function property(): MorphOne
    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}