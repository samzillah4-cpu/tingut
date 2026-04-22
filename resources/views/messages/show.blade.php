@extends('adminlte::page')

@section('title', 'Message Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('messages.inbox') }}">Messages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($message->subject, 30) }}</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="mb-1">{{ $message->subject }}</h5>
                            <small class="text-muted">
                                From: <strong>{{ $message->sender->name }}</strong> •
                                To: <strong>{{ $message->receiver->name }}</strong> •
                                {{ $message->created_at->format('M d, Y \a\t g:i A') }}
                            </small>
                        </div>
                        <div>
                            <a href="{{ route('messages.create', ['receiver_id' => $message->sender_id, 'product_id' => $message->product_id]) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-reply me-1"></i>Reply
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($message->product)
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-box me-2"></i>
                            <strong>Regarding Product:</strong>
                            <a href="{{ route('products.show', $message->product) }}" class="alert-link">{{ $message->product->title }}</a>
                        </div>
                    @endif

                    <div class="message-content">
                        <p class="mb-0" style="white-space: pre-line;">{{ $message->message }}</p>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            @if($message->is_read)
                                <i class="fas fa-check text-success me-1"></i>Read
                            @else
                                <i class="fas fa-envelope text-warning me-1"></i>Unread
                            @endif
                        </small>
                        <div>
                            <a href="{{ route('messages.inbox') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Back to Inbox
                            </a>
                            <a href="{{ route('messages.create', ['receiver_id' => $message->sender_id, 'product_id' => $message->product_id]) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-reply me-1"></i>Reply
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
