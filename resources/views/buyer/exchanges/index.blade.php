@extends('adminlte::page')

@section('title', 'My Exchange Proposals')

@section('content_header')
    <h1>My Exchange Proposals</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Exchange Proposals Management</h3>
            <div class="card-tools">
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-search"></i> Browse Products
                </a>
            </div>
        </div>

        <div class="card-body">
            @if($exchanges->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Offered Product</th>
                                <th>Requested Product</th>
                                <th>Proposer</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exchanges as $exchange)
                                <tr>
                                    <td>
                                        <strong>{{ $exchange->offeredProduct->title }}</strong><br>
                                        <small class="text-muted">{{ $exchange->offeredProduct->category->name }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $exchange->requestedProduct->title }}</strong><br>
                                        <small class="text-muted">{{ $exchange->requestedProduct->category->name }}</small>
                                    </td>
                                    <td>{{ $exchange->proposer->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ $exchange->status === 'pending' ? 'warning' : ($exchange->status === 'accepted' ? 'success' : ($exchange->status === 'rejected' ? 'danger' : 'info')) }}">
                                            {{ ucfirst($exchange->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $exchange->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('buyer.exchanges.show', $exchange) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        @if($exchange->status === 'pending')
                                            <form method="POST" action="{{ route('buyer.exchanges.update', $exchange) }}" class="d-inline ml-1">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Accept this exchange?')">
                                                    <i class="fas fa-check"></i> Accept
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('buyer.exchanges.update', $exchange) }}" class="d-inline ml-1">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Reject this exchange?')">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $exchanges->links() }}
                </div>
            @else
                <div class="alert alert-info text-center">
                    <h5><i class="icon fas fa-info"></i> No Exchange Proposals Yet!</h5>
                    <p>You haven't received any exchange proposals yet.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-search"></i> Start Browsing Products
                    </a>
                </div>
            @endif
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop
