<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showsingleuser(User $user){
        return view('singleuser', [
            'title' => "User Information",
            'active' => 'singleuser',
            'user' => $user -> load('category','role','cart','permission') //ini category sm author karena di html nya dipanggil catgory sm author
            // Post::find($id)

        ]);
    }

    public function reducePoints(Request $request) {
        $user_id = Auth::user()->id;
        $user = User::where('id',$user_id )->first();
        $totalPrice = $request->input('totalPrice'); // Ganti dengan cara Anda mendapatkan total harga dari request
        $user->points -= $totalPrice;
        $user->save();

        return response()->json(['success' => true]);
    }
}
