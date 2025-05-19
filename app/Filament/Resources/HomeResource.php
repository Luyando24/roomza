<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeResource\Pages;
use App\Filament\Resources\HomeResource\RelationManagers;
use App\Models\Home;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;

class HomeResource extends Resource
{
    protected static ?string $model = Home::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'Property Types';
    protected static ?int $navigationSort = 10;
    
    // Hide the "Create" button
    protected static bool $canCreate = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('bedrooms')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('bathrooms')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('square_meters')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('year_built')
                    ->numeric()
                    ->default(null),
                Forms\Components\Toggle::make('has_garage')
                    ->required(),
                Forms\Components\TextInput::make('garage_capacity')
                    ->numeric()
                    ->default(null),
                Forms\Components\Toggle::make('has_garden')
                    ->required(),
                Forms\Components\TextInput::make('garden_size')
                    ->numeric()
                    ->default(null),
                Forms\Components\Toggle::make('has_swimming_pool')
                    ->required(),
                Forms\Components\TextInput::make('property_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('construction_materials')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('roof_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('is_new_construction')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('property.title')
                    ->label('Home Name')
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
                Tables\Columns\TextColumn::make('bedrooms')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bathrooms')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('square_meters')
                    ->numeric()
                    ->suffix(' m²')
                    ->sortable(),
                Tables\Columns\TextColumn::make('year_built')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_garage')
                    ->label('Garage')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_garden')
                    ->label('Garden')
                    ->boolean(),
                Tables\Columns\IconColumn::make('has_swimming_pool')
                    ->label('Pool')
                    ->boolean(),
                Tables\Columns\TextColumn::make('property_type')
                    ->badge(),
                Tables\Columns\TextColumn::make('property.price')
                    ->label('Price')
                    ->formatStateUsing(fn ($state, $record) => $record->property ? "{$record->property->currency} " . number_format($state, 2) : '-')
                    ->sortable(),
                Tables\Columns\IconColumn::make('property.is_featured')
                    ->label('Featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('property.is_active')
                    ->label('Active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('property_type')
                    ->options([
                        'apartment' => 'Apartment',
                        'house' => 'House',
                        'villa' => 'Villa',
                        'condo' => 'Condo',
                        'townhouse' => 'Townhouse',
                    ]),
                Tables\Filters\TernaryFilter::make('has_garage')
                    ->label('Has Garage'),
                Tables\Filters\TernaryFilter::make('has_garden')
                    ->label('Has Garden'),
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
                    ->url(fn (Home $record): ?string => $record->property ? route('filament.admin.resources.properties.edit', ['record' => $record->property->id]) : null)
                    ->visible(fn (Home $record): bool => $record->property !== null)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No Homes Found')
            ->emptyStateDescription('Homes are created through the main Property creation process.')
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
            'index' => Pages\ListHomes::route('/'),
            'edit' => Pages\EditHome::route('/{record}/edit'),
            // Remove the 'create' page
        ];
    }
}
