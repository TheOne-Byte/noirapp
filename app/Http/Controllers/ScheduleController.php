<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AvailableTime;

class ScheduleController extends Controller
{
    public function showSchedule($user_id)
    {
        $availableTimes = AvailableTime::where('user_id', $user_id)->get();
        return view('schedule',['active' => 'register'], compact('availableTimes'));
    }
}
