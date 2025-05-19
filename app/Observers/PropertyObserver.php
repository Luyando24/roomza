<?php

namespace App\Observers;

use App\Models\Property;
use Illuminate\Support\Facades\Log;

class PropertyObserver
{
    /**
     * Handle the Property "saving" event.
     */
    public function saving(Property $property): void
    {
        // Log the current state for debugging
        Log::info('Property saving', [
            'id' => $property->id,
            'is_verified' => $property->is_verified,
            'verified_at' => $property->verified_at,
            'verified_by' => $property->verified_by,
            'dirty' => $property->getDirty()
        ]);

        // If property is being marked as verified and verified_at is not set
        if ($property->is_verified && $property->isDirty('is_verified') && !$property->verified_at) {
            $property->verified_at = now();
        }
        
        // If property is being marked as unverified, clear verification data
        if (!$property->is_verified && $property->isDirty('is_verified')) {
            $property->verified_at = null;
            $property->verified_by = null;
        }
    }

    /**
     * Handle the Property "saved" event.
     */
    public function saved(Property $property): void
    {
        // Log the saved state for debugging
        Log::info('Property saved', [
            'id' => $property->id,
            'is_verified' => $property->is_verified,
            'verified_at' => $property->verified_at,
            'verified_by' => $property->verified_by
        ]);
    }
}
