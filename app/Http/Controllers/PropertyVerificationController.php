<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PropertyVerificationController extends Controller
{
    /**
     * Mark a property as verified.
     */
    public function verify(Request $request, Property $property)
    {
        $this->authorize('verify', $property);
        
        // Log before state
        Log::info('Before verify', [
            'id' => $property->id,
            'is_verified' => $property->is_verified,
            'verified_at' => $property->verified_at,
            'verified_by' => $property->verified_by
        ]);
        
        // Use direct DB update to bypass any model issues
        DB::table('properties')
            ->where('id', $property->id)
            ->update([
                'is_verified' => true,
                'verified_at' => now(),
                'verified_by' => Auth::id(),
            ]);
        
        // Refresh the model from database
        $property->refresh();
        
        // Log after state
        Log::info('After verify', [
            'id' => $property->id,
            'is_verified' => $property->is_verified,
            'verified_at' => $property->verified_at,
            'verified_by' => $property->verified_by
        ]);
        
        return back()->with('success', 'Property has been verified successfully.');
    }
    
    /**
     * Mark a property as unverified.
     */
    public function unverify(Request $request, Property $property)
    {
        $this->authorize('verify', $property);
        
        // Log before state
        Log::info('Before unverify', [
            'id' => $property->id,
            'is_verified' => $property->is_verified,
            'verified_at' => $property->verified_at,
            'verified_by' => $property->verified_by
        ]);
        
        // Use direct DB update to bypass any model issues
        DB::table('properties')
            ->where('id', $property->id)
            ->update([
                'is_verified' => false,
                'verified_at' => null,
                'verified_by' => null,
            ]);
        
        // Refresh the model from database
        $property->refresh();
        
        // Log after state
        Log::info('After unverify', [
            'id' => $property->id,
            'is_verified' => $property->is_verified,
            'verified_at' => $property->verified_at,
            'verified_by' => $property->verified_by
        ]);
        
        return back()->with('success', 'Property verification has been removed.');
    }
}

