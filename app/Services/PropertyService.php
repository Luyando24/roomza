<?php

namespace App\Services;

use App\Models\Property;
use App\Models\BoardingHouse;
use App\Models\Hotel;
use App\Models\Lodge;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PropertyService
{
    /**
     * Create a new property with its specific type.
     *
     * @param array $propertyData
     * @param array $typeData
     * @param string $type
     * @return Property
     */
    public function createProperty(array $propertyData, array $typeData, string $type): Property
    {
        return DB::transaction(function () use ($propertyData, $typeData, $type) {
            // Handle image uploads if present
            if (isset($propertyData['cover_image']) && $propertyData['cover_image']->isValid()) {
                $path = $propertyData['cover_image']->store('properties', 'public');
                $propertyData['cover_image'] = $path;
            }

            if (isset($propertyData['detail_images'])) {
                $paths = [];
                foreach ($propertyData['detail_images'] as $image) {
                    if ($image->isValid()) {
                        $paths[] = $image->store('properties', 'public');
                    }
                }
                $propertyData['detail_images'] = $paths;
            }

            // Create the specific property type
            $propertyable = $this->createPropertyType($typeData, $type);

            // Create the main property and associate it with the specific type
            $property = new Property($propertyData);
            $property->propertyable()->associate($propertyable);
            $property->save();

            return $property;
        });
    }

    /**
     * Create the specific property type model.
     *
     * @param array $data
     * @param string $type
     * @return mixed
     */
    private function createPropertyType(array $data, string $type)
    {
        return match ($type) {
            'boarding_house' => BoardingHouse::create($data),
            'hotel' => Hotel::create($data),
            'lodge' => Lodge::create($data),
            default => throw new \InvalidArgumentException("Unsupported property type: {$type}"),
        };
    }

    /**
     * Update an existing property.
     *
     * @param Property $property
     * @param array $propertyData
     * @param array $typeData
     * @return Property
     */
    public function updateProperty(Property $property, array $propertyData, array $typeData): Property
    {
        return DB::transaction(function () use ($property, $propertyData, $typeData) {
            // Handle image uploads if present
            if (isset($propertyData['cover_image']) && $propertyData['cover_image']->isValid()) {
                // Delete old image if exists
                if ($property->cover_image) {
                    Storage::disk('public')->delete($property->cover_image);
                }
                
                $path = $propertyData['cover_image']->store('properties', 'public');
                $propertyData['cover_image'] = $path;
            }

            if (isset($propertyData['detail_images'])) {
                $paths = $property->detail_images ?? [];
                
                foreach ($propertyData['detail_images'] as $image) {
                    if ($image->isValid()) {
                        $paths[] = $image->store('properties', 'public');
                    }
                }
                
                $propertyData['detail_images'] = $paths;
            }

            // Update the property
            $property->update($propertyData);

            // Update the specific property type
            if ($property->propertyable) {
                $property->propertyable->update($typeData);
            }

            return $property;
        });
    }
}