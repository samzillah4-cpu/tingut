@extends('adminlte::page')

@section('title', 'Edit Rental')

@section('content_header')
    <h1>Edit Rental</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                    <i class="fas fa-edit text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0">Edit Rental #{{ $rental->id }}</h5>
                    <small class="text-muted">Modify rental details</small>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.rentals.update', $rental) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Renter</label>
                        <input type="text" class="form-control" value="{{ $rental->renter->name }} ({{ $rental->renter->email }})" readonly>
                        <small class="form-text text-muted">Cannot be changed</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product</label>
                        <input type="text" class="form-control" value="{{ $rental->product->title }} (by {{ $rental->product->user->name }})" readonly>
                        <small class="form-text text-muted">Cannot be changed</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="text" class="form-control" value="{{ $rental->start_date->format('M d, Y') }}" readonly>
                        <small class="form-text text-muted">Cannot be changed</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">End Date</label>
                        <input type="text" class="form-control" value="{{ $rental->end_date->format('M d, Y') }}" readonly>
                        <small class="form-text text-muted">Cannot be changed</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="pending" {{ $rental->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $rental->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="active" {{ $rental->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ $rental->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $rental->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="rejected" {{ $rental->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Total Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control" value="{{ number_format($rental->total_price, 2) }}" readonly>
                        </div>
                        <small class="form-text text-muted">Cannot be changed</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-top-0">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Rental
                    </a>
                    <button type="submit" class="btn" style="background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-save me-2"></i>Update Rental
                    </button>
                </div>
            </div>
        </form>
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
    </style>
@stop
