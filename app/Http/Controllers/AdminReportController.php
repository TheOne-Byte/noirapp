<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index(){
        return view('admin.reports.index', [
            'title' => "Id Card Role",
            'active' => 'Id Card Role',
            'users' => User::where('report_times', '>', 0)->get()
        ]);
    }

    public function index_detail(User $user){


        // dd($scheduleCount);
        return view('admin.reports.detail', [
            'active' => 'report_detail',
            'user' => $user,
            'reports'=> Report::where('user_id',$user->id)->get()
            // Post::find($id)

        ]);
    }
}
