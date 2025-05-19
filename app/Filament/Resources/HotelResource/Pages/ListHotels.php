<?php

namespace App\Filament\Resources\HotelResource\Pages;

use App\Filament\Resources\HotelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHotels extends ListRecords
{
    protected static string $resource = HotelResource::class;

    // Override the getHeaderActions method to remove the CreateAction
    protected function getHeaderActions(): array
    {
        return [
            // Intentionally empty to remove the CreateAction
        ];
    }
}

