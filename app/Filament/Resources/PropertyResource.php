<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use App\Models\Province;
use App\Models\City;
use App\Models\Area;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = 'Property Management';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Property')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Basic Information')
                            ->schema([
                                Forms\Components\Select::make('user_id')
                                    ->label('Property Owner')
                                    ->relationship('user', 'business_name', function (Builder $query) {
                                        // If user is not an admin, only show their own account
                                        if (!auth()->user()->hasRole('admin')) {
                                            return $query->where('id', auth()->id());
                                        }
                                        return $query;
                                    })
                                    ->getOptionLabelFromRecordUsing(fn (User $record) => $record->business_name ?: $record->name)
                                    ->searchable()
                                    ->placeholder('Select property owner')
                                    ->required()
                                    ->default(fn () => auth()->id())
                                    ->disabled(fn () => !auth()->user()->hasRole('admin')),
                                Forms\Components\TextInput::make('title')
                                    ->label('Property Name')
                                    ->required()
                                    ->placeholder('Type the name of the property')
                                    ->maxLength(255),
                                Forms\Components\RichEditor::make('description')
                                    ->placeholder('Describe the property in detail')
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'bulletList',
                                        'orderedList',
                                        'link',
                                    ])
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('type')
                                    ->options([
                                        'boarding_house' => 'Boarding House',
                                        'hotel' => 'Hotel',
                                        'lodge' => 'Lodge',
                                        'home' => 'Home',
                                        'guest_house' => 'Guest House',
                                    ])
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Set $set, $state) {
                                        $propertyableType = match ($state) {
                                            'boarding_house' => 'App\\Models\\BoardingHouse',
                                            'hotel' => 'App\\Models\\Hotel',
                                            'lodge' => 'App\\Models\\Lodge',
                                            'home' => 'App\\Models\\Home',
                                            'guest_house' => 'App\\Models\\GuestHouse',
                                            default => null,
                                        };
                                        
                                        $set('propertyable_type', $propertyableType);
                                    }),
                                Forms\Components\Select::make('currency')
                                    ->options([
                                        'ZMW' => 'ZMW (Zambian Kwacha)',
                                        'USD' => 'USD (US Dollar)',
                                    ])
                                    ->default('ZMW')
                                    ->required()
                                    ->live(),
                                Forms\Components\TextInput::make('price')
                                    ->numeric()
                                    ->prefix(fn (Forms\Get $get) => $get('currency'))
                                    ->required()
                                    ->label(function (Forms\Get $get) {
                                        return match ($get('type')) {
                                            'boarding_house' => 'Monthly Rent',
                                            'hotel' => 'Price per Night',
                                            'lodge' => 'Price per Night',
                                            'home' => 'Sale Price',
                                            'guest_house' => 'Price per Night',
                                            default => 'Price',
                                        };
                                    })
                                    ->placeholder(function (Forms\Get $get) {
                                        return match ($get('type')) {
                                            'boarding_house' => '500.00',
                                            'hotel' => '150.00',
                                            'lodge' => '100.00',
                                            'home' => '250000.00',
                                            'guest_house' => '120.00',
                                            default => '0.00',
                                        };
                                    })
                                    ->helperText(function (Forms\Get $get) {
                                        return match ($get('type')) {
                                            'boarding_house' => 'Monthly rental amount',
                                            'hotel' => 'Standard rate per night',
                                            'lodge' => 'Standard rate per night',
                                            'home' => 'Total property sale price',
                                            'guest_house' => 'Standard rate per night',
                                            default => '',
                                        };
                                    }),
                                Forms\Components\Toggle::make('is_featured')
                                    ->default(false),
                                Forms\Components\Toggle::make('is_active')
                                    ->default(true),
                                Forms\Components\Section::make('Verification')
                                    ->schema([
                                        Forms\Components\Toggle::make('is_verified')
                                            ->label('Verified by Roomza')
                                            ->helperText('This property has been physically inspected by Roomza staff')
                                            ->reactive(),
                                        Forms\Components\DateTimePicker::make('verified_at')
                                            ->label('Verification Date')
                                            ->visible(fn (callable $get) => $get('is_verified'))
                                            ->required(fn (callable $get) => $get('is_verified'))
                                            ->default(now()),
                                        Forms\Components\Select::make('verified_by')
                                            ->label('Verified By')
                                            ->relationship('verifier', 'name')
                                            ->visible(fn (callable $get) => $get('is_verified'))
                                            ->required(fn (callable $get) => $get('is_verified')),
                                    ])
                                    ->collapsible(),
                            ]),
                        
                        Forms\Components\Tabs\Tab::make('Location')
                            ->schema([
                                Forms\Components\TextInput::make('location')
                                    ->required()
                                    ->placeholder('Enter full address')
                                    ->maxLength(255),
                                Forms\Components\Select::make('province_id')
                                    ->relationship('province', 'name')
                                    ->searchable()
                                    ->placeholder('Select province')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, ?string $state) {
                                        $set('city_id', null);
                                        $set('area_id', null);
                                        
                                        if ($state) {
                                            $province = Province::find($state);
                                            if ($province) {
                                                $set('province_name', $province->name);
                                            }
                                        }
                                    }),
                                Forms\Components\Select::make('city_id')
                                    ->relationship('city', 'name', function (Builder $query, Forms\Get $get) {
                                        return $query->where('province_id', $get('province_id'));
                                    })
                                    ->searchable()
                                    ->placeholder('Select city')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, ?string $state) {
                                        $set('area_id', null);
                                        
                                        if ($state) {
                                            $city = City::find($state);
                                            if ($city) {
                                                $set('city_name', $city->name);
                                            }
                                        }
                                    }),
                                Forms\Components\Select::make('area_id')
                                    ->relationship('area', 'name', function (Builder $query, Forms\Get $get) {
                                        return $query->where('city_id', $get('city_id'));
                                    })
                                    ->searchable()
                                    ->placeholder('Select area')
                                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, ?string $state) {
                                        // Optional: Add area name to a hidden field if needed
                                    }),
                                Forms\Components\TextInput::make('nearest_shopping_mall')
                                    ->placeholder('E.g., City Mall (2km)')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('nearest_market')
                                    ->placeholder('E.g., Central Market (1.5km)')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('nearest_hospital')
                                    ->placeholder('E.g., General Hospital (3km)')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('water_source')
                                    ->placeholder('E.g., Municipal water supply')
                                    ->maxLength(255),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('Images & Amenities')
                            ->schema([
                                Forms\Components\FileUpload::make('cover_image')
                                    ->image()
                                    ->directory('properties')
                                    ->visibility('public')
                                    ->required()
                                    ->imageResizeMode('cover')
                                    ->imageCropAspectRatio('16:9')
                                    ->imageResizeTargetWidth('1200')
                                    ->imageResizeTargetHeight('675')
                                    ->label('Cover Image'),
                                Forms\Components\FileUpload::make('detail_images')
                                    ->multiple()
                                    ->image()
                                    ->directory('properties')
                                    ->maxFiles(20)
                                    ->ImagePreviewHeight(50)
                                    ->visibility('public')
                                    ->reorderable()
                                    ->appendFiles()
                                    ->label('Property Images'),
                                Forms\Components\CheckboxList::make('amenities')
                                    ->options([
                                        'wifi' => 'WiFi',
                                        'parking' => 'Parking',
                                        'security' => '24/7 Security',
                                        'air_conditioning' => 'Air Conditioning',
                                        'kitchen' => 'Kitchen',
                                        'laundry' => 'Laundry',
                                        'tv' => 'TV',
                                        'hot_water' => 'Hot Water',
                                        'gym' => 'Gym',
                                        'swimming_pool' => 'Swimming Pool',
                                    ])
                                    ->columns(2),
                            ]),
                            
                        Forms\Components\Tabs\Tab::make('propertyTypeDetails')
                            ->label('Property Type Details')
                            ->schema([
                                // Boarding House specific fields
                                Forms\Components\Section::make('Boarding House Details')
                                    ->schema([
                                        Forms\Components\TextInput::make('nearby_school')
                                            ->label('Nearby School')
                                            ->placeholder('Enter nearby school name'),
                                        Forms\Components\TextInput::make('max_students')
                                            ->label('Maximum Students')
                                            ->numeric()
                                            ->minValue(1),
                                        Forms\Components\TextInput::make('current_students')
                                            ->label('Current Students')
                                            ->numeric()
                                            ->minValue(0),
                                        Forms\Components\Select::make('gender_policy')
                                            ->label('Gender Policy')
                                            ->options([
                                                'mixed' => 'Mixed Gender',
                                                'male' => 'Male Only',
                                                'female' => 'Female Only',
                                            ])
                                            ->default('mixed'),
                                        Forms\Components\Toggle::make('shared_rooms')
                                            ->label('Shared Rooms Available')
                                            ->default(false),
                                        Forms\Components\TextInput::make('room_capacity')
                                            ->label('Room Capacity')
                                            ->numeric()
                                            ->minValue(1),
                                        Forms\Components\Textarea::make('rules')
                                            ->label('House Rules')
                                            ->rows(3),
                                    ])
                                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'boarding_house')
                                    ->columns(2),
                                
                                // Hotel specific fields
                                Forms\Components\Section::make('Hotel Details')
                                    ->schema([
                                        Forms\Components\TextInput::make('star_rating')
                                            ->label('Star Rating')
                                            ->numeric()
                                            ->minValue(1)
                                            ->maxValue(5),
                                        Forms\Components\Toggle::make('has_restaurant')
                                            ->label('Has Restaurant')
                                            ->default(false),
                                        Forms\Components\Toggle::make('has_conference_room')
                                            ->label('Has Conference Room')
                                            ->default(false),
                                        Forms\Components\Toggle::make('has_swimming_pool')
                                            ->label('Has Swimming Pool')
                                            ->default(false),
                                        Forms\Components\Toggle::make('has_spa')
                                            ->label('Has Spa')
                                            ->default(false),
                                        Forms\Components\Toggle::make('has_gym')
                                            ->label('Has Gym')
                                            ->default(false),
                                        Forms\Components\Toggle::make('has_room_service')
                                            ->label('Has Room Service')
                                            ->default(false),
                                        Forms\Components\TextInput::make('check_in_time')
                                            ->label('Check-in Time')
                                            ->type('time')
                                            ->default('14:00'),
                                        Forms\Components\TextInput::make('check_out_time')
                                            ->label('Check-out Time')
                                            ->type('time')
                                            ->default('11:00'),
                                    ])
                                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'hotel')
                                    ->columns(2),
                                
                                // Lodge specific fields
                                Forms\Components\Section::make('Lodge Details')
                                    ->schema([
                                        Forms\Components\Toggle::make('has_meeting_hall')
                                            ->label('Has Meeting Hall')
                                            ->default(false),
                                        Forms\Components\Toggle::make('has_bar')
                                            ->label('Has Bar')
                                            ->default(false),
                                        Forms\Components\Toggle::make('has_restaurant')
                                            ->label('Has Restaurant')
                                            ->default(false),
                                        Forms\Components\Toggle::make('has_outdoor_seating')
                                            ->label('Has Outdoor Seating')
                                            ->default(false),
                                        Forms\Components\Toggle::make('has_parking')
                                            ->label('Has Parking')
                                            ->default(false),
                                        Forms\Components\Toggle::make('has_security')
                                            ->label('Has Security')
                                            ->default(false),
                                        Forms\Components\TextInput::make('check_in_time')
                                            ->label('Check-in Time')
                                            ->type('time')
                                            ->default('14:00'),
                                        Forms\Components\TextInput::make('check_out_time')
                                            ->label('Check-out Time')
                                            ->type('time')
                                            ->default('11:00'),
                                    ])
                                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'lodge')
                                    ->columns(2),
                                
                                // Home specific fields
                                Forms\Components\Section::make('Home Details')
                                    ->schema([
                                        Forms\Components\TextInput::make('bedrooms')
                                            ->numeric()
                                            ->minValue(0)
                                            ->placeholder('3')
                                            ->label('Number of Bedrooms'),
                                        Forms\Components\TextInput::make('bathrooms')
                                            ->numeric()
                                            ->minValue(0)
                                            ->placeholder('2')
                                            ->label('Number of Bathrooms'),
                                        Forms\Components\TextInput::make('square_meters')
                                            ->numeric()
                                            ->minValue(0)
                                            ->placeholder('120')
                                            ->label('Square Meters'),
                                        Forms\Components\TextInput::make('year_built')
                                            ->numeric()
                                            ->placeholder('2010')
                                            ->label('Year Built'),
                                        Forms\Components\Toggle::make('has_garage')
                                            ->default(false)
                                            ->label('Has Garage'),
                                        Forms\Components\TextInput::make('garage_capacity')
                                            ->numeric()
                                            ->minValue(0)
                                            ->placeholder('2')
                                            ->label('Garage Capacity'),
                                        Forms\Components\Toggle::make('has_garden')
                                            ->default(false)
                                            ->label('Has Garden'),
                                        Forms\Components\TextInput::make('garden_size')
                                            ->numeric()
                                            ->minValue(0)
                                            ->placeholder('50')
                                            ->label('Garden Size (sq m)'),
                                        Forms\Components\Toggle::make('has_swimming_pool')
                                            ->default(false)
                                            ->label('Has Swimming Pool'),
                                        Forms\Components\TextInput::make('property_type')
                                            ->placeholder('Detached, Semi-detached, Townhouse, etc.')
                                            ->label('Property Type'),
                                        Forms\Components\TextInput::make('construction_materials')
                                            ->placeholder('Brick, Concrete, Wood, etc.')
                                            ->label('Construction Materials'),
                                        Forms\Components\TextInput::make('roof_type')
                                            ->placeholder('Tile, Metal, Shingle, etc.')
                                            ->label('Roof Type'),
                                        Forms\Components\Toggle::make('is_new_construction')
                                            ->default(false)
                                            ->label('Is New Construction'),
                                    ])
                                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'home')
                                    ->columns(2),
                                
                                // Guest House specific fields
                                Forms\Components\Section::make('Guest House Details')
                                    ->schema([
                                        Forms\Components\Toggle::make('has_conference_room')
                                            ->default(false)
                                            ->label('Has Conference Room'),
                                        Forms\Components\Toggle::make('has_restaurant')
                                            ->default(false)
                                            ->label('Has Restaurant'),
                                        Forms\Components\Toggle::make('has_bar')
                                            ->default(false)
                                            ->label('Has Bar'),
                                        Forms\Components\Toggle::make('has_swimming_pool')
                                            ->default(false)
                                            ->label('Has Swimming Pool'),
                                        Forms\Components\Toggle::make('has_wifi')
                                            ->default(false)
                                            ->label('Has WiFi'),
                                        Forms\Components\Toggle::make('has_tv')
                                            ->default(false)
                                            ->label('Has TV'),
                                        Forms\Components\Toggle::make('has_parking')
                                            ->default(false)
                                            ->label('Has Parking'),
                                        Forms\Components\Toggle::make('has_security')
                                            ->default(false)
                                            ->label('Has Security'),
                                        Forms\Components\TextInput::make('check_in_time')
                                            ->type('time')
                                            ->placeholder('14:00')
                                            ->label('Check-in Time'),
                                        Forms\Components\TextInput::make('check_out_time')
                                            ->type('time')
                                            ->placeholder('11:00')
                                            ->label('Check-out Time'),
                                    ])
                                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'guest_house')
                                    ->columns(2),
                            ]),
                    ])
                    ->columnSpanFull(),
                
                // Hidden fields for polymorphic relationship
                Forms\Components\Hidden::make('propertyable_type'),
                Forms\Components\Hidden::make('propertyable_id'),
                Forms\Components\Hidden::make('city_name'),
                Forms\Components\Hidden::make('province_name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'boarding_house' => 'success',
                        'hotel' => 'warning',
                        'lodge' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Owner')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('city.name')
                    ->label('City')
                    ->searchable(),
                Tables\Columns\TextColumn::make('province.name')
                    ->label('Province')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->formatStateUsing(fn ($state, $record) => "{$record->currency} " . number_format($state, 2))
                    ->sortable(),
                Tables\Columns\ImageColumn::make('cover_image')
                    ->circular(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->label('Featured'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('reviews_count')
                    ->label('Reviews')
                    ->counts('reviews')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_verified')
                    ->boolean()
                    ->label('Verified')
                    ->trueIcon('heroicon-o-check-badge') 
                    ->falseIcon('heroicon-o-x-mark')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'boarding_house' => 'Boarding House',
                        'hotel' => 'Hotel',
                        'lodge' => 'Lodge',
                    ]),
                Tables\Filters\SelectFilter::make('province_id')
                    ->relationship('province', 'name')
                    ->searchable()
                    ->preload(),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view')
                    ->url(fn (Property $record): string => route('properties.show', $record->slug))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('feature')
                        ->label('Set as Featured')
                        ->icon('heroicon-o-star')
                        ->action(fn (Builder $query) => $query->update(['is_featured' => true])),
                    Tables\Actions\BulkAction::make('unfeature')
                        ->label('Remove Featured')
                        ->icon('heroicon-o-star')
                        ->action(fn (Builder $query) => $query->update(['is_featured' => false])),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn (Builder $query) => $query->update(['is_active' => true])),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-o-x-circle')
                        ->action(fn (Builder $query) => $query->update(['is_active' => false])),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ReviewsRelationManager::class,
            RelationManagers\RoomsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
