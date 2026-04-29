@extends('adminlte::page')

@section('title', 'Buyer Dashboard')

@section('content_header')
    <div class="seller-header">
        <div class="seller-welcome">
            <div class="seller-avatar">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div class="seller-info">
                <h1 class="seller-name">Welcome back, {{ auth()->user()->name }}</h1>
                <p class="seller-subtitle">Manage your exchanges and rentals</p>
            </div>
        </div>
        <div class="seller-actions">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-search me-1"></i>Browse Products
            </a>
            <a href="{{ route('buyer.exchanges.index') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-exchange-alt me-1"></i>My Exchanges
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row mb-4" style="margin-top: -1rem;">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="card stats-card border-left-primary">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Exchanges
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalReceivedExchanges }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exchange-alt fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="card stats-card border-left-warning">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Requests
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingExchangesCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="card stats-card border-left-success">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Completed Exchanges
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedExchangesCount }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 mb-3">
                <div class="card stats-card border-left-info">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Rentals
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRentals }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-home fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Row -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-rocket text-primary me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg w-100">
                                    <i class="fas fa-search d-block mb-1"></i>
                                    <span class="btn-text">Browse Products</span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <a href="{{ route('buyer.exchanges.index') }}" class="btn btn-secondary btn-lg w-100">
                                    <i class="fas fa-exchange-alt d-block mb-1"></i>
                                    <span class="btn-text">My Exchanges</span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <a href="{{ route('buyer.rentals.index') }}" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-calendar-alt d-block mb-1"></i>
                                    <span class="btn-text">My Rentals</span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <a href="{{ route('buyer.chats.admin') }}" class="btn btn-info btn-lg w-100 position-relative" id="chatActionBtn">
                                    <i class="fas fa-comments d-block mb-1"></i>
                                    <span class="btn-text">Chat with Admin</span>
                                    <span class="badge bg-danger position-absolute top-0 end-0 chat-badge" id="chatBadge" style="display: none;">0</span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <a href="{{ route('buyer.account.edit') }}" class="btn btn-warning btn-lg w-100">
                                    <i class="fas fa-user-cog d-block mb-1"></i>
                                    <span class="btn-text">Account Settings</span>
                                </a>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-6">
                                <a href="{{ route('buyer.exchanges.create') }}" class="btn btn-danger btn-lg w-100">
                                    <i class="fas fa-plus-circle d-block mb-1"></i>
                                    <span class="btn-text">New Exchange</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Rows -->
        <div class="row">
            <!-- Recent Exchanges -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-sign-in-alt text-primary me-2"></i>Incoming Exchange Requests</h5>
                        <a href="{{ route('buyer.exchanges.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        @if($recentReceivedExchanges->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($recentReceivedExchanges as $exchange)
                                    <div class="list-group-item px-0 py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="avatar-circle me-3">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $exchange->proposer->name }}</h6>
                                                        <small class="text-muted">{{ $exchange->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                                <div class="exchange-details">
                                                    <div class="mb-1">
                                                        <i class="fas fa-arrow-right text-success me-2"></i>
                                                        <small class="text-muted">Offers:</small>
                                                        <strong>{{ Str::limit($exchange->offeredProduct->title, 30) }}</strong>
                                                    </div>
                                                    <div>
                                                        <i class="fas fa-arrow-left text-warning me-2"></i>
                                                        <small class="text-muted">For your:</small>
                                                        <strong>{{ Str::limit($exchange->requestedProduct->title, 30) }}</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column align-items-end gap-2">
                                                <span class="badge bg-{{ $exchange->status === 'pending' ? 'warning' : ($exchange->status === 'accepted' ? 'success' : 'secondary') }}">
                                                    {{ ucfirst($exchange->status) }}
                                                </span>
                                                <a href="{{ route('buyer.exchanges.show', $exchange) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No exchange requests yet</h6>
                                <p class="text-muted small mb-3">When someone wants to exchange with your products, you'll see them here.</p>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-search me-1"></i>Browse Products
                                    </a>
                                    <a href="{{ route('buyer.exchanges.create') }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i>Start Exchange
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Rentals -->
            <div class="col-lg-6 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fas fa-calendar-check text-success me-2"></i>My Rentals</h5>
                        <a href="{{ route('buyer.rentals.index') }}" class="btn btn-sm btn-outline-success">View All</a>
                    </div>
                    <div class="card-body">
                        @if($recentRentals->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($recentRentals as $rental)
                                    <div class="list-group-item px-0 py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="avatar-circle me-3">
                                                        <i class="fas fa-box"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ Str::limit($rental->product->title, 35) }}</h6>
                                                        <small class="text-muted">From {{ $rental->product->user->name }}</small>
                                                    </div>
                                                </div>
                                                <div class="rental-period">
                                                    <i class="fas fa-calendar-alt text-info me-2"></i>
                                                    <small>{{ $rental->start_date->format('M d') }} - {{ $rental->end_date->format('M d, Y') }}</small>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column align-items-end gap-2">
                                                <span class="badge bg-{{ $rental->status === 'active' ? 'success' : ($rental->status === 'pending' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($rental->status) }}
                                                </span>
                                                <a href="{{ route('buyer.rentals.show', $rental) }}" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-info me-1"></i>View
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No rentals yet</h6>
                                <p class="text-muted small mb-3">Rent products from other users for a period of time.</p>
                                <a href="{{ route('products.index') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-search me-1"></i>Browse Products
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
            <div class="stat-info">
                <div class="stat-value">{{ $totalReceivedExchanges }}</div>
                <div class="stat-label">Total Exchanges</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $pendingExchangesCount }}</div>
                <div class="stat-label">Pending Requests</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $completedExchangesCount }}</div>
                <div class="stat-label">Completed Exchanges</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-home"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $totalRentals }}</div>
                <div class="stat-label">Total Rentals</div>
            </div>
        </div>
    </div>

    <!-- Enhanced Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Quick Actions -->
        <div class="dashboard-card actions-card">
            <div class="card-header">
                <h3><i class="fas fa-rocket me-2"></i>Quick Actions</h3>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-search me-2"></i>Browse Products
                    </a>
                    <a href="{{ route('buyer.exchanges.index') }}" class="btn btn-secondary">
                        <i class="fas fa-exchange-alt me-2"></i>My Exchanges
                    </a>
                    <a href="{{ route('buyer.rentals.index') }}" class="btn btn-success">
                        <i class="fas fa-calendar-alt me-2"></i>My Rentals
                    </a>
                    <a href="{{ route('buyer.chats.admin') }}" class="btn btn-info" id="chatActionBtn">
                        <i class="fas fa-comments me-2"></i>Chat with Admin
                        <span class="chat-badge" id="chatBadge" style="display: none;">0</span>
                    </a>
                    <a href="{{ route('buyer.account.edit') }}" class="btn btn-warning">
                        <i class="fas fa-user-cog me-2"></i>Account Settings
                    </a>
                    <a href="{{ route('buyer.exchanges.create') }}" class="btn btn-danger">
                        <i class="fas fa-plus-circle me-2"></i>New Exchange
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Exchanges (Received) -->
        <div class="dashboard-card exchanges-card">
            <div class="card-header">
                <h3><i class="fas fa-sign-in-alt me-2"></i>Incoming Exchange Requests</h3>
                <a href="{{ route('buyer.exchanges.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentReceivedExchanges->count() > 0)
                    <div class="exchange-grid">
                        @foreach($recentReceivedExchanges as $exchange)
                            <div class="exchange-card" data-status="{{ $exchange->status }}">
                                <div class="exchange-header">
                                    <div class="proposer-avatar">
                                        <div class="avatar-circle">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="proposer-info">
                                            <span class="proposer-name">{{ $exchange->proposer->name }}</span>
                                            <span class="exchange-date">{{ $exchange->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <span class="exchange-status {{ $exchange->status }}">
                                        <i class="status-icon"></i>
                                        {{ ucfirst($exchange->status) }}
                                    </span>
                                </div>
                                <div class="exchange-body">
                                    <div class="exchange-offer">
                                        <div class="product-info">
                                            <i class="fas fa-arrow-right"></i>
                                            <div>
                                                <small>Offers:</small>
                                                <strong>{{ Str::limit($exchange->offeredProduct->title, 35) }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="exchange-request">
                                        <div class="product-info">
                                            <i class="fas fa-arrow-left"></i>
                                            <div>
                                                <small>For your:</small>
                                                <strong>{{ Str::limit($exchange->requestedProduct->title, 35) }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="exchange-actions">
                                    @if($exchange->status === 'pending')
                                        <a href="{{ route('buyer.exchanges.show', $exchange) }}" class="btn btn-sm btn-primary action-btn-primary">
                                            <i class="fas fa-eye"></i>
                                            Review Request
                                        </a>
                                    @else
                                        <a href="{{ route('buyer.exchanges.show', $exchange) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-info-circle"></i>
                                            View Details
                                        </a>
                                    @endif
                                </div>
                                <div class="card-shine"></div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state enhanced">
                        <div class="empty-icon">
                            <i class="fas fa-exchange-alt"></i>
                            <div class="icon-particles">
                                <span></span><span></span><span></span>
                            </div>
                        </div>
                        <h4>No exchange requests yet</h4>
                        <p>Don't worry! When someone wants to exchange with your products, you'll see them here. Start by browsing products and making your own proposals.</p>
                        <div class="empty-actions">
                            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-search me-2"></i>Browse Products
                            </a>
                            <a href="{{ route('buyer.exchanges.create') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-plus me-2"></i>Start an Exchange
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="requests-row">
        <!-- My Rentals -->
        <div class="dashboard-card giveaway-card">
            <div class="card-header">
                <h3><i class="fas fa-calendar-check me-2"></i>My Rentals</h3>
                <a href="{{ route('buyer.rentals.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentRentals->count() > 0)
                    <div class="giveaway-grid">
                        @foreach($recentRentals as $rental)
                            <div class="giveaway-card">
                                <div class="giveaway-header">
                                    <div class="requester-info">
                                        <i class="fas fa-box"></i>
                                        <span>{{ Str::limit($rental->product->title, 25) }}</span>
                                    </div>
                                    <span class="giveaway-status {{ $rental->status }}">{{ ucfirst($rental->status) }}</span>
                                </div>
                                <div class="giveaway-body">
                                    <div class="giveaway-product">
                                        <small>From:</small>
                                        <strong>{{ $rental->product->user->name }}</strong>
                                    </div>
                                    <div class="giveaway-date">
                                        <small>{{ $rental->start_date->format('M d') }} - {{ $rental->end_date->format('M d, Y') }}</small>
                                    </div>
                                </div>
                                <div class="giveaway-actions">
                                    <a href="{{ route('buyer.rentals.show', $rental) }}" class="btn btn-sm btn-outline-primary">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-alt"></i>
                        <h4>No rentals yet</h4>
                        <p>Rent products from other users for a period of time</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Browse Products
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
    <style>
        /* Hide sidebar */
        .main-sidebar { display: none !important; }
        .content-wrapper { margin-left: 0 !important; }
        .main-header { margin-left: 0 !important; }

        /* Header styling */
        .seller-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%) !important;
            border-radius: 0 0 12px 12px;
        }

        .seller-name {
            color: white !important;
        }

        .seller-subtitle {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .seller-avatar {
            background: rgba(255, 255, 255, 0.2) !important;
        }

        /* Dashboard Styles */
        :root {
            --primary: #136163;
            --secondary: #f9f2d5;
            --primary-light: #1a7a7d;
            --primary-dark: #0d4a4d;
            --secondary-light: #fdf8e3;
            --secondary-dark: #f5e6b7;
            --success: #28a745;
            --warning: #ffc107;
            --info: #17a2b8;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --border-color: #e9ecef;
            --shadow: 0 1px 3px rgba(19, 97, 99, 0.1);
            --shadow-lg: 0 2px 8px rgba(19, 97, 99, 0.15);
            --background: linear-gradient(135deg, var(--secondary) 0%, #ffffff 100%);
        }

        /* Statistics Cards */
        .stats-card {
            transition: all 0.3s ease;
            border-left: 4px solid;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(19, 97, 99, 0.15);
            background: rgba(255, 255, 255, 0.95);
        }

        .border-left-primary { border-left-color: var(--primary) !important; }
        .border-left-warning { border-left-color: var(--warning) !important; }
        .border-left-success { border-left-color: var(--success) !important; }
        .border-left-info { border-left-color: var(--info) !important; }

        .text-xs { font-size: 0.75rem; }
        .text-gray-800 { color: #2d3748 !important; }
        .font-weight-bold { font-weight: 700 !important; }

        /* Body background */
        body {
            background: var(--background) !important;
        }

        .content {
            background: transparent !important;
        }

        /* Quick Actions */
        .btn-text {
            font-size: 0.875rem;
            white-space: nowrap;
        }

        .btn-lg {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        /* Custom button colors */
        .btn-primary {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }

        .btn-secondary {
            background-color: var(--secondary) !important;
            border-color: #ddd !important;
            color: var(--primary) !important;
        }

        .btn-secondary:hover {
            background-color: var(--secondary-dark) !important;
            border-color: #ccc !important;
            color: var(--primary-dark) !important;
        }

        .btn-success {
            background-color: var(--success) !important;
            border-color: var(--success) !important;
        }

        .btn-info {
            background-color: var(--info) !important;
            border-color: var(--info) !important;
        }

        .btn-warning {
            background-color: var(--warning) !important;
            border-color: var(--warning) !important;
            color: #212529 !important;
        }

        .btn-danger {
            background-color: var(--danger) !important;
            border-color: var(--danger) !important;
        }

        /* Avatar Circle */
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(19, 97, 99, 0.2);
        }

        /* Cards styling */
        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(19, 97, 99, 0.1);
            box-shadow: var(--shadow);
        }

        .card-header {
            background: var(--secondary-light);
            border-bottom: 1px solid rgba(19, 97, 99, 0.1);
        }

        .card-header h5 {
            color: var(--primary);
            font-weight: 600;
        }

        /* Exchange Details */
        .exchange-details {
            margin-left: 52px;
        }

        .exchange-details > div {
            display: flex;
            align-items: center;
            margin-bottom: 0.25rem;
        }

        /* Rental Period */
        .rental-period {
            margin-left: 52px;
            display: flex;
            align-items: center;
        }

        /* Enhanced Stats Cards */
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow);
            border: 1px solid var(--border-color);
        }

        .stat-card[data-stat="exchanges"]:hover {
            border-color: var(--primary);
        }

        .stat-card[data-stat="pending"]:hover {
            border-color: var(--warning);
        }

        .stat-card[data-stat="completed"]:hover {
            border-color: var(--success);
        }

        .stat-card[data-stat="rentals"]:hover {
            border-color: var(--info);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.4rem;
            position: relative;
            z-index: 2;
        }

        .icon-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 14px;
            opacity: 0.3;
            background: inherit;
            transform: scale(1.2);
        }

        .stat-info {
            flex: 1;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .stat-trend i {
            font-size: 0.7rem;
        }

        .stat-sparkline {
            display: flex;
            align-items: flex-end;
            gap: 2px;
            height: 30px;
        }

        .sparkline-bar {
            width: 4px;
            background: var(--primary);
            border-radius: 2px;
            opacity: 0.6;
            transition: all 0.3s ease;
        }

        .stat-card:hover .sparkline-bar {
            opacity: 1;
        }

        .content {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
            padding: 0 !important;
            min-height: 100vh;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }

        /* Ensure no horizontal overflow on mobile */
        body {
            overflow-x: hidden;
        }

        /* Box sizing for all elements */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        /* Seller Header */
        .seller-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0 0 16px 16px;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-lg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .seller-welcome {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .seller-avatar {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            font-size: 1rem;
        }

        .seller-name {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            color: white;
        }

        .seller-subtitle {
            margin: 0;
            opacity: 0.9;
            font-size: 0.8rem;
        }

        .seller-actions {
            display: flex;
            gap: 0.5rem;
        }

        .seller-actions .btn {
            border-radius: 20px;
            padding: 0.35rem 0.75rem;
            font-weight: 600;
            font-size: 0.8rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .seller-actions .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .seller-actions .btn-outline-light {
            background: transparent;
            color: white;
        }

        /* Chat Badge Animation */
        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .stat-icon.primary { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); }
        .stat-icon.success { background: linear-gradient(135deg, var(--success) 0%, #20c997 100%); }
        .stat-icon.warning { background: linear-gradient(135deg, var(--warning) 0%, #fd7e14 100%); }
        .stat-icon.info { background: linear-gradient(135deg, var(--info) 0%, #0dcaf0 100%); }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 1.5rem;
            margin: 0 1.5rem 1.5rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .dashboard-card .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 1.25rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }

        .dashboard-card .card-header h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-subtitle {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin: 0;
            font-weight: 400;
        }

        .dashboard-card .card-body {
            padding: 1.25rem;
        }

        /* Quick Actions */
        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .quick-actions .btn {
            flex: 1;
            min-width: 150px;
            position: relative;
        }

        .quick-actions .btn-info {
            position: relative;
        }

        .chat-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 10px;
            font-weight: 600;
            min-width: 18px;
            text-align: center;
            animation: pulse-badge 1s infinite;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.25rem 1rem;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.1);
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            color: var(--text-primary);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
        }

        .btn-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 0.75rem;
        }

        .action-btn.primary .btn-icon { background: var(--gradient-primary); color: white; }

        .action-btn.secondary .btn-icon { background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; }

        .action-btn.success .btn-icon { background: var(--gradient-success); color: white; }

        .action-btn.info .btn-icon { background: var(--gradient-info); color: white; }

        .action-btn.warning .btn-icon { background: var(--gradient-warning); color: white; }

        .action-btn.chat-btn { background: linear-gradient(135deg, #fd7e14 0%, #e83e8c 100%); color: white; position: relative; }
        .action-btn.chat-btn .btn-icon { background: rgba(255,255,255,0.2); color: white; }

        .action-btn span {
            font-weight: 600;
            font-size: 0.85rem;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .action-btn i {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .action-btn span {
            font-weight: 600;
            font-size: 0.8rem;
            text-align: center;
        }

        /* Chat Badge */
        .chat-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            font-size: 0.65rem;
            padding: 0.15rem 0.4rem;
            border-radius: 10px;
            font-weight: 600;
            min-width: 18px;
            text-align: center;
            animation: pulse-badge 1s infinite;
        }

        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        /* New Chats List in Tooltip */
        .new-chats-tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            color: var(--text-primary);
            padding: 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            white-space: nowrap;
            min-width: 250px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            margin-bottom: 10px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
        }

        .new-chats-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 8px solid transparent;
            border-top-color: white;
        }

        .new-chats-tooltip.show {
            opacity: 1;
            visibility: visible;
        }

        .new-chats-tooltip .tooltip-header {
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .new-chats-tooltip .tooltip-chat {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 6px;
            margin-bottom: 0.25rem;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .new-chats-tooltip .tooltip-chat:hover {
            background: var(--bg-light);
        }

        .new-chats-tooltip .tooltip-chat:last-child {
            margin-bottom: 0;
        }

        .new-chats-tooltip .tooltip-chat-avatar {
            width: 28px;
            height: 28px;
            background: var(--bg-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 0.8rem;
        }

        .new-chats-tooltip .tooltip-chat-info {
            flex: 1;
            overflow: hidden;
        }

        .new-chats-tooltip .tooltip-chat-name {
            font-weight: 600;
            font-size: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .new-chats-tooltip .tooltip-chat-time {
            font-size: 0.65rem;
            color: var(--text-secondary);
        }

        .new-chats-tooltip .tooltip-empty {
            color: var(--text-secondary);
            text-align: center;
            padding: 0.5rem;
        }

        /* Enhanced Exchange Cards */
        .requests-row {
            margin: 0 1.5rem 1.5rem;
        }

        .requests-row .exchanges-card,
        .requests-row .giveaway-card {
            margin: 0;
        }

        .exchanges-card, .giveaway-card {
            margin: 0 1.5rem 1.5rem;
        }

        .exchange-grid, .giveaway-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .exchange-card, .giveaway-card {
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.25rem;
            transition: all 0.4s ease;
            position: relative;
            background: white;
            overflow: hidden;
        }

        .exchange-card:hover, .giveaway-card:hover {
            border-color: var(--primary);
            box-shadow: 0 8px 30px rgba(15, 80, 87, 0.15);
            transform: translateY(-4px);
        }

        .exchange-card[data-status="pending"] {
            border-left: 4px solid var(--warning);
        }

        .exchange-card[data-status="accepted"] {
            border-left: 4px solid var(--success);
        }

        .exchange-card[data-status="completed"] {
            border-left: 4px solid var(--info);
        }



        .exchange-header, .giveaway-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .proposer-avatar {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .proposer-info {
            display: flex;
            flex-direction: column;
        }

        .proposer-name {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .exchange-date {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .exchange-status, .giveaway-status {
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            white-space: nowrap;
        }

        .status-icon {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
        }

        .exchange-status.pending { background: #fff3cd; color: #856404; }
        .exchange-status.pending .status-icon { background: #ffc107; }

        .exchange-status.accepted { background: #d4edda; color: #155724; }
        .exchange-status.accepted .status-icon { background: #28a745; }

        .exchange-status.rejected { background: #f8d7da; color: #721c24; }
        .exchange-status.rejected .status-icon { background: #dc3545; }

        .exchange-status.completed { background: #d1ecf1; color: #0c5460; }
        .exchange-status.completed .status-icon { background: #17a2b8; }

        .giveaway-status.pending { background: #fff3cd; color: #856404; }
        .giveaway-status.approved { background: #d1ecf1; color: #0c5460; }
        .giveaway-status.active { background: #d4edda; color: #155724; }
        .giveaway-status.completed { background: #d1ecf1; color: #0c5460; }
        .giveaway-status.rejected { background: #f8d7da; color: #721c24; }

        .exchange-body, .giveaway-body {
            margin-bottom: 1rem;
        }

        .exchange-offer, .exchange-request, .giveaway-product, .giveaway-date {
            padding: 0.75rem;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            border: 1px solid transparent;
        }

        .product-info {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .product-info i {
            color: var(--primary);
            margin-top: 0.1rem;
            font-size: 0.8rem;
        }

        .exchange-offer { background: #f0f9ff; border-color: #0ea5e9; }
        .exchange-offer i { color: #0ea5e9; }

        .exchange-request { background: #fef3c7; border-color: #f59e0b; }
        .exchange-request i { color: #f59e0b; }

        .giveaway-product { background: #f0fdf4; border-color: #10b981; }
        .giveaway-date { background: #f8fafc; border-color: #64748b; }

        .exchange-actions, .giveaway-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .action-btn-primary {
            background: var(--gradient-primary);
            color: white;
            border: none;
        }

        .action-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 80, 87, 0.3);
        }

        /* Enhanced Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
            color: var(--text-secondary);
            position: relative;
        }

        .empty-state.enhanced {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%);
            border-radius: 16px;
            border: 2px dashed var(--border-color);
            margin: 1rem 0;
        }

        .empty-icon {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .empty-icon i {
            font-size: 3.5rem;
            color: var(--primary);
            opacity: 0.6;
        }

        .icon-particles {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
        }

        .icon-particles span {
            position: absolute;
            width: 6px;
            height: 6px;
            background: var(--primary);
            border-radius: 50%;
            opacity: 0.4;
            animation: particle-float 3s ease-in-out infinite;
        }

        .icon-particles span:nth-child(1) {
            top: -10px;
            left: -10px;
            animation-delay: 0s;
        }

        .icon-particles span:nth-child(2) {
            top: -5px;
            right: -15px;
            animation-delay: 1s;
        }

        .icon-particles span:nth-child(3) {
            bottom: -10px;
            left: 10px;
            animation-delay: 2s;
        }

        @keyframes particle-float {
            0%, 100% { transform: translateY(0px) scale(1); opacity: 0.4; }
            50% { transform: translateY(-15px) scale(1.2); opacity: 0.8; }
        }

        .empty-state h4 {
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-size: 1.2rem;
            color: var(--text-primary);
        }

        .empty-state p {
            margin-bottom: 2rem;
            font-size: 0.9rem;
            line-height: 1.5;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .empty-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .empty-actions .btn {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .empty-actions .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        /* Mobile Responsive Design */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 0 15px;
            }

            .row {
                margin: 0 -10px;
            }

            .col-lg-6 {
                padding: 0 10px;
            }

            .btn-text {
                font-size: 0.75rem;
            }

            .avatar-circle {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }

            .exchange-details,
            .rental-period {
                margin-left: 45px;
            }

            .list-group-item {
                padding: 1rem 0;
            }

            body {
                background: var(--secondary) !important;
            }
        }

        @media (max-width: 576px) {
            .quick-actions .col-lg-2 {
                flex: 0 0 50%;
                max-width: 50%;
                margin-bottom: 0.5rem;
            }

            .quick-actions .btn {
                padding: 0.5rem 0.25rem;
            }

            .btn-text {
                font-size: 0.7rem;
            }

            .avatar-circle {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            .exchange-details,
            .rental-period {
                margin-left: 40px;
            }

            .card {
                margin-bottom: 1rem;
            }
        }

        /* Touch devices */
        @media (hover: none) and (pointer: coarse) {
            .stats-card:hover,
            .btn:hover {
                transform: none;
                box-shadow: var(--shadow);
            }

            .stats-card:active,
            .btn:active {
                transform: scale(0.98);
                transition: transform 0.1s ease;
            }

            .btn {
                min-height: 44px;
            }
        }

        /* Ensure consistent background */
        .content-wrapper {
            background: transparent !important;
        }

        .btn:hover {
            transform: translateY(-1px) !important;
        }

        /* Fully Responsive Design */

        /* Large screens (1200px and up) */
        @media (min-width: 1201px) {
            .welcome-section {
                margin: 0 2rem 2rem;
            }
            .stats-row, .dashboard-grid, .requests-row {
                margin: 0 2rem 2rem;
            }
        }

        /* Medium screens (992px to 1200px) */
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            .exchange-grid, .giveaway-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .welcome-section {
                margin: 0 1.5rem 1.5rem;
            }
        }

        /* Small screens (768px to 991px) */
        @media (max-width: 991px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
                margin: 0 1rem 1.5rem;
            }
            .welcome-section {
                margin: 0 1rem 1.5rem;
            }
        }

        /* Tablets and small devices (576px to 767px) */
        @media (max-width: 767px) {
            /* Welcome Section Mobile */
            .welcome-section {
                margin: 0 1rem 1.5rem;
                padding: 1.5rem 1rem;
                border-radius: 16px;
            }

            .welcome-content {
                flex-direction: column;
                gap: 1.5rem;
                text-align: center;
            }

            .welcome-text h2 {
                font-size: 1.8rem;
            }

            .welcome-text p {
                font-size: 1rem;
            }

            .quick-stats {
                justify-content: center;
                gap: 1.5rem;
            }

            .welcome-actions {
                justify-content: center;
                flex-wrap: wrap;
                gap: 0.75rem;
            }

            .cta-btn {
                padding: 0.875rem 1.25rem;
                font-size: 0.9rem;
            }

            .welcome-decoration {
                display: none; /* Hide floating shapes on mobile */
            }

            /* Stats Cards Mobile */
            .stats-row {
                grid-template-columns: 1fr;
                gap: 0.75rem;
                margin: 0 1rem 1.5rem;
            }

            .stat-card {
                padding: 1rem;
            }

            .stat-value {
                font-size: 1.75rem;
            }

            .stat-sparkline {
                height: 25px;
            }

            /* Dashboard Grid Mobile */
            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                margin: 0 1rem 1.5rem;
            }

            .action-buttons {
                grid-template-columns: repeat(3, 1fr);
                gap: 0.75rem;
            }

            .action-btn {
                padding: 1rem 0.5rem;
            }

            .btn-icon {
                width: 40px;
                height: 40px;
            }

            .action-btn span {
                font-size: 0.75rem;
            }

            /* Exchange Cards Mobile */
            .requests-row {
                flex-direction: column;
                gap: 1.5rem;
                margin: 0 1rem 1.5rem;
            }

            .exchange-grid, .giveaway-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .exchange-card, .giveaway-card {
                padding: 1rem;
            }

            .exchange-header, .giveaway-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .exchange-status, .giveaway-status {
                align-self: flex-end;
                font-size: 0.65rem;
                padding: 0.2rem 0.6rem;
            }

            /* Empty State Mobile */
            .empty-state {
                padding: 2rem 1rem;
            }

            .empty-state h4 {
                font-size: 1.1rem;
            }

            .empty-actions {
                flex-direction: column;
                gap: 0.75rem;
            }

            .empty-actions .btn {
                width: 100%;
                justify-content: center;
            }
        }

        /* Small phones (480px to 575px) */
        @media (max-width: 575px) {
            .welcome-section {
                margin: 0 0.75rem 1rem;
                padding: 1.25rem 0.75rem;
            }

            .welcome-text h2 {
                font-size: 1.5rem;
                margin-bottom: 0.5rem;
            }

            .quick-stats {
                flex-wrap: wrap;
                gap: 1rem;
                justify-content: space-around;
            }

            .quick-stat {
                flex: 1;
                min-width: 80px;
            }

            .stat-number {
                font-size: 1.5rem;
            }

            .stat-text {
                font-size: 0.8rem;
            }

            .cta-btn {
                padding: 0.75rem 1rem;
                font-size: 0.85rem;
            }

            .stats-row {
                margin: 0 0.75rem 1rem;
                gap: 0.5rem;
            }

            .stat-card {
                padding: 0.875rem;
            }

            .stat-value {
                font-size: 1.5rem;
            }

            .stat-label {
                font-size: 0.75rem;
            }

            .dashboard-grid, .requests-row {
                margin: 0 0.75rem 1rem;
                gap: 1rem;
            }

            .action-buttons {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }

            .action-btn {
                padding: 0.875rem 0.25rem;
            }

            .btn-icon {
                width: 36px;
                height: 36px;
            }

            .action-btn span {
                font-size: 0.7rem;
            }

            .dashboard-card .card-header {
                padding: 1rem 0.75rem;
            }

            .dashboard-card .card-header h3 {
                font-size: 1rem;
            }

            .card-subtitle {
                font-size: 0.75rem;
            }

            .dashboard-card .card-body {
                padding: 0.875rem;
            }

            .exchange-card, .giveaway-card {
                padding: 0.875rem;
            }

            .proposer-avatar {
                flex-direction: row;
                gap: 0.5rem;
            }

            .proposer-name {
                font-size: 0.85rem;
            }

            .exchange-date {
                font-size: 0.7rem;
            }

            .product-info small {
                font-size: 0.75rem;
            }

            .empty-state h4 {
                font-size: 1rem;
            }

            .empty-state p {
                font-size: 0.85rem;
                margin-bottom: 1.5rem;
            }
        }

        /* Extra small phones (320px to 479px) */
        @media (max-width: 479px) {
            .content {
                padding: 0.5rem !important;
            }

            .welcome-section {
                margin: 0 0.5rem 1rem;
                padding: 1rem 0.5rem;
                border-radius: 12px;
            }

            .welcome-text h2 {
                font-size: 1.3rem;
                line-height: 1.3;
            }

            .welcome-text p {
                font-size: 0.9rem;
                margin-bottom: 1rem;
            }

            .quick-stats {
                gap: 0.75rem;
            }

            .quick-stat {
                min-width: 70px;
            }

            .stat-number {
                font-size: 1.3rem;
            }

            .stat-text {
                font-size: 0.75rem;
            }

            .welcome-actions {
                gap: 0.5rem;
            }

            .cta-btn {
                padding: 0.625rem 0.875rem;
                font-size: 0.8rem;
                border-radius: 20px;
            }

            .stats-row {
                margin: 0 0.5rem 1rem;
                gap: 0.5rem;
            }

            .stat-card {
                padding: 0.75rem;
                border-radius: 12px;
            }

            .stat-value {
                font-size: 1.25rem;
            }

            .stat-label {
                font-size: 0.7rem;
            }

            .stat-trend {
                font-size: 0.7rem;
            }

            .stat-sparkline {
                height: 20px;
            }

            .sparkline-bar {
                width: 3px;
            }

            .dashboard-grid, .requests-row {
                margin: 0 0.5rem 1rem;
                gap: 1rem;
            }

            .action-buttons {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.5rem;
            }

            .action-btn {
                padding: 0.75rem 0.25rem;
                border-radius: 12px;
            }

            .btn-icon {
                width: 32px;
                height: 32px;
            }

            .action-btn span {
                font-size: 0.65rem;
                line-height: 1.2;
            }

            .dashboard-card {
                border-radius: 12px;
            }

            .dashboard-card .card-header {
                padding: 0.875rem 0.625rem;
            }

            .dashboard-card .card-header h3 {
                font-size: 0.95rem;
            }

            .card-subtitle {
                font-size: 0.7rem;
            }

            .dashboard-card .card-body {
                padding: 0.75rem 0.625rem;
            }

            .exchange-card, .giveaway-card {
                padding: 0.75rem;
                border-radius: 12px;
            }

            .proposer-avatar {
                gap: 0.5rem;
            }

            .avatar-circle {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
            }

            .proposer-name {
                font-size: 0.8rem;
            }

            .exchange-date {
                font-size: 0.65rem;
            }

            .exchange-status, .giveaway-status {
                padding: 0.15rem 0.5rem;
                font-size: 0.6rem;
                border-radius: 12px;
            }

            .product-info {
                gap: 0.25rem;
            }

            .product-info small {
                font-size: 0.7rem;
            }

            .exchange-offer, .exchange-request, .giveaway-product, .giveaway-date {
                padding: 0.5rem;
                border-radius: 6px;
                font-size: 0.8rem;
            }

            .exchange-actions, .giveaway-actions {
                margin-top: 0.5rem;
            }

            .action-btn-primary {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }

            .empty-state {
                padding: 1.5rem 0.75rem;
            }

            .empty-icon i {
                font-size: 2.5rem;
            }

            .empty-state h4 {
                font-size: 0.95rem;
                margin-bottom: 0.5rem;
            }

            .empty-state p {
                font-size: 0.8rem;
                margin-bottom: 1rem;
            }

            .empty-actions {
                gap: 0.5rem;
            }

            .empty-actions .btn {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
                border-radius: 20px;
            }
        }

        /* Ultra small screens (320px and below) */
        @media (max-width: 320px) {
            .welcome-section {
                margin: 0 0.25rem 0.75rem;
                padding: 0.875rem 0.375rem;
            }

            .welcome-text h2 {
                font-size: 1.2rem;
            }

            .welcome-text p {
                font-size: 0.85rem;
                margin-bottom: 0.875rem;
            }

            .quick-stats {
                gap: 0.5rem;
            }

            .quick-stat {
                min-width: 60px;
            }

            .stat-number {
                font-size: 1.2rem;
            }

            .stat-text {
                font-size: 0.7rem;
            }

            .cta-btn {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
            }

            .cta-btn i {
                font-size: 0.9rem;
            }

            .stats-row {
                margin: 0 0.25rem 0.75rem;
                gap: 0.375rem;
            }

            .stat-card {
                padding: 0.625rem;
            }

            .stat-value {
                font-size: 1.1rem;
            }

            .stat-label {
                font-size: 0.65rem;
            }

            .dashboard-grid, .requests-row {
                margin: 0 0.25rem 0.75rem;
                gap: 0.75rem;
            }

            .action-buttons {
                grid-template-columns: 1fr;
                gap: 0.375rem;
            }

            .action-btn {
                padding: 0.625rem 0.25rem;
                justify-content: center;
                text-align: center;
            }

            .btn-icon {
                width: 28px;
                height: 28px;
            }

            .action-btn span {
                font-size: 0.6rem;
            }

            .dashboard-card .card-header {
                padding: 0.75rem 0.5rem;
            }

            .dashboard-card .card-header h3 {
                font-size: 0.9rem;
            }

            .card-subtitle {
                font-size: 0.65rem;
            }

            .dashboard-card .card-body {
                padding: 0.625rem 0.5rem;
            }

            .exchange-card, .giveaway-card {
                padding: 0.625rem;
            }

            .avatar-circle {
                width: 28px;
                height: 28px;
                font-size: 0.8rem;
            }

            .proposer-name {
                font-size: 0.75rem;
            }

            .exchange-date {
                font-size: 0.6rem;
            }

            .exchange-status, .giveaway-status {
                padding: 0.125rem 0.375rem;
                font-size: 0.55rem;
            }

            .product-info small {
                font-size: 0.65rem;
            }

            .exchange-offer, .exchange-request, .giveaway-product, .giveaway-date {
                padding: 0.375rem;
                font-size: 0.75rem;
            }

            .empty-state {
                padding: 1.25rem 0.5rem;
            }

            .empty-icon i {
                font-size: 2.2rem;
            }

            .empty-state h4 {
                font-size: 0.9rem;
            }

            .empty-state p {
                font-size: 0.75rem;
            }

            .empty-actions .btn {
                padding: 0.375rem 0.875rem;
                font-size: 0.8rem;
            }
        }

        /* Touch device optimizations */
        @media (hover: none) and (pointer: coarse) {
            .stat-card:hover,
            .action-btn:hover,
            .exchange-card:hover,
            .giveaway-card:hover,
            .cta-btn:hover {
                transform: none;
                box-shadow: var(--shadow);
            }

            .action-btn:active,
            .stat-card:active,
            .cta-btn:active {
                transform: scale(0.98);
                transition: transform 0.1s ease;
            }

            /* Increase touch targets for better usability */
            .action-btn,
            .cta-btn,
            .btn {
                min-height: 44px; /* Apple's recommended minimum touch target */
                min-width: 44px;
            }

            .action-btn span {
                pointer-events: none; /* Prevent text selection on tap */
            }

            /* Better button spacing on touch devices */
            .action-buttons {
                gap: 0.75rem;
            }

            .welcome-actions {
                gap: 0.75rem;
            }
        }

        /* High DPI displays */
        @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
            .avatar-circle,
            .stat-icon .icon-bg,
            .btn-icon {
                image-rendering: -webkit-optimize-contrast;
            }
        }

        /* Print styles */
        @media print {
            .welcome-section,
            .action-buttons,
            .dashboard-card .card-header a {
                display: none !important;
            }

            .dashboard-card {
                break-inside: avoid;
                box-shadow: none;
                border: 1px solid #ddd;
            }
        }
    </style>
@stop

@section('js')
<script>
    // Audio notification sound
    const notificationSound = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');

    let previousUnreadCount = 0;

    // Update chat unread count
    function updateChatUnreadCount() {
        fetch('{{ route('buyer.chats.unread-count') }}')
            .then(response => response.json())
            .then(data => {
                const chatBadge = document.getElementById('chatBadge');
                if (chatBadge) {
                    if (data.count > 0) {
                        chatBadge.textContent = data.count > 99 ? '99+' : data.count;
                        chatBadge.style.display = 'inline-block';
                        // Add visual feedback
                        chatBadge.classList.add('pulse');
                        setTimeout(() => chatBadge.classList.remove('pulse'), 500);

                        // Play notification sound if new messages
                        if (data.count > previousUnreadCount) {
                            notificationSound.play().catch(() => {});
                        }
                        previousUnreadCount = data.count;
                    } else {
                        chatBadge.style.display = 'none';
                        previousUnreadCount = 0;
                    }

                    // Update page title with unread count
                    if (data.count > 0) {
                        document.title = `(${data.count}) Buyer Dashboard`;
                    } else {
                        document.title = 'Buyer Dashboard';
                    }
                }

                // Update tooltip with new chats
                updateChatsTooltip(data.chats);
            })
            .catch(error => {
                console.error('Error fetching chat count:', error);
            });
    }

    // Update tooltip with new chats
    function updateChatsTooltip(chats) {
        const tooltipId = 'buyerChatsTooltip';
        let tooltip = document.getElementById(tooltipId);

        if (!tooltip) {
            tooltip = document.createElement('div');
            tooltip.id = tooltipId;
            tooltip.className = 'new-chats-tooltip';
            document.body.appendChild(tooltip);
        }

        if (chats && chats.length > 0) {
            let html = '<div class="tooltip-header">New Messages</div>';
            chats.forEach(chat => {
                html += `
                    <div class="tooltip-chat" onclick="window.location.href='/buyer/chats/${chat.id}'">
                        <div class="tooltip-chat-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="tooltip-chat-info">
                            <div class="tooltip-chat-name">${chat.user_name}</div>
                            <div class="tooltip-chat-time">${chat.last_message_at} ${chat.unread_count > 0 ? `• ${chat.unread_count} new` : ''}</div>
                        </div>
                    </div>
                `;
            });
            tooltip.innerHTML = html;
        } else {
            tooltip.innerHTML = '<div class="tooltip-empty">No new messages</div>';
        }

        // Position tooltip
        const chatBtn = document.getElementById('chatActionBtn');
        if (chatBtn) {
            const rect = chatBtn.getBoundingClientRect();
            tooltip.style.left = rect.left + rect.width / 2 + 'px';
            tooltip.style.top = rect.top + 'px';
        }
    }

    // Setup chat tooltip hover
    document.addEventListener('DOMContentLoaded', function() {
        const chatBtn = document.getElementById('chatActionBtn');
        if (chatBtn) {
            chatBtn.addEventListener('mouseenter', function() {
                fetch('{{ route('buyer.chats.unread-count') }}')
                    .then(response => response.json())
                    .then(data => {
                        updateChatsTooltip(data.chats);
                        const tooltip = document.getElementById('buyerChatsTooltip');
                        if (tooltip) {
                            tooltip.classList.add('show');
                        }
                    });
            });

            chatBtn.addEventListener('mouseleave', function() {
                const tooltip = document.getElementById('buyerChatsTooltip');
                if (tooltip) {
                    tooltip.classList.remove('show');
                }
            });
        }

        // Initial fetch
        updateChatUnreadCount();

        // Update every 5 seconds
        setInterval(updateChatUnreadCount, 5000);

        // Also update when page becomes visible
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                updateChatUnreadCount();
            }
        });
    });
</script>
@stop
