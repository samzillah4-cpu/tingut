@extends('adminlte::page')

@section('title', 'Seller Dashboard')

@section('content_header')
    <div class="seller-header">
        <div class="seller-welcome">
            <div class="seller-avatar">
                <i class="fas fa-store"></i>
            </div>
            <div class="seller-info">
                <h1 class="seller-name">Welcome back, {{ auth()->user()->name }}</h1>
                <p class="seller-subtitle">Manage your products and grow your business</p>
            </div>
        </div>
        <div class="seller-actions">
            <a href="{{ route('seller.products.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Post New Product
            </a>
            <a href="{{ route('subscriptions') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-crown me-1"></i>Subscription
            </a>
        </div>
    </div>
@stop

@section('content')
    <!-- Subscription Status Banner -->
    @if($subscriptionStatus === 'Inactive')
        <div class="subscription-banner warning">
            <div class="banner-content">
                <i class="fas fa-exclamation-triangle"></i>
                <div class="banner-text">
                    <strong>Subscription Required</strong>
                    <span>Subscribe to a plan to start posting products</span>
                </div>
                <a href="{{ route('subscriptions') }}" class="btn btn-warning btn-sm">Subscribe Now</a>
            </div>
        </div>
    @else
        <div class="subscription-banner success">
            <div class="banner-content">
                <i class="fas fa-check-circle"></i>
                <div class="banner-text">
                    <strong>{{ $subscriptionPlan }} Plan Active</strong>
                    <span>Expires on {{ $subscriptionEndDate }}</span>
                </div>
                <a href="{{ route('subscriptions') }}" class="btn btn-success btn-sm">Manage Plan</a>
            </div>
        </div>
    @endif

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" id="stat-products-count">{{ $productsCount }}</div>
                <div class="stat-label">Total Products</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" id="stat-active-products-count">{{ $activeProductsCount }}</div>
                <div class="stat-label">Active Listings</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" id="stat-pending-exchanges-count">{{ $pendingExchangesCount }}</div>
                <div class="stat-label">Pending Exchanges</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">{{ $sellerLocation }}</div>
                <div class="stat-label">Your Location</div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Quick Actions -->
        <div class="dashboard-card actions-card">
            <div class="card-header">
                <h3><i class="fas fa-bolt me-2"></i>Quick Actions</h3>
            </div>
            <div class="card-body">
                <div class="action-buttons">
                    <a href="{{ route('seller.products.create') }}" class="action-btn primary">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Product</span>
                    </a>
                    <a href="{{ route('seller.products.index') }}" class="action-btn secondary">
                        <i class="fas fa-list"></i>
                        <span>Manage Products</span>
                    </a>
                    <a href="{{ route('seller.exchanges.index') }}" class="action-btn success">
                        <i class="fas fa-exchange-alt"></i>
                        <span>Exchanges</span>
                    </a>
                    <a href="{{ route('messages.inbox') }}" class="action-btn warning">
                        <i class="fas fa-envelope"></i>
                        <span>Messages</span>
                    </a>
                    <a href="{{ route('seller.account.edit') }}" class="action-btn info">
                        <i class="fas fa-user-cog"></i>
                        <span>Account</span>
                    </a>
                    <a href="{{ route('seller.chats.index') }}" class="action-btn chat-btn" id="chatActionBtn">
                        <i class="fas fa-comments"></i>
                        <span>Chats</span>
                        <span class="chat-badge" id="chatBadge" style="display: none;">0</span>
                    </a>
                    <a href="{{ route('subscriptions') }}" class="action-btn royal">
                        <i class="fas fa-crown"></i>
                        <span>Subscription</span>
                    </div>
            </div>
        </a>
                </div>

        <!-- Recent Products -->
        <div class="dashboard-card products-card">
            <div class="card-header">
                <h3><i class="fas fa-box me-2"></i>Recent Products</h3>
                <a href="{{ route('seller.products.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentProducts->count() > 0)
                    <div class="product-grid">
                        @foreach($recentProducts->take(4) as $product)
                            <div class="product-card">
                                <div class="product-image">
                                    @if($product->images && count($product->images) > 0)
                                        @if(str_starts_with($product->images[0], 'http'))
                                            <img src="{{ $product->images[0] }}" alt="{{ $product->title }}">
                                        @else
                                            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->title }}">
                                        @endif
                                    @else
                                        <div class="no-image">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    @endif
                                    <span class="status-badge {{ $product->status }}">{{ ucfirst($product->status) }}</span>
                                </div>
                                <div class="product-details">
                                    <h4>{{ Str::limit($product->title, 25) }}</h4>
                                    <p class="category">{{ $product->category->name }}</p>
                                    <div class="product-actions">
                                        <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('seller.products.show', $product) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <h4>No products yet</h4>
                        <p>Start by adding your first product</p>
                        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Product
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Exchange Proposals & Giveaway Requests Row -->
    <div class="requests-row">
        <!-- Exchange Proposals -->
        <div class="dashboard-card exchanges-card">
            <div class="card-header">
                <h3><i class="fas fa-exchange-alt me-2"></i>Exchange Proposals</h3>
                <a href="{{ route('seller.exchanges.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body" id="exchanges-widget-container">
                @php
                    $recentExchanges = \App\Models\Exchange::whereHas('requestedProduct', function($query) {
                        $query->where('user_id', auth()->id());
                    })->with(['proposer', 'offeredProduct', 'requestedProduct'])->latest()->take(3)->get();
                @endphp

                @if($recentExchanges->count() > 0)
                    <div class="exchange-grid">
                        @foreach($recentExchanges as $exchange)
                            <div class="exchange-card">
                                <div class="exchange-header">
                                    <div class="proposer-info">
                                        <i class="fas fa-user-circle"></i>
                                        <span>{{ $exchange->proposer->name }}</span>
                                    </div>
                                    <span class="exchange-status {{ $exchange->status }}">{{ ucfirst($exchange->status) }}</span>
                                </div>
                                <div class="exchange-body">
                                    <div class="exchange-offer">
                                        <small>Offers:</small>
                                        <strong>{{ Str::limit($exchange->offeredProduct->title, 30) }}</strong>
                                    </div>
                                    <div class="exchange-request">
                                        <small>For your:</small>
                                        <strong>{{ Str::limit($exchange->requestedProduct->title, 30) }}</strong>
                                    </div>
                                </div>
                                <div class="exchange-actions">
                                    @if($exchange->status === 'pending')
                                        <button class="btn btn-sm btn-success" onclick="updateExchange({{ $exchange->id }}, 'accepted')">
                                            Accept
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="updateExchange({{ $exchange->id }}, 'rejected')">
                                            Reject
                                        </button>
                                    @else
                                        <a href="{{ route('seller.exchanges.show', $exchange) }}" class="btn btn-sm btn-outline-primary">
                                            View Details
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-exchange-alt"></i>
                        <h4>No exchange proposals</h4>
                        <p>Exchange proposals will appear here when buyers show interest</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Giveaway Requests -->
        <div class="dashboard-card giveaway-card">
            <div class="card-header">
                <h3><i class="fas fa-gift me-2"></i>Giveaway Requests</h3>
                <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body" id="giveaways-widget-container">
                @php
                    $recentGiveawayRequests = \App\Models\GiveawayRequest::whereHas('product', function($query) {
                        $query->where('user_id', auth()->id());
                    })->with(['requester', 'product'])->latest()->take(3)->get();
                @endphp

                @if($recentGiveawayRequests->count() > 0)
                    <div class="giveaway-grid">
                        @foreach($recentGiveawayRequests as $request)
                            <div class="giveaway-card">
                                <div class="giveaway-header">
                                    <div class="requester-info">
                                        <i class="fas fa-user-circle"></i>
                                        <span>{{ $request->requester->name }}</span>
                                    </div>
                                    <span class="giveaway-status {{ $request->status }}">{{ ucfirst($request->status) }}</span>
                                </div>
                                <div class="giveaway-body">
                                    <div class="giveaway-product">
                                        <small>Requested:</small>
                                        <strong>{{ Str::limit($request->product->title, 35) }}</strong>
                                    </div>
                                    <div class="giveaway-date">
                                        <small>{{ $request->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                                <div class="giveaway-actions">
                                    @if($request->status === 'pending')
                                        <button class="btn btn-sm btn-success" onclick="updateGiveawayRequest({{ $request->id }}, 'approved')">
                                            Approve
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="updateGiveawayRequest({{ $request->id }}, 'rejected')">
                                            Reject
                                        </button>
                                    @else
                                        <span class="text-muted small">
                                            @if($request->status === 'approved')
                                                Approved {{ $request->approved_at ? $request->approved_at->diffForHumans() : '' }}
                                            @else
                                                Rejected
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-gift"></i>
                        <h4>No giveaway requests</h4>
                        <p>Giveaway requests will appear here when people request your free items</p>
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

        /* Website colors integration */
        :root {
            --primary: #0f5057;
            --primary-light: #147a8a;
            --primary-dark: #0a3540;
            --secondary: #faf4d7;
            --secondary-dark: #f5eac4;
            --success: #28a745;
            --warning: #ffc107;
            --info: #17a2b8;
            --royal: #6f42c1;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --border-color: #e9ecef;
            --bg-light: #f8f9fa;
            --shadow: 0 2px 8px rgba(15, 80, 87, 0.1);
            --shadow-lg: 0 4px 16px rgba(15, 80, 87, 0.15);
        }

        .content {
            background: var(--bg-light) !important;
            padding: 0 !important;
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

        /* Subscription Banner */
        .subscription-banner {
            margin: 0 1.5rem 1.5rem;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .subscription-banner.warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border-left: 4px solid var(--warning);
        }

        .subscription-banner.success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 4px solid var(--success);
        }

        .banner-content {
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .banner-content i {
            font-size: 1.25rem;
            color: #495057;
        }

        .banner-text strong {
            display: block;
            font-size: 1rem;
            color: #495057;
        }

        .banner-text span {
            color: #6c757d;
            font-size: 0.85rem;
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin: 0 1.5rem 1.5rem;
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
            background: var(--bg-light);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-card .card-header h3 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .dashboard-card .card-body {
            padding: 1.25rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1rem 0.75rem;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .action-btn.primary { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; }
        .action-btn.secondary { background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; }
        .action-btn.success { background: linear-gradient(135deg, var(--success) 0%, #20c997 100%); color: white; }
        .action-btn.warning { background: linear-gradient(135deg, var(--warning) 0%, #fd7e14 100%); color: #212529; }
        .action-btn.info { background: linear-gradient(135deg, var(--info) 0%, #0dcaf0 100%); color: white; }
        .action-btn.royal { background: linear-gradient(135deg, var(--royal) 0%, #e83e8c 100%); color: white; }
        .action-btn.chat-btn { background: linear-gradient(135deg, #fd7e14 0%, #e83e8c 100%); color: white; position: relative; }

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

        /* Chat Tooltip */
        .chat-tooltip {
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #212529;
            color: white;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            margin-bottom: 5px;
        }

        .chat-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 5px solid transparent;
            border-top-color: #212529;
        }

        .action-btn:hover .chat-tooltip {
            opacity: 1;
            visibility: visible;
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

        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .product-card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow);
        }

        .product-image {
            position: relative;
            height: 100px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-image .no-image {
            width: 100%;
            height: 100%;
            background: var(--bg-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            font-size: 2rem;
        }

        .product-image .status-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            padding: 0.25rem 0.5rem;
            border-radius: 8px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-badge.active { background: #d4edda; color: #155724; }
        .status-badge.inactive { background: #f8d7da; color: #721c24; }

        .product-details {
            padding: 0.75rem;
        }

        .product-details h4 {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 0.25rem 0;
        }

        .product-details .category {
            color: var(--text-secondary);
            font-size: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .product-actions {
            display: flex;
            gap: 0.5rem;
        }

        .product-actions .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        /* Exchange Cards */
        .requests-row {
            display: flex;
            gap: 1.5rem;
            margin: 0 1.5rem 1.5rem;
        }

        .requests-row .exchanges-card,
        .requests-row .giveaway-card {
            flex: 1;
            margin: 0;
        }

        .exchanges-card, .giveaway-card {
            margin: 0 1.5rem 1.5rem;
        }

        .exchange-grid, .giveaway-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .exchange-card, .giveaway-card-item {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .exchange-card:hover, .giveaway-card-item:hover {
            border-color: var(--warning-color);
            box-shadow: var(--shadow);
        }

        .exchange-header, .giveaway-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .proposer-info, .requester-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .proposer-info i, .requester-info i {
            color: var(--primary);
        }

        .exchange-status, .giveaway-status {
            padding: 0.2rem 0.5rem;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .exchange-status.pending { background: #fff3cd; color: #856404; }
        .exchange-status.accepted { background: #d4edda; color: #155724; }
        .exchange-status.rejected { background: #f8d7da; color: #721c24; }

        .giveaway-status.pending { background: #fff3cd; color: #856404; }
        .giveaway-status.approved { background: #d1ecf1; color: #0c5460; }
        .giveaway-status.rejected { background: #f8d7da; color: #721c24; }

        .exchange-body, .giveaway-body {
            margin-bottom: 0.75rem;
        }

        .exchange-offer, .exchange-request, .giveaway-product, .giveaway-date {
            padding: 0.5rem;
            border-radius: 6px;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
        }

        .exchange-offer { background: #f8f9fa; border-left: 3px solid var(--success); }
        .exchange-request { background: #fff3cd; border-left: 3px solid var(--warning); }
        .giveaway-product { background: #f8f9fa; border-left: 3px solid var(--info); }
        .giveaway-date { background: #e9ecef; border-left: 3px solid #6c757d; font-size: 0.8rem; }

        .exchange-actions, .giveaway-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 2rem 1rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
            opacity: 0.5;
        }

        .empty-state h4 {
            font-weight: 600;
            margin-bottom: 0.25rem;
            font-size: 1rem;
        }

        .empty-state p {
            margin-bottom: 1rem;
            font-size: 0.85rem;
        }

        /* Buttons */
        .btn {
            border-radius: 8px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }

        .btn:hover {
            transform: translateY(-1px) !important;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            .exchange-grid, .giveaway-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 992px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
            .product-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .stats-row {
                grid-template-columns: 1fr;
                margin: 0 1rem 1.5rem;
            }
            .dashboard-grid {
                margin: 0 1rem 1.5rem;
            }
            .requests-row {
                flex-direction: column;
                margin: 0 1rem 1.5rem;
            }
            .exchanges-card, .giveaway-card {
                margin: 0;
            }
            .exchanges-card {
                margin-bottom: 1rem;
            }
            .exchange-grid, .giveaway-grid {
                grid-template-columns: 1fr;
            }
            .seller-header {
                padding: 0.75rem 1rem;
                border-radius: 0 0 12px 12px;
                flex-direction: column;
                text-align: center;
            }
            .seller-welcome {
                flex-direction: column;
                gap: 0.5rem;
            }
            .seller-actions {
                justify-content: center;
                flex-wrap: wrap;
                margin-top: 0.5rem;
            }
            .action-buttons {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 480px) {
            .action-buttons {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@stop

@section('js')
<script>
// Real-time dashboard stats update
function updateDashboardStats() {
    fetch('{{ route('seller.dashboard.stats') }}')
        .then(response => response.json())
        .then(data => {
            // Update stats values with animation
            updateStatValue('products-count', data.products_count);
            updateStatValue('active-products-count', data.active_products_count);
            updateStatValue('pending-exchanges-count', data.pending_exchanges_count);

            // Update subscription banner
            const subscriptionBanner = document.querySelector('.subscription-banner');
            if (subscriptionBanner) {
                if (data.subscription_status === 'Inactive') {
                    subscriptionBanner.classList.remove('success');
                    subscriptionBanner.classList.add('warning');
                    subscriptionBanner.innerHTML = `
                        <div class="banner-content">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div class="banner-text">
                                <strong>Subscription Required</strong>
                                <span>Subscribe to a plan to start posting products</span>
                            </div>
                            <a href="{{ route('subscriptions') }}" class="btn btn-warning btn-sm">Subscribe Now</a>
                        </div>
                    `;
                } else {
                    subscriptionBanner.classList.remove('warning');
                    subscriptionBanner.classList.add('success');
                    subscriptionBanner.innerHTML = `
                        <div class="banner-content">
                            <i class="fas fa-check-circle"></i>
                            <div class="banner-text">
                                <strong>${data.subscription_plan} Plan Active</strong>
                                <span>Expires on ${data.subscription_end_date}</span>
                            </div>
                            <a href="{{ route('subscriptions') }}" class="btn btn-success btn-sm">Manage Plan</a>
                        </div>
                    `;
                }
            }

            // Update page title badge if subscription is inactive
            document.title = data.subscription_status === 'Inactive'
                ? '⚠️ Seller Dashboard - Subscription Required'
                : 'Seller Dashboard';
        })
        .catch(error => {
            console.error('Error fetching dashboard stats:', error);
        });
}

// Real-time dashboard widgets update (exchanges & giveaways)
function updateDashboardWidgets() {
    fetch('{{ route('seller.dashboard.widgets') }}')
        .then(response => response.json())
        .then(data => {
            // Update exchanges widget
            updateExchangesWidget(data.exchanges);

            // Update giveaways widget
            updateGiveawaysWidget(data.giveaways);
        })
        .catch(error => {
            console.error('Error fetching dashboard widgets:', error);
        });
}

function updateExchangesWidget(exchanges) {
    const container = document.getElementById('exchanges-widget-container');
    if (!container) return;

    if (exchanges && exchanges.length > 0) {
        let html = '<div class="exchange-grid">';
        exchanges.forEach(exchange => {
            html += `
                <div class="exchange-card">
                    <div class="exchange-header">
                        <div class="proposer-info">
                            <i class="fas fa-user-circle"></i>
                            <span>${exchange.proposer_name}</span>
                        </div>
                        <span class="exchange-status ${exchange.status}">${exchange.status}</span>
                    </div>
                    <div class="exchange-body">
                        <div class="exchange-offer">
                            <small>Offers:</small>
                            <strong>${exchange.offered_product_title}</strong>
                        </div>
                        <div class="exchange-request">
                            <small>For your:</small>
                            <strong>${exchange.requested_product_title}</strong>
                        </div>
                    </div>
                    <div class="exchange-actions">
                        ${exchange.status === 'pending' ? `
                            <button class="btn btn-sm btn-success" onclick="updateExchange(${exchange.id}, 'accepted')">
                                Accept
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="updateExchange(${exchange.id}, 'rejected')">
                                Reject
                            </button>
                        ` : `
                            <a href="/seller/exchanges/${exchange.id}" class="btn btn-sm btn-outline-primary">
                                View Details
                            </a>
                        `}
                    </div>
                </div>
            `;
        });
        html += '</div>';
        container.innerHTML = html;
    } else {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-exchange-alt"></i>
                <h4>No exchange proposals</h4>
                <p>Exchange proposals will appear here when buyers show interest</p>
            </div>
        `;
    }
}

function updateGiveawaysWidget(giveaways) {
    const container = document.getElementById('giveaways-widget-container');
    if (!container) return;

    if (giveaways && giveaways.length > 0) {
        let html = '<div class="giveaway-grid">';
        giveaways.forEach(request => {
            html += `
                <div class="giveaway-card">
                    <div class="giveaway-header">
                        <div class="requester-info">
                            <i class="fas fa-user-circle"></i>
                            <span>${request.requester_name}</span>
                        </div>
                        <span class="giveaway-status ${request.status}">${request.status}</span>
                    </div>
                    <div class="giveaway-body">
                        <div class="giveaway-product">
                            <small>Requested:</small>
                            <strong>${request.product_title}</strong>
                        </div>
                        <div class="giveaway-date">
                            <small>${request.created_at}</small>
                        </div>
                    </div>
                    <div class="giveaway-actions">
                        ${request.status === 'pending' ? `
                            <button class="btn btn-sm btn-success" onclick="updateGiveawayRequest(${request.id}, 'approved')">
                                Approve
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="updateGiveawayRequest(${request.id}, 'rejected')">
                                Reject
                            </button>
                        ` : `
                            <span class="text-muted small">
                                ${request.status === 'approved' ? 'Approved' : 'Rejected'}
                            </span>
                        `}
                    </div>
                </div>
            `;
        });
        html += '</div>';
        container.innerHTML = html;
    } else {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-gift"></i>
                <h4>No giveaway requests</h4>
                <p>Giveaway requests will appear here when people request your free items</p>
            </div>
        `;
    }
}

function updateStatValue(elementId, newValue) {
    const element = document.getElementById('stat-' + elementId);
    if (element && element.textContent != newValue) {
        // Add pulse animation
        element.classList.add('pulse');
        element.textContent = newValue;
        setTimeout(() => {
            element.classList.remove('pulse');
        }, 500);
    }
}

function updateExchange(exchangeId, status) {
    if (confirm('Are you sure you want to ' + status + ' this exchange proposal?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/seller/exchanges/${exchangeId}`;

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';
        form.appendChild(methodField);

        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'status';
        statusField.value = status;
        form.appendChild(statusField);

        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = '{{ csrf_token() }}';
        form.appendChild(csrfField);

        document.body.appendChild(form);
        form.submit();
    }
}

function updateGiveawayRequest(requestId, status) {
    if (confirm('Are you sure you want to ' + status + ' this giveaway request?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/giveaway-requests/${requestId}`;

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';
        form.appendChild(methodField);

        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'status';
        statusField.value = status;
        form.appendChild(statusField);

        const csrfField = document.createElement('input');
        csrfField.type = 'hidden';
        csrfField.name = '_token';
        csrfField.value = '{{ csrf_token() }}';
        form.appendChild(csrfField);

        document.body.appendChild(form);
        form.submit();
    }
}

// Initialize real-time updates when page loads
let lastNotificationCheck = new Date();

document.addEventListener('DOMContentLoaded', function() {
    // Initial fetch
    updateDashboardStats();
    updateDashboardWidgets();
    updateChatUnreadCount();

    // Update every 30 seconds
    setInterval(updateDashboardStats, 30000);
    setInterval(updateDashboardWidgets, 30000);
    setInterval(updateChatUnreadCount, 15000); // Check for new chats every 15 seconds

    // Also update when page becomes visible (after switching tabs)
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            updateDashboardStats();
            updateDashboardWidgets();
            updateChatUnreadCount();
        }
    });

    // Setup chat tooltip hover
    const chatBtn = document.getElementById('chatActionBtn');
    if (chatBtn) {
        chatBtn.addEventListener('mouseenter', function() {
            fetchNewChatsTooltip();
        });
    }

    // Setup polling for new message notifications with sound and tooltip
    setupMessageNotificationPolling();
});

// Play notification sound (WhatsApp-style)
function playNotificationSound() {
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);

        // WhatsApp-style notification sound
        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(587.33, audioContext.currentTime); // D5
        oscillator.frequency.setValueAtTime(783.99, audioContext.currentTime + 0.1); // G5

        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);

        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.3);
    } catch (e) {
        console.log('Audio playback not supported');
    }
}

// Setup polling for new message notifications
function setupMessageNotificationPolling() {
    // Check for new messages every 10 seconds
    setInterval(checkForNewMessages, 10000);

    // Also check when page becomes visible
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            checkForNewMessages();
        }
    });
}

// Check for new messages and show notification
function checkForNewMessages() {
    fetch('{{ route('seller.chats.notifications') }}')
        .then(response => response.json())
        .then(data => {
            const now = new Date();

            if (data.notifications && data.notifications.length > 0) {
                data.notifications.forEach(notification => {
                    const notificationTime = new Date(notification.created_at);

                    if (notificationTime > lastNotificationCheck) {
                        // New notification! Play sound and show tooltip
                        playNotificationSound();
                        showMessageNotificationToast(notification);
                        updateChatUnreadCount();
                    }
                });
            }

            lastNotificationCheck = now;
        })
        .catch(error => {
            console.error('Error checking messages:', error);
        });
}

// Show message notification toast
function showMessageNotificationToast(notification) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = 'message-notification-toast';
    toast.innerHTML = `
        <div class="toast-content">
            <div class="toast-icon">
                <i class="fab fa-whatsapp"></i>
            </div>
            <div class="toast-body">
                <div class="toast-title">${notification.user_name}</div>
                <div class="toast-message">${notification.last_message}</div>
                <div class="toast-time">${notification.time_ago}</div>
            </div>
            <button class="toast-close" onclick="this.parentElement.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `;

    // Add styles
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        color: white;
        padding: 12px 16px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4);
        z-index: 9999;
        animation: slideIn 0.3s ease-out;
        max-width: 320px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        cursor: pointer;
    `;

    const toastContent = toast.querySelector('.toast-content');
    toastContent.style.cssText = `
        display: flex;
        align-items: flex-start;
        gap: 12px;
    `;

    const toastIcon = toast.querySelector('.toast-icon');
    toastIcon.style.cssText = `
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    `;

    const toastBody = toast.querySelector('.toast-body');
    toastBody.style.cssText = `
        flex: 1;
        min-width: 0;
    `;

    const toastTitle = toast.querySelector('.toast-title');
    toastTitle.style.cssText = `
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 2px;
    `;

    const toastMessage = toast.querySelector('.toast-message');
    toastMessage.style.cssText = `
        font-size: 13px;
        opacity: 0.95;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    `;

    const toastTime = toast.querySelector('.toast-time');
    toastTime.style.cssText = `
        font-size: 11px;
        opacity: 0.8;
        margin-top: 2px;
    `;

    const toastClose = toast.querySelector('.toast-close');
    toastClose.style.cssText = `
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        padding: 4px;
        opacity: 0.7;
        transition: opacity 0.2s;
    `;

    toast.querySelector('.toast-close').addEventListener('mouseenter', function() {
        this.style.opacity = '1';
    });
    toast.querySelector('.toast-close').addEventListener('mouseleave', function() {
        this.style.opacity = '0.7';
    });

    // Add animation keyframes if not exists
    if (!document.getElementById('toastAnimations')) {
        const style = document.createElement('style');
        style.id = 'toastAnimations';
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);
    }

    document.body.appendChild(toast);

    // Auto-remove after 5 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease-out forwards';
        setTimeout(() => toast.remove(), 300);
    }, 5000);

    // Click to open chat
    toast.addEventListener('click', function(e) {
        if (!e.target.closest('.toast-close')) {
            window.location.href = notification.chat_url;
        }
    });
}

// Update chat unread count
function updateChatUnreadCount() {
    fetch('{{ route('seller.chats.unread-count') }}')
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
                } else {
                    chatBadge.style.display = 'none';
                }
            }

            // Update page title with unread count
            if (data.count > 0) {
                document.title = `(${data.count}) Seller Dashboard`;
            } else {
                document.title = 'Seller Dashboard';
            }
        })
        .catch(error => {
            console.error('Error fetching chat count:', error);
        });
}

// Fetch new chats for tooltip
function fetchNewChatsTooltip() {
    fetch('{{ route('seller.chats.unread-count') }}')
        .then(response => response.json())
        .then(data => {
            const tooltipId = 'newChatsTooltip';
            let tooltip = document.getElementById(tooltipId);

            if (!tooltip) {
                tooltip = document.createElement('div');
                tooltip.id = tooltipId;
                tooltip.className = 'new-chats-tooltip';
                document.body.appendChild(tooltip);
            }

            if (data.chats && data.chats.length > 0) {
                let html = '<div class="tooltip-header">New Messages</div>';
                data.chats.forEach(chat => {
                    html += `
                        <div class="tooltip-chat" onclick="window.location.href='/seller/chats/${chat.id}'">
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
        })
        .catch(error => {
            console.error('Error fetching new chats:', error);
        });
}
</script>
<style>
/* Add pulse animation for stats updates */
.pulse {
    animation: pulse 0.5s ease-in-out;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); color: var(--primary); }
    100% { transform: scale(1); }
}
</style>
@stop
