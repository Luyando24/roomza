<?php

namespace App\Filament\Resources\BoardingHouseResource\Pages;

use App\Filament\Resources\BoardingHouseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBoardingHouses extends ListRecords
{
    protected static string $resource = BoardingHouseResource::class;

    // Override the getHeaderActions method to remove the CreateAction
    protected function getHeaderActions(): array
    {
        return [
            // Intentionally empty to remove the CreateAction
        ];
    }
}

