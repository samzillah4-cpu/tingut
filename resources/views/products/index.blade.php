@extends('layouts.public')

@section('title', config('settings.site_name', 'TingUt.no') . ' - ' . ucfirst(request('listing_type', 'sale')))

@section('content')
    @php
        $currentType = request('listing_type', 'sale');
        $pageTitles = [
            'sale' => 'Browse Garage Sale Items',
            'exchange' => 'Browse Exchange Items',
            'giveaway' => 'Browse Free Giveaways'
        ];
        $pageDescriptions = [
            'sale' => 'Buy items from our community marketplace',
            'exchange' => 'Find items to trade with our community',
            'giveaway' => 'Discover free items being given away'
        ];
    @endphp

    <!-- Page Header -->
    <section class="page-header py-3" style="background: linear-gradient(135deg, var(--primary-color) 0%, #1c6c6c 100%); position: relative; overflow: hidden;">
        <div class="container-fluid px-5">
            <div class="row align-items-center">
                <div class="col-lg-8 text-white">
                    <h1 class="h2 fw-bold mb-2">{{ $pageTitles[$currentType] ?? 'Browse Items' }}</h1>
                    <p class="mb-3 opacity-90" style="font-size: 1rem;">{{ $pageDescriptions[$currentType] ?? 'Find items from our community' }}</p>
                    <div class="d-flex flex-wrap gap-2">
                        <div class="stat-badge bg-white bg-opacity-20 px-2 py-1 rounded-pill" style="font-size: 0.8rem;">
                            <span class="fw-bold">{{ $products->total() }}</span> Products
                        </div>
                        <div class="stat-badge bg-white bg-opacity-20 px-2 py-1 rounded-pill" style="font-size: 0.8rem;">
                            <span class="fw-bold">{{ $categories->count() }}</span> Categories
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="header-icon">
                        <i class="fas fa-shopping-bag fa-4x text-white opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-decoration">
            <div class="floating-circle circle-1"></div>
            <div class="floating-circle circle-2"></div>
            <div class="floating-circle circle-3"></div>
        </div>
    </section>

    <!-- Advanced Filters Section -->
    <section class="filters-section py-4 bg-light border-bottom">
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col-12">
                    <form method="GET" id="filtersForm" class="filters-form">
                        <div class="row g-2 align-items-end">
                            <!-- Search Input -->
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label fw-bold text-dark small">Search</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0" style="background-color: #0f545a; color: white;">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="form-control border-0 ps-0" style="box-shadow: none; border-radius: 0 6px 6px 0; font-size: 0.9rem;">
                                </div>
                            </div>

                            <!-- Category Filter -->
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label class="form-label fw-bold text-dark small">Category</label>
                                <select name="category_id" class="form-select" style="border-radius: 6px; border-color: #dee2e6; font-size: 0.9rem;">
                                    <option value="">All</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Listing Type Filter -->
                            <div class="col-lg-1 col-md-4 col-sm-6">
                                <label class="form-label fw-bold text-dark small">Type</label>
                                <select name="listing_type" class="form-select" style="border-radius: 6px; border-color: #dee2e6; font-size: 0.9rem;">
                                    <option value="sale" {{ request('listing_type', 'sale') == 'sale' ? 'selected' : '' }}>Sale</option>
                                    <option value="exchange" {{ request('listing_type') == 'exchange' ? 'selected' : '' }}>Exchange</option>
                                    <option value="giveaway" {{ request('listing_type') == 'giveaway' ? 'selected' : '' }}>Giveaway</option>
                                </select>
                            </div>

                            <!-- Location Filter -->
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <label class="form-label fw-bold text-dark small">Location</label>
                                <select name="location" class="form-select" style="border-radius: 6px; border-color: #dee2e6; font-size: 0.9rem;">
                                    <option value="">All</option>
                                    @php
                                        $locations = \App\Models\User::whereHas('products', function($q) {
                                                $q->where('status', 'active');
                                            })
                                            ->whereNotNull('location')
                                            ->distinct()
                                            ->pluck('location')
                                            ->sort();
                                    @endphp
                                    @foreach($locations as $location)
                                        <option value="{{ $location }}" {{ request('location') == $location ? 'selected' : '' }}>
                                            {{ $location }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sort Options -->
                            <div class="col-lg-2 col-md-6 col-sm-6">
                                <label class="form-label fw-bold text-dark small">Sort</label>
                                <select name="sort" class="form-select" style="border-radius: 6px; border-color: #dee2e6; font-size: 0.9rem;">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                    <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>A-Z</option>
                                    <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Z-A</option>
                                </select>
                            </div>

                            <!-- View & Actions -->
                            <div class="col-lg-2 col-md-6 col-sm-12">
                                <label class="form-label fw-bold text-dark small">View</label>
                                <div class="d-flex gap-1">
                                    <div class="btn-group flex-fill" role="group">
                                        <input type="radio" class="btn-check" name="view" id="gridView" value="grid" {{ request('view', 'grid') == 'grid' ? 'checked' : '' }}>
                                        <label class="btn btn-sm" for="gridView" style="border-radius: 6px 0 0 6px; background-color: #0f545a; color: white; border-color: #0f545a; padding: 0.4rem 0.6rem;">
                                            <i class="fas fa-th"></i>
                                        </label>
                                        <input type="radio" class="btn-check" name="view" id="listView" value="list" {{ request('view') == 'list' ? 'checked' : '' }}>
                                        <label class="btn btn-sm" for="listView" style="border-radius: 0 6px 6px 0; background-color: #0f545a; color: white; border-color: #0f545a; padding: 0.4rem 0.6rem;">
                                            <i class="fas fa-list"></i>
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn-sm" style="border-radius: 6px; background-color: #0f545a; color: white; border-color: #0f545a; padding: 0.4rem 0.8rem;">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                    @if(request()->hasAny(['search', 'category_id', 'location', 'sort']))
                                        <a href="{{ route('products.index') }}" class="btn btn-sm" style="border-radius: 6px; background-color: #0f545a; color: white; border-color: #0f545a; padding: 0.4rem 0.6rem;" title="Clear Filters">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products-section py-5">
        <div class="container-fluid px-5">
            <!-- Results Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="results-info">
                            @if($products->total() > 0)
                                <h5 class="mb-0 text-dark">
                                    <i class="fas fa-box me-2 text-primary"></i>
                                    Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} products
                                </h5>
                            @else
                                <h5 class="mb-0 text-muted">
                                    <i class="fas fa-search me-2"></i>
                                    No products found
                                </h5>
                            @endif
                        </div>
                        @if($products->hasPages())
                            <div class="pagination-info text-muted">
                                Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($products->count() > 0)
                <!-- Products Grid/List View -->
                <div class="row g-4" id="productsContainer">
                    @foreach($products as $product)
                        @if(request('view') == 'list')
                            <!-- List View -->
                            <div class="col-12">
                                <div class="product-card-list h-100" style="border-radius: 15px; background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid rgba(26, 105, 105, 0.1); overflow: hidden;">
                                    <div class="row g-0 h-100">
                                        <div class="col-md-4">
                                            @if($product->images && count($product->images) > 0)
                                                <div class="product-image-list position-relative" style="height: 200px; overflow: hidden;">
                                                    @if(str_starts_with($product->images[0], 'http'))
                                                        <img src="{{ $product->images[0] }}" alt="{{ $product->title }}" class="w-100 h-100 object-fit-cover">
                                                    @else
                                                        <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->title }}" class="w-100 h-100 object-fit-cover">
                                                    @endif
                                                    <div class="product-overlay-list position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(26, 105, 105, 0.8); opacity: 0; transition: opacity 0.3s ease;">
                                                        <a href="{{ route('products.show', $product) }}" class="btn btn-light btn-lg">View Details</a>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="product-image-list d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, var(--primary-color), #1c6c6c);">
                                                    <i class="fas fa-image fa-3x text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-8">
                                            <div class="product-content-list p-4 h-100 d-flex flex-column">
                                                <div class="d-flex justify-content-between align-items-start mb-3">
                                                    <div class="flex-grow-1">
                                                        <h4 class="product-title-list fw-bold mb-2" style="color: var(--primary-color);">
                                                            <a href="{{ route('products.show', $product) }}" class="text-decoration-none">{{ $product->title }}</a>
                                                        </h4>
                                                        <div class="product-meta-list d-flex flex-wrap gap-3 mb-3">
                                                            <span class="badge" style="background: #1c6c6c; color: white;">
                                                                <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                                                            </span>
                                                            @if($product->listing_type == 'sale')
                                                                <span class="badge" style="background: #28a745; color: white;">
                                                                    <i class="fas fa-shopping-cart me-1"></i>Sale
                                                                </span>
                                                            @elseif($product->listing_type == 'exchange')
                                                                <span class="badge" style="background: #ffc107; color: black;">
                                                                    <i class="fas fa-exchange-alt me-1"></i>Exchange
                                                                </span>
                                                            @endif
                                                            @if($product->is_giveaway)
                                                                <span class="badge" style="background: #dc3545; color: white;">
                                                                    <i class="fas fa-gift me-1"></i>GIVEAWAY
                                                                </span>
                                                            @elseif($product->listing_type == 'giveaway')
                                                                <span class="badge" style="background: #17a2b8; color: white;">
                                                                    <i class="fas fa-gift me-1"></i>Giveaway
                                                                </span>
                                                            @endif
                                                            @if($product->location)
                                                                <span class="badge bg-light text-dark">
                                                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $product->location }}
                                                                </span>
                                                            @endif
                                                            <span class="badge bg-light text-dark">
                                                                <i class="fas fa-calendar me-1"></i>{{ $product->created_at->diffForHumans() }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="product-description-list text-muted mb-3 flex-grow-1">
                                                    @if($product->short_description)
                                                        {{ Str::limit($product->short_description, 200) }}
                                                    @else
                                                        {{ Str::limit($product->description, 200) }}
                                                    @endif
                                                </p>
                                                @if($product->listing_type == 'sale' && $product->sale_price)
                                                    <div class="price-info mb-3">
                                                        <span class="fw-bold text-success fs-5">
                                                            NOK {{ number_format($product->sale_price, 0) }}
                                                        </span>
                                                    </div>
                                                @elseif($product->is_giveaway)
                                                    <div class="price-info mb-3">
                                                        <span class="fw-bold text-danger fs-5">
                                                            <i class="fas fa-gift me-1"></i>FREE GIVEAWAY
                                                        </span>
                                                    </div>
                                                @elseif($product->listing_type == 'giveaway')
                                                    <div class="price-info mb-3">
                                                        <span class="fw-bold text-primary fs-5">
                                                            <i class="fas fa-gift me-1"></i>FREE
                                                        </span>
                                                    </div>
                                                @endif
                                                <div class="product-footer-list d-flex justify-content-between align-items-center">
                                                    <div class="seller-info">
                                                        <small class="text-muted">
                                                            <i class="fas fa-user me-1"></i>
                                                            <a href="{{ route('sellers.products', $product->user) }}" class="text-decoration-none" style="color: var(--primary-color);">
                                                                {{ $product->user->name }}
                                                            </a>
                                                        </small>
                                                    </div>
                                                    <a href="{{ route('products.show', $product) }}" class="btn btn-primary px-4 py-2" style="border-radius: 25px;">
                                                        <i class="fas fa-eye me-1"></i>View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Grid View -->
                            <div class="col-xl-3 col-lg-4 col-md-6">
                                <div class="product-card-grid h-100" style="border-radius: 15px; background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid rgba(26, 105, 105, 0.1); overflow: hidden;">
                                    @if($product->images && count($product->images) > 0)
                                        <div class="product-image-grid position-relative" style="height: 200px; overflow: hidden;">
                                            @if(str_starts_with($product->images[0], 'http'))
                                                <img src="{{ $product->images[0] }}" alt="{{ $product->title }}" class="w-100 h-100 object-fit-cover" style="transition: transform 0.3s ease;">
                                            @else
                                                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->title }}" class="w-100 h-100 object-fit-cover" style="transition: transform 0.3s ease;">
                                            @endif
                                            <div class="product-overlay-grid position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(26, 105, 105, 0.8); opacity: 0; transition: opacity 0.3s ease;">
                                                <a href="{{ route('products.show', $product) }}" class="btn btn-light btn-lg">View Details</a>
                                            </div>
                                        </div>
                                    @else
                                        <div class="product-image-grid d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, var(--primary-color), #1c6c6c);">
                                            <i class="fas fa-image fa-3x text-white"></i>
                                        </div>
                                    @endif
                                    <div class="product-content-grid p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="product-title-grid fw-bold mb-0" style="color: var(--primary-color); font-size: 0.95rem;">
                                                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none">{{ Str::limit($product->title, 35) }}</a>
                                                </h6>
                                            </div>
                                            <p class="product-description-grid text-muted small mb-3" style="font-size: 0.8rem; line-height: 1.3;">
                                                @if($product->short_description)
                                                    {{ Str::limit($product->short_description, 70) }}
                                                @else
                                                    {{ Str::limit($product->description, 70) }}
                                                @endif
                                            </p>
                                        <div class="product-meta-grid d-flex justify-content-between align-items-center mb-3">
                                            <div class="category-badge">
                                                <span class="badge badge-sm" style="background: #1c6c6c; color: white; font-size: 0.7rem;">
                                                    {{ $product->category->name }}
                                                </span>
                                                @if($product->listing_type == 'sale')
                                                    <span class="badge badge-sm ms-1" style="background: #28a745; color: white; font-size: 0.7rem;">
                                                        <i class="fas fa-shopping-cart me-1"></i>Sale
                                                    </span>
                                                @elseif($product->listing_type == 'exchange')
                                                    <span class="badge badge-sm ms-1" style="background: #ffc107; color: black; font-size: 0.7rem;">
                                                        <i class="fas fa-exchange-alt me-1"></i>Exchange
                                                    </span>
                                                @endif
                                                @if($product->is_giveaway)
                                                    <span class="badge badge-sm ms-1" style="background: #dc3545; color: white; font-size: 0.7rem; animation: pulse 2s infinite;">
                                                        <i class="fas fa-gift me-1"></i>GIVEAWAY
                                                    </span>
                                                @elseif($product->listing_type == 'giveaway')
                                                    <span class="badge badge-sm ms-1" style="background: #17a2b8; color: white; font-size: 0.7rem;">
                                                        <i class="fas fa-gift me-1"></i>Giveaway
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="date-info">
                                                <small class="text-muted" style="font-size: 0.7rem;">
                                                    <i class="fas fa-clock me-1"></i>{{ $product->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                        </div>
                                        @if($product->listing_type == 'sale' && $product->sale_price)
                                            <div class="price-info mb-2">
                                                <span class="fw-bold text-success" style="font-size: 1.1rem;">
                                                    NOK {{ number_format($product->sale_price, 0) }}
                                                </span>
                                            </div>
                                        @elseif($product->is_giveaway)
                                            <div class="price-info mb-2">
                                                <span class="fw-bold text-danger" style="font-size: 1.1rem;">
                                                    <i class="fas fa-gift me-1"></i>FREE GIVEAWAY
                                                </span>
                                            </div>
                                        @elseif($product->listing_type == 'giveaway')
                                            <div class="price-info mb-2">
                                                <span class="fw-bold text-primary" style="font-size: 1.1rem;">
                                                    <i class="fas fa-gift me-1"></i>FREE
                                                </span>
                                            </div>
                                        @endif
                                        <div class="product-footer-grid d-flex justify-content-between align-items-center">
                                            <div class="seller-info">
                                                <small class="text-muted" style="font-size: 0.75rem;">
                                                    <i class="fas fa-user me-1"></i>
                                                    <a href="{{ route('sellers.products', $product->user) }}" class="text-decoration-none" style="color: var(--primary-color);">
                                                        {{ Str::limit($product->user->name, 15) }}
                                                    </a>
                                                </small>
                                            </div>
                                        </div>
                                        @if($product->location)
                                            <div class="location-info mt-2">
                                                <small class="text-muted" style="font-size: 0.7rem;">
                                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $product->location }}
                                                </small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="row mt-5">
                        <div class="col-12">
                            <nav aria-label="Products pagination">
                                <ul class="pagination justify-content-center">
                                    {{-- Previous Page Link --}}
                                    @if ($products->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link" style="border-radius: 8px 0 0 8px;">Previous</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->previousPageUrl() }}" style="border-radius: 8px 0 0 8px; border-color: var(--primary-color); color: var(--primary-color);">Previous</a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                        @if ($page == $products->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link" style="background: var(--primary-color); border-color: var(--primary-color);">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}" style="border-color: var(--primary-color); color: var(--primary-color);">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($products->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $products->nextPageUrl() }}" style="border-radius: 0 8px 8px 0; border-color: var(--primary-color); color: var(--primary-color);">Next</a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link" style="border-radius: 0 8px 8px 0;">Next</span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="row">
                    <div class="col-12">
                        <div class="empty-state text-center py-5">
                            <div class="empty-state-icon mb-4">
                                <i class="fas fa-search fa-5x text-muted"></i>
                            </div>
                            <h3 class="text-muted mb-3">No products found</h3>
                            <p class="text-muted mb-4" style="font-size: 1.1rem;">Try adjusting your search criteria or browse all available products.</p>
                            @if(request()->hasAny(['search', 'category_id', 'location', 'sort']))
                                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4 py-3" style="border-radius: 50px;">
                                    <i class="fas fa-times me-2"></i>Clear All Filters
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <style>
        /* Page Header Styles */
        .page-header {
            position: relative;
            min-height: 150px;
        }

        .stat-badge {
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
        }

        .header-icon {
            animation: float 3s ease-in-out infinite;
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            animation: float 6s ease-in-out infinite;
        }

        .circle-1 {
            width: 100px;
            height: 100px;
            top: 10%;
            right: 10%;
            animation-delay: 0s;
        }

        .circle-2 {
            width: 60px;
            height: 60px;
            top: 60%;
            right: 20%;
            animation-delay: 2s;
        }

        .circle-3 {
            width: 80px;
            height: 80px;
            bottom: 10%;
            left: 15%;
            animation-delay: 4s;
        }

        /* Filters Section */
        .filters-form {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .form-label {
            color: #374151;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        /* Product Cards */
        .product-card-grid:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }

        .product-card-list:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }

        .product-card-grid:hover .product-image-grid img {
            transform: scale(1.1);
        }

        .product-card-list:hover .product-image-list {
            transform: scale(1.02);
        }

        .product-card-grid:hover .product-overlay-grid,
        .product-card-list:hover .product-overlay-list {
            opacity: 1;
        }

        .badge-sm {
            font-size: 0.65rem;
            padding: 0.25rem 0.5rem;
        }

        /* Pagination */
        .pagination .page-link {
            border-radius: 8px !important;
            margin: 0 2px;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 500;
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .pagination .page-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        /* Empty State */
        .empty-state-icon {
            opacity: 0.3;
            animation: pulse 2s infinite;
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .filters-form .row > div {
                margin-bottom: 1rem;
            }

            .stat-badge {
                font-size: 0.8rem;
                padding: 0.5rem 1rem;
            }

            .product-card-list .col-md-4,
            .product-card-list .col-md-8 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .product-image-list {
                height: 150px !important;
            }

            .pagination {
                flex-wrap: wrap;
            }

            .page-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
            }
        }

        @media (max-width: 576px) {
            .page-header {
                padding: 2rem 0;
            }

            .display-4 {
                font-size: 2rem;
            }

            .filters-form {
                padding: 1.5rem;
            }

            .btn-group .btn {
                padding: 0.5rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #1c6c6c;
        }

        /* Loading States */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit form when filters change
            const filterInputs = document.querySelectorAll('#filtersForm input, #filtersForm select');
            filterInputs.forEach(input => {
                input.addEventListener('change', function() {
                    // Add loading state
                    const container = document.getElementById('productsContainer');
                    if (container) {
                        container.style.opacity = '0.5';
                        container.style.pointerEvents = 'none';
                    }

                    // Submit form
                    document.getElementById('filtersForm').submit();
                });
            });

            // View toggle functionality
            const viewInputs = document.querySelectorAll('input[name="view"]');
            viewInputs.forEach(input => {
                input.addEventListener('change', function() {
                    document.getElementById('filtersForm').submit();
                });
            });

            // Smooth scroll to results on filter change
            if (window.location.search) {
                const resultsSection = document.querySelector('.products-section');
                if (resultsSection) {
                    resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    </script>
@endsection
