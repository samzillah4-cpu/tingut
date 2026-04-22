@extends('adminlte::page')

@section('title', 'My Chats')

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

        /* Main Container */
        .chats-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1.5rem 1.5rem;
        }

        /* Chat Type Tabs */
        .chat-tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            background: white;
            padding: 0.5rem;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .chat-tabs .tab {
            flex: 1;
            text-align: center;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .chat-tabs .tab:hover {
            background: var(--bg-light);
            color: var(--primary);
        }

        .chat-tabs .tab.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
        }

        .chat-tabs .badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 10px;
            background: #dc3545;
            color: white;
        }

        .chat-tabs .tab.active .badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        /* Chats List */
        .chats-list {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .chat-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .chat-item:last-child {
            border-bottom: none;
        }

        .chat-item:hover {
            background: var(--bg-light);
        }

        .chat-item.unread {
            background: #fff8e6;
            border-left: 3px solid var(--warning);
        }

        .chat-item.unread:hover {
            background: #fff3cd;
        }

        .chat-avatar {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 1.25rem;
            color: white;
        }

        .chat-info {
            flex: 1;
            position: relative;
            min-width: 0;
        }

        .chat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.25rem;
        }

        .chat-name {
            font-weight: 600;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-time {
            font-size: 0.75rem;
            color: var(--text-secondary);
            white-space: nowrap;
        }

        .chat-meta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .chat-type {
            font-size: 0.7rem;
            padding: 0.15rem 0.5rem;
            border-radius: 6px;
            background: var(--bg-light);
            color: var(--text-secondary);
            font-weight: 500;
        }

        .chat-type.admin {
            background: linear-gradient(135deg, var(--royal) 0%, #e83e8c 100%);
            color: white;
        }

        .chat-subject {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-style: italic;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .unread-badge {
            background: linear-gradient(135deg, var(--warning) 0%, #fd7e14 100%);
            color: #212529;
            font-size: 0.7rem;
            padding: 0.2rem 0.5rem;
            border-radius: 8px;
            font-weight: 600;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
            color: var(--primary);
        }

        .empty-state h4 {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }

        .empty-state p {
            margin-bottom: 1.5rem;
        }

        .empty-state .btn {
            border-radius: 20px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            border: none;
            color: white;
        }

        .empty-state .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Pagination */
        .pagination-container {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
        }

        .pagination-container .pagination {
            gap: 0.25rem;
        }

        .pagination-container .page-link {
            border-radius: 8px;
            border: none;
            color: var(--text-primary);
            padding: 0.5rem 0.75rem;
            font-weight: 500;
        }

        .pagination-container .page-link:hover {
            background: var(--bg-light);
            color: var(--primary);
        }

        .pagination-container .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
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

            .chats-container {
                padding: 0 1rem 1rem;
            }

            .chat-tabs {
                flex-direction: column;
            }

            .chat-item {
                padding: 0.75rem 1rem;
            }

            .chat-avatar {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }
    </style>
@stop

@section('content_header')
    <div class="seller-header">
        <div class="seller-welcome">
            <div class="seller-avatar">
                <i class="fas fa-comments"></i>
            </div>
            <div class="seller-info">
                <h1 class="seller-name">My Chats</h1>
                <p class="seller-subtitle">Manage your conversations with customers and admins</p>
            </div>
        </div>
        <div class="seller-actions">
            <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
            </a>
            <a href="{{ route('seller.chats.admin') }}" class="btn btn-outline-light btn-sm">
                <i class="fas fa-headset me-1"></i>Chat with Admin
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="chats-container">
        <!-- Chat Type Tabs -->
        <div class="chat-tabs">
            <a href="{{ route('seller.chats.index') }}?type=all" class="tab {{ !request('type') || request('type') == 'all' ? 'active' : '' }}">
                All Chats
            </a>
            <a href="{{ route('seller.chats.index') }}?type=seller_customer" class="tab {{ request('type') == 'seller_customer' ? 'active' : '' }}">
                <i class="fas fa-users me-1"></i>Customers
                @if($customerChatsCount > 0)
                    <span class="badge">{{ $customerChatsCount }}</span>
                @endif
            </a>
            <a href="{{ route('seller.chats.index') }}?type=seller_admin" class="tab {{ request('type') == 'seller_admin' ? 'active' : '' }}">
                <i class="fas fa-user-shield me-1"></i>Admin
                @if($adminChat && $adminChat->unread_messages_count > 0)
                    <span class="badge">{{ $adminChat->unread_messages_count }}</span>
                @endif
            </a>
        </div>

        <!-- Chats List -->
        <div class="chats-list">
            @if($chats->count() > 0)
                @foreach($chats as $chat)
                    @php
                        $otherUser = $chat->user_id === auth()->id() ? $chat->relatedUser : $chat->user;
                        $unreadCount = $chat->messages()->where('user_id', '!=', auth()->id())->whereNull('read_at')->count();
                        $chatTypeLabel = $chat->chat_type === 'seller_customer' ? 'Customer' : 'Admin Support';
                        $isAdminChat = $chat->chat_type === 'seller_admin';
                    @endphp
                    <div class="chat-item {{ $unreadCount > 0 ? 'unread' : '' }}" onclick="window.location.href='{{ route('seller.chats.show', $chat) }}'">
                        <div class="chat-avatar">
                            <i class="fas {{ $isAdminChat ? 'fa-user-shield' : 'fa-user' }}"></i>
                        </div>
                        <div class="chat-info">
                            <div class="chat-header">
                                <span class="chat-name">{{ $otherUser ? $otherUser->name : 'Unknown User' }}</span>
                                <span class="chat-time">{{ $chat->last_message_at->diffForHumans() }}</span>
                            </div>
                            <div class="chat-meta">
                                <span class="chat-type {{ $isAdminChat ? 'admin' : '' }}">{{ $chatTypeLabel }}</span>
                                @if($chat->subject)
                                    <span class="chat-subject">{{ $chat->subject }}</span>
                                @endif
                            </div>
                        </div>
                        @if($unreadCount > 0)
                            <span class="unread-badge">{{ $unreadCount }} new</span>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <i class="fas fa-comments"></i>
                    <h4>No chats yet</h4>
                    <p>Start a conversation with customers or admins</p>
                    <a href="{{ route('seller.chats.admin') }}" class="btn">
                        <i class="fas fa-headset me-2"></i>Chat with Admin
                    </a>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($chats->hasPages())
        <div class="pagination-container">
            {{ $chats->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
@stop

@section('js')
<script>
    // Real-time update for unread count
    function updateUnreadCount() {
        fetch('{{ route('seller.chats.unread-count') }}')
            .then(response => response.json())
            .then(data => {
                // Update page title with unread count
                if (data.count > 0) {
                    document.title = `(${data.count}) My Chats - TingUt`;
                } else {
                    document.title = 'My Chats';
                }
            })
            .catch(error => console.error('Error checking unread count:', error));
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateUnreadCount();

        // Update every 30 seconds
        setInterval(updateUnreadCount, 30000);
    });
</script>
@stop
