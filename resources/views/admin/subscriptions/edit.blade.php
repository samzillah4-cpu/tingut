@extends('adminlte::page')

@section('title', 'Edit Subscription Plan')

@section('content_header')
    <h1>Edit Subscription Plan</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                    <i class="fas fa-edit text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0">Edit Subscription Plan</h5>
                    <small class="text-muted">Update plan details</small>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.subscriptions.update', $plan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Plan Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $plan->name }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price (NOK)</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ $plan->price }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration</label>
                            <select class="form-control" id="duration" name="duration" required>
                                <option value="monthly" {{ $plan->duration == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="yearly" {{ $plan->duration == 'yearly' ? 'selected' : '' }}>Yearly</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="max_products" class="form-label">Max Products (0 for unlimited)</label>
                            <input type="number" class="form-control" id="max_products" name="max_products" value="{{ $plan->max_products }}" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category (Optional - leave empty for general plans)</label>
                    <select class="form-control" id="category_id" name="category_id">
                        <option value="">General Plan (all categories)</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $plan->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ $plan->description }}</textarea>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $plan->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active Plan
                        </label>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn" style="background-color: var(--primary-color); color: white; border-color: var(--primary-color);">Update Plan</button>
                </div>
            </form>
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
    </style>
@stop
