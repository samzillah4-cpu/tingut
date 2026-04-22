@extends('layouts.public')

@section('content')
<div class="container">
    <h1>My Orders</h1>
    @if($orders->count() > 0)
        @foreach($orders as $order)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Order #{{ $order->id }}</h5>
                            <p>Product: {{ $order->product->title }}</p>
                            <p>Quantity: {{ $order->quantity }}</p>
                            <p>Total: {{ $order->total_amount }} NOK</p>
                            <p>Status: {{ $order->status }}</p>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p>No orders yet</p>
    @endif
</div>
@endsection
