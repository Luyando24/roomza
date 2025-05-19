<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestChatController extends Controller
{
    public function index()
    {
        return "Chat test route is working!";
    }
}