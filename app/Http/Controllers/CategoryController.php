<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('category.entry', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);
        Category::create($validatedData);
        return back()->with('addsuccess', $validatedData['name'] . ' was successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(String $id){

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('category.index')->with('updatesuccess', $request['name'].' updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return back()->with('deletefail', 'Category not found.');
        }

        $name = $category->name;
        $category->delete();

        return back()->with('deletesuccess', $name . ' was deleted');
    }

    public function passvalidator(Request $request)
    {
        $passcolor = $request->input('passcolor');
        $passcode = $request->input('textcode');
        if ($passcolor === '#111111' && $passcode === '000000') {
            // Redirect to a specific route upon successful validation
            return redirect()->route('category.index');
        }
    }

    
}
