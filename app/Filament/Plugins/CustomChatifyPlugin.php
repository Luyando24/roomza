<?php

namespace App\Filament\Plugins;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Illuminate\Support\Facades\Route;

class CustomChatifyPlugin implements Plugin
{
    use EvaluatesClosures;

    public function getId(): string
    {
        return 'custom-chatify';
    }

    public function register(Panel $panel): void
    {
        // Register any custom functionality here
    }

    public function boot(Panel $panel): void
    {
        // Override the Chatify route
        if (!Route::has('chat.index')) {
            Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])
                ->name('chat.index')
                ->middleware(['web', 'auth']);
        }
        
        // Define the chatify route as an alias to chat.index
        if (!Route::has('chatify')) {
            Route::get('/chatify', function () {
                return redirect()->route('chat.index');
            })->name('chatify');
        }
    }
}