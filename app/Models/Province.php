<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    protected $fillable = ['name'];

    /**
     * Get the cities for this province.
     */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get all properties in this province.
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
