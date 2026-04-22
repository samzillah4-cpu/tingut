@extends('layouts.public')

@section('title', $category->name . ' - ' . config('settings.site_name', 'Bytte.no'))

@section('content')
<style>
    /* Finn.no Inspired Styles for Real Estate Category */
    :root {
        --primary-color: #0f5057;
        --primary-dark: #0a3d42;
        --secondary-color: #faf4d7;
        --finn-blue: #0f5057;
        --finn-bg: #f5f5f5;
        --finn-card-bg: #ffffff;
        --finn-text: #333333;
        --finn-text-light: #666666;
        --finn-border: #e0e0e0;
    }

    .finn-main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px 15px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 24px;
        font-weight: 600;
        color: var(--finn-text);
        margin: 0;
    }

    .section-count {
        font-size: 14px;
        color: var(--finn-text-light);
        margin-top: 4px;
    }

    /* Filter Bar Styles */
    .filter-bar {
        background: var(--secondary-color);
        border: 1px solid var(--finn-border);
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
    }

    .filter-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-group.small {
        flex: 0 0 auto;
        min-width: 150px;
    }

    .filter-label {
        display: block;
        font-size: 12px;
        font-weight: 500;
        color: var(--finn-text-light);
        margin-bottom: 6px;
    }

    .filter-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--finn-border);
        border-radius: 4px;
        font-size: 14px;
        transition: all 0.2s ease;
        background: white;
    }

    .filter-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(15, 80, 87, 0.1);
    }

    .btn-filter {
        padding: 10px 20px;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-filter:hover {
        background: var(--primary-dark);
    }

    .btn-clear {
        padding: 10px 16px;
        background: transparent;
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-clear:hover {
        background: var(--primary-color);
        color: white;
    }

    .listings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
    }

    .property-card {
        background: var(--finn-card-bg);
        border: 1px solid var(--finn-border);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.2s ease;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .property-card:hover {
        box-shadow: 0 4px 12px rgba(15, 80, 87, 0.15);
        border-color: var(--primary-color);
        color: inherit;
        text-decoration: none;
    }

    .property-image-container {
        position: relative;
        padding-top: 60%;
        background: #f5f5f5;
        overflow: hidden;
    }

    .property-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .property-content {
        padding: 16px;
    }

    .property-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--finn-text);
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .property-price {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: rgba(15, 80, 87, 0.1);
        color: var(--primary-color);
        border-radius: 4px;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .property-description {
        font-size: 14px;
        color: var(--finn-text-light);
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .property-details {
        display: flex;
        gap: 16px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }

    .property-detail {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 13px;
        color: var(--finn-text-light);
    }

    .property-location {
        font-size: 13px;
        color: var(--finn-text-light);
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 8px;
    }

    .property-seller {
        font-size: 12px;
        color: var(--finn-text-light);
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .property-badges {
        display: flex;
        gap: 6px;
        margin-bottom: 8px;
        flex-wrap: wrap;
    }

    .property-badge {
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
    }

    .badge-sale {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .badge-exchange {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }

    .badge-giveaway {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: var(--finn-card-bg);
        border-radius: 8px;
        border: 1px solid var(--finn-border);
    }

    .empty-state i {
        font-size: 48px;
        color: var(--finn-text-light);
        margin-bottom: 16px;
    }

    .empty-state h4 {
        color: var(--finn-text);
        margin-bottom: 8px;
    }

    .empty-state p {
        color: var(--finn-text-light);
        margin-bottom: 20px;
    }

    .results-count {
        font-size: 13px;
        color: var(--finn-text-light);
        margin-bottom: 16px;
    }

    .pagination-container {
        margin-top: 40px;
        text-align: center;
    }

    .pagination {
        display: inline-flex;
        gap: 4px;
        align-items: center;
    }

    .page-link {
        padding: 8px 12px;
        border: 1px solid var(--finn-border);
        background: white;
        color: var(--finn-text);
        text-decoration: none;
        border-radius: 4px;
        transition: all 0.2s ease;
    }

    .page-link:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .page-link.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    @media (max-width: 768px) {
        .listings-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .filter-row {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
            min-width: 100%;
        }

        .property-details {
            flex-direction: column;
            gap: 8px;
        }
    }

    @media (max-width: 480px) {
        .listings-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="finn-main-container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="section-header">
        <div>
            @if($category->is_real_estate)
                <h1 class="section-title">🏠 {{ $category->name }}</h1>
                <p class="section-count">{{ $products->total() }} properties found</p>
            @else
                <h1 class="section-title">{{ $category->name }}</h1>
                <p class="section-count">{{ $products->total() }} products found</p>
            @endif
        </div>
        <a href="{{ route('categories.index') }}" class="btn-clear">
            <i class="fas fa-arrow-left"></i> Back to Categories
        </a>
    </div>

    <!-- Filter Bar for All Categories -->
    <div class="filter-bar">
        <form action="{{ route('categories.show', $category) }}" method="GET" id="filterForm">
            <div class="filter-row">
                @if($category->is_real_estate)
                    <!-- Property Type Filter for Real Estate -->
                    <div class="filter-group small">
                        <label class="filter-label">Property Type</label>
                        <select class="filter-input" name="property_type">
                            <option value="">All Types</option>
                            <option value="apartment">Apartment</option>
                            <option value="house">House</option>
                            <option value="townhouse">Townhouse</option>
                            <option value="condo">Condo</option>
                            <option value="villa">Villa</option>
                            <option value="cottage">Cottage</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Bedrooms for Real Estate -->
                    <div class="filter-group small">
                        <label class="filter-label">Min Bedrooms</label>
                        <select class="filter-input" name="min_bedrooms">
                            <option value="">Any</option>
                            <option value="1">1+</option>
                            <option value="2">2+</option>
                            <option value="3">3+</option>
                            <option value="4">4+</option>
                            <option value="5">5+</option>
                        </select>
                    </div>
                @endif

                <!-- Price Range -->
                <div class="filter-group small">
                    <label class="filter-label">Min Price (NOK)</label>
                    <input type="number" class="filter-input" name="min_price" placeholder="0" value="{{ request('min_price') }}">
                </div>

                <div class="filter-group small">
                    <label class="filter-label">Max Price (NOK)</label>
                    <input type="number" class="filter-input" name="max_price" placeholder="No limit" value="{{ request('max_price') }}">
                </div>

                <!-- Location -->
                <div class="filter-group">
                    <label class="filter-label">Location</label>
                    <input type="text" class="filter-input" name="location" placeholder="City or area" value="{{ request('location') }}">
                </div>

                <!-- Listing Type Filter -->
                <div class="filter-group small">
                    <label class="filter-label">Type</label>
                    <select class="filter-input" name="listing_type">
                        <option value="">All Types</option>
                        <option value="sale" {{ request('listing_type') == 'sale' ? 'selected' : '' }}>For Sale</option>
                        <option value="exchange" {{ request('listing_type') == 'exchange' ? 'selected' : '' }}>For Exchange</option>
                        <option value="giveaway" {{ request('listing_type') == 'giveaway' ? 'selected' : '' }}>Giveaway</option>
                    </select>
                </div>

                <!-- Sort Options -->
                <div class="filter-group small">
                    <label class="filter-label">Sort By</label>
                    <select class="filter-input" name="sort">
                        <option value="latest" {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>Newest First</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="filter-group small" style="flex: 0 0 auto;">
                    <button type="submit" class="btn-filter">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>

                <!-- Clear Button -->
                <div class="filter-group small" style="flex: 0 0 auto;">
                    <a href="{{ route('categories.show', $category) }}" class="btn-clear">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Count -->
    @if(request()->hasAny(['property_type', 'min_price', 'max_price', 'min_bedrooms', 'location']))
        <p class="results-count">
            Showing {{ $products->count() }} result(s)
            @if(request('property_type'))
                for "<strong>{{ ucfirst(request('property_type')) }}</strong>"
            @endif
        </p>
    @endif

    @if($products->count() > 0)
        <div class="listings-grid">
            @foreach($products as $product)
                <a href="{{ route('products.show', $product) }}" class="property-card">
                    <div class="property-image-container">
                        @if($product->images && count($product->images) > 0)
                            @if(str_starts_with($product->images[0], 'http'))
                                <img src="{{ $product->images[0] }}" alt="{{ $product->title }}" class="property-image">
                            @else
                                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->title }}" class="property-image">
                            @endif
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
                                @if($category->is_real_estate)
                                    <i class="fas fa-home fa-3x text-white"></i>
                                @elseif($category->name == 'Vehicles')
                                    <i class="fas fa-car fa-3x text-white"></i>
                                @elseif($category->name == 'Electronics')
                                    <i class="fas fa-mobile-alt fa-3x text-white"></i>
                                @elseif($category->name == 'Clothing')
                                    <i class="fas fa-tshirt fa-3x text-white"></i>
                                @elseif($category->name == 'Books')
                                    <i class="fas fa-book fa-3x text-white"></i>
                                @elseif($category->name == 'Home & Garden')
                                    <i class="fas fa-tools fa-3x text-white"></i>
                                @elseif($category->name == 'Sports & Outdoors')
                                    <i class="fas fa-basketball-ball fa-3x text-white"></i>
                                @else
                                    <i class="fas fa-box fa-3x text-white"></i>
                                @endif
                            </div>
                        @endif

                        <!-- Badges -->
                        <div class="property-badges" style="position: absolute; top: 8px; left: 8px; right: 8px;">
                            @if($product->is_for_sale && !$product->is_giveaway)
                                <span class="property-badge badge-sale">
                                    <i class="fas fa-shopping-cart me-1"></i>For Sale
                                </span>
                            @elseif($product->is_giveaway || $product->listing_type == 'giveaway')
                                <span class="property-badge badge-giveaway">
                                    <i class="fas fa-gift me-1"></i>Free
                                </span>
                            @else
                                <span class="property-badge badge-exchange">
                                    <i class="fas fa-exchange-alt me-1"></i>Exchange
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="property-content">
                        <h5 class="property-title">{{ Str::limit($product->title, 60) }}</h5>

                        @if($product->is_for_sale && !$product->is_giveaway)
                            <div class="property-price">
                                <i class="fas fa-tag"></i>
                                {{ number_format($product->sale_price, 0, ',', ' ') }} {{ config('settings.currency', 'NOK') }}
                            </div>
                        @elseif($product->is_giveaway || $product->listing_type == 'giveaway')
                            <div class="property-price" style="background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                                <i class="fas fa-gift"></i>
                                FREE
                            </div>
                        @endif

                        <p class="property-description">{{ Str::limit($product->description, 100) }}</p>

                        @if($category->is_real_estate)
                            <div class="property-details">
                                @if($product->house_rooms)
                                    <div class="property-detail">
                                        <i class="fas fa-door-open"></i>
                                        {{ $product->house_rooms }} rooms
                                    </div>
                                @endif
                                @if($product->house_bedrooms)
                                    <div class="property-detail">
                                        <i class="fas fa-bed"></i>
                                        {{ $product->house_bedrooms }} bed
                                    </div>
                                @endif
                                @if($product->house_bathrooms)
                                    <div class="property-detail">
                                        <i class="fas fa-bath"></i>
                                        {{ $product->house_bathrooms }} bath
                                    </div>
                                @endif
                                @if($product->house_living_area)
                                    <div class="property-detail">
                                        <i class="fas fa-ruler-combined"></i>
                                        {{ number_format($product->house_living_area, 0, ',', ' ') }} m²
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($product->location)
                            <div class="property-location">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $product->location }}
                            </div>
                        @endif

                        <div class="property-seller">
                            <i class="fas fa-user"></i>
                            {{ $product->user->name }}
                            <span style="margin-left: auto; color: var(--finn-text-light);">
                                {{ $product->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="pagination-container">
            {{ $products->links() }}
        </div>
    @else
        <div class="empty-state">
            @if($category->is_real_estate)
                <i class="fas fa-home"></i>
                <h4>No properties found</h4>
                <p>Try adjusting your filters or check back later for new real estate listings.</p>
            @elseif($category->name == 'Vehicles')
                <i class="fas fa-car"></i>
                <h4>No vehicles found</h4>
                <p>Try adjusting your filters or check back later for new vehicle listings.</p>
            @elseif($category->name == 'Electronics')
                <i class="fas fa-mobile-alt"></i>
                <h4>No electronics found</h4>
                <p>Try adjusting your filters or check back later for new electronic items.</p>
            @elseif($category->name == 'Clothing')
                <i class="fas fa-tshirt"></i>
                <h4>No clothing found</h4>
                <p>Try adjusting your filters or check back later for new clothing items.</p>
            @elseif($category->name == 'Books')
                <i class="fas fa-book"></i>
                <h4>No books found</h4>
                <p>Try adjusting your filters or check back later for new book listings.</p>
            @else
                <i class="fas fa-box-open"></i>
                <h4>No products found</h4>
                <p>Try adjusting your search or check back later for new items in this category.</p>
            @endif
            <a href="{{ route('categories.show', $category) }}" class="btn-filter">
                <i class="fas fa-redo me-2"></i>View All {{ $category->is_real_estate ? 'Properties' : 'Products' }}
            </a>
        </div>
    @endif
</div>
@endsection
