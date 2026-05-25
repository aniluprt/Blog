@extends('layouts.app')
@section('title', 'Edit Post')
@section('content')

    <div style="max-width: 600px; margin: 0 auto; padding: 30px 20px;">
        <div style="background: white; border: 1px solid #dbdbdb; border-radius: 8px; padding: 30px;">
            <h1 style="text-align: center; font-size: 24px; margin-bottom: 30px;">Edit Post</h1>

            @if($errors->any())
                <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('posts.update', $post) }}" method="POST">
                @csrf
                @method('PUT')

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Title</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Categories</label>
                    <select name="category_ids[]" multiple style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, $post->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Content</label>
                    <textarea name="body" rows="10" style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;">{{ old('body', $post->body) }}</textarea>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" name="is_published" value="1" {{ $post->is_published ? 'checked' : '' }}>
                        <span>Published</span>
                    </label>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" style="flex: 1; background: #0095f6; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">Update Post</button>
                    <a href="{{ route('posts.show', $post->slug) }}" style="flex: 1; background: #dbdbdb; color: #262626; text-align: center; padding: 10px; text-decoration: none; border-radius: 4px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
