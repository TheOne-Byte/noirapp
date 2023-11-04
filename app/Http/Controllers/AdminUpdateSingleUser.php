<?php

namespace App\Http\Controllers;

use App\Models\EditDisplayed;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUpdateSingleUser extends Controller
{

    public function showPendingUpdates()
    {
        $active = 'editdisplayeditem';
        $pendingUpdates = EditDisplayed::where('is_approved', 0)->get();


        return view('admin.updatesingleuserrequest', compact('pendingUpdates', 'active'));
    }


    public function approveUpdate($id)
    {
        $updateRequest = EditDisplayed::find($id);
        $updateRequest->is_approved = 1;
        $updateRequest->save();

        $user = User::find($updateRequest->user_id);
        $user->body = $updateRequest->bio;
        $user->save();

        // Redirect back to the pending updates page or show a success message
        return redirect()->route('admin.pending-updates')->with('success', 'Update request approved successfully.');
    }

}
