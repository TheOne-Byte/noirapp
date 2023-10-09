<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\category;
use App\Models\permission;
use App\Models\role;

use Illuminate\Http\Request;

class RoleRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('requestrole.index',
        [
            "title" => "request role",
            'active' => 'request role',
            'categories' => category::all(),
            'roles' => role::whereNotIn('name',['user','admin'])->get()

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
        $data = permission::where('user_id',auth()->user()->id)->first();
        $validated = $request->validate([
            'role_id' =>'required',
            'price' => 'required',
            'image' => 'required|image|file|max:1024',
            'category_id' => 'required',
            'body' => 'required|max:30'
        ]);

        if($request->file('image')){
            $validated['image'] = $request->file('image')->store('role-request-images');
        }
        $validated['user_id'] = auth()->user()->id;
        $validated['statcode'] = "REQ";



        if($data){
            if($data->statcode ==="REQ"){
                return redirect('/role/request')->with('danger','You Already Have Pending Request!');    
            }
            else if($data->statcode ==="APV"){
                if($data->role_id == $request->role_id){
                    return redirect('/role/request')->with('danger','Nothing To Change!');    
                }
                permission::where('id',$data->id)
                ->update($validated);
                return redirect('/role/request')->with('success','Changing Role Request Has Been Submitted!');    
            }
            else if($data->statcode ==="RJC"){
                permission::where('id',$data->id)
                ->update($validated);
                return redirect('/role/request')->with('success','Role Request Again Has Been Submitted!');   
            }
        }

        permission::create($validated);
        return redirect('/role/request')->with('success','Request Has Been Submitted!');    
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
