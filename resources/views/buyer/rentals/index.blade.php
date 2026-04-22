@extends('adminlte::page')

@section('title', 'My Rentals')

@section('content_header')
    <h1>My Rentals</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Rental Management</h3>
            <div class="card-tools">
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-search"></i> Browse Products
                </a>
            </div>
        </div>

        <div class="card-body">
            @if($rentals->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Owner</th>
                                <th>Duration</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentals as $rental)
                                <tr>
                                    <td>
                                        <strong>{{ $rental->product->title }}</strong><br>
                                        <small class="text-muted">{{ $rental->product->category->name }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $rental->product->user->name }}</strong><br>
                                        <small class="text-muted">{{ $rental->product->user->email }}</small>
                                    </td>
                                    <td>
                                        {{ $rental->start_date->format('M d') }} - {{ $rental->end_date->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <strong>${{ number_format($rental->total_price, 2) }}</strong>
                                        @if($rental->deposit_amount)
                                            <br><small class="text-muted">Deposit: ${{ number_format($rental->deposit_amount, 2) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $rental->status === 'pending' ? 'warning' : ($rental->status === 'approved' ? 'info' : ($rental->status === 'active' ? 'primary' : ($rental->status === 'completed' ? 'success' : 'danger'))) }}">
                                            {{ ucfirst($rental->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $rental->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('buyer.rentals.show', $rental) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        @if($rental->status === 'pending')
                                            <form method="POST" action="{{ route('buyer.rentals.update', $rental) }}" class="d-inline ml-1">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Cancel this rental request?')">
                                                    <i class="fas fa-times"></i> Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $rentals->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <h5><i class="icon fas fa-info"></i> No Rentals Yet!</h5>
                    <p>You haven't rented any products yet.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-search"></i> Start Browsing Products
                    </a>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop
