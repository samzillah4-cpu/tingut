@extends('adminlte::page')

@section('title', 'Product Details')

@section('content_header')
    <h1>Product Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $product->title }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $product->id }}</dd>

                <dt class="col-sm-3">Name</dt>
                <dd class="col-sm-9">{{ $product->title }}</dd>

                <dt class="col-sm-3">Description</dt>
                <dd class="col-sm-9">{{ $product->description }}</dd>

                <dt class="col-sm-3">Category</dt>
                <dd class="col-sm-9">{{ $product->category->name }}</dd>

                <dt class="col-sm-3">Listing Type</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-info">
                        {{ ucfirst($product->listing_type ?? 'sale') }}
                    </span>
                </dd>

                <dt class="col-sm-3">User</dt>
                <dd class="col-sm-9">{{ $product->user->name }} ({{ $product->user->email }})</dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </dd>

                <dt class="col-sm-3">Images</dt>
                <dd class="col-sm-9">
                    @if($product->images && count($product->images) > 0)
                        <div class="row">
                            @foreach($product->images as $image)
                                <div class="col-md-3 mb-3">
                                    @if(str_starts_with($image, 'http'))
                                        <img src="{{ $image }}" alt="Product Image" class="img-fluid">
                                    @else
                                        <img src="{{ asset('storage/' . $image) }}" alt="Product Image" class="img-fluid">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        No Images
                    @endif
                </dd>

                <dt class="col-sm-3">Created At</dt>
                <dd class="col-sm-9">{{ $product->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Updated At</dt>
                <dd class="col-sm-9">{{ $product->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
@stop
