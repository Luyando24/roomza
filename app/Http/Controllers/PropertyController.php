<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use App\Models\Property;
use App\Models\Province;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class PropertyController extends Controller
{
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
        $this->middleware('auth')->except(['index', 'show', 'search']);
    }

    /**
     * Display a listing of properties.
     */
    public function index()
    {
        $properties = Property::with(['area', 'city', 'province'])
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new property.
     */
    public function create()
    {
        $provinces = Province::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();

        return view('properties.create', compact('provinces', 'cities', 'areas'));
    }

    /**
     * Store a newly created property.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|string|in:boarding_house,hotel,lodge',
            'location' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'nullable|exists:areas,id',
            'price' => 'required|numeric|min:0',
            'cover_image' => 'required|image|max:2048',
            'detail_images.*' => 'nullable|image|max:2048',
            'amenities' => 'nullable|array',
        ]);

        // Prepare property data
        $propertyData = $request->except(['_token', 'type_specific']);
        $propertyData['user_id'] = Auth::id();
        
        // Get city and province names for easier searching
        $city = City::find($request->city_id);
        $province = Province::find($request->province_id);
        
        if ($city) {
            $propertyData['city_name'] = $city->name;
        }
        
        if ($province) {
            $propertyData['province_name'] = $province->name;
        }

        // Get type-specific data
        $typeData = $request->input('type_specific', []);

        // Create the property
        $property = $this->propertyService->createProperty(
            $propertyData,
            $typeData,
            $request->type
        );

        return redirect()->route('properties.show', $property)
            ->with('success', 'Property created successfully!');
    }

    /**
     * Display the specified property.
     */
    public function show($slug)
    {
        $property = Property::where('slug', $slug)
            ->with(['propertyable', 'city', 'area', 'province', 'amenities', 'reviews' => function($query) {
                $query->with('user')->latest()->take(3);
            }])
            ->firstOrFail();
        
        $reviews = $property->reviews()->with('user')->latest()->take(3)->get();
        
        return view('properties.show', compact('property', 'reviews'));
    }

    /**
     * Show the form for editing the specified property.
     */
    public function edit(Property $property)
    {
        $this->authorize('update', $property);

        $property->load('propertyable');
        
        $provinces = Province::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();

        return view('properties.edit', compact('property', 'provinces', 'cities', 'areas'));
    }

    /**
     * Update the specified property.
     */
    public function update(Request $request, Property $property)
    {
        $this->authorize('update', $property);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'area_id' => 'nullable|exists:areas,id',
            'price' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|max:2048',
            'detail_images.*' => 'nullable|image|max:2048',
            'amenities' => 'nullable|array',
        ]);

        // Prepare property data
        $propertyData = $request->except(['_token', 'type_specific', '_method']);
        
        // Get city and province names for easier searching
        $city = City::find($request->city_id);
        $province = Province::find($request->province_id);
        
        if ($city) {
            $propertyData['city_name'] = $city->name;
        }
        
        if ($province) {
            $propertyData['province_name'] = $province->name;
        }

        // Get type-specific data
        $typeData = $request->input('type_specific', []);

        // Update the property
        $property = $this->propertyService->updateProperty(
            $property,
            $propertyData,
            $typeData
        );

        return redirect()->route('properties.show', $property)
            ->with('success', 'Property updated successfully!');
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);

        // Delete images
        if ($property->cover_image) {
            Storage::disk('public')->delete($property->cover_image);
        }

        if ($property->detail_images) {
            foreach ($property->detail_images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        // Delete the property (will cascade to propertyable due to database relationship)
        $property->delete();

        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully!');
    }

    /**
     * Search for properties.
     */
    public function search(Request $request)
    {
        $query = Property::query()->where('is_active', true);

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by location
        if ($request->filled('location')) {
            $location = $request->location;
            $query->where(function($q) use ($location) {
                $q->where('location', 'like', "%{$location}%")
                  ->orWhere('city_name', 'like', "%{$location}%")
                  ->orWhere('province_name', 'like', "%{$location}%");
            });
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by amenities
        if ($request->filled('amenities')) {
            $amenities = $request->amenities;
            $query->where(function($q) use ($amenities) {
                foreach ($amenities as $amenity) {
                    $q->whereJsonContains('amenities', $amenity);
                }
            });
        }

        $properties = $query->with(['area', 'city', 'province'])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('properties.index', compact('properties'));
    }

    public function listYourProperty(){
        return view('list-your-property');
    }
}




