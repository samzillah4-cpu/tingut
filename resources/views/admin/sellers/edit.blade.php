@extends('adminlte::page')

@section('title', 'Edit Seller')

@section('content_header')
    <h1>Edit Seller: {{ $seller->name }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                            <i class="fas fa-user-edit text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Edit Seller</h5>
                            <small class="text-muted">{{ $seller->name }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.sellers.update', $seller) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control form-control-sm border-0 bg-light" value="{{ old('name', $seller->name) }}" required style="border-radius: 8px; padding: 12px;">
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control form-control-sm border-0 bg-light" value="{{ old('email', $seller->email) }}" required style="border-radius: 8px; padding: 12px;">
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input type="tel" name="phone" id="phone" class="form-control form-control-sm border-0 bg-light" value="{{ old('phone', $seller->phone) }}" placeholder="+47" style="border-radius: 8px; padding: 12px;">
                                @error('phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="location" class="form-label fw-semibold">Location</label>
                                <select name="location" id="location" class="form-control form-control-sm border-0 bg-light" required style="border-radius: 8px; padding: 12px;">
                                    <option value="">Select location</option>
                                    <option value="Agder" {{ old('location', $seller->location) == 'Agder' ? 'selected' : '' }}>Agder</option>
                                    <option value="Innlandet" {{ old('location', $seller->location) == 'Innlandet' ? 'selected' : '' }}>Innlandet</option>
                                    <option value="Møre og Romsdal" {{ old('location', $seller->location) == 'Møre og Romsdal' ? 'selected' : '' }}>Møre og Romsdal</option>
                                    <option value="Nordland" {{ old('location', $seller->location) == 'Nordland' ? 'selected' : '' }}>Nordland</option>
                                    <option value="Oslo" {{ old('location', $seller->location) == 'Oslo' ? 'selected' : '' }}>Oslo</option>
                                    <option value="Rogaland" {{ old('location', $seller->location) == 'Rogaland' ? 'selected' : '' }}>Rogaland</option>
                                    <option value="Troms og Finnmark" {{ old('location', $seller->location) == 'Troms og Finnmark' ? 'selected' : '' }}>Troms og Finnmark</option>
                                    <option value="Trøndelag" {{ old('location', $seller->location) == 'Trøndelag' ? 'selected' : '' }}>Trøndelag</option>
                                    <option value="Vestfold og Telemark" {{ old('location', $seller->location) == 'Vestfold og Telemark' ? 'selected' : '' }}>Vestfold og Telemark</option>
                                    <option value="Vestland" {{ old('location', $seller->location) == 'Vestland' ? 'selected' : '' }}>Vestland</option>
                                    <option value="Viken" {{ old('location', $seller->location) == 'Viken' ? 'selected' : '' }}>Viken</option>
                                </select>
                                @error('location')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                @if($seller->location)
                                    <div class="form-text text-success small mt-1">
                                        <i class="fas fa-check-circle me-1"></i>Current: <strong>{{ $seller->location }}</strong>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="password" class="form-label fw-semibold">New Password</label>
                            <input type="password" name="password" id="password" class="form-control form-control-sm border-0 bg-light" style="border-radius: 8px; padding: 12px;">
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted mt-1">
                                <i class="fas fa-info-circle me-1"></i>Leave blank to keep the current password
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="subscription_plan_id" class="form-label fw-semibold">Subscription Plan</label>
                            <select name="subscription_plan_id" id="subscription_plan_id" class="form-control form-control-sm border-0 bg-light" style="border-radius: 8px; padding: 12px;">
                                <option value="">Select subscription plan</option>
                                @foreach($subscriptionPlans as $plan)
                                    <option value="{{ $plan->id }}" {{ ($activeSubscription && $activeSubscription->subscription_plan_id == $plan->id) ? 'selected' : '' }}>
                                        {{ $plan->name }} - ${{ $plan->price }}/{{ $plan->duration }} (Max: {{ $plan->max_products == 0 ? 'Unlimited' : $plan->max_products }} products)
                                    </option>
                                @endforeach
                            </select>
                            @error('subscription_plan_id')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted mt-1">
                                <i class="fas fa-info-circle me-1"></i>
                                @if($activeSubscription)
                                    <span class="text-success"><strong>Current:</strong> {{ $activeSubscription->plan->name }} (Expires: {{ $activeSubscription->end_date->format('M d, Y') }})</span>
                                @else
                                    <span class="text-warning">No active subscription. Select a plan to assign one.</span>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4 pt-3 border-top">
                            <button type="submit" class="btn px-4" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                                <i class="fas fa-save me-2"></i>Update Seller
                            </button>
                            <a href="{{ route('admin.sellers.show', $seller) }}" class="btn btn-outline-secondary px-4" style="border-radius: 8px;">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
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
