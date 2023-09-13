<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatifyController extends Controller
{
    public function showChatify()
    {
        if (auth()->user()) {
            session()->put('chat_with', auth()->user()->id);
        }

        return view('vendor.Chatify.pages.app');
    }

}
