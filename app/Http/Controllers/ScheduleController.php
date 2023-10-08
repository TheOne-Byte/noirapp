<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\AvailableTime;

class ScheduleController extends Controller
{
    public function showSchedule($user_id)
{
    $availableTimes = AvailableTime::where('user_id', $user_id)->get();
    $availableDates = $availableTimes->pluck('day')->unique(); // Ambil tanggal yang tersedia

    return view('schedule', ['active' => 'register', 'availableTimes' => $availableTimes, 'availableDates' => $availableDates]);
}
    public function saveSchedule(Request $request) {
        $userId = $request->input('user_id');
        $date = $request->input('date');
        $time = $request->input('time');

        Schedule::create([
            'user_id' => $userId,
            'date' => $date,
            'time' => $time,
        ]);

        return redirect('/order')->with('success', 'Tanggal dan waktu telah disimpan.');
    }
}
