@extends('adminlte::page')

@section('title', 'View Buyer')

@section('content_header')
    <h1>Buyer Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Buyer: {{ $buyer->name }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.buyers.edit', $buyer) }}" class="btn btn-warning btn-sm">Edit</a>
                <a href="{{ route('admin.buyers.index') }}" class="btn btn-secondary btn-sm">Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Basic Information</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $buyer->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $buyer->email }}</td>
                        </tr>
                        <tr>
                            <th>Location:</th>
                            <td>{{ $buyer->location ?: 'Not specified' }}</td>
                        </tr>
                        <tr>
                            <th>Role:</th>
                            <td>{{ $buyer->getRoleNames()->first() }}</td>
                        </tr>
                        <tr>
                            <th>Joined:</th>
                            <td>{{ $buyer->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $buyer->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5>Activity Summary</h5>
                    <table class="table table-borderless">
                        <tr>
                            <th>Total Exchanges:</th>
                            <td>{{ $buyer->proposedExchanges->count() + $buyer->receivedExchanges->count() }}</td>
                        </tr>
                        <tr>
                            <th>Completed Exchanges:</th>
                            <td>{{ $buyer->proposedExchanges->where('status', 'completed')->count() + $buyer->receivedExchanges->where('status', 'completed')->count() }}</td>
                        </tr>
                        <tr>
                            <th>Pending Exchanges:</th>
                            <td>{{ $buyer->proposedExchanges->where('status', 'pending')->count() + $buyer->receivedExchanges->where('status', 'pending')->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @php
        $allExchanges = $buyer->proposedExchanges->merge($buyer->receivedExchanges)->sortByDesc('created_at');
    @endphp
    @if($allExchanges->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Exchange History</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Product Offered</th>
                            <th>Product Requested</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($allExchanges as $exchange)
                            <tr>
                                <td>
                                    @if($exchange->offeredProduct)
                                        <a href="{{ route('products.show', $exchange->offeredProduct) }}" target="_blank">
                                            {{ Str::limit($exchange->offeredProduct->title, 30) }}
                                        </a>
                                    @else
                                        <em>Product removed</em>
                                    @endif
                                </td>
                                <td>
                                    @if($exchange->requestedProduct)
                                        <a href="{{ route('products.show', $exchange->requestedProduct) }}" target="_blank">
                                            {{ Str::limit($exchange->requestedProduct->title, 30) }}
                                        </a>
                                    @else
                                        <em>Product removed</em>
                                    @endif
                                </td>
                                <td>
                                    @if($exchange->proposer_id === $buyer->id)
                                        <span class="badge badge-primary">Proposer</span>
                                    @else
                                        <span class="badge badge-secondary">Receiver</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge
                                        @if($exchange->status === 'completed') badge-success
                                        @elseif($exchange->status === 'pending') badge-warning
                                        @elseif($exchange->status === 'accepted') badge-info
                                        @else badge-danger
                                        @endif">
                                        {{ ucfirst($exchange->status) }}
                                    </span>
                                </td>
                                <td>{{ $exchange->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
@stop

@section('js')
    <!-- Add any custom JS here -->
@stop
