<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

        $request->validate([
            'content' => 'required|max:255',
        ]);

        // Create a new comment
        $comment = new Comments();
        $comment->user_id = $request->input('userID');
        $comment->post_id = $request->input('postId');
        $comment->content = $request->input('content');
        $comment->save();

        // Redirect back to the post with a success message
        return redirect()->back()->with('success', 'Comment submitted successfully');
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
    // Update a comment
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'content' => 'required|string|max:255', // Add any other validation rules you need
        ]);

        // Find the comment by its ID
        $comment = Comments::findOrFail($id);

        // Update the comment's content
        $comment->content = $request->input('content');
        $comment->save();

        return redirect()->back()->with('success', 'Comment updated successfully');
    }



    // Delete a comment
    public function destroy($id)
    {
        // Find the comment by its ID
        $comment = Comments::findOrFail($id);

        // Delete the comment
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully');
    }
}
