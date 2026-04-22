@extends('adminlte::page')

@section('title', 'Category Details')

@section('content_header')
    <h1>Category Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $category->name }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $category->id }}</dd>

                <dt class="col-sm-3">Name</dt>
                <dd class="col-sm-9">{{ $category->name }}</dd>

                <dt class="col-sm-3">Description</dt>
                <dd class="col-sm-9">{{ $category->description ?: 'No description' }}</dd>

                <dt class="col-sm-3">Products Count</dt>
                <dd class="col-sm-9">{{ $category->products->count() }}</dd>

                <dt class="col-sm-3">Image</dt>
                <dd class="col-sm-9">
                    @if($category->image)
                        @if(str_starts_with($category->image, 'http'))
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" class="img-fluid">
                        @else
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-fluid">
                        @endif
                    @else
                        No Image
                    @endif
                </dd>

                <dt class="col-sm-3">Created At</dt>
                <dd class="col-sm-9">{{ $category->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Updated At</dt>
                <dd class="col-sm-9">{{ $category->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>

            @if($category->products->count() > 0)
                <h4>Recent Products</h4>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($category->products->take(10) as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->user->name }}</td>
                                    <td>{{ ucfirst($product->status) }}</td>
                                    <td>{{ $product->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@stop
