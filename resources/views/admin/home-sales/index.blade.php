@extends('adminlte::page')

@section('title', 'Home Sales')

@section('content_header')
    <h1>Home Sales</h1>
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
                        <h5 class="mb-0">Home Sales Management</h5>
                        <small class="text-muted">{{ $homeSales->total() }} total home sales</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.home-sales.create') }}" class="btn px-3" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-plus me-2"></i>Add Home Sale
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div id="searchResults">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Sale Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($homeSales as $homeSale)
                            <tr>
                                <td>{{ $homeSale->id }}</td>
                                <td>
                                    @if($homeSale->images && count($homeSale->images) > 0)
                                        @if(str_starts_with($homeSale->images[0], 'http'))
                                            <img src="{{ $homeSale->images[0] }}" alt="{{ $homeSale->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                        @else
                                            <img src="{{ asset('storage/' . $homeSale->images[0]) }}" alt="{{ $homeSale->title }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                        @endif
                                    @else
                                        <div class="text-muted small">No Image</div>
                                    @endif
                                </td>
                                <td>{{ Str::limit($homeSale->title, 40) }}</td>
                                <td>
                                    {{ $homeSale->sale_date_from->format('M d, Y') }} - {{ $homeSale->sale_date_to->format('M d, Y') }}
                                </td>
                                <td>{{ $homeSale->location }}</td>
                                <td>
                                    <span class="badge {{ $homeSale->status === 'active' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ ucfirst($homeSale->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($homeSale->is_featured)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="fas fa-star text-muted"></i>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.home-sales.show', $homeSale) }}" class="btn btn-outline-info btn-sm" style="border-radius: 6px 0 0 6px;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.home-sales.edit', $homeSale) }}" class="btn btn-outline-warning btn-sm" style="border-radius: 0;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.home-sales.destroy', $homeSale) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius: 0 6px 6px 0;" onclick="return confirm('Are you sure you want to delete this home sale?')">
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
        </div>
        <div class="card-footer bg-light border-top-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $homeSales->firstItem() ?? 0 }} to {{ $homeSales->lastItem() ?? 0 }} of {{ $homeSales->total() }} home sales
                </div>
                {{ $homeSales->links() }}
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

        .btn:hover {
            background-color: #146060 !important;
            border-color: #146060 !important;
        }

        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(26, 105, 105, 0.25) !important;
        }

        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
        }

        .table td {
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .badge {
            font-size: 0.75rem;
        }

        .pagination {
            margin-bottom: 0;
        }

        .card-footer {
            border-radius: 0 0 12px 12px;
        }

        .btn-group .btn {
            border-color: #dee2e6 !important;
        }

        .btn-group .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
@stop
