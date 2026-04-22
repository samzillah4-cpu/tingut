@extends('adminlte::page')

@section('title', 'Exchange Details')

@section('content_header')
    <h1>Exchange Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Exchange #{{ $exchange->id }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.exchanges.edit', $exchange) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('admin.exchanges.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $exchange->id }}</dd>

                <dt class="col-sm-3">Proposer</dt>
                <dd class="col-sm-9">{{ $exchange->proposer->name }} ({{ $exchange->proposer->email }})</dd>

                <dt class="col-sm-3">Offered Product</dt>
                <dd class="col-sm-9">
                    {{ $exchange->offeredProduct->name }}
                    <br><small class="text-muted">Category: {{ $exchange->offeredProduct->category->name }}</small>
                </dd>

                <dt class="col-sm-3">Receiver</dt>
                <dd class="col-sm-9">{{ $exchange->receiver->name }} ({{ $exchange->receiver->email }})</dd>

                <dt class="col-sm-3">Requested Product</dt>
                <dd class="col-sm-9">
                    {{ $exchange->requestedProduct->name }}
                    <br><small class="text-muted">Category: {{ $exchange->requestedProduct->category->name }}</small>
                </dd>

                <dt class="col-sm-3">Status</dt>
                <dd class="col-sm-9">
                    <span class="badge badge-{{ $exchange->status == 'pending' ? 'warning' : ($exchange->status == 'accepted' ? 'success' : ($exchange->status == 'rejected' ? 'danger' : 'info')) }}">
                        {{ ucfirst($exchange->status) }}
                    </span>
                </dd>

                <dt class="col-sm-3">Created At</dt>
                <dd class="col-sm-9">{{ $exchange->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Updated At</dt>
                <dd class="col-sm-9">{{ $exchange->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
    </div>
@stop
