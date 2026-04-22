<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Rental Details') }}
            </h2>
            <a href="{{ route('seller.rentals.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Rentals
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4">Rental Information</h4>
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold" style="width: 140px;">Status:</td>
                                    <td>
                                        <span class="badge
                                            @if($rental->status === 'completed') bg-success
                                            @elseif($rental->status === 'active') bg-primary
                                            @elseif($rental->status === 'approved') bg-info
                                            @elseif($rental->status === 'pending') bg-warning
                                            @else bg-danger
                                            @endif">
                                            {{ ucfirst($rental->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Start Date:</td>
                                    <td>{{ $rental->start_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">End Date:</td>
                                    <td>{{ $rental->end_date->format('M d, Y') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Total Price:</td>
                                    <td><strong>${{ number_format($rental->total_price, 2) }}</strong></td>
                                </tr>
                                @if($rental->deposit_amount)
                                <tr>
                                    <td class="fw-semibold">Deposit:</td>
                                    <td>${{ number_format($rental->deposit_amount, 2) }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-4">Parties Involved</h4>
                            <div class="mb-4">
                                <h6 class="text-primary">Renter</h6>
                                <div class="d-flex align-items-center">
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-user text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $rental->renter->name }}</div>
                                        <small class="text-muted">{{ $rental->renter->email }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-4">Product Details</h4>
                            <div class="card border">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h5 class="card-title">{{ $rental->product->title }}</h5>
                                            <p class="card-text">{{ Str::limit($rental->product->description, 200) }}</p>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    Category: {{ $rental->product->category->name ?? 'N/A' }}
                                                </small>
                                            </p>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <a href="{{ route('products.show', $rental->product) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-external-link-alt me-1"></i>View Product
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($rental->notes)
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="mb-4">Notes</h4>
                            <p class="mb-0">{{ $rental->notes }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4 class="mb-4">Actions</h4>
                            <div class="d-flex gap-2 flex-wrap">
                                @if($rental->status === 'pending')
                                    <form method="POST" action="{{ route('seller.rentals.update', $rental) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check me-2"></i>Approve Rental
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('seller.rentals.update', $rental) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-times me-2"></i>Reject Rental
                                        </button>
                                    </form>
                                @elseif($rental->status === 'approved')
                                    <form method="POST" action="{{ route('seller.rentals.update', $rental) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="active">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-play me-2"></i>Start Rental
                                        </button>
                                    </form>
                                @elseif($rental->status === 'active')
                                    <form method="POST" action="{{ route('seller.rentals.update', $rental) }}" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check-circle me-2"></i>Mark as Completed
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">No actions available for {{ ucfirst($rental->status) }} rentals.</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
