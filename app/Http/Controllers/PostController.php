<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the three latest posts
        $latestPosts = Post::latest()->take(3)->get();
        // dd($latestPosts);

        return view('welcome', compact('latestPosts'));
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
        // Validate the incoming data
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'privacy' => 'required|in:0,1',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        // Create the post
        $post = new Post();
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->privacy = $validatedData['privacy'];
        $post->user_id = $request->userid;

        // Save the image if provided
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images/postimages');
            $post->image = $imagePath;
        }

        $post->save();

        // Attach categories to the post
        $post->categories()->attach($validatedData['category_ids']);

        return redirect()
            ->back()
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()->back()->with('error', 'Post not found.');
        }
        // Check if the post is public (privacy = 0) or if the authenticated user owns the post
        if ($post->privacy === 0 || (auth()->check() && $post->user_id === auth()->user()->id)) {
            // Proceed if the post is public or if the authenticated user owns the post

            $user = User::find($post->user_id);

            if (!$user) {
                $userName = "User not found";
            } else {
                $userName = $user->name;
            }

            // related post
            // Find the hero section post by its ID

            if (!$post) {
                abort(404); // Handle the case where the post is not found
            }

            // Retrieve the category ID of the hero section post
            $categoryId = DB::table('categories_posts')
                ->where('post_id', $post->id)
                ->value('category_id');

            // Retrieve related posts by category, excluding privacy mode 1
            $relatedPosts = Post::whereHas('categories', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })
                ->where('id', '!=', $post->id) // Exclude the hero section post itself
                ->where('privacy', '!=', 1) // Exclude posts with privacy mode 1
                ->inRandomOrder() // Retrieve related posts in random order
                ->limit(3) // Limit the number of related posts to display
                ->get();


            // Retrieve the category names of the hero section post
            $categoryNames = DB::table('categories')
                ->join('categories_posts', 'categories.id', '=', 'categories_posts.category_id')
                ->where('categories_posts.post_id', $post->id)
                ->pluck('categories.name');

            return view('postdetails', compact(['post', 'userName', 'relatedPosts', 'categoryNames']));
        } else {
            // If the post is private (privacy = 1) and the authenticated user doesn't own the post, deny access
            return redirect()->back()->with('error', 'Access denied.');
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $posts = Post::find($id);
        $categories = Category::all();
        return view('postedit', compact(['posts', 'categories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'privacy' => 'required|in:0,1',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
        ]);

        // Find the post by ID
        $post = Post::find($id);

        // Check if the post exists
        if (!$post) {
            return redirect()
                ->back()
                ->with('error', 'Post not found.');
        }

        // Update the post data
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->privacy = $validatedData['privacy'];

        // Update the image if provided
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($post->image) {
                Storage::delete($post->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('public/images/postimages');
            $post->image = $imagePath;
        }

        // Save the updated post
        $post->save();

        // Sync the categories for the post
        $post->categories()->sync($validatedData['category_ids']);

        return redirect()
            ->route('user.index')
            ->with('PostEditSucc', 'Post is successfully edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if (!$post) {
            return redirect()
                ->back()
                ->with('error', 'Post not found.');
        }

        if ($post->image) {
            Storage::delete($post->image);
        }

        $post->categories()->detach();

        $post->delete();

        return redirect()
            ->back()
            ->with('success', 'Post deleted successfully.');
    }
}
