<?php

namespace App\Filament\Resources\LodgeResource\Pages;

use App\Filament\Resources\LodgeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLodge extends EditRecord
{
    protected static string $resource = LodgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
