@extends('adminlte::page')

@section('title', 'Send Message')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('messages.inbox') }}">Messages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">New Message</li>
                </ol>
            </nav>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-paper-plane me-2"></i>Send New Message
                    </h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="receiver_id" class="form-label">Recipient</label>
                            <select name="receiver_id" id="receiver_id" class="form-control" required>
                                <option value="">Select a recipient</option>
                                @php
                                    $users = \App\Models\User::where('id', '!=', auth()->id())->get();
                                @endphp
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('receiver_id', $receiverId) == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('receiver_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="product_id" class="form-label">Related Product (Optional)</label>
                            <select name="product_id" id="product_id" class="form-control">
                                <option value="">Select a product (optional)</option>
                                @php
                                    $products = \App\Models\Product::where('user_id', auth()->id())->where('status', 'active')->get();
                                @endphp
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id', $productId) == $product->id ? 'selected' : '' }}>
                                        {{ $product->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea name="message" id="message" class="form-control" rows="6" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('messages.inbox') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
