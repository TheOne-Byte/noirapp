<?php

namespace App\Http\Controllers;

use App\Models\rating;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('review.rating', [
            "title" => "rating",
            'active' => 'rating',
            'slug' => $request->TrxNo
            // Post::find($id)

        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $transaction = Transaction::where('slug', $request->slug)->first();
        $rating = rating::where('id',$transaction->id)->first();
        
        if($rating){
            return redirect('/history')->with('error','You Already Review This!');    
        }

        $validated = $request->validate([
            'rating' =>'required|min:1|max:5',
            'comment' =>'required|string|min:1|max:25',
        ]);

        $validated['transaction_id'] = $transaction->id;
        $validated['buyer_id'] = $transaction->buyer_id;
        $validated['seller_id'] = $transaction->seller_id;

        rating::create($validated);
        return redirect('/history')->with('success','Review Has Been Saved!');    

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(rating $rating)
    {
        //
    }
}
