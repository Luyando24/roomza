<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Chatify\Facades\ChatifyMessenger as Chatify;

class ChatifyController extends Controller
{
    /**
     * Get the count of unread messages for the authenticated user
     */
    public function getUnreadCount()
    {
        $unreadCount = Chatify::countUnseenMessages(Auth::id());
        
        return response()->json([
            'count' => $unreadCount
        ]);
    }
}
