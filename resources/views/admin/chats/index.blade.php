@extends('adminlte::page')

@section('title', 'Live Chats')

@section('content_header')
    <h1>Live Chats</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-comments text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Live Chat Management</h5>
                        <small class="text-muted">{{ $chats->total() }} total chats</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr class="border-bottom">
                            <th>ID</th>
                            <th>Visitor</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Last Message</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($chats as $chat)
                            <tr class="border-bottom border-light">
                                <td><strong>{{ $chat->id }}</strong></td>
                                <td>
                                    <div class="fw-semibold">{{ $chat->name }}</div>
                                </td>
                                <td>{{ $chat->email }}</td>
                                <td>{{ $chat->phone ?: '-' }}</td>
                                <td>
                                    <span class="badge
                                        @if($chat->status === 'active') bg-success
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst($chat->status) }}
                                    </span>
                                </td>
                                <td><small class="text-muted">{{ $chat->last_message_at ? $chat->last_message_at->diffForHumans() : '-' }}</small></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.chats.show', $chat) }}" class="btn btn-outline-info" title="View Chat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No chats found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light border-top-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $chats->firstItem() ?? 0 }} to {{ $chats->lastItem() ?? 0 }} of {{ $chats->total() }} chats
                </div>
                {{ $chats->links() }}
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

        .pagination {
            margin-bottom: 0;
        }

        .card-footer {
            border-radius: 0 0 12px 12px;
        }

        .btn-group .btn {
            border-color: #dee2e6 !important;
        }

        .btn-group .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
@stop
