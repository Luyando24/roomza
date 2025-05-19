<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Home extends Model
{
    use HasFactory;

    protected $fillable = [
        'bedrooms',
        'bathrooms',
        'square_meters',
        'year_built',
        'has_garage',
        'garage_capacity',
        'has_garden',
        'garden_size',
        'has_swimming_pool',
        'property_type', // detached, semi-detached, townhouse, etc.
        'construction_materials',
        'roof_type',
        'is_new_construction',
    ];

    protected $casts = [
        'has_garage' => 'boolean',
        'has_garden' => 'boolean',
        'has_swimming_pool' => 'boolean',
        'is_new_construction' => 'boolean',
        'square_meters' => 'decimal:2',
        'garden_size' => 'decimal:2',
        'year_built' => 'integer',
    ];

    /**
     * Get the property record for this home.
     */
    public function property(): MorphOne
    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}