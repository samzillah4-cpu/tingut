@extends('adminlte::page')

@section('title', 'Create Rental')

@section('content_header')
    <h1>Create Rental</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0">Create New Rental</h5>
                    <small class="text-muted">Add a new rental to the system</small>
                </div>
            </div>
        </div>
        <form action="{{ route('admin.rentals.store') }}" method="POST">
            @csrf
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="renter_id" class="form-label">Renter <span class="text-danger">*</span></label>
                        <select class="form-control @error('renter_id') is-invalid @enderror" id="renter_id" name="renter_id" required>
                            <option value="">Select a renter</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('renter_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('renter_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                        <select class="form-control @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                            <option value="">Select a product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->title }} (by {{ $product->user->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date"
                               value="{{ old('start_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        @error('start_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date"
                               value="{{ old('end_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Total Price</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" id="total_price_display" readonly>
                        </div>
                        <small class="form-text text-muted">Calculated automatically based on rental duration</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light border-top-0">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.rentals.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Rentals
                    </a>
                    <button type="submit" class="btn" style="background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-save me-2"></i>Create Rental
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

@section('js')
<script>
$(document).ready(function() {
    // Calculate total price when dates or product change
    function calculatePrice() {
        const productId = $('#product_id').val();
        const startDate = $('#start_date').val();
        const endDate = $('#end_date').val();

        if (productId && startDate && endDate) {
            // This would need AJAX call to calculate price on server
            // For now, just show placeholder
            $('#total_price_display').val('Calculated on save');
        }
    }

    $('#product_id, #start_date, #end_date').on('change', calculatePrice);
});
</script>
@stop
