<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPostPrivacy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $postId = $request->route('post'); // Assuming the route parameter is 'post'

        $post = Post::findOrFail($postId);
    
        if ($post->privacy === 0 || ($post->privacy === 1 && $post->user_id === auth()->id())) {
            return $next($request);
        }
    
        // If the user doesn't have access, you can redirect or return an error response.
        return abort(403, 'You do not have permission to access this post.');
    }
}
