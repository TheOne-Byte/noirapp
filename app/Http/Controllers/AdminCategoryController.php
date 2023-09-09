<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index', [
            'title' => "Categories",
            'active' => 'admincategory',
            'categories' => category::all() // Use the correct model name
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create',[
            'active' =>'createpost',
            'categories' => Category::all() 
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' =>'required|max:20',
            'slug' => 'required|unique:categories',
            'image' => 'image|file|max:1024'
        ]);

        if($request->file('image')){
            $validated['image'] = $request->file('image')->store('category-images');
        }
     
        category::create($validated);
        return redirect('/dashboard/categories')->with('success','New Category Has Been Added!');   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        return view('admin.categories.edit',[
            'category' => $category,
            'active' => 'edit'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {

        $rules = [
            'name' =>'required|max:20'
        ];


        if($request->slug != $category->slug){
            $rules['slug'] = 'required|unique:categories';
        }

        $validated = $request->validate($rules); 

        if($request->file('image')){
            if($request->oldImage){
                Storage::delete([$request->oldImage]);
            }
            $validated['image'] = $request->file('image')->store('category-images');
        }

       
        // $validated['excerpt'] = Str::limit(strip_tags($request->body),200); //strip tags biar bold dll ilang 

        category::where('id',$category->id)
        ->update($validated);
        return redirect('/dashboard/categories')->with('success','Category Has Been Edited!');    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        if($category->image){
            Storage::delete($category->image);
        
        }
        category::destroy($category->id);
        return redirect('/dashboard/categories')->with('success','Category Successfully deleted!');    
    }

  
}
