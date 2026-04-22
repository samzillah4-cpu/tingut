<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('seller.products.edit', $product) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit
                </a>
                <a href="{{ route('seller.products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Products
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Product Info -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">{{ $product->title }}</h3>

                            <div class="mb-4">
                                <strong>Category:</strong> {{ $product->category->name }}
                            </div>

                            <div class="mb-4">
                                <strong>Status:</strong>
                                <span class="px-2 py-1 rounded-full text-xs {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </div>

                            <div class="mb-4">
                                <strong>Created:</strong> {{ $product->created_at->format('M d, Y H:i') }}
                            </div>

                            <div class="mb-4">
                                <strong>Description:</strong>
                                <p class="mt-2 text-gray-700">{{ $product->description }}</p>
                            </div>
                        </div>

                        <!-- Images -->
                        <div>
                            @if($product->images && count($product->images) > 0)
                                <h4 class="text-md font-semibold mb-4">Images</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    @foreach($product->images as $image)
                                        <div>
                                            @if(str_starts_with($image, 'http'))
                                                <img src="{{ $image }}" alt="Product Image" class="w-full h-32 object-cover rounded">
                                            @else
                                                <img src="{{ Storage::url($image) }}" alt="Product Image" class="w-full h-32 object-cover rounded">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No images uploaded</p>
                            @endif
                        </div>
                    </div>

                    <!-- Exchange Proposals -->
                    <div class="mt-8">
                        <h4 class="text-lg font-semibold mb-4">Exchange Proposals</h4>
                        @if($product->requestedExchanges->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full table-auto">
                                    <thead>
                                        <tr class="bg-gray-50">
                                            <th class="px-4 py-2 text-left">Proposer</th>
                                            <th class="px-4 py-2 text-left">Offered Product</th>
                                            <th class="px-4 py-2 text-left">Status</th>
                                            <th class="px-4 py-2 text-left">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($product->requestedExchanges as $exchange)
                                            <tr class="border-t">
                                                <td class="px-4 py-2">{{ $exchange->proposer->name }}</td>
                                                <td class="px-4 py-2">{{ $exchange->offeredProduct->title }}</td>
                                                <td class="px-4 py-2">
                                                    <span class="px-2 py-1 rounded-full text-xs {{ $exchange->status === 'accepted' ? 'bg-green-100 text-green-800' : ($exchange->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                        {{ ucfirst($exchange->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-4 py-2">{{ $exchange->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-500">No exchange proposals yet.</p>
                        @endif
                    </div>

                    <!-- Giveaway Requests -->
                    @if($product->is_giveaway || $product->listing_type == 'giveaway')
                        <div class="mt-8">
                            <h4 class="text-lg font-semibold mb-4">Giveaway Requests</h4>
                            @if($product->giveawayRequests->count() > 0)
                                <div class="overflow-x-auto">
                                    <table class="min-w-full table-auto">
                                        <thead>
                                            <tr class="bg-gray-50">
                                                <th class="px-4 py-2 text-left">Requester</th>
                                                <th class="px-4 py-2 text-left">Status</th>
                                                <th class="px-4 py-2 text-left">Date</th>
                                                <th class="px-4 py-2 text-left">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product->giveawayRequests as $request)
                                                <tr class="border-t">
                                                    <td class="px-4 py-2">{{ $request->requester->name }}</td>
                                                    <td class="px-4 py-2">
                                                        <span class="px-2 py-1 rounded-full text-xs {{ $request->status === 'approved' ? 'bg-green-100 text-green-800' : ($request->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                            {{ ucfirst($request->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-4 py-2">{{ $request->created_at->format('M d, Y') }}</td>
                                                    <td class="px-4 py-2">
                                                        @if($request->status === 'pending')
                                                            <form action="{{ route('giveaway.request.update', $request) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="approved">
                                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white text-xs font-bold py-1 px-2 rounded mr-1">
                                                                    Approve
                                                                </button>
                                                            </form>
                                                            <form action="{{ route('giveaway.request.update', $request) }}" method="POST" class="inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="rejected">
                                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 rounded">
                                                                    Reject
                                                                </button>
                                                            </form>
                                                        @else
                                                            <span class="text-gray-500 text-xs">No actions available</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-gray-500">No giveaway requests yet.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
