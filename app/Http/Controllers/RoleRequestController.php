<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use App\Models\category;
use App\Models\permission;

use Illuminate\Http\Request;
use App\Models\AvailableTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user(); // Assuming you're using Laravel's authentication

        // Permissions data
        $permissions = DB::table('permissions')
            ->where('user_id', $user->id)
            ->where('statcode', 'APV')
            ->get(['id', 'category_id', 'role_id', 'user_id', 'price', 'imageprofile', 'image', 'video', 'norekening', 'statcode', 'body']);

        // Available times data
        $availableTimes = DB::table('available_times')
            ->where('user_id', $user->id)
            ->get(['id', 'user_id', 'day', 'start_time', 'end_time']);

        return view('requestrole.index', [
            "title" => "request role",
            'active' => 'request role',
            'categories' => category::all(),
            'roles' => role::whereNotIn('name', ['user', 'admin'])->get(),
            'permissions' => $permissions,
            'availableTimes' => $availableTimes,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   public function store(Request $request)
{
    $user = auth()->user();
    $data = permission::where('user_id', $user->id)->first();

    $validated = $request->validate([
        'role_id' => 'required',
        'price' => 'required',
        'imageprofile' => 'required|image|file|max:1024',
        'image' => 'required|image|file|max:1024',
        'video' => 'required|mimes:mp4,avi,wmv|max:10240',
        'category_id' => 'required',
        'norekening' => 'required|max:16|min:16',
        'body' => 'required|max:30',
    ]);

    if ($request->file('imageprofile')) {
        $validated['imageprofile'] = $request->file('imageprofile')->store('role-profile-images');
    }

    if ($request->file('image')) {
        $validated['image'] = $request->file('image')->store('role-request-images');
    }

    if ($request->file('video')) {
        $validated['video'] = $request->file('video')->store('role-request-videos');
    }

    $validated['user_id'] = $user->id;
    $validated['statcode'] = "REQ";

    // Check if there is an existing record with statcode "APV" for the same user
    if ($data && $data->statcode === "APV") {
        // Update the existing record
        permission::where('id', $data->id)->update($validated);
        return redirect('/role/request')->with('success', 'Changing Role Request Has Been Submitted!');
    }

    // Check other conditions and update or create permission records accordingly
    if ($data) {
        if ($data->statcode === "REQ") {
            return redirect('/role/request')->with('danger', 'You Already Have Pending Request!');
        } else if ($data->statcode === "RJC") {
            // Use updateOrCreate instead of update
            permission::updateOrCreate(
                ['user_id' => $user->id, 'statcode' => 'REQ'],
                $validated
            );
            return redirect('/role/request')->with('success', 'Role Request Again Has Been Submitted!');
        }
    }
        foreach ($request->input('available_days', []) as $day => $value) {
            AvailableTime::updateOrCreate(
                ['user_id' => auth()->user()->id, 'day' => $day],
                ['start_time' => $request->input('available_time_start', '00:00'), 'end_time' => $request->input('available_time_end', '23:59')]
            );
        }
    // Check for an existing record based on 'norekening' before creating a new one
    $existingRecord = permission::where('norekening', $request->input('norekening'))->first();

    if (!$existingRecord) {
        // Create a new permission record only if no existing record with the same 'norekening' is found
        permission::updateOrCreate(
            ['user_id' => $user->id, 'statcode' => 'REQ'],
            $validated
        );

        // Update or create AvailableTime records

        return redirect('/role/request')->with('success', 'Request Has Been Submitted!');
    }

    return redirect('/role/request')->with('danger', 'A record with the same "norekening" already exists!');
}



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
