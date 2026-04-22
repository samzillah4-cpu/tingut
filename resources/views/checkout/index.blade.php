@extends('layouts.public')

@section('content')
<div class="container">
    <h1>Checkout</h1>
    <form method="POST" action="{{ route('checkout.process') }}">
        @csrf
        <div class="card mb-3">
            <div class="card-header">Payment Method</div>
            <div class="card-body">
                <select name="payment_method" class="form-control" required>
                    <option value="vipps">Vipps</option>
                    <option value="cash">Cash on Delivery</option>
                </select>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-header">Order Summary</div>
            <div class="card-body">
                @foreach($cartItems as $cart)
                    <div class="d-flex justify-content-between">
                        <span>{{ $cart->product->title }} ({{ $cart->quantity }})</span>
                        <span>{{ $cart->total }} NOK</span>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong>{{ $total }} NOK</strong>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>
</div>
@endsection
