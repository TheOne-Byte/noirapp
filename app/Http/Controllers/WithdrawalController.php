<?php

namespace App\Http\Controllers;

use App\Models\points;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\point  $point
     * @return \Illuminate\Http\Response
     */
    public function show(point $point)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\point  $point
     * @return \Illuminate\Http\Response
     */
    public function edit(point $point)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\point  $point
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, point $point)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\point  $point
     * @return \Illuminate\Http\Response
     */
    public function destroy(point $point)
    {
        //
    }
}
