<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userdata = User::all();
        $categories = Category::all();
        $posts = Post::all();
        return view('/profile', compact(['userdata','categories','posts']));
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
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'bio' => 'required|string',
            'dob' => 'required|date',
            'address' => 'required|string',
        ]);

        if (
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'bio' => $request->bio,
                'dob' => $request->dob,
                'Address' => $request->address,
            ])
        ) {
            return redirect()
                ->back()
                ->with('success', 'Profile updated successfully!');
        } else {
            dd('Update failed: ' . $user->getConnection()->getPdo()->errorCode());
        }
    }

    public function imgupdate(Request $request, User $user)
    {
        $request->validate([
            'image' => ['required', 'image'],
        ]);

        // Get the current user's image path
        $currentImagePath = $user->image;

        // Store the new image
        $imagePath = $request->file('image')->store('public/profile_images');

        // Check if the current image exists and is not the default image
        if (file_exists($currentImagePath) && $currentImagePath !== 'default.jpg') {
            // Delete the old image
            Storage::delete($currentImagePath);
        }

        // Update the user's image path in the database
        $user->update([
            'image' => $imagePath,
        ]);

        return back()->with('profileupdatesuccess', 'Your Profile is updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
