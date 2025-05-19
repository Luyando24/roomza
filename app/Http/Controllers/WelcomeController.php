<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Property;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Show the welcome page.
     */
    public function index(Request $request)
    {
        // Get featured properties
        $featuredPropertiesQuery = Property::with(['city', 'province'])
            ->where('is_featured', true)
            ->where('is_active', true)
            ->latest();
        
        // Apply city filter if provided
        if ($request->has('city_filter') && $request->city_filter !== 'All') {
            $featuredPropertiesQuery->whereHas('city', function($query) use ($request) {
                $query->where('name', $request->city_filter);
            });
        }
        
        $featuredProperties = $featuredPropertiesQuery->take(6)->get();

        // Get popular cities with property count
        $popularCities = City::withCount('properties')
            ->orderBy('properties_count', 'desc')
            ->take(6)
            ->get();

        return view('welcome', compact('featuredProperties', 'popularCities'));
    }
}



