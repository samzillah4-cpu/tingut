@extends('layouts.public')

@section('title', 'Blog - ' . config('settings.site_name', 'Bytte.no'))

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-5" style="color: var(--primary-color); font-weight: 700;">Our Blog</h1>

                @if($blogs->count() > 0)
                    <div class="row">
                        @foreach($blogs as $blog)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="freecycle-card h-100">
                                <div class="card-body d-flex flex-column">
                                    @if($blog->image)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $blog->image) }}"
                                                 alt="{{ $blog->title }}"
                                                 class="w-100 rounded"
                                                 style="height: 200px; object-fit: cover;">
                                        </div>
                                    @endif

                                    <h5 class="card-title mb-3">
                                        <a href="{{ route('blogs.show', $blog) }}"
                                           class="text-decoration-none"
                                           style="color: var(--primary-color);">{{ $blog->title }}</a>
                                    </h5>

                                    <p class="card-text text-muted flex-grow-1">
                                        {{ Str::limit(strip_tags($blog->content), 150) }}
                                    </p>

                                    <div class="mt-auto">
                                        <small class="text-muted">
                                            Published on {{ $blog->published_at->format('M d, Y') }}
                                        </small>
                                        <br>
                                        <a href="{{ route('blogs.show', $blog) }}" class="btn-freecycle-outline btn-sm mt-2">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $blogs->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <p class="text-muted">No blog posts available yet. Check back soon!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
