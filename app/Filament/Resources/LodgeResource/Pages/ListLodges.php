<?php

namespace App\Filament\Resources\LodgeResource\Pages;

use App\Filament\Resources\LodgeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLodges extends ListRecords
{
    protected static string $resource = LodgeResource::class;

    // Override the getHeaderActions method to remove the CreateAction
    protected function getHeaderActions(): array
    {
        return [
            // Intentionally empty to remove the CreateAction
        ];
    }
}

