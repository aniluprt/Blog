<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index(): PostCollection
    {
        $user = auth('sanctum')->user();

        if ($user && $user->isAdmin()) {
            $posts = Post::with(['user', 'categories'])->latest()->paginate(15);
        } else {
            $posts = Post::published()->with(['user', 'categories'])->latest()->paginate(15);
        }

        return new PostCollection($posts);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $post = $request->user()->posts()->create([
            'title'        => $validated['title'],
            'slug'         => $validated['slug'],
            'body'         => $validated['body'],
            'is_published' => $validated['is_published'] ?? false,
        ]);

        if (!empty($validated['category_ids'])) {
            $post->categories()->sync($validated['category_ids']);
        }

        $post->load(['user', 'categories', 'comments']);

        return (new PostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    public function show(string $slug): PostResource
    {
        $post = Post::where('slug', $slug)
            ->with(['user', 'categories', 'comments'])
            ->firstOrFail();

        $this->authorize('view', $post);

        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        $validated = $request->validated();

        $post->update([
            'title' => $validated['title'] ?? $post->title,
            'slug'=> $validated['slug'] ?? $post->slug,
            'body' => $validated['body'] ?? $post->body,
            'is_published'=> $validated['is_published'] ?? $post->is_published,
        ]);

        if (isset($validated['category_ids'])) {
            $post->categories()->sync($validated['category_ids']);
        }

        $post->load(['user', 'categories', 'comments']);

        return new PostResource($post);
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->authorize('delete', $post);
        $post->delete();

        return response()->json(null, 204);
    }
}
