<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $citiesByProvince = [
            'Lusaka' => ['Lusaka', 'Kafue', 'Chongwe', 'Chilanga'],
            'Copperbelt' => ['Ndola', 'Kitwe', 'Chingola', 'Mufulira', 'Luanshya', 'Kalulushi', 'Chililabombwe'],
            'Central' => ['Kabwe', 'Kapiri Mposhi', 'Mkushi', 'Serenje'],
            'Eastern' => ['Chipata', 'Petauke', 'Katete', 'Lundazi'],
            'Northern' => ['Kasama', 'Mpika', 'Mbala', 'Mporokoso'],
            'Luapula' => ['Mansa', 'Samfya', 'Kawambwa', 'Nchelenge'],
            'North-Western' => ['Solwezi', 'Mwinilunga', 'Kasempa', 'Zambezi'],
            'Western' => ['Mongu', 'Kaoma', 'Senanga', 'Kalabo'],
            'Southern' => ['Livingstone', 'Choma', 'Mazabuka', 'Monze', 'Kalomo'],
            'Muchinga' => ['Chinsali', 'Mpika', 'Nakonde', 'Isoka'],
        ];

        foreach ($citiesByProvince as $provinceName => $cities) {
            $province = Province::where('name', $provinceName)->first();
            
            if ($province) {
                foreach ($cities as $cityName) {
                    City::create([
                        'province_id' => $province->id,
                        'name' => $cityName,
                    ]);
                }
            }
        }
    }
}

