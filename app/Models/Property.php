<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'price',
        'currency',
        'location',
        'province_id',
        'city_id',
        'area_id',
        'province_name',
        'city_name',
        'area_name',
        'nearest_shopping_mall',
        'nearest_market',
        'nearest_hospital',
        'water_source',
        'cover_image',
        'detail_images',
        'amenities',
        'is_featured',
        'is_active',
        'is_verified',
        'verified_at',
        'verified_by',
        'propertyable_type',
        'propertyable_id',
        'slug',
    ];

    protected $casts = [
        'detail_images' => 'array',
        'amenities' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    protected function slug(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => $value ?: Str::slug($this->title)
        );
    }
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($property) {
            if (!$property->slug) {
                $property->slug = Str::slug($property->title);
            }
        });
        
        static::updating(function ($property) {
            if ($property->isDirty('title') && !$property->isDirty('slug')) {
                $property->slug = Str::slug($property->title);
            }
        });
    }

    /**
     * Scope a query to only include properties for sale.
     */
    public function scopeForSale(Builder $query): Builder
    {
        return $query->where('type', 'sale');
    }

    /**
     * Scope a query to only include rental properties.
     */
    public function scopeForRent(Builder $query): Builder
    {
        return $query->where('type', 'rental');
    }

    /**
     * Get the specific property type model (Hotel, BoardingHouse, GuestHouse, etc.).
     */
    public function propertyable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who owns this property.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the province of this property.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
    
    /**
     * Get the city of this property.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
    
    /**
     * Get the area of this property.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
    
    /**
     * Get the rooms for this property.
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
    
    /**
     * Get the bookings for this property.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the reviews for this property.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the average rating for this property.
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating') ?? 0;
    }

    /**
     * Get the total number of reviews for this property.
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->where('is_approved', true)->count();
    }

    /**
     * Get the boarding house details for this property.
     */
    public function boardingHouse()
    {
        return $this->propertyable()
                    ->where('propertyable_type', 'App\\Models\\BoardingHouse');
    }

    /**
     * Get the user who verified this property.
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
