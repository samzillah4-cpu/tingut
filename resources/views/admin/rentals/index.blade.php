@extends('adminlte::page')

@section('title', 'Rentals')

@section('content_header')
    <h1>Rentals</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-handshake text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Rental Management</h5>
                        <small class="text-muted">{{ $rentals->total() }} total rentals</small>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center flex-grow-1">
                    <!-- Search Bar -->
                    <div class="input-group input-group-sm" style="width: 400px;">
                        <form method="GET" class="d-flex w-100">
                            <input type="text" name="search" class="form-control border-0 bg-light" placeholder="Search by user name..." value="{{ request('search') }}" style="border-radius: 8px 0 0 8px; padding: 8px 12px;">
                            <select name="status" class="form-control border-0 bg-light" style="border-radius: 0; padding: 8px 12px; max-width: 140px;">
                                <option value="">All Statuses</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            <button type="submit" class="btn border-0" style="background-color: var(--primary-color); color: white; border-radius: 0 8px 8px 0;">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.rentals.create') }}" class="btn px-3" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-plus me-2"></i>Add Rental
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr class="border-bottom">
                            <th>ID</th>
                            <th>Renter</th>
                            <th>Product</th>
                            <th>Owner</th>
                            <th>Duration</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rentals as $rental)
                            <tr class="border-bottom border-light">
                                <td><strong>{{ $rental->id }}</strong></td>
                                <td>
                                    <div>
                                        <div class="fw-semibold">{{ $rental->renter->name }}</div>
                                        <small class="text-muted">{{ $rental->renter->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($rental->product)
                                        <a href="{{ route('products.show', $rental->product) }}" target="_blank" class="text-decoration-none">
                                            <strong>{{ Str::limit($rental->product->title, 25) }}</strong>
                                        </a>
                                    @else
                                        <em class="text-muted">Product removed</em>
                                    @endif
                                </td>
                                <td>
                                    @if($rental->product)
                                        <div>
                                            <div class="fw-semibold">{{ $rental->product->user->name }}</div>
                                            <small class="text-muted">{{ $rental->product->user->email }}</small>
                                        </div>
                                    @else
                                        <em class="text-muted">N/A</em>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $rental->start_date->format('M d') }} - {{ $rental->end_date->format('M d, Y') }}</small>
                                </td>
                                <td>
                                    <strong>${{ number_format($rental->total_price, 2) }}</strong>
                                </td>
                                <td>
                                    <span class="badge
                                        @if($rental->status === 'completed') bg-success
                                        @elseif($rental->status === 'active') bg-primary
                                        @elseif($rental->status === 'approved') bg-info
                                        @elseif($rental->status === 'pending') bg-warning
                                        @else bg-danger
                                        @endif">
                                        {{ ucfirst($rental->status) }}
                                    </span>
                                </td>
                                <td><small class="text-muted">{{ $rental->created_at->format('M d, Y') }}</small></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-outline-info" title="View Rental">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.rentals.edit', $rental) }}" class="btn btn-outline-warning" title="Edit Rental">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.rentals.destroy', $rental) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete Rental" onclick="return confirm('Are you sure you want to delete this rental?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No rentals found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light border-top-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $rentals->firstItem() ?? 0 }} to {{ $rentals->lastItem() ?? 0 }} of {{ $rentals->total() }} rentals
                </div>
                {{ $rentals->links() }}
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

        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(26, 105, 105, 0.25) !important;
        }
    </style>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Enhanced search functionality
    $('input[name="search"], select[name="status"]').on('change input', function() {
        $(this).closest('form').submit();
    });
});
</script>
@stop
