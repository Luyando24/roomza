<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Models\User;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Assign roles to users when they register
        Event::listen(Registered::class, function (Registered $event) {
            $user = $event->user;
            
            // No need to check for the Spatie package anymore
            // We're using our custom implementation
            
            // The User model now has a hasRole method that doesn't rely on Spatie
            // So we don't need to do anything special here
            
            // The business_type field will be used by our custom hasRole method
        });
    }
}
