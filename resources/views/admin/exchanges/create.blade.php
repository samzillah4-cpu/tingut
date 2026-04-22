@extends('adminlte::page')

@section('title', 'Create Exchange')

@section('content_header')
    <h1>Create Exchange</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add New Exchange</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.exchanges.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="proposer_id">Proposer</label>
                    <select name="proposer_id" class="form-control" required>
                        <option value="">Select Proposer</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="offered_product_id">Offered Product</label>
                    <select name="offered_product_id" class="form-control" required>
                        <option value="">Select Offered Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (by {{ $product->user->name }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="receiver_id">Receiver</label>
                    <select name="receiver_id" class="form-control" required>
                        <option value="">Select Receiver</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="requested_product_id">Requested Product</label>
                    <select name="requested_product_id" class="form-control" required>
                        <option value="">Select Requested Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} (by {{ $product->user->name }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="pending">Pending</option>
                        <option value="accepted">Accepted</option>
                        <option value="rejected">Rejected</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create Exchange</button>
                <a href="{{ route('admin.exchanges.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
@stop
