<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Exchange Details') }}
            </h2>
            <a href="{{ route('buyer.exchanges.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Back to Exchanges
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold">Exchange Status</h3>
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($exchange->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($exchange->status === 'accepted') bg-green-100 text-green-800
                                @elseif($exchange->status === 'rejected') bg-red-100 text-red-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst($exchange->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">Proposed {{ $exchange->created_at->diffForHumans() }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Offered Product -->
                        <div class="border rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">You Offered</h4>
                            <div class="flex items-start space-x-4">
                                @if($exchange->offeredProduct->images && count($exchange->offeredProduct->images) > 0)
                                    @if(str_starts_with($exchange->offeredProduct->images[0], 'http'))
                                        <img src="{{ $exchange->offeredProduct->images[0] }}" alt="{{ $exchange->offeredProduct->title }}" class="w-20 h-20 object-cover rounded">
                                    @else
                                        <img src="{{ asset('storage/' . $exchange->offeredProduct->images[0]) }}" alt="{{ $exchange->offeredProduct->title }}" class="w-20 h-20 object-cover rounded">
                                    @endif
                                @endif
                                <div class="flex-1">
                                    <h5 class="font-medium">{{ $exchange->offeredProduct->title }}</h5>
                                    <p class="text-sm text-gray-600">{{ $exchange->offeredProduct->category->name }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($exchange->offeredProduct->description, 100) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Requested Product -->
                        <div class="border rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Requested From</h4>
                            <div class="flex items-start space-x-4">
                                @if($exchange->requestedProduct->images && count($exchange->requestedProduct->images) > 0)
                                    @if(str_starts_with($exchange->requestedProduct->images[0], 'http'))
                                        <img src="{{ $exchange->requestedProduct->images[0] }}" alt="{{ $exchange->requestedProduct->title }}" class="w-20 h-20 object-cover rounded">
                                    @else
                                        <img src="{{ asset('storage/' . $exchange->requestedProduct->images[0]) }}" alt="{{ $exchange->requestedProduct->title }}" class="w-20 h-20 object-cover rounded">
                                    @endif
                                @endif
                                <div class="flex-1">
                                    <h5 class="font-medium">{{ $exchange->requestedProduct->title }}</h5>
                                    <p class="text-sm text-gray-600">{{ $exchange->requestedProduct->category->name }}</p>
                                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($exchange->requestedProduct->description, 100) }}</p>
                                    <p class="text-sm text-gray-500 mt-2">by {{ $exchange->proposer->name }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($exchange->status === 'pending')
                        <div class="mt-8 flex justify-center space-x-4">
                            <form method="POST" action="{{ route('buyer.exchanges.update', $exchange) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="accepted">
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded" onclick="return confirm('Accept this exchange?')">
                                    Accept Exchange
                                </button>
                            </form>

                            <form method="POST" action="{{ route('buyer.exchanges.update', $exchange) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-6 rounded" onclick="return confirm('Reject this exchange?')">
                                    Reject Exchange
                                </button>
                            </form>
                        </div>
                    @elseif($exchange->status === 'accepted')
                        <div class="mt-8 p-4 bg-green-50 border border-green-200 rounded-md">
                            <p class="text-green-800 text-center mb-4">
                                This exchange has been accepted! Please complete the payment to finalize the exchange.
                            </p>

                            @if($exchange->payment_status !== 'completed')
                                <div class="text-center">
                                    <form method="POST" action="{{ route('exchange.payment.process', $exchange) }}" class="inline">
                                        @csrf
                                        <input type="hidden" name="payment_method" value="vipps">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg inline-flex items-center">
                                            <i class="fas fa-mobile-alt mr-2"></i>
                                            Pay with Vipps (10 NOK)
                                        </button>
                                    </form>
                                    <p class="text-sm text-gray-600 mt-2">Secure payment via Vipps MobilePay</p>
                                </div>
                            @else
                                <div class="text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Payment Completed
                                    </span>
                                </div>
                            @endif
                        </div>
                    @elseif($exchange->status === 'rejected')
                        <div class="mt-8 p-4 bg-red-50 border border-red-200 rounded-md">
                            <p class="text-red-800 text-center">
                                This exchange has been rejected.
                            </p>
                        </div>
                    @else
                        <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-md">
                            <p class="text-blue-800 text-center">
                                This exchange has been completed.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
