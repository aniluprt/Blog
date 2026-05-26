<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'categories', 'comments']);

        if (!$request->user()) {
            $query->published();
        } elseif (!$request->user()->isAdmin()) {
            $query->where(function($q) use ($request) {
                $q->published()->orWhere('user_id', $request->user()->id);
            });
        }

        $posts = $query->latest()->paginate(15);
        return new PostCollection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        $slug = empty($validated['slug']) ? Str::slug($validated['title']) : Str::slug($validated['slug']);
        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $post = $request->user()->posts()->create([
            'title' => $validated['title'],
            'slug' => $slug,
            'body' => $validated['body'],
            'is_published' => $validated['is_published'] ?? false,
        ]);

        if (isset($validated['category_ids'])) {
            $post->categories()->attach($validated['category_ids']);
        }
        $post->load(['user', 'categories', 'comments']);
        return (new PostResource($post))
            ->additional(['message' => 'Post created successfully'])
            ->response()
            ->setStatusCode(201);
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->with(['user', 'categories', 'comments.user'])
            ->firstOrFail();

        if (!$post->is_published && auth()->id() !== $post->user_id && !auth()->user()?->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validated();

        if (isset($validated['slug']) && !empty($validated['slug'])) {
            $slug = Str::slug($validated['slug']);
        } elseif (isset($validated['title'])) {
            $slug = Str::slug($validated['title']);
        } else {
            $slug = $post->slug;
        }

        if ($slug !== $post->slug) {
            $originalSlug = $slug;
            $counter = 1;
            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $post->update([
            'title' => $validated['title'] ?? $post->title,
            'slug' => $slug,
            'body' => $validated['body'] ?? $post->body,
            'is_published' => $validated['is_published'] ?? $post->is_published,
        ]);

        if (isset($validated['category_ids'])) {
            $post->categories()->sync($validated['category_ids']);
        }

        $post->load(['user', 'categories', 'comments']);

        return (new PostResource($post))
            ->additional(['message' => 'Post updated successfully']);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json(['message' => 'Post deleted successfully'], 204);
    }
}
