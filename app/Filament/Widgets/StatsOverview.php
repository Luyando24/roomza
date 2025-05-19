<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Properties', \App\Models\Property::count())
                ->description('Total Properties')
                ->icon('heroicon-o-home'),
            
            Stat::make('Boarding Houses', \App\Models\BoardingHouse::count())
                ->description('Total Boarding Houses')
                ->icon('heroicon-o-home'),

            Stat::make('Lodges', \App\Models\Lodge::count())
                ->description('Total Lodges')
                ->icon('heroicon-o-home'),

            Stat::make('Guest Houses', \App\Models\GuestHouse::count())
                ->description('Total Guest Houses')
                ->icon('heroicon-o-home'),
            
            Stat::make('Hotels', \App\Models\Hotel::count())
                ->description('Total Hotels')
                ->icon('heroicon-o-home'),
            
            Stat::make('Homes', \App\Models\Home::count())
                ->description('Total Homes')
                ->icon('heroicon-o-home'),
        ];
    }
}
