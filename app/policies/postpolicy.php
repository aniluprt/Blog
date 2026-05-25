<?php
namespace App\policies;
use App\Models\Post;
use App\Models\User;
class postpolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->isAdmin()) {
            return true;
        }
        $writeActions = ['create', 'store', 'update', 'delete', 'publish'];
        if ($user->isGuest() && in_array($ability, $writeActions)) {
            return false;
        }

        return null;
    }

    public function view(?User $user, Post $post): bool
    {
        if ($post->is_published) {
            return true;
        }
        return $user?->id === $post->user_id;
    }

    public function create(User $user): bool
    {
        return ! $user->isGuest();
    }
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
    public function publish(User $user, Post $post): bool
    {
        return false;
    }
}
