<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display the chat interface.
     */
    public function index()
    {
        // Forward to the Chatify controller
        return app()->make(\Chatify\Http\Controllers\MessagesController::class)->index();
    }
}