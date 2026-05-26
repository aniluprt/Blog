<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'categories'])
            ->published()
            ->latest()
            ->paginate(8);

        return view('posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::with(['user', 'comments.user', 'categories'])
            ->where('slug', $slug)
            ->firstOrFail();

        if (!$post->is_published && !auth()->user()?->isAdmin()) {     //can see unpublished post too by admin
            abort(404);
        }

        $post->increment('view_count');

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();
        if (empty($validated['slug'])) {
            $slug = Str::slug($validated['title']);
        } else {
            $slug = Str::slug($validated['slug']);
        }

        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $post = auth()->user()->posts()->create([
            'title' => $validated['title'],
            'slug' => $slug,
            'body' => $validated['body'],
            'is_published' => $validated['is_published'] ?? false,
        ]);

        if (isset($validated['category_ids'])) {
            $post->categories()->attach($validated['category_ids']);
        }

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Your post has been created successfully!');
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
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

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Post deleted successfully!');
    }

    public function dashboard()
    {
        $posts = auth()->user()->posts()
            ->with('categories')
            ->latest()
            ->paginate(10);

        return view('dashboard', compact('posts'));
    }
}
