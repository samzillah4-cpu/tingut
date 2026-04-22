@extends('adminlte::page')

@section('title', 'Edit Exchange')

@section('content_header')
    <h1>Edit Exchange</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Exchange #{{ $exchange->id }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.exchanges.update', $exchange) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Proposer</label>
                    <p class="form-control-plaintext">{{ $exchange->proposer->name }} ({{ $exchange->proposer->email }})</p>
                </div>
                <div class="form-group">
                    <label>Offered Product</label>
                    <p class="form-control-plaintext">{{ $exchange->offeredProduct->name }}</p>
                </div>
                <div class="form-group">
                    <label>Receiver</label>
                    <p class="form-control-plaintext">{{ $exchange->receiver->name }} ({{ $exchange->receiver->email }})</p>
                </div>
                <div class="form-group">
                    <label>Requested Product</label>
                    <p class="form-control-plaintext">{{ $exchange->requestedProduct->name }}</p>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending" {{ $exchange->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ $exchange->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ $exchange->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="completed" {{ $exchange->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Update Exchange</button>
                <a href="{{ route('admin.exchanges.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
