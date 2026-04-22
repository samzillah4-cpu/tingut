@extends('layouts.public')

@section('content')
<div class="container">
    <h1>Your Cart</h1>
    @if($carts->count() > 0)
        <div class="row">
            <div class="col-md-8">
                @foreach($carts as $cart)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-2">
                                    @if($cart->product->images)
                                        @if(str_starts_with($cart->product->images[0], 'http'))
                                            <img src="{{ $cart->product->images[0] }}" class="img-fluid" alt="{{ $cart->product->title }}">
                                        @else
                                            <img src="{{ asset('storage/' . $cart->product->images[0]) }}" class="img-fluid" alt="{{ $cart->product->title }}">
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h5>{{ $cart->product->title }}</h5>
                                    <p>{{ $cart->product->sale_price }} NOK</p>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control quantity-input" value="{{ $cart->quantity }}" min="1" data-cart-id="{{ $cart->id }}">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-danger remove-item" data-cart-id="{{ $cart->id }}">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5>Total: {{ $total }} NOK</h5>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p>Your cart is empty</p>
    @endif
</div>

@section('js')
<script>
$(document).ready(function() {
    // Update quantity
    $('.quantity-input').on('change', function() {
        const cartId = $(this).data('cart-id');
        const quantity = $(this).val();

        $.ajax({
            url: '/cart/' + cartId,
            method: 'PATCH',
            data: {
                quantity: quantity,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload(); // Reload to update totals
            },
            error: function() {
                alert('Failed to update quantity');
            }
        });
    });

    // Remove item
    $('.remove-item').on('click', function() {
        const cartId = $(this).data('cart-id');

        $.ajax({
            url: '/cart/' + cartId,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload(); // Reload to remove item
            },
            error: function() {
                alert('Failed to remove item');
            }
        });
    });
});
</script>
@endsection
