<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AvailableTime;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showsingleuser(User $user){
        $availableTimes = AvailableTime::where('user_id', $user->id)->get();

        return view('singleuser',compact('availableTimes'), [
            'title' => "User Information",
            'active' => 'singleuser',
            'user' => $user->load('category', 'role', 'cart', 'permission')
            //ini category sm author karena di html nya dipanggil catgory sm author
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
    public function availableTimes() {
        return $this->hasMany(AvailableTime::class);
    }
}
