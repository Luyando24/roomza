<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\City;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areasByCity = [
            'Lusaka' => [
                'Kabulonga', 'Woodlands', 'Roma', 'Chelstone', 'Avondale', 
                'Kalingalinga', 'Matero', 'Chilenje', 'Kabwata', 'Emmasdale',
                'Garden', 'Olympia', 'Northmead', 'Chainda', 'Chawama',
                'Makeni', 'Kabanana', 'Mtendere', 'Bauleni', 'Kamwala'
            ],
            'Ndola' => [
                'Kansenshi', 'Itawa', 'Northrise', 'Hillcrest', 'Kanini',
                'Masala', 'Lubuto', 'Kabushi', 'Chifubu', 'Ndeke'
            ],
            'Kitwe' => [
                'Parklands', 'Riverside', 'Nkana East', 'Nkana West', 'Chimwemwe',
                'Buchi', 'Wusakile', 'Kwacha', 'Bulangililo', 'Garneton'
            ],
            'Livingstone' => [
                'Dambwa North', 'Dambwa Central', 'Libuyu', 'Linda', 'Maramba',
                'Nottie Broadie', 'Zecco', 'Highlands', 'Ellaine Brittel'
            ]
        ];

        foreach ($areasByCity as $cityName => $areas) {
            $city = City::where('name', $cityName)->first();
            
            if ($city) {
                foreach ($areas as $areaName) {
                    Area::create([
                        'city_id' => $city->id,
                        'name' => $areaName,
                    ]);
                }
            }
        }
    }
}