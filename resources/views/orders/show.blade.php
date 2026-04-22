@extends('layouts.public')

@section('content')
<div class="container">
    <h1>Order #{{ $order->id }}</h1>
    <p>Status: {{ $order->status }}</p>
    <p>Total: {{ $order->total_amount }} NOK</p>
    <p>Product: {{ $order->product->title }}</p>
    <p>Quantity: {{ $order->quantity }}</p>
    <p>Unit Price: {{ $order->unit_price }} NOK</p>
    <p>Seller: {{ $order->seller->name }}</p>
</div>
@endsection
