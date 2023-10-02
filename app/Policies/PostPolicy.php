<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Post $post)
    {
        return $post->privacy === 0 || $post->user_id === $user->id;
    }
}
