<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatifyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Chatify custom routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chatify/api/unread-count', [ChatifyController::class, 'getUnreadCount']);
});

