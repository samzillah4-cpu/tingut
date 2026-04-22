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
    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-exchange-alt"></i>
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

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Quick Actions -->
        <div class="dashboard-card actions-card">
            <div class="card-header">
                <h3><i class="fas fa-bolt me-2"></i>Quick Actions</h3>
            </div>
            <div class="card-body">
                <div class="action-buttons">
                    <a href="{{ route('products.index') }}" class="action-btn primary">
                        <i class="fas fa-search"></i>
                        <span>Browse Products</span>
                    </a>
                    <a href="{{ route('buyer.exchanges.index') }}" class="action-btn secondary">
                        <i class="fas fa-list"></i>
                        <span>My Exchanges</span>
                    </a>
                    <a href="{{ route('buyer.rentals.index') }}" class="action-btn success">
                        <i class="fas fa-calendar-alt"></i>
                        <span>My Rentals</span>
                    </a>
                    <a href="{{ route('buyer.chats.admin') }}" class="action-btn chat-btn" id="chatActionBtn">
                        <i class="fas fa-comments"></i>
                        <span>Chat with Admin</span>
                        <span class="chat-badge" id="chatBadge" style="display: none;">0</span>
                    </a>
                    <a href="{{ route('buyer.account.edit') }}" class="action-btn info">
                        <i class="fas fa-user-cog"></i>
                        <span>Account</span>
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
                                        <a href="{{ route('buyer.exchanges.show', $exchange) }}" class="btn btn-sm btn-outline-primary">
                                            Review
                                        </a>
                                    @else
                                        <a href="{{ route('buyer.exchanges.show', $exchange) }}" class="btn btn-sm btn-outline-primary">
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
                        <h4>No exchange requests yet</h4>
                        <p>When someone wants to exchange with you, requests will appear here</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Browse Products
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Second Row -->
    <div class="requests-row">
        <!-- My Sent Exchanges -->
        <div class="dashboard-card exchanges-card">
            <div class="card-header">
                <h3><i class="fas fa-sign-out-alt me-2"></i>My Sent Proposals</h3>
                <a href="{{ route('buyer.exchanges.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @if($recentSentExchanges->count() > 0)
                    <div class="exchange-grid">
                        @foreach($recentSentExchanges as $exchange)
                            <div class="exchange-card">
                                <div class="exchange-header">
                                    <div class="proposer-info">
                                        <i class="fas fa-store"></i>
                                        <span>{{ $exchange->requestedProduct->user->name }}</span>
                                    </div>
                                    <span class="exchange-status {{ $exchange->status }}">{{ ucfirst($exchange->status) }}</span>
                                </div>
                                <div class="exchange-body">
                                    <div class="exchange-offer">
                                        <small>You Offer:</small>
                                        <strong>{{ Str::limit($exchange->offeredProduct->title, 30) }}</strong>
                                    </div>
                                    <div class="exchange-request">
                                        <small>For Their:</small>
                                        <strong>{{ Str::limit($exchange->requestedProduct->title, 30) }}</strong>
                                    </div>
                                </div>
                                <div class="exchange-actions">
                                    <a href="{{ route('buyer.exchanges.show', $exchange) }}" class="btn btn-sm btn-outline-primary">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-paper-plane"></i>
                        <h4>No sent proposals</h4>
                        <p>Browse products and propose exchanges to start trading</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            <i class="fas fa-search me-2"></i>Browse Products
                        </a>
                    </div>
                @endif
            </div>
        </div>

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
            position: relative;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .action-btn.primary { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); color: white; }
        .action-btn.secondary { background: linear-gradient(135deg, #6c757d 0%, #495057 100%); color: white; }
        .action-btn.success { background: linear-gradient(135deg, var(--success) 0%, #20c997 100%); color: white; }
        .action-btn.info { background: linear-gradient(135deg, var(--info) 0%, #0dcaf0 100%); color: white; }
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
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .exchange-card, .giveaway-card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .exchange-card:hover, .giveaway-card:hover {
            border-color: var(--primary);
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
        .exchange-status.completed { background: #d1ecf1; color: #0c5460; }

        .giveaway-status.pending { background: #fff3cd; color: #856404; }
        .giveaway-status.approved { background: #d1ecf1; color: #0c5460; }
        .giveaway-status.active { background: #d4edda; color: #155724; }
        .giveaway-status.completed { background: #d1ecf1; color: #0c5460; }
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
