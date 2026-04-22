@extends('adminlte::page')

@section('title', 'Rental Details')

@section('content_header')
    <h1>Rental Details</h1>
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
                        <h5 class="mb-0">Rental #{{ $rental->id }}</h5>
                        <small class="text-muted">Created {{ $rental->created_at->format('M d, Y \a\t H:i') }}</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.rentals.edit', $rental) }}" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.rentals.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back to Rentals
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-muted mb-3">Rental Information</h6>
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-semibold" style="width: 140px;">Status:</td>
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
                        </tr>
                        <tr>
                            <td class="fw-semibold">Start Date:</td>
                            <td>{{ $rental->start_date->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">End Date:</td>
                            <td>{{ $rental->end_date->format('M d, Y') }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Total Price:</td>
                            <td><strong>${{ number_format($rental->total_price, 2) }}</strong></td>
                        </tr>
                        @if($rental->deposit_amount)
                        <tr>
                            <td class="fw-semibold">Deposit:</td>
                            <td>${{ number_format($rental->deposit_amount, 2) }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted mb-3">Parties Involved</h6>
                    <div class="mb-4">
                        <h6 class="text-primary">Renter</h6>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $rental->renter->name }}</div>
                                <small class="text-muted">{{ $rental->renter->email }}</small>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-success">Product Owner</h6>
                        <div class="d-flex align-items-center">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-store text-success"></i>
                            </div>
                            <div>
                                <div class="fw-semibold">{{ $rental->product->user->name }}</div>
                                <small class="text-muted">{{ $rental->product->user->email }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-12">
                    <h6 class="text-muted mb-3">Product Details</h6>
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
                                <div class="col-md-4 text-end">
                                    <a href="{{ route('products.show', $rental->product) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-external-link-alt me-1"></i>View Product
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
                    <h6 class="text-muted mb-3">Notes</h6>
                    <p class="mb-0">{{ $rental->notes }}</p>
                </div>
            </div>
            @endif
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

        .table td {
            border: none;
            padding: 8px 0;
        }
    </style>
@stop
