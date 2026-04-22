<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">{{ __('Featured Products') }}</h3>

                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($products as $product)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <h4 class="font-semibold text-lg">{{ $product->title }}</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $product->description }}</p>
                                    <p class="text-sm mt-2"><strong>Category:</strong> {{ $product->category->name }}</p>
                                    <p class="text-sm"><strong>Seller:</strong> {{ $product->user->name }}</p>
                                    <a href="{{ route('products.show', $product) }}" class="mt-2 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        View Details
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No products available.</p>
                    @endif

                    <div class="mt-6">
                        <a href="{{ route('products.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Browse All Products
                        </a>
                        <a href="{{ route('categories.index') }}" class="ml-4 bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Browse Categories
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
