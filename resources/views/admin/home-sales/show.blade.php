@extends('adminlte::page')

@section('title', 'View Home Sale')

@section('content_header')
    <h1>Home Sale Details</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-home text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">{{ $homeSale->title }}</h5>
                        <small class="text-muted">Home Sale ID: {{ $homeSale->id }}</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.home-sales.edit', $homeSale) }}" class="btn btn-warning mr-2">
                        <i class="fas fa-edit mr-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.home-sales.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i>Back
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-8">
                    <h4 class="mb-3">Description</h4>
                    <p class="text-muted">{{ $homeSale->description }}</p>

                    <hr class="my-4">

                    <h4 class="mb-3">Sale Information</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Sale Start Date:</strong><br>{{ $homeSale->sale_date_from->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Sale End Date:</strong><br>{{ $homeSale->sale_date_to->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h4 class="mb-3">Location</h4>
                    <p>
                        <strong>Location:</strong> {{ $homeSale->location }}<br>
                        @if($homeSale->address)
                            <strong>Address:</strong> {{ $homeSale->address }}<br>
                        @endif
                        @if($homeSale->city)
                            <strong>City:</strong> {{ $homeSale->city }}
                        @endif
                    </p>

                    <hr class="my-4">

                    <!-- Items Section -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Listed Items</h4>
                        <a href="{{ route('admin.home-sales.items.create', $homeSale) }}" class="btn" style="background-color: var(--primary-color); color: white;">
                            <i class="fas fa-plus mr-1"></i>Add Item
                        </a>
                    </div>

                    @if($homeSale->items->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead style="background-color: var(--primary-color); color: white;">
                                    <tr>
                                        <th class="text-center" style="width: 60px;">#</th>
                                        <th style="width: 100px;">Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Condition</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($homeSale->items as $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                @if($item->image)
                                                    @if(str_starts_with($item->image, 'http'))
                                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                                    @endif
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center bg-light" style="width: 60px; height: 60px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $item->name }}</strong>
                                                @if($item->description)
                                                    <br><small class="text-muted">{{ Str::limit($item->description, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $item->category ?? '-' }}</td>
                                            <td>{{ $item->condition ?? '-' }}</td>
                                            <td>
                                                @if($item->price)
                                                    NOK {{ number_format($item->price, 2, ',', '.') }}
                                                @else
                                                    <span class="text-muted">No price</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($item->is_sold)
                                                    <span class="badge badge-secondary">Sold</span>
                                                @else
                                                    <span class="badge badge-success">Available</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.home-sales.items.edit', [$homeSale, $item]) }}" class="btn btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.home-sales.items.toggle-sold', [$homeSale, $item]) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-outline-{{ $item->is_sold ? 'success' : 'warning' }}" title="{{ $item->is_sold ? 'Mark as Available' : 'Mark as Sold' }}">
                                                            <i class="fas {{ $item->is_sold ? 'fa-check' : 'fa-times' }}"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('admin.home-sales.items.destroy', [$homeSale, $item]) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this item?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 bg-light rounded">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No items listed yet.</p>
                            <a href="{{ route('admin.home-sales.items.create', $homeSale) }}" class="btn mt-2" style="background-color: var(--primary-color); color: white;">
                                <i class="fas fa-plus mr-1"></i>Add First Item
                            </a>
                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="card-body">
                            <span class="badge {{ $homeSale->status === 'active' ? 'badge-success' : 'badge-secondary' }} badge-lg">
                                {{ ucfirst($homeSale->status) }}
                            </span>
                            @if($homeSale->is_featured)
                                <span class="badge badge-warning mt-2">
                                    <i class="fas fa-star mr-1"></i>Featured
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0">Seller Information</h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Name:</strong> {{ $homeSale->user->name }}</p>
                            <p class="mb-0"><strong>Email:</strong> {{ $homeSale->user->email }}</p>
                        </div>
                    </div>

                    @if($homeSale->images && count($homeSale->images) > 0)
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Images</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($homeSale->images as $image)
                                        <div class="col-6 mb-2">
                                            @if(str_starts_with($image, 'http'))
                                                <img src="{{ $image }}" alt="Home Sale Image" class="img-thumbnail w-100" style="height: 100px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('storage/' . $image) }}" alt="Home Sale Image" class="img-thumbnail w-100" style="height: 100px; object-fit: cover;">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer bg-light border-top-0">
            <div class="d-flex justify-content-between">
                <small class="text-muted">
                    Created: {{ $homeSale->created_at->format('M d, Y H:i') }}
                    @if($homeSale->updated_at != $homeSale->created_at)
                        | Updated: {{ $homeSale->updated_at->format('M d, Y H:i') }}
                    @endif
                </small>
                <form action="{{ route('admin.home-sales.destroy', $homeSale) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this home sale?')">
                        <i class="fas fa-trash mr-1"></i>Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
    <style>
        :root {
            --primary-color: {{ config('settings.primary_color', '#1a6969') }};
        }

        .card {
            border-radius: 12px;
            border: none;
        }

        .badge-lg {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .table th {
            font-weight: 500;
        }

        .table td {
            vertical-align: middle;
        }
    </style>
@stop
