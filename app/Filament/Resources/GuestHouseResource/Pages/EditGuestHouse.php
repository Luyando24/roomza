<?php

namespace App\Filament\Resources\GuestHouseResource\Pages;

use App\Filament\Resources\GuestHouseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuestHouse extends EditRecord
{
    protected static string $resource = GuestHouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
