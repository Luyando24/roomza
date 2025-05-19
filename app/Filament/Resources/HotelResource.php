<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HotelResource\Pages;
use App\Filament\Resources\HotelResource\RelationManagers;
use App\Models\Hotel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;

class HotelResource extends Resource
{
    protected static ?string $model = Hotel::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Property Types';
    protected static ?int $navigationSort = 20;
    
    // Hide the "Create" button
    protected static bool $canCreate = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('star_rating')
                    ->numeric()
                    ->default(null),
                Forms\Components\Toggle::make('has_restaurant')
                    ->required(),
                Forms\Components\Toggle::make('has_conference_room')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('property.title')
                    ->label('Hotel Name')
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
                Tables\Columns\TextColumn::make('star_rating')
                    ->formatStateUsing(fn ($state) => $state ? "⭐ {$state}" : 'Not rated')
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_restaurant')
                    ->label('Restaurant')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_conference_room')
                    ->label('Conference Room')
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
                Tables\Columns\TextColumn::make('property.updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('star_rating')
                    ->options([
                        '1' => '1 Star',
                        '2' => '2 Stars',
                        '3' => '3 Stars',
                        '4' => '4 Stars',
                        '5' => '5 Stars',
                    ]),
                Tables\Filters\TernaryFilter::make('has_restaurant')
                    ->label('Has Restaurant'),
                Tables\Filters\TernaryFilter::make('has_conference_room')
                    ->label('Has Conference Room'),
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
                    ->url(fn (Hotel $record): ?string => $record->property ? route('filament.admin.resources.properties.edit', ['record' => $record->property->id]) : null)
                    ->visible(fn (Hotel $record): bool => $record->property !== null)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No Hotels Found')
            ->emptyStateDescription('Hotels are created through the main Property creation process.')
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
            'index' => Pages\ListHotels::route('/'),
            'edit' => Pages\EditHotel::route('/{record}/edit'),
            // Remove the 'create' page
        ];
    }
}




