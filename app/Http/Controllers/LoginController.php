<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login.index', [
            "title" => "login",
            'active' => 'login'
            // Post::find($id)
    
        ]);
    }

    public function authenticate(Request $request){

        
        $credential = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);

        if(Auth::attempt($credential)){
            $request->session()->regenerate(); //regenerate itu untuk keamanaan biar ga kena session fixation (wikipedia)

            return redirect()->intended('/game');
        }

        // return back()->withErrors();
        return back()->with('loginError','login failed!');


    }
}
