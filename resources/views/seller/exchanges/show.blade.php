@extends('adminlte::page')

@section('title', 'Exchange Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('seller.exchanges.index') }}">Exchange Proposals</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Exchange #{{ $exchange->id }}</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-exchange-alt mr-2"></i>
                        Exchange Proposal Details
                    </h3>
                    <div class="card-tools">
                        <span class="badge badge-{{ $exchange->status === 'accepted' ? 'success' : ($exchange->status === 'rejected' ? 'danger' : 'warning') }}">
                            {{ ucfirst($exchange->status) }}
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- Proposer Information -->
                        <div class="col-md-6">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-user mr-2"></i>Proposer Information
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        @if($exchange->proposer->profile_picture)
                                            <img src="{{ asset('storage/' . $exchange->proposer->profile_picture) }}"
                                                 alt="{{ $exchange->proposer->name }}"
                                                 class="rounded-circle mr-3"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mr-3"
                                                 style="width: 60px; height: 60px;">
                                                <i class="fas fa-user fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $exchange->proposer->name }}</h6>
                                            <p class="text-muted mb-0">{{ $exchange->proposer->email }}</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <small class="text-muted">Member since:</small><br>
                                            <span>{{ $exchange->proposer->created_at->format('M d, Y') }}</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <small class="text-muted">Total Products:</small><br>
                                            <span>{{ $exchange->proposer->products()->count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Exchange Details -->
                        <div class="col-md-6">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-info-circle mr-2"></i>Exchange Details
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <small class="text-muted">Exchange ID:</small><br>
                                        <strong>#{{ $exchange->id }}</strong>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Proposed on:</small><br>
                                        <strong>{{ $exchange->created_at->format('M d, Y \a\t g:i A') }}</strong>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Last updated:</small><br>
                                        <strong>{{ $exchange->updated_at->format('M d, Y \a\t g:i A') }}</strong>
                                    </div>
                                    <div class="mb-3">
                                        <small class="text-muted">Status:</small><br>
                                        <span class="badge badge-{{ $exchange->status === 'accepted' ? 'success' : ($exchange->status === 'rejected' ? 'danger' : 'warning') }} badge-lg">
                                            {{ ucfirst($exchange->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <!-- Your Product (Requested) -->
                        <div class="col-md-6">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-hand-holding-heart mr-2"></i>Your Product (Requested)
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        @if($exchange->requestedProduct->images && count($exchange->requestedProduct->images) > 0)
                                            <img src="{{ asset('storage/' . $exchange->requestedProduct->images[0]) }}"
                                                 alt="{{ $exchange->requestedProduct->title }}"
                                                 class="img-thumbnail mr-3"
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center mr-3"
                                                 style="width: 80px; height: 80px; border-radius: 8px;">
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $exchange->requestedProduct->title }}</h6>
                                            <p class="text-muted mb-1">{{ Str::limit($exchange->requestedProduct->description, 100) }}</p>
                                            <small class="text-muted">
                                                <i class="fas fa-tag mr-1"></i>{{ $exchange->requestedProduct->category->name }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Offered Product -->
                        <div class="col-md-6">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-gift mr-2"></i>Offered Product
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        @if($exchange->offeredProduct->images && count($exchange->offeredProduct->images) > 0)
                                            <img src="{{ asset('storage/' . $exchange->offeredProduct->images[0]) }}"
                                                 alt="{{ $exchange->offeredProduct->title }}"
                                                 class="img-thumbnail mr-3"
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center mr-3"
                                                 style="width: 80px; height: 80px; border-radius: 8px;">
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $exchange->offeredProduct->title }}</h6>
                                            <p class="text-muted mb-1">{{ Str::limit($exchange->offeredProduct->description, 100) }}</p>
                                            <small class="text-muted">
                                                <i class="fas fa-tag mr-1"></i>{{ $exchange->offeredProduct->category->name }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Exchange Message -->
                    @if($exchange->message)
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card border-secondary">
                                <div class="card-header bg-secondary text-white">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-envelope mr-2"></i>Exchange Message
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0" style="white-space: pre-line;">{{ $exchange->message }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('seller.exchanges.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>Back to Exchanges
                        </a>

                        @if($exchange->status === 'pending')
                        <div>
                            <form method="POST" action="{{ route('seller.exchanges.update', $exchange) }}" class="d-inline mr-2">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to accept this exchange proposal?')">
                                    <i class="fas fa-check mr-1"></i>Accept Exchange
                                </button>
                            </form>
                            <form method="POST" action="{{ route('seller.exchanges.update', $exchange) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this exchange proposal?')">
                                    <i class="fas fa-times mr-1"></i>Reject Exchange
                                </button>
                            </form>
                        </div>
                        @else
                        <div>
                            <span class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                This exchange has been {{ $exchange->status }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@endsection
