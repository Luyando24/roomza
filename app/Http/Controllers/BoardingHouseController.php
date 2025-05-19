<?php

namespace App\Http\Controllers;

use App\Models\BoardingHouse;
use App\Models\Property;
use Illuminate\Http\Request;

class BoardingHouseController extends Controller
{
    /**
     * Display a listing of boarding houses.
     */
    public function index(Request $request)
    {
        // Start with a query for boarding houses only
        $query = Property::where('propertyable_type', 'App\\Models\\BoardingHouse')
            ->with(['propertyable', 'city', 'area'])
            ->where('is_active', true);

        // Apply filters if provided
        if ($request->filled('city')) {
            $query->where('city_id', $request->city);
        }

        if ($request->filled('area')) {
            $query->where('area_id', $request->area);
        }

        // Filter by gender policy - specifically for boarding houses
        if ($request->filled('gender_policy')) {
            $query->whereHasMorph(
                'propertyable', 
                [BoardingHouse::class], 
                function($q) use ($request) {
                    $q->where('gender_policy', $request->gender_policy);
                }
            );
        }

        // Filter by shared rooms - specifically for boarding houses
        if ($request->filled('shared_rooms')) {
            $sharedRooms = $request->shared_rooms === 'true';
            $query->whereHasMorph(
                'propertyable',
                [BoardingHouse::class],
                function($q) use ($sharedRooms) {
                    $q->where('shared_rooms', $sharedRooms);
                }
            );
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort results
        $sortBy = $request->sort_by ?? 'created_at';
        $sortOrder = $request->sort_order ?? 'desc';
        
        // Handle distance-based sorting
        if ($sortBy === 'distance' && $request->filled('latitude') && $request->filled('longitude')) {
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            
            // Calculate distance using the Haversine formula
            $query->selectRaw("*, 
                (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", 
                [$latitude, $longitude, $latitude]
            )->orderBy('distance', 'asc');
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $boardingHouses = $query->paginate(12)->withQueryString();
        
        // Get cities and areas for filters
        $cities = \App\Models\City::whereHas('properties', function($q) {
            $q->where('propertyable_type', 'App\\Models\\BoardingHouse');
        })->get();
        
        return view('boarding-houses.index', [
            'properties' => $boardingHouses,
            'cities' => $cities,
            'filters' => $request->all(),
        ]);
    }

    /**
     * Display the specified boarding house.
     */
    public function show(Property $property)
    {
        // Check if this property is a boarding house
        if ($property->propertyable_type !== 'App\\Models\\BoardingHouse') {
            abort(404);
        }
        
        // Load the property with its relationships
        $property->load(['user', 'province', 'city', 'area', 'rooms', 'propertyable']);
        
        // Get approved reviews
        $reviews = $property->reviews()
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->take(3)
            ->get();
        
        // Get similar boarding houses in the same area
        $similarProperties = Property::where('propertyable_type', 'App\\Models\\BoardingHouse')
            ->where('id', '!=', $property->id)
            ->where('area_id', $property->area_id)
            ->where('is_active', true)
            ->with(['propertyable', 'city', 'area'])
            ->take(3)
            ->get();
        
        return view('boarding-houses.show', compact('property', 'reviews', 'similarProperties'));
    }
}

