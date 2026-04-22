@extends('layouts.public')

@section('head')
    <title>{{ $user->name }}'s Products - {{ config('settings.site_name', 'Bytte.no') }}</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}'s Products</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12">
            <div class="freecycle-card mb-4">
                <div class="card-body p-4">
                    <h1 class="text-center mb-4" style="color: var(--primary-color);">{{ $user->name }}'s Products</h1>
                    <p class="text-center text-muted">Browse all products listed by {{ $user->name }}</p>
                    @if($user->location)
                        <p class="text-center text-muted mb-0">
                            <i class="fas fa-map-marker-alt me-1"></i>{{ $user->location }}, Norway
                        </p>
                    @endif
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="freecycle-card mb-4">
                <div class="card-body p-4">
                    <form method="GET" class="row g-3">
                        <div class="col-md-6">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search {{ $user->name }}'s products..." class="form-control" style="border-color: #e0e0e0;">
                        </div>
                        <div class="col-md-4">
                            <select name="category_id" class="form-select" style="border-color: #e0e0e0;">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn-freecycle w-100">Search</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                            <div class="freecycle-card h-100">
                                @if($product->images && count($product->images) > 0)
                                    @if(str_starts_with($product->images[0], 'http'))
                                        <img src="{{ $product->images[0] }}" class="card-img-top rounded-top" alt="{{ $product->title }}" style="height: 200px; object-fit: cover; border-bottom: 1px solid #e0e0e0;">
                                    @else
                                        <img src="{{ asset('storage/' . $product->images[0]) }}" class="card-img-top rounded-top" alt="{{ $product->title }}" style="height: 200px; object-fit: cover; border-bottom: 1px solid #e0e0e0;">
                                    @endif
                                @else
                                    <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center text-white rounded-top" style="height: 200px; border-bottom: 1px solid #e0e0e0;">
                                        <i class="fas fa-image fa-2x"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column p-3">
                                    <h5 class="card-title mb-2">
                                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none" style="color: var(--primary-color);">{{ Str::limit($product->title, 50) }}</a>
                                    </h5>
                                    <p class="card-text text-muted small mb-3">{{ Str::limit($product->description, 80) }}</p>
                                    <div class="mt-auto">
                                        <small class="text-muted d-block mb-2">
                                            <i class="fas fa-tag me-1"></i>{{ $product->category->name }} •
                                            <i class="fas fa-calendar me-1"></i>{{ $product->created_at->format('M d, Y') }}
                                        </small>
                                        <a href="{{ route('products.show', $product) }}" class="btn-freecycle btn-sm w-100 text-center">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">{{ $user->name }} hasn't listed any products yet</h4>
                    <p class="text-muted">Check back later for new products</p>
                    <a href="{{ route('products.index') }}" class="btn-freecycle-outline mt-3">Browse All Products</a>
                </div>
            @endif
        </div>
    </div>
@endsection
