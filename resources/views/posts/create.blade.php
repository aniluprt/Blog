@extends('layouts.app')
@section('title', 'Create Post')
@section('content')

    <div style="max-width: 600px; margin: 0 auto; padding: 30px 20px;">
        <div style="background: white; border: 1px solid #dbdbdb; border-radius: 8px; padding: 30px;">
            <h1 style="text-align: center; font-size: 24px; margin-bottom: 30px;">Create New Post</h1>

            @if($errors->any())
                <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 4px; margin-bottom: 20px;">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('posts.store') }}" method="POST">
                @csrf

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;" required>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                           style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;">
                    <div style="font-size: 12px; color: #8e8e8e; margin-top: 4px;">Auto-generated from title. You can edit if needed.</div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Categories</label>
                    <select name="category_ids[]" multiple style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, old('category_ids', [])) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div style="font-size: 12px; color: #8e8e8e; margin-top: 4px;">Hold Ctrl to select multiple</div>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600;">Content</label>
                    <textarea name="body" rows="10" style="width: 100%; padding: 10px; border: 1px solid #dbdbdb; border-radius: 4px;" required>{{ old('body') }}</textarea>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: flex; align-items: center; gap: 8px;">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <span>Publish immediately</span>
                    </label>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" style="flex: 1; background: #0095f6; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-weight: 600;">Create Post</button>
                    <a href="{{ route('dashboard') }}" style="flex: 1; background: #dbdbdb; color: #262626; text-align: center; padding: 10px; text-decoration: none; border-radius: 4px;">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');

        function titleToSlug(text) {
            return text
                .toString()
                .toLowerCase()                          // Convert to lowercase
                .trim()                                 // Remove whitespace from both ends
                .replace(/\s+/g, '-')                   // Replace spaces with -
                .replace(/[^\w\-]+/g, '')               // Remove all non-word chars
                .replace(/\-\-+/g, '-')                 // Replace multiple - with single -
                .replace(/^-+/, '')                     // Trim - from start of text
                .replace(/-+$/, '');                    // Trim - from end of text
        }

        titleInput.addEventListener('input', function() {
            const titleValue = this.value;
            const slugValue = titleToSlug(titleValue);

            if (slugInput.value === '' || slugInput.getAttribute('data-user-edited') !== 'true') {
                slugInput.value = slugValue;
            }
        });

        slugInput.addEventListener('focus', function() {
            if (this.value !== '') {
                this.setAttribute('data-user-edited', 'true');
            }
        });

        if (titleInput.value && slugInput.value === '') {
            slugInput.value = titleToSlug(titleInput.value);
        }
    </script>
@endsection
