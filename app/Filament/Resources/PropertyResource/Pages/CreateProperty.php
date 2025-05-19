<?php

namespace App\Filament\Resources\PropertyResource\Pages;

use App\Filament\Resources\PropertyResource;
use App\Models\BoardingHouse;
use App\Models\Hotel;
use App\Models\Lodge;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProperty extends CreateRecord
{
    protected static string $resource = PropertyResource::class;

    // Override the default buttons
    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction(),
            $this->getSaveAndNextFormAction(),
        ];
    }

    // Customize the Save button
    protected function getSaveFormAction(): Actions\Action
    {
        return Actions\Action::make('save')
            ->label('Save')
            ->submit('create')
            ->keyBindings(['mod+s'])
            ->color('primary');
    }

    // Create a Save & Next button
    protected function getSaveAndNextFormAction(): Actions\Action
    {
        return Actions\Action::make('saveAndNext')
            ->label('Save & Next')
            ->action(function (): void {
                // Validate the form
                $data = $this->form->getState();
                
                // Ensure user_id is set if not present in form data
                if (!isset($data['user_id'])) {
                    $data['user_id'] = auth()->id();
                }
                
                // Create the record
                $record = $this->handleRecordCreation($data);
                
                $this->record = $record;
                
                // Get the property ID for the redirect
                $propertyId = $record->id;
                
                // Redirect to the edit page for the property type details
                // This will take the user directly to the property type tab
                $this->redirect(route('filament.admin.resources.properties.edit', ['record' => $propertyId]) . '?activeTab=propertyTypeDetails');
            })
            ->keyBindings(['mod+shift+s'])
            ->color('success');
    }

    protected function handleRecordCreation(array $data): Model
    {
        // Create the specific property type first
        $propertyableType = $data['propertyable_type'] ?? null;
        $propertyable = null;
        
        // Extract type-specific data based on the property type
        $typeData = [];
        
        if ($propertyableType === 'App\\Models\\BoardingHouse') {
            $typeData = [
                'nearby_school' => $data['nearby_school'] ?? null,
                'max_students' => $data['max_students'] ?? null,
                'current_students' => $data['current_students'] ?? null,
                'gender_policy' => $data['gender_policy'] ?? 'mixed',
                'shared_rooms' => $data['shared_rooms'] ?? false,
                'room_capacity' => $data['room_capacity'] ?? null,
                'rules' => $data['rules'] ?? null,
            ];
            $propertyable = \App\Models\BoardingHouse::create($typeData);
        } elseif ($propertyableType === 'App\\Models\\Hotel') {
            $typeData = [
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
            $propertyable = \App\Models\Hotel::create($typeData);
        } elseif ($propertyableType === 'App\\Models\\Lodge') {
            $typeData = [
                'has_meeting_hall' => $data['has_meeting_hall'] ?? false,
                'has_bar' => $data['has_bar'] ?? false,
                'has_restaurant' => $data['has_restaurant'] ?? false,
                'has_outdoor_seating' => $data['has_outdoor_seating'] ?? false,
                'has_parking' => $data['has_parking'] ?? false,
                'has_security' => $data['has_security'] ?? false,
                'check_in_time' => $data['check_in_time'] ?? null,
                'check_out_time' => $data['check_out_time'] ?? null,
            ];
            $propertyable = \App\Models\Lodge::create($typeData);
        } elseif ($propertyableType === 'App\\Models\\Home') {
            $typeData = [
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
            $propertyable = \App\Models\Home::create($typeData);
        } elseif ($propertyableType === 'App\\Models\\GuestHouse') {
            $typeData = [
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
            $propertyable = \App\Models\GuestHouse::create($typeData);
        }
        
        // Now create the property and associate it with the specific type
        $property = new \App\Models\Property();
        
        // Set the main property fields
        $property->user_id = $data['user_id'];
        $property->title = $data['title'];
        $property->description = $data['description'] ?? null;
        $property->type = $data['type'];
        $property->location = $data['location'];
        $property->nearest_shopping_mall = $data['nearest_shopping_mall'] ?? null;
        $property->nearest_market = $data['nearest_market'] ?? null;
        $property->nearest_hospital = $data['nearest_hospital'] ?? null;
        $property->water_source = $data['water_source'] ?? null;
        $property->province_id = $data['province_id'] ?? null;
        $property->city_id = $data['city_id'] ?? null;
        $property->area_id = $data['area_id'] ?? null;
        $property->city_name = $data['city_name'] ?? null;
        $property->province_name = $data['province_name'] ?? null;
        $property->price = $data['price'];
        $property->currency = $data['currency'] ?? 'ZMW';
        $property->cover_image = $data['cover_image'] ?? null;
        $property->detail_images = $data['detail_images'] ?? null;
        $property->amenities = $data['amenities'] ?? null;
        $property->is_featured = $data['is_featured'] ?? false;
        $property->is_active = $data['is_active'] ?? true;
        
        // Associate with the specific property type
        if ($propertyable) {
            $property->propertyable()->associate($propertyable);
        }
        
        $property->save();
        
        return $property;
    }
}


