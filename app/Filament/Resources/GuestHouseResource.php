<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestHouseResource\Pages;
use App\Filament\Resources\GuestHouseResource\RelationManagers;
use App\Models\GuestHouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;

class GuestHouseResource extends Resource
{
    protected static ?string $model = GuestHouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'Property Types';
    protected static ?int $navigationSort = 50;
    
    // Hide the "Create" button
    protected static bool $canCreate = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Existing form fields
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('property.title')
                    ->label('Guest House Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('property.city.name')
                    ->label('City')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('property.province.name')
                    ->label('Province')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_conference_room')
                    ->label('Conference Room')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_restaurant')
                    ->label('Restaurant')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_bar')
                    ->label('Bar')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_swimming_pool')
                    ->label('Pool')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_wifi')
                    ->label('WiFi')
                    ->boolean(),
                Tables\Columns\TextColumn::make('property.price')
                    ->label('Starting Price')
                    ->formatStateUsing(fn ($state, $record) => $record->property ? "{$record->property->currency} " . number_format($state, 2) : '-')
                    ->sortable(),
                Tables\Columns\IconColumn::make('property.is_featured')
                    ->label('Featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('property.is_active')
                    ->label('Active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('property.created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('has_restaurant')
                    ->label('Has Restaurant'),
                Tables\Filters\TernaryFilter::make('has_conference_room')
                    ->label('Has Conference Room'),
                Tables\Filters\TernaryFilter::make('has_swimming_pool')
                    ->label('Has Swimming Pool'),
                Tables\Filters\TernaryFilter::make('property.is_featured')
                    ->label('Featured'),
                Tables\Filters\TernaryFilter::make('property.is_active')
                    ->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view_property')
                    ->label('View Property')
                    ->icon('heroicon-o-eye')
                    ->url(fn (GuestHouse $record): ?string => $record->property ? route('filament.admin.resources.properties.edit', ['record' => $record->property->id]) : null)
                    ->visible(fn (GuestHouse $record): bool => $record->property !== null)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No Guest Houses Found')
            ->emptyStateDescription('Guest Houses are created through the main Property creation process.')
            ->emptyStateActions([
                Action::make('create_property')
                    ->label('Create New Property')
                    ->url(route('filament.admin.resources.properties.create'))
                    ->icon('heroicon-o-plus')
                    ->button(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuestHouses::route('/'),
            'edit' => Pages\EditGuestHouse::route('/{record}/edit'),
            // Remove the 'create' page
        ];
    }
}





