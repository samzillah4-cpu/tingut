@extends('layouts.public')

@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">Propose Exchange</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
                            <div class="freecycle-card">
                                <div class="card-body p-4">
                                    <h1 class="card-title text-center mb-4" style="color: var(--primary-color);">Propose Exchange</h1>

                                    @if($requestedProduct)
                                        <div class="mb-4 p-3" style="background-color: var(--secondary-color); border-radius: 8px;">
                                            <h5 class="mb-3" style="color: var(--primary-color);">You want to exchange for:</h5>
                                            <div class="d-flex align-items-center">
                                                @if($requestedProduct->images && count($requestedProduct->images) > 0)
                                                    <img src="{{ asset('storage/' . $requestedProduct->images[0]) }}" alt="{{ $requestedProduct->title }}" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <h6 class="mb-1">{{ $requestedProduct->title }}</h6>
                                                    <p class="text-muted small mb-0">{{ $requestedProduct->category->name }} • by {{ $requestedProduct->user->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('buyer.exchanges.store') }}">
                                        @csrf

                                        @if($requestedProduct)
                                            <input type="hidden" name="requested_product_id" value="{{ $requestedProduct->id }}">
                                        @else
                                            <div class="mb-3">
                                                <label for="requested_product_id" class="form-label" style="color: var(--primary-color);">Product to Request</label>
                                                <select name="requested_product_id" id="requested_product_id" class="form-control" style="border-color: #e0e0e0; focus: border-color: var(--primary-color);" required>
                                                    <option value="">Select a product...</option>
                                                    <!-- This would need to be populated with available products -->
                                                </select>
                                                @if($errors->has('requested_product_id'))
                                                    <div class="text-danger small mt-1">{{ $errors->first('requested_product_id') }}</div>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="mb-3">
                                            <label for="offered_product_id" class="form-label" style="color: var(--primary-color);">Your Product to Offer</label>
                                            <select name="offered_product_id" id="offered_product_id" class="form-control" style="border-color: #e0e0e0;" required>
                                                <option value="">Select your product...</option>
                                                @foreach($userProducts as $product)
                                                    <option value="{{ $product->id }}">{{ $product->title }} ({{ $product->category->name }})</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('offered_product_id'))
                                                <div class="text-danger small mt-1">{{ $errors->first('offered_product_id') }}</div>
                                            @endif
                                        </div>

                                        @if($userProducts->count() === 0)
                                            <div class="mb-3 p-3" style="background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px;">
                                                <p class="text-warning-emphasis mb-2">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>You don't have any active products to offer.
                                                </p>
                                                <a href="{{ route('seller.products.create') }}" class="btn-freecycle-outline btn-sm">Create a product first</a>
                                            </div>
                                        @endif

                                        @if($errors->any())
                                            <div class="mb-3 p-3" style="background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px;">
                                                <ul class="text-danger-emphasis mb-0">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                            <button type="submit" class="btn-freecycle" :disabled="$userProducts->count() === 0">
                                                <i class="fas fa-exchange-alt me-2"></i>Propose Exchange
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection
