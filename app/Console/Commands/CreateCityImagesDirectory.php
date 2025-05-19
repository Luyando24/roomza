<?php

namespace App\Console\Commands;

use App\Models\City;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CreateCityImagesDirectory extends Command
{
    protected $signature = 'make:city-images {--update-db : Update database with existing images}';
    protected $description = 'Create directory structure for city images and optionally update database';

    public function handle()
    {
        $path = public_path('images/cities');
        
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
            $this->info('Created directory: ' . $path);
        } else {
            $this->info('Directory already exists: ' . $path);
        }
        
        $cities = ['lusaka', 'kitwe', 'ndola', 'livingstone', 'kabwe', 'chipata'];
        
        foreach ($cities as $city) {
            $placeholder = $path . '/' . $city . '.jpg';
            if (!File::exists($placeholder)) {
                $this->info('You need to add an image for ' . ucfirst($city) . ' at: ' . $placeholder);
            } else if ($this->option('update-db')) {
                $this->updateCityImageInDatabase($city, $placeholder);
            }
        }
        
        $this->info('Please add city images (recommended size: 300x300px) to the directory.');
        
        if (!$this->option('update-db')) {
            $this->info('After adding images, run: php artisan make:city-images --update-db');
        }
        
        return Command::SUCCESS;
    }
    
    protected function updateCityImageInDatabase($cityName, $imagePath)
    {
        $city = City::where('name', 'like', '%' . ucfirst($cityName) . '%')->first();
        
        if (!$city) {
            $this->warn("City not found in database: " . ucfirst($cityName));
            return;
        }
        
        // Copy the image to the storage directory
        $storagePath = 'cities/' . basename($imagePath);
        $fileContent = File::get($imagePath);
        Storage::disk('public')->put($storagePath, $fileContent);
        
        // Update the city record
        $city->city_image = $storagePath;
        $city->save();
        
        $this->info("Updated city_image for " . $city->name);
    }
}
