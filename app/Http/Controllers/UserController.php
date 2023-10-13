<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\AvailableTime;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showsingleuser(User $user){
        $availableTimes = AvailableTime::where('user_id', $user->id)->get();
        $availableDays = $availableTimes->pluck('day')->unique()->values()->toArray();
        $schedules = Schedule::where('buyer_id',auth()->user()->id)->get();
        // Ambil hari yang tersedia
        // $userSelectedDates = Schedule::where('user_id', $user->id)->pluck('date');
        // $formattedDates = $userSelectedDates->map(function ($date) {
        //     return Carbon::parse($date)->toDateString();
        // });
        // dd($userSelectedDate);

        // dd($selectedDate);
        // $existingTimes = Schedule::where('user_id', $user->id)
        // ->select('start_time', 'end_time')
        // ->get();
        //  dd($existingTimes);

        return view('singleuser',compact('availableTimes','availableDays','schedules'), [
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
