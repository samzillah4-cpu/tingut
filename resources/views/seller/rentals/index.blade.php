<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rental Requests') }}
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
                                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
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

                    <!-- Rentals Table -->
                    @if($rentals->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-auto">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="px-4 py-2 text-left">Renter</th>
                                        <th class="px-4 py-2 text-left">Product</th>
                                        <th class="px-4 py-2 text-left">Duration</th>
                                        <th class="px-4 py-2 text-left">Total Price</th>
                                        <th class="px-4 py-2 text-left">Status</th>
                                        <th class="px-4 py-2 text-left">Date</th>
                                        <th class="px-4 py-2 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rentals as $rental)
                                        <tr class="border-t">
                                            <td class="px-4 py-2">
                                                <div>
                                                    <div class="font-medium">{{ $rental->renter->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $rental->renter->email }}</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2">
                                                <div>
                                                    <div class="font-medium">{{ $rental->product->title }}</div>
                                                    <div class="text-sm text-gray-500">{{ $rental->product->category->name }}</div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2">
                                                <div class="text-sm">
                                                    {{ $rental->start_date->format('M d') }} - {{ $rental->end_date->format('M d, Y') }}
                                                </div>
                                            </td>
                                            <td class="px-4 py-2">
                                                <div class="font-medium">${{ number_format($rental->total_price, 2) }}</div>
                                            </td>
                                            <td class="px-4 py-2">
                                                <span class="px-2 py-1 rounded-full text-xs
                                                    @if($rental->status === 'completed') bg-green-100 text-green-800
                                                    @elseif($rental->status === 'active') bg-blue-100 text-blue-800
                                                    @elseif($rental->status === 'approved') bg-info-100 text-info-800
                                                    @elseif($rental->status === 'pending') bg-yellow-100 text-yellow-800
                                                    @else bg-red-100 text-red-800
                                                    @endif">
                                                    {{ ucfirst($rental->status) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2">{{ $rental->created_at->format('M d, Y H:i') }}</td>
                                            <td class="px-4 py-2">
                                                <div class="flex gap-2">
                                                    <a href="{{ route('seller.rentals.show', $rental) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm">
                                                        View
                                                    </a>
                                                    @if(in_array($rental->status, ['pending', 'approved', 'active']))
                                                        <form method="POST" action="{{ route('seller.rentals.update', $rental) }}" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            @if($rental->status === 'pending')
                                                                <input type="hidden" name="status" value="approved">
                                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded text-sm">
                                                                    Approve
                                                                </button>
                                                            @elseif($rental->status === 'approved')
                                                                <input type="hidden" name="status" value="active">
                                                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-sm">
                                                                    Start
                                                                </button>
                                                            @elseif($rental->status === 'active')
                                                                <input type="hidden" name="status" value="completed">
                                                                <button type="submit" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-1 px-2 rounded text-sm">
                                                                    Complete
                                                                </button>
                                                            @endif
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $rentals->links() }}
                        </div>
                    @else
                        <p class="text-gray-500">No rental requests found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
