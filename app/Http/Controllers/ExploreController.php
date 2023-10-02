<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');

        $posts = Post::where(function ($query) use ($search, $categoryId) {
            $query->where('title', 'like', "%$search%")
                ->orWhere('content', 'like', "%$search%");

            // Check if a category ID is provided
            if ($categoryId) {
                $query->orWhereHas('categories', function ($subQuery) use ($categoryId) {
                    $subQuery->where('categories.id', $categoryId);
                });
            }
        })->latest()->simplePaginate(3);

        return view('explore', compact('posts'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
