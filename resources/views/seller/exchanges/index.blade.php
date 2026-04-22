<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exchange Proposals') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Filter -->
                    <div class="mb-6">
                        <form method="GET" class="flex flex-col md:flex-row gap-4">
                            <div>
                                <select name="status" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div>
                                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Filter
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Exchanges Table -->
                    @if($exchanges->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-2 text-left">Proposer</th>
                                        <th class="px-4 py-2 text-left">Your Product</th>
                                        <th class="px-4 py-2 text-left">Offered Product</th>
                                        <th class="px-4 py-2 text-left">Status</th>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($exchanges as $exchange)
                                        <tr class="border-t">
                                            <td class="px-4 py-2">
                                                <div>
                                                    <div class="font-medium">{{ $exchange->proposer->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $exchange->proposer->email }}</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2">
                                                <div>
                                                    <div class="font-medium">{{ $exchange->requestedProduct->title }}</div>
                                                    <div class="text-sm text-gray-500">{{ $exchange->requestedProduct->category->name }}</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2">
                                                <div>
                                                    <div class="font-medium">{{ $exchange->offeredProduct->title }}</div>
                                                    <div class="text-sm text-gray-500">{{ $exchange->offeredProduct->category->name }}</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2">
                                                <span class="px-2 py-1 rounded-full text-xs {{ $exchange->status === 'accepted' ? 'bg-green-100 text-green-800' : ($exchange->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                    {{ ucfirst($exchange->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2">{{ $exchange->created_at->format('M d, Y H:i') }}</td>
                                            <td class="px-4 py-2">
                                                @if($exchange->status === 'pending')
                                                    <form method="POST" action="{{ route('seller.exchanges.update', $exchange) }}" class="inline mr-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="accepted">
                                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-sm">
                                                            Accept
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('seller.exchanges.update', $exchange) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-sm">
                                                            Reject
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-500">{{ ucfirst($exchange->status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $exchanges->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No exchange proposals found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
