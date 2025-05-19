<?php

namespace App\Filament\Resources\HomeResource\Pages;

use App\Filament\Resources\HomeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomes extends ListRecords
{
    protected static string $resource = HomeResource::class;

    // Override the getHeaderActions method to remove the CreateAction
    protected function getHeaderActions(): array
    {
        return [
            // Intentionally empty to remove the CreateAction
        ];
    }
}

