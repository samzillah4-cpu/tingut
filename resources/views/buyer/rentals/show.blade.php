@extends('adminlte::page')

@section('title', 'Rental Details')

@section('content_header')
    <h1>Rental Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Rental #{{ $rental->id }}</h3>
            <div class="card-tools">
                <a href="{{ route('buyer.rentals.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to My Rentals
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h4>Rental Information</h4>
                    <table class="table table-borderless">
                        <tr>
                            <td class="font-weight-bold" style="width: 140px;">Status:</td>
                            <td>
                                <span class="badge badge-{{ $rental->status === 'pending' ? 'warning' : ($rental->status === 'approved' ? 'info' : ($rental->status === 'active' ? 'primary' : ($rental->status === 'completed' ? 'success' : 'danger'))) }}">
                                    {{ ucfirst($rental->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Start Date:</td>
                            <td>{{ $rental->start_date->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">End Date:</td>
                            <td>{{ $rental->end_date->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Total Price:</td>
                            <td><strong>${{ number_format($rental->total_price, 2) }}</strong></td>
                        </tr>
                        @if($rental->deposit_amount)
                        <tr>
                            <td class="font-weight-bold">Deposit:</td>
                            <td>${{ number_format($rental->deposit_amount, 2) }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-6">
                    <h4>Product Owner</h4>
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-store text-primary fa-lg"></i>
                        </div>
                        <div>
                            <div class="font-weight-bold">{{ $rental->product->user->name }}</div>
                            <small class="text-muted">{{ $rental->product->user->email }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-12">
                    <h4>Product Details</h4>
                    <div class="card border">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="card-title">{{ $rental->product->title }}</h5>
                                    <p class="card-text">{{ Str::limit($rental->product->description, 200) }}</p>
                                    <p class="card-text">
                                        <small class="text-muted">
                                            Category: {{ $rental->product->category->name ?? 'N/A' }}
                                        </small>
                                    </p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <a href="{{ route('products.show', $rental->product) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-external-link-alt"></i> View Product
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($rental->notes)
            <hr>
            <div class="row">
                <div class="col-12">
                    <h4>Notes</h4>
                    <p class="mb-0">{{ $rental->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Actions -->
            <div class="row mt-4">
                <div class="col-12">
                    <h4>Actions</h4>
                    <div class="d-flex gap-2 flex-wrap">
                        @if($rental->status === 'pending')
                            <form method="POST" action="{{ route('buyer.rentals.update', $rental) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="cancelled">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel this rental request?')">
                                    <i class="fas fa-times"></i> Cancel Request
                                </button>
                            </form>
                        @else
                            <span class="text-muted">No actions available for {{ ucfirst($rental->status) }} rentals.</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop
