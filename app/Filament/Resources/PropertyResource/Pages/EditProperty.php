<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditProperty extends EditRecord
{
    protected static string $resource = PropertyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('view')
                ->url(fn () => route('properties.show', $this->record))
                ->openUrlInNewTab(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $property = $this->record;
        
        // If there's a propertyable relationship, load its data
        if ($property->propertyable) {
            $propertyable = $property->propertyable;
            
            // Add the propertyable's attributes to the form data
            foreach ($propertyable->getAttributes() as $key => $value) {
                if (!in_array($key, ['id', 'created_at', 'updated_at'])) {
                    $data[$key] = $value;
                }
            }
        }
        
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Ensure user_id is set if not present in form data
        if (!isset($data['user_id'])) {
            $data['user_id'] = $record->user_id ?? auth()->id();
        }
        
        // Update the property
        $record->user_id = $data['user_id'];
        $record->title = $data['title'];
        $record->description = $data['description'] ?? null;
        $record->location = $data['location'];
        $record->nearest_shopping_mall = $data['nearest_shopping_mall'] ?? null;
        $record->nearest_market = $data['nearest_market'] ?? null;
        $record->nearest_hospital = $data['nearest_hospital'] ?? null;
        $record->water_source = $data['water_source'] ?? null;
        $record->province_id = $data['province_id'] ?? null;
        $record->city_id = $data['city_id'] ?? null;
        $record->area_id = $data['area_id'] ?? null;
        $record->city_name = $data['city_name'] ?? null;
        $record->province_name = $data['province_name'] ?? null;
        $record->price = $data['price'];
        $record->currency = $data['currency'] ?? 'ZMW';
        $record->is_featured = $data['is_featured'] ?? false;
        $record->is_active = $data['is_active'] ?? true;
        
        // Add the missing verification fields
        $record->is_verified = $data['is_verified'] ?? false;
        $record->verified_at = $data['verified_at'] ?? null;
        $record->verified_by = $data['verified_by'] ?? null;
        
        // Handle file uploads
        if (isset($data['cover_image'])) {
            $record->cover_image = $data['cover_image'];
        }
        
        if (isset($data['detail_images'])) {
            $record->detail_images = $data['detail_images'];
        }
        
        if (isset($data['amenities'])) {
            $record->amenities = $data['amenities'];
        }
        
        $record->save();

        // Update the propertyable
        if ($record->propertyable) {
            $propertyable = $record->propertyable;
            $propertyableData = [];
            
            // Extract the relevant data based on property type
            if ($record->type === 'boarding_house') {
                $propertyableData = [
                    'nearby_school' => $data['nearby_school'] ?? null,
                    'max_students' => $data['max_students'] ?? null,
                    'current_students' => $data['current_students'] ?? null,
                    'gender_policy' => $data['gender_policy'] ?? 'mixed',
                    'shared_rooms' => $data['shared_rooms'] ?? false,
                    'room_capacity' => $data['room_capacity'] ?? null,
                    'rules' => $data['rules'] ?? null,
                ];
            } elseif ($record->type === 'hotel') {
                $propertyableData = [
                    'star_rating' => $data['star_rating'] ?? null,
                    'has_restaurant' => $data['has_restaurant'] ?? false,
                    'has_conference_room' => $data['has_conference_room'] ?? false,
                    'has_swimming_pool' => $data['has_swimming_pool'] ?? false,
                    'has_spa' => $data['has_spa'] ?? false,
                    'has_gym' => $data['has_gym'] ?? false,
                    'has_room_service' => $data['has_room_service'] ?? false,
                    'check_in_time' => $data['check_in_time'] ?? null,
                    'check_out_time' => $data['check_out_time'] ?? null,
                ];
            } elseif ($record->type === 'lodge') {
                $propertyableData = [
                    'has_meeting_hall' => $data['has_meeting_hall'] ?? false,
                    'has_bar' => $data['has_bar'] ?? false,
                    'has_restaurant' => $data['has_restaurant'] ?? false,
                    'has_outdoor_seating' => $data['has_outdoor_seating'] ?? false,
                    'has_parking' => $data['has_parking'] ?? false,
                    'has_security' => $data['has_security'] ?? false,
                    'check_in_time' => $data['check_in_time'] ?? null,
                    'check_out_time' => $data['check_out_time'] ?? null,
                ];
            } elseif ($record->type === 'home') {
                $propertyableData = [
                    'bedrooms' => $data['bedrooms'] ?? null,
                    'bathrooms' => $data['bathrooms'] ?? null,
                    'square_meters' => $data['square_meters'] ?? null,
                    'year_built' => $data['year_built'] ?? null,
                    'has_garage' => $data['has_garage'] ?? false,
                    'garage_capacity' => $data['garage_capacity'] ?? null,
                    'has_garden' => $data['has_garden'] ?? false,
                    'garden_size' => $data['garden_size'] ?? null,
                    'has_swimming_pool' => $data['has_swimming_pool'] ?? false,
                    'property_type' => $data['property_type'] ?? null,
                    'construction_materials' => $data['construction_materials'] ?? null,
                    'roof_type' => $data['roof_type'] ?? null,
                    'is_new_construction' => $data['is_new_construction'] ?? false,
                ];
            } elseif ($record->type === 'guest_house') {
                $propertyableData = [
                    'has_conference_room' => $data['has_conference_room'] ?? false,
                    'has_restaurant' => $data['has_restaurant'] ?? false,
                    'has_bar' => $data['has_bar'] ?? false,
                    'has_swimming_pool' => $data['has_swimming_pool'] ?? false,
                    'has_wifi' => $data['has_wifi'] ?? false,
                    'has_tv' => $data['has_tv'] ?? false,
                    'has_parking' => $data['has_parking'] ?? false,
                    'has_security' => $data['has_security'] ?? false,
                    'check_in_time' => $data['check_in_time'] ?? null,
                    'check_out_time' => $data['check_out_time'] ?? null,
                ];
            }
            
            $propertyable->update($propertyableData);
        }

        return $record;
    }
}







