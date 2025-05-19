<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardingHouseResource\Pages;
use App\Filament\Resources\BoardingHouseResource\RelationManagers;
use App\Models\BoardingHouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;

class BoardingHouseResource extends Resource
{
    protected static ?string $model = BoardingHouse::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Property Types';
    protected static ?int $navigationSort = 30;
    
    // Hide the "Create" button
    protected static bool $canCreate = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nearby_school')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('max_students')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('current_students')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('gender_policy')
                    ->required(),
                Forms\Components\Toggle::make('shared_rooms')
                    ->required(),
                Forms\Components\TextInput::make('room_capacity')
                    ->numeric()
                    ->default(null),
                Forms\Components\Textarea::make('rules')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('property.title')
                    ->label('Boarding House Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('property.city.name')
                    ->label('City')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nearby_school')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_students')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_students')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender_policy')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'male_only' => 'blue',
                        'female_only' => 'pink',
                        'mixed' => 'purple',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('shared_rooms')
                    ->boolean(),
                Tables\Columns\TextColumn::make('room_capacity')
                    ->numeric()
                    ->sortable(),
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('gender_policy')
                    ->options([
                        'male_only' => 'Male Only',
                        'female_only' => 'Female Only',
                        'mixed' => 'Mixed',
                    ]),
                Tables\Filters\TernaryFilter::make('shared_rooms')
                    ->label('Shared Rooms'),
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
                    ->url(fn (BoardingHouse $record): ?string => $record->property ? route('filament.admin.resources.properties.edit', ['record' => $record->property->id]) : null)
                    ->visible(fn (BoardingHouse $record): bool => $record->property !== null)
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No Boarding Houses Found')
            ->emptyStateDescription('Boarding Houses are created through the main Property creation process.')
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
            'index' => Pages\ListBoardingHouses::route('/'),
            'edit' => Pages\EditBoardingHouse::route('/{record}/edit'),
            // Remove the 'create' page
        ];
    }
}




