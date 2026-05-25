<div class="post-card">
    <div class="post-card-content">
        <div class="post-meta">
            <div class="author-info">
                <div class="author-avatar">
                    {{ substr($post->user->name, 0, 2) }}
                </div>
                <span>{{ $post->user->name }}</span>
            </div>
            <span>
                <i class="far fa-calendar-alt"></i> {{ $post->created_at->format('M d, Y') }}
            </span>
            @if($post->view_count)
                <span>
                    <i class="fas fa-eye"></i> {{ $post->view_count }}
                </span>
            @endif
        </div>

        <h3>
            <a href="{{ route('posts.show', $post->slug) }}">
                {{ $post->title }}
            </a>
        </h3>

        <div class="post-excerpt">
            {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 120) }}
        </div>

        @if($post->categories->count())
            <div class="post-categories">
                @foreach($post->categories as $category)
                    <span class="category-tag">
                        <i class="fas fa-tag"></i> {{ $category->name }}
                    </span>
                @endforeach
            </div>
        @endif

        <a href="{{ route('posts.show', $post->slug) }}" class="read-more">
            Read Article <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>
