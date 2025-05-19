<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new room.
     */
    public function create(Property $property)
    {
        $this->authorize('update', $property);
        
        return view('rooms.create', compact('property'));
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request, Property $property)
    {
        $this->authorize('update', $property);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'amenities' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $roomData = $request->except('_token', 'images');
        
        // Handle image uploads
        if ($request->hasFile('images')) {
            $paths = [];
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $paths[] = $image->store('rooms', 'public');
                }
            }
            $roomData['images'] = $paths;
        }

        $room = $property->rooms()->create($roomData);

        return redirect()->route('properties.show', $property)
            ->with('success', 'Room added successfully!');
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Property $property, Room $room)
    {
        $this->authorize('update', $property);
        
        return view('rooms.edit', compact('property', 'room'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Property $property, Room $room)
    {
        $this->authorize('update', $property);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'amenities' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048',
        ]);

        $roomData = $request->except('_token', '_method', 'images');
        
        // Handle image uploads
        if ($request->hasFile('images')) {
            $paths = $room->images ?? [];
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $paths[] = $image->store('rooms', 'public');
                }
            }
            $roomData['images'] = $paths;
        }

        $room->update($roomData);

        return redirect()->route('properties.show', $property)
            ->with('success', 'Room updated successfully!');
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Property $property, Room $room)
    {
        $this->authorize('update', $property);
        
        // Delete images
        if ($room->images) {
            foreach ($room->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $room->delete();

        return redirect()->route('properties.show', $property)
            ->with('success', 'Room deleted successfully!');
    }
}