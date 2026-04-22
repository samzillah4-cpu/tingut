@extends('layouts.public')

@section('title', config('settings.site_name', 'Bytte.no') . ' - Shop')

@section('content')
    <!-- Page Header -->
    <section class="page-header py-3" style="background: linear-gradient(135deg, var(--primary-color) 0%, #1c6c6c 100%); position: relative; overflow: hidden;">
        <div class="container-fluid px-5">
            <div class="row align-items-center">
                <div class="col-lg-8 text-white">
                    <h1 class="h2 fw-bold mb-2">Shop</h1>
                    <p class="mb-3 opacity-90" style="font-size: 1rem;">Buy amazing products from our community sellers</p>
                    <div class="d-flex flex-wrap gap-2">
                        <div class="stat-badge bg-white bg-opacity-20 px-2 py-1 rounded-pill" style="font-size: 0.8rem;">
                            <span class="fw-bold">{{ $products->total() }}</span> Products for Sale
                        </div>
                        <div class="stat-badge bg-white bg-opacity-20 px-2 py-1 rounded-pill" style="font-size: 0.8rem;">
                            <span class="fw-bold">{{ $categories->count() }}</span> Categories
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="header-icon">
                        <i class="fas fa-shopping-cart fa-4x text-white opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="filters-section py-4 bg-light border-bottom">
        <div class="container-fluid px-5">
            <div class="row">
                <div class="col-12">
                    <form method="GET" id="filtersForm" class="filters-form">
                        <div class="row g-3 align-items-end">
                            <!-- Search Input -->
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label fw-bold text-dark">Search Products</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0" style="background-color: #0f545a; color: white;">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="form-control border-0 ps-0" style="box-shadow: none; border-radius: 0 8px 8px 0;">
                                </div>
                            </div>

                            <!-- Category Filter -->
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label fw-bold text-dark">Category</label>
                                <select name="category_id" class="form-select" style="border-radius: 8px; border-color: #dee2e6;">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $category->products_count }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sort Options -->
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label fw-bold text-dark">Sort By</label>
                                <select name="sort" class="form-select" style="border-radius: 8px; border-color: #dee2e6;">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest First</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-lg-2 col-md-12">
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn px-3" style="border-radius: 8px; background-color: #0f545a; color: white; border-color: #0f545a;">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                    @if(request()->hasAny(['search', 'category_id', 'sort']))
                                        <a href="{{ route('shop') }}" class="btn px-3" style="border-radius: 8px; background-color: #0f545a; color: white; border-color: #0f545a;" title="Clear Filters">
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
            @if($products->count() > 0)
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="product-card h-100" style="border-radius: 15px; background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.08); transition: all 0.3s ease; border: 1px solid rgba(26, 105, 105, 0.1); overflow: hidden;">
                                @if($product->images && count($product->images) > 0)
                                    <div class="product-image position-relative" style="height: 200px; overflow: hidden;">
                                        @if(str_starts_with($product->images[0], 'http'))
                                            <img src="{{ $product->images[0] }}" alt="{{ $product->title }}" class="w-100 h-100 object-fit-cover" style="transition: transform 0.3s ease;">
                                        @else
                                            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->title }}" class="w-100 h-100 object-fit-cover" style="transition: transform 0.3s ease;">
                                        @endif
                                        <div class="product-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(26, 105, 105, 0.8); opacity: 0; transition: opacity 0.3s ease;">
                                            <a href="{{ route('products.show', $product) }}" class="btn btn-light btn-lg">View Details</a>
                                        </div>
                                    </div>
                                @else
                                    <div class="product-image d-flex align-items-center justify-content-center" style="height: 200px; background: linear-gradient(135deg, var(--primary-color), #1c6c6c);">
                                        <i class="fas fa-image fa-3x text-white"></i>
                                    </div>
                                @endif
                                <div class="product-content p-3">
                                    <h6 class="product-title fw-bold mb-2" style="color: var(--primary-color);">
                                        <a href="{{ route('products.show', $product) }}" class="text-decoration-none">{{ Str::limit($product->title, 35) }}</a>
                                    </h6>
                                    <div class="price mb-2">
                                        <span class="h5 text-success fw-bold">{{ number_format($product->sale_price, 2) }} {{ config('settings.currency', 'NOK') }}</span>
                                    </div>
                                    <p class="product-description text-muted small mb-3" style="font-size: 0.8rem;">
                                        {{ Str::limit($product->description, 70) }}
                                    </p>
                                    <div class="product-meta d-flex justify-content-between align-items-center mb-3">
                                        <span class="badge" style="background: #1c6c6c; color: white;">
                                            {{ $product->category->name }}
                                        </span>
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>{{ Str::limit($product->user->name, 15) }}
                                        </small>
                                    </div>
                                    <div class="product-actions d-flex gap-2">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        @auth
                                            <button type="button" class="btn btn-primary btn-sm flex-fill add-to-cart" data-product-id="{{ $product->id }}">
                                                <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                            </button>
                                        @else
                                            <a href="#" class="btn btn-primary btn-sm flex-fill" data-bs-toggle="modal" data-bs-target="#loginModal">
                                                <i class="fas fa-sign-in-alt me-1"></i>Login to Buy
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="row mt-5">
                        <div class="col-12">
                            {{ $products->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="empty-state text-center py-5">
                            <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                            <h3 class="text-muted mb-3">No products for sale</h3>
                            <p class="text-muted">Check back later for new products.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <style>
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .filters-form {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
    </style>

    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const btn = this;

                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Adding...';

                    fetch('/cart', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: 1
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            btn.innerHTML = '<i class="fas fa-check me-1"></i>Added!';
                            btn.classList.remove('btn-primary');
                            btn.classList.add('btn-success');

                            // Show success tooltip
                            const tooltip = bootstrap.Tooltip.getInstance(btn) || new bootstrap.Tooltip(btn, {
                                title: data.product_name + ' added to cart!',
                                placement: 'top',
                                trigger: 'manual'
                            });
                            tooltip.show();

                            // Hide tooltip after 2 seconds
                            setTimeout(() => {
                                tooltip.hide();
                            }, 2000);

                            // Update cart badge
                            updateCartBadge(data.cart_count);

                            // Reset button after 3 seconds
                            setTimeout(() => {
                                btn.disabled = false;
                                btn.innerHTML = '<i class="fas fa-cart-plus me-1"></i>Add to Cart';
                                btn.classList.remove('btn-success');
                                btn.classList.add('btn-primary');
                            }, 3000);
                        } else {
                            alert(data.error || 'Failed to add to cart');
                            btn.disabled = false;
                            btn.innerHTML = '<i class="fas fa-cart-plus me-1"></i>Add to Cart';
                        }
                    })
                    .catch(error => {
                        alert('An error occurred. Please try again.');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="fas fa-cart-plus me-1"></i>Add to Cart';
                    });
                });
            });

            function updateCartBadge(count) {
                const cartBadge = document.getElementById('cartBadge');
                if (cartBadge) {
                    if (count > 0) {
                        cartBadge.textContent = count > 99 ? '99+' : count;
                        cartBadge.style.display = 'inline-block';
                    } else {
                        cartBadge.style.display = 'none';
                    }
                }
            }
        });
    </script>
    @endauth
@endsection
