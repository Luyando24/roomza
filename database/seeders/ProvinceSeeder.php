<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $provinces = [
            'Lusaka',
            'Copperbelt',
            'Central',
            'Eastern',
            'Northern',
            'Luapula',
            'North-Western',
            'Western',
            'Southern',
            'Muchinga',
        ];

        foreach ($provinces as $province) {
            Province::create(['name' => $province]);
        }
    }
}

