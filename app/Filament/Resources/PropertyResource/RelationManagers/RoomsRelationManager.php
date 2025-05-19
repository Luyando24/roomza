<?php

namespace App\Filament\Resources\PropertyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RoomsRelationManager extends RelationManager
{
    protected static string $relationship = 'rooms';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('room_number')
                    ->maxLength(50),
                Forms\Components\TextInput::make('price_per_night')
                    ->numeric()
                    ->prefix('$')
                    ->required(),
                Forms\Components\TextInput::make('capacity')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
                Forms\Components\Select::make('room_type')
                    ->options([
                        'single' => 'Single',
                        'double' => 'Double',
                        'twin' => 'Twin',
                        'triple' => 'Triple',
                        'quad' => 'Quad',
                        'studio' => 'Studio',
                        'suite' => 'Suite',
                        'dormitory' => 'Dormitory',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('images')
                    ->multiple()
                    ->image()
                    ->directory('rooms')
                    ->visibility('public')
                    ->reorderable()
                    ->columnSpanFull(),
                Forms\Components\CheckboxList::make('amenities')
                    ->options([
                        'private_bathroom' => 'Private Bathroom',
                        'air_conditioning' => 'Air Conditioning',
                        'tv' => 'TV',
                        'wifi' => 'WiFi',
                        'refrigerator' => 'Refrigerator',
                        'desk' => 'Desk',
                        'wardrobe' => 'Wardrobe',
                        'balcony' => 'Balcony',
                        'kitchen' => 'Kitchen',
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_available')
                    ->default(true)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('room_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('room_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'single' => 'gray',
                        'double' => 'info',
                        'twin' => 'info',
                        'triple' => 'warning',
                        'quad' => 'warning',
                        'studio' => 'success',
                        'suite' => 'danger',
                        'dormitory' => 'primary',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('price_per_night')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('room_type')
                    ->options([
                        'single' => 'Single',
                        'double' => 'Double',
                        'twin' => 'Twin',
                        'triple' => 'Triple',
                        'quad' => 'Quad',
                        'studio' => 'Studio',
                        'suite' => 'Suite',
                        'dormitory' => 'Dormitory',
                    ]),
                Tables\Filters\TernaryFilter::make('is_available')
                    ->label('Available'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('toggle_availability')
                    ->label(fn ($record) => $record->is_available ? 'Mark as Unavailable' : 'Mark as Available')
                    ->icon(fn ($record) => $record->is_available ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn ($record) => $record->is_available ? 'danger' : 'success')
                    ->action(function ($record) {
                        $record->update(['is_available' => !$record->is_available]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('mark_available')
                        ->label('Mark as Available')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn (Builder $query) => $query->update(['is_available' => true])),
                    Tables\Actions\BulkAction::make('mark_unavailable')
                        ->label('Mark as Unavailable')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn (Builder $query) => $query->update(['is_available' => false])),
                ]),
            ]);
    }
}

