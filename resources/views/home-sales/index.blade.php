@extends('layouts.public')

@section('title', __('Home Sales') . ' - ' . config('settings.site_name', 'Bytte.no'))

@section('content')
<style>
    /* Finn.no Inspired Styles for Home Sales */
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

    .search-input-wrapper {
        position: relative;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--finn-text-light);
    }

    .search-input {
        padding-left: 40px;
    }

    .search-results-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--finn-card-bg);
        border: 1px solid var(--primary-color);
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        max-height: 300px;
        overflow-y: auto;
        display: none;
    }

    .search-results-dropdown.show {
        display: block;
    }

    .search-result-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: background-color 0.2s ease;
        text-decoration: none;
        color: inherit;
    }

    .search-result-item:last-child {
        border-bottom: none;
    }

    .search-result-item:hover {
        background-color: var(--secondary-color);
    }

    .search-result-image {
        width: 50px;
        height: 50px;
        border-radius: 4px;
        object-fit: cover;
        background: #f5f5f5;
    }

    .search-result-content {
        flex: 1;
    }

    .search-result-title {
        font-size: 14px;
        font-weight: 500;
        color: var(--finn-text);
        margin-bottom: 4px;
    }

    .search-result-meta {
        font-size: 12px;
        color: var(--finn-text-light);
        display: flex;
        align-items: center;
        gap: 8px;
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

    .home-sale-card {
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

    .home-sale-card:hover {
        box-shadow: 0 4px 12px rgba(15, 80, 87, 0.15);
        border-color: var(--primary-color);
        color: inherit;
        text-decoration: none;
    }

    .home-sale-image-container {
        position: relative;
        padding-top: 60%;
        background: #f5f5f5;
        overflow: hidden;
    }

    .home-sale-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .home-sale-content {
        padding: 16px;
    }

    .home-sale-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--finn-text);
        margin-bottom: 8px;
    }

    .home-sale-date {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: rgba(15, 80, 87, 0.1);
        color: var(--primary-color);
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .home-sale-description {
        font-size: 14px;
        color: var(--finn-text-light);
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .home-sale-location {
        font-size: 13px;
        color: var(--finn-text-light);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .home-sale-seller {
        font-size: 12px;
        color: var(--finn-text-light);
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 4px;
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
    }

    @media (max-width: 480px) {
        .listings-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="finn-main-container">
    <div class="section-header">
        <div>
            <h1 class="section-title">🏠 Home Sales</h1>
            <p class="section-count">{{ $upcomingHomeSales->count() }} upcoming sales</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <form action="{{ route('home-sales.index') }}" method="GET" id="filterForm">
            <div class="filter-row">
                <!-- Search Input with Live Search -->
                <div class="filter-group" style="flex: 1.5; min-width: 250px;">
                    <label class="filter-label">Search</label>
                    <div class="search-input-wrapper">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text"
                               class="filter-input search-input"
                               id="searchInput"
                               name="search"
                               placeholder="Search by title, description or location..."
                               value="{{ request('search', '') }}"
                               autocomplete="off">
                        <div class="search-results-dropdown" id="searchResults"></div>
                    </div>
                </div>

                <!-- Location Filter -->
                <div class="filter-group">
                    <label class="filter-label">Location</label>
                    <input type="text"
                           class="filter-input"
                           name="location"
                           placeholder="City or area"
                           value="{{ request('location', '') }}">
                </div>

                <!-- Date Filter -->
                <div class="filter-group small">
                    <label class="filter-label">From Date</label>
                    <input type="date"
                           class="filter-input"
                           name="date_from"
                           value="{{ request('date_from', '') }}">
                </div>

                <!-- Sort Options -->
                <div class="filter-group small">
                    <label class="filter-label">Sort By</label>
                    <select class="filter-input" name="sort">
                        <option value="date" {{ request('sort', 'date') == 'date' ? 'selected' : '' }}>Date (Soonest)</option>
                        <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date (Latest)</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
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
                    <a href="{{ route('home-sales.index') }}" class="btn-clear">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Count -->
    @if(request()->has('search') || request()->has('location') || request()->has('date_from'))
        <p class="results-count">
            Showing {{ $upcomingHomeSales->count() }} result(s)
            @if(request('search'))
                for "<strong>{{ request('search') }}</strong>"
            @endif
        </p>
    @endif

    @if($upcomingHomeSales->count() > 0)
        <div class="listings-grid" id="homeSalesGrid">
            @foreach($upcomingHomeSales as $homeSale)
                <a href="{{ route('home-sales.show', $homeSale) }}" class="home-sale-card" data-title="{{ strtolower($homeSale->title) }}" data-location="{{ strtolower($homeSale->location . ' ' . $homeSale->city) }}">
                    <div class="home-sale-image-container">
                        @if($homeSale->images && count($homeSale->images) > 0)
                            @if(str_starts_with($homeSale->images[0], 'http'))
                                <img src="{{ $homeSale->images[0] }}" alt="{{ $homeSale->title }}" class="home-sale-image">
                            @else
                                <img src="{{ asset('storage/' . $homeSale->images[0]) }}" alt="{{ $homeSale->title }}" class="home-sale-image">
                            @endif
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));">
                                <i class="fas fa-home fa-3x text-white"></i>
                            </div>
                        @endif
                        @if($homeSale->is_featured)
                            <span class="product-badge badge-exchange" style="position: absolute; top: 8px; left: 8px; padding: 4px 10px; background: #ffc107; color: #333; border-radius: 4px; font-size: 11px; font-weight: 600;">
                                <i class="fas fa-star me-1"></i>Featured
                            </span>
                        @endif
                    </div>
                    <div class="home-sale-content">
                        <h5 class="home-sale-title">{{ Str::limit($homeSale->title, 50) }}</h5>
                        <div class="home-sale-date">
                            <i class="fas fa-calendar"></i>
                            {{ $homeSale->sale_date_from->format('M d') }} - {{ $homeSale->sale_date_to->format('M d, Y') }}
                        </div>
                        <p class="home-sale-description">{{ Str::limit($homeSale->description, 100) }}</p>
                        @if($homeSale->available_items)
                            <div class="home-sale-location">
                                <i class="fas fa-box"></i>
                                {{ Str::limit($homeSale->available_items, 50) }}
                            </div>
                        @endif
                        <div class="home-sale-location" style="margin-top: 8px;">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $homeSale->location }}{{ $homeSale->city ? ', ' . $homeSale->city : '' }}
                        </div>
                        <div class="home-sale-seller">
                            <i class="fas fa-user"></i>
                            {{ $homeSale->user->name }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-home"></i>
            <h4>No upcoming home sales found</h4>
            <p>Try adjusting your search filters or check back later for new garage sales and estate sales in your area.</p>
            <a href="{{ route('home-sales.index') }}" class="btn-filter">
                <i class="fas fa-redo me-2"></i>View All Sales
            </a>
        </div>
    @endif
</div>

<script>
    // Live Search Functionality
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');
    let searchTimeout = null;

    searchInput.addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        const query = e.target.value.trim();

        // Hide dropdown if query is empty
        if (query.length < 2) {
            searchResults.classList.remove('show');
            return;
        }

        // Debounce the search
        searchTimeout = setTimeout(() => {
            performLiveSearch(query);
        }, 300);
    });

    function performLiveSearch(query) {
        fetch(`{{ route('home-sales.search') }}?q=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    showSearchResults(data.data);
                } else {
                    searchResults.classList.remove('show');
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                searchResults.classList.remove('show');
            });
    }

    function showSearchResults(results) {
        const html = results.map(item => `
            <a href="${item.url}" class="search-result-item">
                ${item.image ? `<img src="${item.image}" alt="${item.title}" class="search-result-image">` : '<div class="search-result-image" style="display:flex;align-items:center;justify-content:center;"><i class="fas fa-home" style="color:#999;"></i></div>'}
                <div class="search-result-content">
                    <div class="search-result-title">${item.title}</div>
                    <div class="search-result-meta">
                        <span><i class="fas fa-map-marker-alt"></i> ${item.location}</span>
                        <span><i class="fas fa-calendar"></i> ${item.date_from} - ${item.date_to}</span>
                    </div>
                </div>
            </a>
        `).join('');

        searchResults.innerHTML = html;
        searchResults.classList.add('show');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.remove('show');
        }
    });

    // Handle keyboard navigation
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            searchResults.classList.remove('show');
        }
    });

    // Client-side filtering for instant feedback
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        // Form will submit normally for page reload with filters
    });
</script>
@endsection
