@extends('layouts.public')

@section('title', config('settings.site_name', 'Bytte.no') . ' - Browse Categories')

@section('content')
<body>
    <!-- Page Header -->
    <section class="page-header-section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-5 fw-bold mb-3" style="color: var(--primary-color); font-size: 2.7rem;">Browse Categories</h1>
                    <p class="lead text-muted">Discover items organized by category</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Grid Section -->
    <section class="categories-grid-section py-5" style="background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
        <div class="container">
            @if($categories->count() > 0)
                <div class="row g-4">
                    @foreach($categories as $category)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('categories.show', $category) }}" class="text-decoration-none">
                                <div class="category-card-modern position-relative overflow-hidden" style="border-radius: 15px; background: white; box-shadow: 0 8px 25px rgba(0,0,0,0.1); transition: all 0.3s ease; height: 200px; border: 1px solid rgba(26, 105, 105, 0.1);">
                                    @if($category->image)
                                        @if(str_starts_with($category->image, 'http'))
                                            <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0">
                                        @else
                                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0">
                                        @endif
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--primary-color) 0%, #1c6c6c 100%);">
                                            <i class="fas fa-tag fa-3x text-white"></i>
                                        </div>
                                    @endif
                                    <div class="category-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-end" style="background: linear-gradient(transparent, rgba(26, 105, 105, 0.9));">
                                        <div class="category-content p-4 text-white">
                                            <h5 class="category-title fw-bold mb-2">{{ $category->name }}</h5>
                                            @if($category->description)
                                                <p class="category-description text-white-50 small mb-2" style="font-size: 0.8rem; line-height: 1.3;">{{ Str::limit($category->description, 80) }}</p>
                                            @endif
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge" style="background: #f8f0d4; color: var(--primary-color);">{{ $category->products_count }} items</span>
                                                <i class="fas fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="empty-state">
                        <i class="fas fa-tags fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted mb-3">No categories available yet</h4>
                        <p class="text-muted mb-4">Categories will be added soon. Check back later!</p>
                        <a href="{{ route('home') }}" class="btn btn-lg fw-bold" style="border-radius: 50px; background: linear-gradient(135deg, var(--primary-color) 0%, #1c6c6c 100%); color: white; border: none;">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <style>
        /* Categories Page Styles */
        .category-card-modern:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .category-overlay {
            backdrop-filter: blur(1px);
        }

        .empty-state {
            max-width: 500px;
            margin: 0 auto;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header-section h1 {
                font-size: 2rem;
            }

            .category-card-modern {
                height: 180px !important;
            }

            .category-content {
                padding: 1rem !important;
            }

            .category-title {
                font-size: 1rem !important;
            }
        }
    </style>
@endsection
