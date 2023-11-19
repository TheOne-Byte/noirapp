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

        return back()->with('success', 'Tanggal dan waktu telah disimpan.');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required', // Pastikan user_id tersedia dalam request
            'date' => 'required|date',
            'selectedTime' => 'required', // Pastikan selectedTime tersedia dalam request
        ]);
        $buyer_id = auth()->user()->id;
        $selectedDate = $request->input('date');
        $selectedTime = $request->input('selectedTime');
        $existingSchedule = Schedule::where('date', $selectedDate)
        ->where('start_time', $selectedTime)
        ->exists();
        $existingSchedule2 = Schedule::where('buyer_id', $buyer_id)->first();

        if ($existingSchedule2) {
            return redirect()->back()->with('error', 'You already have a schedule.');
        } else if ($existingSchedule) {
            return redirect()->back()->with('error', 'The selected date and time are not available.');
        }
        $user_id = $validated['user_id'];
        $buyer_id = auth()->user()->id;
        $date = $validated['date'];
        $start_time = $validated['selectedTime'];
        $end_time = date('H:i', strtotime($start_time) + 7200); // Menambah 2 jam ke waktu mulai

    $newSchedule = Schedule::create([
        'user_id' => $user_id,
        'buyer_id' => $buyer_id,
        'date' => $date,
        'start_time' => $start_time,
        'end_time' => $end_time,
    ]);

        return redirect()->back()->with('schedule_id', $newSchedule->id)->with('success', 'Schedule saved successfully!');
    }

    public function userSchedules()
    {
        $userSchedules = Schedule::where('buyer_id',auth()->user()->id)->get();

        return view('schedule.userschedule', ['schedules' => $userSchedules,'active' => 'userschedule']);
    }

    public function sellerSchedules()
    {
        $userSchedules = Schedule::where('user_id',auth()->user()->id)->get();

        return view('schedule.sellerschedule', ['schedules' => $userSchedules,'active' => 'userschedule']);
    }
}
