<?php

namespace App\policies;

use App\Models\User;
use App\Models\Post;

class postpolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Post $post): bool
    {
        if ($post->is_published) {
            return true;
        }

        return $user && ($user->id === $post->user_id || $user->isAdmin());
    }

    public function create(User $user): bool
    {
        return $user !== null;
    }

    public function update(User $user, Post $post): bool
    {
        // ONLY the author can edit - Admin CANNOT edit others' posts
        return $user && $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post): bool
    {
        // Author OR Admin can delete
        return $user && ($user->id === $post->user_id || $user->isAdmin());
    }
}
