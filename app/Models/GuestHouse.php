<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
class GuestHouse extends Model{
    use HasFactory;
    protected $fillable = [        'has_conference_room',
        'has_restaurant',        'has_bar',
        'has_swimming_pool',        'has_wifi',
        'has_tv',        'has_parking',
        'has_security',        'check_in_time',
        'check_out_time',        'rules',
    ];
    protected $casts = [        'has_conference_room' => 'boolean',
        'has_restaurant' => 'boolean',        'has_bar' => 'boolean',
        'has_swimming_pool' => 'boolean',        'has_wifi' => 'boolean',
        'has_tv' => 'boolean',        'has_parking' => 'boolean',
        'has_security' => 'boolean',        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',    ];
    /**
     * Get the property record for this guest house.     */
    public function property(): MorphOne    {
        return $this->morphOne(Property::class, 'propertyable');
    }
}























