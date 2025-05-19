<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('User Details')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Personal Information')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn ($state) => 
                                        filled($state) ? Hash::make($state) : null)
                                    ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser)
                                    ->dehydrated(fn ($state) => filled($state))
                                    ->maxLength(255),
                                Forms\Components\FileUpload::make('profile_photo_path')
                                    ->image()
                                    ->directory('profile-photos')
                                    ->visibility('public')
                                    ->label('Profile Photo'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Business Information')
                            ->schema([
                                Forms\Components\TextInput::make('business_name')
                                    ->maxLength(255)
                                    ->placeholder('Your Business Name')
                                    ->visible(fn ($record) => $record && $record->business_type === 'business'),
                                Forms\Components\Select::make('business_type')
                                    ->options([
                                        'personal' => 'Personal',
                                        'business' => 'Business',
                                    ])
                                    ->required(),
                                Forms\Components\Textarea::make('business_description')
                                    ->rows(3)
                                    ->placeholder('Brief description of your business')
                                    ->visible(fn ($record) => $record && $record->business_type === 'business'),
                                Forms\Components\FileUpload::make('business_logo')
                                    ->image()
                                    ->directory('business-logos')
                                    ->visibility('public')
                                    ->visible(fn ($record) => $record && $record->business_type === 'business'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('profile_photo_path')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}





