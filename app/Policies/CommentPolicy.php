<?php

namespace App\Policies;

use App\Models\Comments;
use App\Models\User;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Comments $comment){
        return $user->id === $comment->user_id;
    }

    public function delete(User $user, Comments $comment){
        return $user->id === $comment->user_id;
    }
}
