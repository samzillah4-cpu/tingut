@extends('layouts.public')

@section('title', $blog->title . ' - ' . config('settings.site_name', 'Bytte.no'))

@section('head')
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $blog->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($blog->content), 160) }}">
    @if($blog->image)
        <meta property="og:image" content="{{ asset('storage/' . $blog->image) }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
    @endif
    <meta property="og:site_name" content="{{ config('settings.site_name', 'Bytte.no') }}">
    <meta property="article:published_time" content="{{ $blog->published_at->toISOString() }}">
    <meta property="article:modified_time" content="{{ $blog->updated_at->toISOString() }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $blog->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($blog->content), 160) }}">
    @if($blog->image)
        <meta name="twitter:image" content="{{ asset('storage/' . $blog->image) }}">
    @endif

    <!-- Additional Meta Tags -->
    <meta name="description" content="{{ Str::limit(strip_tags($blog->content), 160) }}">
    <meta name="keywords" content="blog, {{ config('settings.site_name', 'Bytte.no') }}, {{ $blog->title }}">
    <meta name="author" content="{{ config('settings.site_name', 'Bytte.no') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Article Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": "{{ $blog->title }}",
        "description": "{{ Str::limit(strip_tags($blog->content), 160) }}",
        "image": [
            @if($blog->image)
                "{{ asset('storage/' . $blog->image) }}"
            @else
                "{{ asset('images/default-blog.jpg') }}"
            @endif
        ],
        "datePublished": "{{ $blog->published_at->format('Y-m-d\TH:i:sP') }}",
        "dateModified": "{{ $blog->updated_at->format('Y-m-d\TH:i:sP') }}",
        "author": {
            "@type": "Organization",
            "name": "{{ config('settings.site_name', 'Bytte.no') }}"
        },
        "publisher": {
            "@type": "Organization",
            "name": "{{ config('settings.site_name', 'Bytte.no') }}",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('images/logo.png') }}"
            }
        },
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ url()->current() }}"
        },
        "url": "{{ url()->current() }}"
    }
    </script>
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Blog Post -->
                <article class="mb-5">
                    @if($blog->image)
                        <div class="mb-4">
                            <img src="{{ asset('storage/' . $blog->image) }}"
                                 alt="{{ $blog->title }}"
                                 class="w-100 rounded shadow"
                                 style="max-height: 400px; object-fit: cover;">
                        </div>
                    @endif

                    <header class="mb-4">
                        <h1 class="mb-3" style="color: var(--primary-color); font-weight: 700;">{{ $blog->title }}</h1>
                        <div class="d-flex align-items-center text-muted">
                            <small>
                                Published on {{ $blog->published_at->format('F d, Y') }}
                                @if($blog->published_at != $blog->created_at)
                                    (Updated {{ $blog->updated_at->format('F d, Y') }})
                                @endif
                            </small>
                        </div>
                    </header>

                    <div class="blog-content">
                        {!! $blog->content !!}
                    </div>

                    <!-- Social Share Buttons -->
                    <div class="mt-4 pt-4 border-top">
                        <h5 class="mb-3" style="color: var(--primary-color);">Share this article</h5>
                        <div class="d-flex flex-wrap gap-2">
                            <!-- Facebook Share -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                               target="_blank"
                               class="btn btn-outline-primary btn-sm d-flex align-items-center"
                               onclick="window.open(this.href, 'facebook-share', 'width=600,height=400'); return false;">
                                <i class="fab fa-facebook-f me-2"></i>Facebook
                            </a>

                            <!-- Twitter Share -->
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}"
                               target="_blank"
                               class="btn btn-outline-info btn-sm d-flex align-items-center"
                               onclick="window.open(this.href, 'twitter-share', 'width=600,height=400'); return false;">
                                <i class="fab fa-twitter me-2"></i>Twitter
                            </a>

                            <!-- LinkedIn Share -->
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                               target="_blank"
                               class="btn btn-outline-primary btn-sm d-flex align-items-center"
                               onclick="window.open(this.href, 'linkedin-share', 'width=600,height=400'); return false;">
                                <i class="fab fa-linkedin-in me-2"></i>LinkedIn
                            </a>

                            <!-- WhatsApp Share -->
                            <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . url()->current()) }}"
                               target="_blank"
                               class="btn btn-outline-success btn-sm d-flex align-items-center">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp
                            </a>

                            <!-- Copy Link -->
                            <button type="button"
                                    class="btn btn-outline-secondary btn-sm d-flex align-items-center"
                                    onclick="copyToClipboard('{{ url()->current() }}')">
                                <i class="fas fa-link me-2"></i>Copy Link
                            </button>
                        </div>
                    </div>
                </article>

                <!-- Comments Section -->
                <section class="comments-section mt-5 pt-4 border-top">
                    <h3 class="mb-4" style="color: var(--primary-color); font-weight: 600;">Comments ({{ $comments->count() }})</h3>

                    <!-- Comment Form (only for authenticated users) -->
                    @auth
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Leave a Comment</h5>
                            <form action="{{ route('blogs.comments.store', $blog) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <textarea class="form-control" id="content" name="content" rows="4"
                                              placeholder="Share your thoughts about this article..."
                                              required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Post Comment</button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Please login to comment.</strong>
                        <a href="#" class="alert-link" data-bs-toggle="modal" data-bs-target="#loginModal">Login here</a> or
                        <a href="#" class="alert-link" data-bs-toggle="modal" data-bs-target="#signupModal">create an account</a>.
                    </div>
                    @endauth

                    <!-- Comments List -->
                    @if($comments->count() > 0)
                        <div class="comments-list">
                            @foreach($comments as $comment)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="me-3">
                                            @if($comment->user->profile_picture ?? false)
                                                <img src="{{ asset('storage/' . $comment->user->profile_picture) }}"
                                                     alt="{{ $comment->user->name }}"
                                                     class="rounded-circle"
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                                     style="width: 50px; height: 50px; font-size: 1.2rem;">
                                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-1 fw-bold" style="color: var(--primary-color);">{{ $comment->user->name }}</h6>
                                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            <p class="mb-0">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">No comments yet. Be the first to share your thoughts!</p>
                        </div>
                    @endif
                </section>

                <!-- Back to Blogs -->
                <div class="text-center mb-5">
                    <a href="{{ route('blogs.index') }}" class="btn-freecycle-outline">← Back to All Blogs</a>
                </div>

                <!-- Related Blogs -->
                @if($relatedBlogs->count() > 0)
                <section class="related-blogs">
                    <h3 class="mb-4 text-center" style="color: var(--primary-color); font-weight: 600;">Related Articles</h3>
                    <div class="row">
                        @foreach($relatedBlogs as $relatedBlog)
                        <div class="col-md-4 mb-4">
                            <div class="freecycle-card h-100">
                                <div class="card-body d-flex flex-column">
                                    @if($relatedBlog->image)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $relatedBlog->image) }}"
                                                 alt="{{ $relatedBlog->title }}"
                                                 class="w-100 rounded"
                                                 style="height: 150px; object-fit: cover;">
                                        </div>
                                    @endif

                                    <h6 class="card-title mb-2">
                                        <a href="{{ route('blogs.show', $relatedBlog) }}"
                                           class="text-decoration-none"
                                           style="color: var(--primary-color);">{{ Str::limit($relatedBlog->title, 50) }}</a>
                                    </h6>

                                    <p class="card-text text-muted small flex-grow-1">
                                        {{ Str::limit(strip_tags($relatedBlog->content), 80) }}
                                    </p>

                                    <div class="mt-auto">
                                        <small class="text-muted">
                                            {{ $relatedBlog->published_at->format('M d, Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif
            </div>
        </div>
    </div>

</section>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
        button.classList.remove('btn-outline-secondary');
        button.classList.add('btn-success');

        setTimeout(function() {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
    }).catch(function(err) {
        console.error('Failed to copy: ', err);
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        try {
            document.execCommand('copy');
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-check me-2"></i>Copied!';
            button.classList.remove('btn-outline-secondary');
            button.classList.add('btn-success');

            setTimeout(function() {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-secondary');
            }, 2000);
        } catch (err) {
            console.error('Fallback copy failed: ', err);
        }
        document.body.removeChild(textArea);
    });
}
</script>
@endsection
