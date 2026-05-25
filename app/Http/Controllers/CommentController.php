<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post): RedirectResponse
    {
        if (auth()->user()->isGuest()) {
            abort(403, 'Guest accounts cannot post comments.');
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'min:3', 'max:100'],
        ], [
            'body.required'=> 'Please write something before posting.',
            'body.min' => 'Your comment must be at least 3 characters.',
            'body.max'=> 'Comments cannot exceed 100 characters.',
        ]);

        $post->comments()->create([
            'body' => $validated['body'],
            'user_id'=> auth()->id(),
        ]);

        return redirect()
            ->route('posts.show', $post->slug)
            ->with('success', 'Your comment has been posted!');
    }
}
