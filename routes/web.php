<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\BoardingHouseController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PropertyVerificationController;
use App\Http\Controllers\ChatifyController;
use App\Http\Controllers\PropertyReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home page
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

// Property routes
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/search', [PropertyController::class, 'search'])->name('properties.search');
Route::get('/properties/{slug}', [PropertyController::class, 'show'])->name('properties.show');

// Add the missing create and store routes
Route::middleware(['auth'])->group(function () {
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
});

// Property Reviews routes
Route::get('/properties/{slug}/reviews', [PropertyReviewController::class, 'index'])->name('properties.reviews.index');
Route::get('/properties/{slug}/reviews/create', [PropertyReviewController::class, 'create'])->name('properties.reviews.create');
Route::post('/properties/{slug}/reviews', [PropertyReviewController::class, 'store'])->name('properties.reviews.store');
Route::post('/reviews/{review}/respond', [ReviewController::class, 'respond'])->name('reviews.respond');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

// Boarding House routes
Route::get('/boarding-houses', [BoardingHouseController::class, 'index'])->name('boarding-houses.index');
Route::get('/boarding-houses/{property}', [BoardingHouseController::class, 'show'])->name('boarding-houses.show');

// Authentication routes (already defined by Laravel Jetstream)

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth:sanctum', 'verified'])->name('dashboard');

// Add Jetstream profile routes if they're missing
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/user/profile', function () {
        return view('profile.show');
    })->name('profile.show');
    
    Route::get('/profile', function () {
        return redirect()->route('profile.show');
    })->name('profile.edit');
});

// Booking routes
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/properties/{property}/bookings/create', [App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/properties/{property}/bookings', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [App\Http\Controllers\BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [App\Http\Controllers\BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [App\Http\Controllers\BookingController::class, 'destroy'])->name('bookings.destroy');
});

// Property verification routes (admin only)
Route::middleware(['auth', 'can:manage-properties'])->group(function () {
    Route::post('/properties/{property}/verify', [PropertyVerificationController::class, 'verify'])->name('properties.verify');
    Route::post('/properties/{property}/unverify', [PropertyVerificationController::class, 'unverify'])->name('properties.unverify');
});

// Add a route for saved properties
Route::middleware(['auth'])->group(function () {
    Route::get('/saved', [PropertyController::class, 'saved'])->name('saved');
});

// Chatify custom routes
Route::middleware(['auth'])->group(function () {
    Route::get('/chatify/api/unread-count', [ChatifyController::class, 'getUnreadCount']);
});

// Use a different route name
Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])
    ->name('chat.index')
    ->middleware(['web', 'auth']);

// Test route
Route::get('/chat-test', [App\Http\Controllers\TestChatController::class, 'index'])
    ->name('chat.test')
    ->middleware(['web', 'auth']);

// Chatify API routes
Route::prefix('chat')->middleware(['web', 'auth'])->group(function () {
    Route::post('/idInfo', [\Chatify\Http\Controllers\MessagesController::class, 'idFetchData']);
    Route::post('/sendMessage', [\Chatify\Http\Controllers\MessagesController::class, 'send'])->name('send.message');
    Route::post('/fetchMessages', [\Chatify\Http\Controllers\MessagesController::class, 'fetch'])->name('fetch.messages');
    Route::get('/download/{fileName}', [\Chatify\Http\Controllers\MessagesController::class, 'download'])->name(config('chatify.attachments.download_route_name'));
    Route::post('/chat/auth', [\Chatify\Http\Controllers\MessagesController::class, 'pusherAuth'])->name('pusher.auth');
    Route::post('/makeSeen', [\Chatify\Http\Controllers\MessagesController::class, 'seen'])->name('messages.seen');
    Route::get('/getContacts', [\Chatify\Http\Controllers\MessagesController::class, 'getContacts'])->name('contacts.get');
    Route::post('/updateContacts', [\Chatify\Http\Controllers\MessagesController::class, 'updateContactItem'])->name('contacts.update');
    Route::post('/star', [\Chatify\Http\Controllers\MessagesController::class, 'favorite'])->name('star');
    Route::post('/favorites', [\Chatify\Http\Controllers\MessagesController::class, 'getFavorites'])->name('favorites');
    Route::get('/search', [\Chatify\Http\Controllers\MessagesController::class, 'search'])->name('search');
    Route::post('/shared', [\Chatify\Http\Controllers\MessagesController::class, 'sharedPhotos'])->name('shared');
    Route::post('/deleteConversation', [\Chatify\Http\Controllers\MessagesController::class, 'deleteConversation'])->name('conversation.delete');
    Route::post('/deleteMessage', [\Chatify\Http\Controllers\MessagesController::class, 'deleteMessage'])->name('message.delete');
    Route::post('/updateSettings', [\Chatify\Http\Controllers\MessagesController::class, 'updateSettings'])->name('avatar.update');
    Route::post('/setActiveStatus', [\Chatify\Http\Controllers\MessagesController::class, 'setActiveStatus'])->name('activeStatus.set');
    
    Route::get('/group/{id}', [\Chatify\Http\Controllers\MessagesController::class, 'index'])->name('group');
    Route::get('/{id}', [\Chatify\Http\Controllers\MessagesController::class, 'index'])->name('user');
});

// Fallback route for 'chatify'
Route::get('/chatify', function () {
    return redirect()->route('chat.index');
})->name('chatify');

Route::middleware(['auth'])->group(function () {
    // Viewing Request routes
});

// List your property page
Route::get('/list-your-property', [PropertyController::class, 'listYourProperty'])->name('list-your-property');









