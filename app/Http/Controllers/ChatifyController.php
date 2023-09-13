<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatifyController extends Controller
{
    public function showChatify()
    {
        // You can add any logic here that's needed before displaying the Chatify view
        // For example, you might want to check if the user is authenticated or perform other checks.

        return view('chatify'); // Assuming you have a 'chatify.blade.php' view
    }

}
