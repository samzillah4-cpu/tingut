@extends('adminlte::page')

@section('title', 'Seller Details')

@section('content_header')
    <h1>Seller Details</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <!-- Basic Information Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">{{ $seller->name }}</h5>
                            <small class="text-muted">{{ $seller->email }}</small>
                        </div>
                    </div>
                    <div class="card-tools">
                        <a href="{{ route('admin.sellers.export-pdf', $seller) }}" class="btn btn-outline-primary btn-sm" style="border-radius: 6px;" target="_blank">
                            <i class="fas fa-file-pdf me-1"></i>Export PDF
                        </a>
                        <a href="{{ route('admin.sellers.edit', $seller) }}" class="btn btn-outline-warning btn-sm" style="border-radius: 6px;">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('admin.sellers.login-as', $seller) }}" class="btn btn-outline-success btn-sm" style="border-radius: 6px;" onclick="return confirm('Are you sure you want to login as this seller?')">
                            <i class="fas fa-sign-in-alt me-1"></i>Login as
                        </a>
                        <a href="{{ route('admin.sellers.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 6px;">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="border-start border-primary border-4 ps-3">
                                <h6 class="text-primary mb-3">Basic Information</h6>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Full Name</small>
                                    <strong>{{ $seller->name }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Email Address</small>
                                    <strong>{{ $seller->email }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Location</small>
                                    <strong>{{ $seller->location ?: 'Not specified' }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Role</small>
                                    <span class="badge bg-primary">{{ $seller->getRoleNames()->first() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="border-start border-success border-4 ps-3">
                                <h6 class="text-success mb-3">Activity Summary</h6>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Total Products</small>
                                    <strong class="text-primary">{{ $seller->products->count() }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Total Exchanges</small>
                                    <strong class="text-info">{{ $seller->proposedExchanges->count() + $seller->receivedExchanges->count() }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Completed Exchanges</small>
                                    <strong class="text-success">{{ $seller->proposedExchanges->where('status', 'completed')->count() + $seller->receivedExchanges->where('status', 'completed')->count() }}</strong>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted d-block">Pending Exchanges</small>
                                    <strong class="text-warning">{{ $seller->proposedExchanges->where('status', 'pending')->count() + $seller->receivedExchanges->where('status', 'pending')->count() }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Subscription Information Card -->
            @php
                $activeSubscription = $seller->subscriptions()->where('status', 'active')->where('end_date', '>', now())->first();
            @endphp
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                            <i class="fas fa-crown text-white"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Subscription Status</h5>
                            <small class="text-muted">Current subscription plan and details</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if($activeSubscription)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small class="text-muted d-block">Current Plan</small>
                                    <h4 class="text-primary mb-0">{{ $activeSubscription->plan->name }}</h4>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Plan Details</small>
                                    <p class="mb-1"><strong>Price:</strong> ${{ $activeSubscription->plan->price }}/{{ $activeSubscription->plan->duration }}</p>
                                    <p class="mb-1"><strong>Max Products:</strong> {{ $activeSubscription->plan->max_products == 0 ? 'Unlimited' : $activeSubscription->plan->max_products }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <small class="text-muted d-block">Subscription Status</small>
                                    <span class="badge bg-success fs-6 px-3 py-2">Active</span>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block">Start Date</small>
                                    <strong>{{ $activeSubscription->start_date->format('M d, Y') }}</strong>
                                </div>
                                <div class="mb-3">
                                    <small class="text-muted d-block">End Date</small>
                                    <strong class="{{ $activeSubscription->end_date->isPast() ? 'text-danger' : 'text-success' }}">
                                        {{ $activeSubscription->end_date->format('M d, Y') }}
                                        @if($activeSubscription->end_date->isPast())
                                            <small class="text-danger">(Expired)</small>
                                        @else
                                            <small class="text-success">({{ $activeSubscription->end_date->diffForHumans() }})</small>
                                        @endif
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 p-3 bg-light rounded">
                            <small class="text-muted">{{ $activeSubscription->plan->description }}</small>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3">
                                <i class="fas fa-exclamation-triangle text-warning fa-3x"></i>
                            </div>
                            <h5 class="text-muted">No Active Subscription</h5>
                            <p class="text-muted mb-3">This seller doesn't have an active subscription plan.</p>
                            <a href="{{ route('admin.sellers.edit', $seller) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Assign Subscription
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Quick Stats Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h6 class="mb-0">Quick Stats</h6>
                </div>
                <div class="card-body p-4">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border border-primary rounded p-3">
                                <div class="h4 text-primary mb-1">{{ $seller->products->where('status', 'active')->count() }}</div>
                                <small class="text-muted">Active Products</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border border-success rounded p-3">
                                <div class="h4 text-success mb-1">{{ $seller->products->where('status', 'inactive')->count() }}</div>
                                <small class="text-muted">Inactive Products</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border border-info rounded p-3">
                                <div class="h4 text-info mb-1">{{ $seller->proposedExchanges->where('status', 'pending')->count() }}</div>
                                <small class="text-muted">Pending Offers</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border border-warning rounded p-3">
                                <div class="h4 text-warning mb-1">{{ $seller->receivedExchanges->where('status', 'pending')->count() }}</div>
                                <small class="text-muted">Pending Requests</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Dates Card -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h6 class="mb-0">Account Timeline</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <small class="text-muted d-block">Member Since</small>
                        <strong>{{ $seller->created_at->format('M d, Y') }}</strong>
                        <br><small class="text-muted">{{ $seller->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Last Updated</small>
                        <strong>{{ $seller->updated_at->format('M d, Y') }}</strong>
                        <br><small class="text-muted">{{ $seller->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products List -->
    @if($seller->products->count() > 0)
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                    <i class="fas fa-box text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0">Products</h5>
                    <small class="text-muted">{{ $seller->products->count() }} total products</small>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr class="border-bottom">
                            <th>ID</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($seller->products as $product)
                            <tr class="border-bottom border-light">
                                <td><strong>{{ $product->id }}</strong></td>
                                <td>{{ Str::limit($product->title, 50) }}</td>
                                <td><span class="badge bg-light text-dark">{{ $product->category->name ?? 'N/A' }}</span></td>
                                <td>
                                    <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td><small class="text-muted">{{ $product->created_at->format('M d, Y') }}</small></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-info" target="_blank" title="View Product">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-warning" title="Edit Product">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Exchange History -->
    @php
        $allExchanges = $seller->proposedExchanges->merge($seller->receivedExchanges)->sortByDesc('created_at');
    @endphp
    @if($allExchanges->count() > 0)
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                    <i class="fas fa-exchange-alt text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0">Exchange History</h5>
                    <small class="text-muted">{{ $allExchanges->count() }} total exchanges</small>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr class="border-bottom">
                            <th>Product Offered</th>
                            <th>Product Requested</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allExchanges as $exchange)
                            <tr class="border-bottom border-light">
                                <td>
                                    @if($exchange->offeredProduct)
                                        <a href="{{ route('products.show', $exchange->offeredProduct) }}" target="_blank" class="text-decoration-none">
                                            <strong>{{ Str::limit($exchange->offeredProduct->title, 30) }}</strong>
                                        </a>
                                    @else
                                        <em class="text-muted">Product removed</em>
                                    @endif
                                </td>
                                <td>
                                    @if($exchange->requestedProduct)
                                        <a href="{{ route('products.show', $exchange->requestedProduct) }}" target="_blank" class="text-decoration-none">
                                            <strong>{{ Str::limit($exchange->requestedProduct->title, 30) }}</strong>
                                        </a>
                                    @else
                                        <em class="text-muted">Product removed</em>
                                    @endif
                                </td>
                                <td>
                                    @if($exchange->proposer_id === $seller->id)
                                        <span class="badge bg-primary">Proposer</span>
                                    @else
                                        <span class="badge bg-secondary">Receiver</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge
                                        @if($exchange->status === 'completed') bg-success
                                        @elseif($exchange->status === 'pending') bg-warning
                                        @elseif($exchange->status === 'accepted') bg-info
                                        @else bg-danger
                                        @endif">
                                        {{ ucfirst($exchange->status) }}
                                    </span>
                                </td>
                                <td><small class="text-muted">{{ $exchange->created_at->format('M d, Y') }}</small></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Seller Button -->
    <div class="card shadow-sm mt-4 border-danger">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: #dc3545;">
                    <i class="fas fa-exclamation-triangle text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0 text-danger">Danger Zone</h5>
                    <small class="text-muted">Irreversible actions</small>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="alert alert-danger border-0">
                <h6 class="alert-heading mb-2">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Delete Seller Account
                </h6>
                <p class="mb-3">
                    Deleting this seller will permanently remove their account and all associated data including products, exchanges, subscriptions, and comments.
                    This action cannot be undone.
                </p>
                <form action="{{ route('admin.sellers.destroy', $seller) }}" method="POST" onsubmit="return confirmDelete()" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Delete Seller Permanently
                    </button>
                </form>
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.08) !important;
        }

        .btn:hover {
            background-color: #146060 !important;
            border-color: #146060 !important;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .table th {
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
            font-size: 0.875rem;
            padding: 12px 8px;
        }

        .table td {
            vertical-align: middle;
            border-color: #e9ecef;
            padding: 12px 8px;
        }

        .border-primary {
            border-color: var(--primary-color) !important;
        }

        .border-success {
            border-color: #198754 !important;
        }

        .border-info {
            border-color: #0dcaf0 !important;
        }

        .border-warning {
            border-color: #ffc107 !important;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c2c7;
            color: #721c24;
        }
    </style>
@stop

@section('js')
<script>
function confirmDelete() {
    const sellerName = '{{ $seller->name }}';
    const productCount = {{ $seller->products->count() }};
    const exchangeCount = {{ $seller->proposedExchanges->count() + $seller->receivedExchanges->count() }};

    let message = `Are you sure you want to delete seller "${sellerName}"?\n\n`;
    message += `This will permanently delete:\n`;
    message += `• The seller account\n`;
    if (productCount > 0) {
        message += `• ${productCount} product(s)\n`;
    }
    if (exchangeCount > 0) {
        message += `• ${exchangeCount} exchange(s)\n`;
    }
    message += `• All associated comments and data\n\n`;
    message += `This action cannot be undone!`;

    return confirm(message);
}
</script>
@stop
