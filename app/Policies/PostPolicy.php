<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function update(mixed $user, Post $post): bool
    {
        if ($user instanceof Admin) {
            return true;
        }

        return $user instanceof User && $user->id === $post->user_id;
    }

    public function delete(mixed $user, Post $post): bool
    {
        if ($user instanceof Admin) {
            return true;
        }

        return $user instanceof User && $user->id === $post->user_id;
    }
}
