@extends('adminlte::page')

@section('title', 'User Details')

@section('content_header')
    <h1>User Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $user->name }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID</dt>
                <dd class="col-sm-9">{{ $user->id }}</dd>
                <dt class="col-sm-3">Name</dt>
                <dd class="col-sm-9">{{ $user->name }}</dd>
                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $user->email }}</dd>
                <dt class="col-sm-3">Location</dt>
                <dd class="col-sm-9">{{ $user->location ?: 'Not specified' }}</dd>
                <dt class="col-sm-3">Roles</dt>
                <dd class="col-sm-9">{{ $user->roles->pluck('name')->join(', ') }}</dd>
                <dt class="col-sm-3">Exchanges Count</dt>
                <dd class="col-sm-9">{{ $user->exchanges_count }}</dd>
            </dl>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Products</h3>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($user->products as $product)
                    <li class="list-group-item">{{ $product->name }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@stop
