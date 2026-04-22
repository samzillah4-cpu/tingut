@extends('adminlte::page')

@section('title', 'Subscriptions')

@section('content_header')
    <h1>Subscriptions</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-crown text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Subscription Management</h5>
                        <small class="text-muted">{{ $plans->count() }} plans, {{ $subscriptions->count() }} subscriptions</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="{{ route('admin.subscriptions.create') }}" class="btn px-3" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-plus me-2"></i>Add Plan
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <!-- Subscription Plans Section -->
            <h6 class="mb-3">Subscription Plans</h6>
            <div class="row mb-4">
                @forelse($plans as $plan)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $plan->name }}</h5>
                                <p class="card-text">{{ $plan->description }}</p>
                                <p class="text-primary fw-bold">NOK {{ $plan->price }} / {{ $plan->duration }}</p>
                                <p class="small">Max Products: {{ $plan->max_products == 0 ? 'Unlimited' : $plan->max_products }}</p>
                                <p class="small">Category: {{ $plan->category ? $plan->category->name : 'General' }}</p>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.subscriptions.edit', $plan) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="{{ route('admin.subscriptions.destroy', $plan) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-4">
                            <i class="fas fa-crown fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No subscription plans found.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Active Subscriptions Section -->
            <h6 class="mb-3">Active Subscriptions</h6>
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->user->name }}</td>
                                <td>{{ $subscription->plan->name }}</td>
                                <td>{{ $subscription->start_date->format('M d, Y') }}</td>
                                <td>{{ $subscription->end_date->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $subscription->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-users fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">No active subscriptions.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
    </style>
@stop
