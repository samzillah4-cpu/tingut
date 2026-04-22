@extends('adminlte::page')

@section('title', 'Sent Messages')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i>Sent Messages
                    </h4>
                    <div>
                        <a href="{{ route('messages.inbox') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-inbox me-1"></i>Inbox
                        </a>
                        <a href="{{ route('messages.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>New Message
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($messages->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($messages as $message)
                                <a href="{{ route('messages.show', $message) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-1">
                                                <h6 class="mb-0 me-2">To: {{ $message->receiver->name }}</h6>
                                                @if($message->is_read)
                                                    <span class="badge bg-success">Read</span>
                                                @else
                                                    <span class="badge bg-secondary">Unread</span>
                                                @endif
                                            </div>
                                            <p class="mb-1 text-truncate">{{ $message->subject }}</p>
                                            @if($message->product)
                                                <small class="text-muted">
                                                    <i class="fas fa-box me-1"></i>Regarding: {{ $message->product->title }}
                                                </small>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            {{ $messages->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-paper-plane fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No sent messages</h5>
                            <p class="text-muted">Messages you send will appear here.</p>
                            <a href="{{ route('messages.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Send First Message
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
