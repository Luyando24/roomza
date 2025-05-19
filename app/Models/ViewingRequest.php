<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ViewingRequest extends Model
{
    protected $fillable = [
        'user_id',
        'property_id',
        'preferred_date',
        'status',
        'notes',
        'phone_number',
        'owner_message'
    ];

    protected $casts = [
        'preferred_date' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function getStatusBadgeClassAttribute()
    {
        return [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'completed' => 'bg-blue-100 text-blue-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
        ][$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatusTextAttribute()
    {
        return ucfirst($this->status);
    }

    public function isOwner()
    {
        return auth()->id() === $this->property->user_id;
    }

    public function isRequester()
    {
        return auth()->id() === $this->user_id;
    }
}
