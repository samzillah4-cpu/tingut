<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-lg text-gray-800 leading-tight">
                    {{ __('Edit Product') }}
                </h2>
            </div>
            <a href="{{ route('seller.products.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-4 px-6 sm:px-10 lg:px-16">
        <div class="max-w-2xl mx-auto">

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <div class="font-bold mb-2">{{ __('Whoops! Something went wrong.') }}</div>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('seller.products.update', $product) }}" enctype="multipart/form-data" id="product-form">
                @csrf
                @method('PATCH')

                <!-- Row 1: Image + Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Image Section -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <label class="text-sm font-medium text-gray-700 mb-3 block">Product Image</label>
                        <div class="aspect-square rounded-lg bg-gray-100 overflow-hidden relative">
                            @if($product->images && count($product->images) > 0)
                                @if(str_starts_with($product->images[0], 'http'))
                                    <img src="{{ $product->images[0] }}" alt="Product" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ Storage::url($product->images[0]) }}" alt="Product" class="w-full h-full object-cover">
                                @endif
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            <label class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 cursor-pointer flex items-center justify-center transition-all">
                                <input type="file" name="images[]" multiple accept="image/*" class="sr-only" id="main-image-input">
                                <span class="text-white opacity-0 hover:opacity-100 text-sm font-medium">Change</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-400 mt-3 text-center">Click to upload new image (leave empty to keep current)</p>
                    </div>

                    <!-- Basic Info -->
                    <div class="md:col-span-2 space-y-5">
                        <!-- Title -->
                        <div>
                            <label for="title" class="text-sm font-medium text-gray-700 mb-2 block">Product Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title', $product->title) }}" required autofocus autocomplete="title"
                                placeholder="Enter product title"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg">
                            <x-input-error :messages="$errors->get('title')" class="mt-1"/>
                        </div>

                        <!-- Listing Type & Category Row -->
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label for="listing_type" class="text-sm font-medium text-gray-700 mb-2 block">Listing Type</label>
                                <select id="listing_type" name="listing_type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
                                    <option value="sale" {{ old('listing_type', $product->listing_type) === 'sale' ? 'selected' : '' }}>For Sale</option>
                                    <option value="exchange" {{ old('listing_type', $product->listing_type) === 'exchange' ? 'selected' : '' }}>Exchange</option>
                                    <option value="giveaway" {{ old('listing_type', $product->listing_type) === 'giveaway' ? 'selected' : '' }}>Give Away</option>
                                </select>
                            </div>
                            <div>
                                <label for="category_id" class="text-sm font-medium text-gray-700 mb-2 block">Category</label>
                                <select id="category_id" name="category_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white" required>
                                    <option value="">Select category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Status & Price Row -->
                        <div class="grid grid-cols-2 gap-5">
                            <div>
                                <label for="status" class="text-sm font-medium text-gray-700 mb-2 block">Status</label>
                                <select id="status" name="status" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm bg-white">
                                    <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div>
                                <label for="sale_price" class="text-sm font-medium text-gray-700 mb-2 block">Price (NOK)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">kr</span>
                                    <input type="number" id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0"
                                        placeholder="0.00"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                                </div>
                            </div>
                        </div>

                        <!-- Short Description -->
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <label for="short_description" class="text-sm font-medium text-gray-700">Short Description</label>
                                <span class="text-xs text-gray-400">{{ strlen(old('short_description', $product->short_description ?? '')) }}/200</span>
                            </div>
                            <textarea id="short_description" name="short_description" rows="2" maxlength="200" placeholder="Brief description for listings..."
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('short_description', $product->short_description) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Details & Images -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Detailed Description -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <label for="long_description" class="text-sm font-medium text-gray-700 mb-3 block">Detailed Description</label>
                        <textarea id="long_description" name="long_description" rows="5" placeholder="Full product details..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm resize-none">{{ old('long_description', $product->long_description) }}</textarea>

                        <!-- Exchange Categories -->
                        <div class="mt-5">
                            <label for="exchange_categories" class="text-sm font-medium text-gray-700 mb-2 block">Accepting Exchanges For</label>
                            <select id="exchange_categories" name="exchange_categories[]" multiple class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm bg-white">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id, old('exchange_categories', $product->exchange_categories ?? [])) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-400 mt-2">Hold Ctrl/Cmd to select multiple</p>
                        </div>
                    </div>

                    <!-- Additional Images -->
                    <div class="bg-white rounded-xl border border-gray-200 p-5">
                        <label class="text-sm font-medium text-gray-700 mb-3 block">Additional Images</label>
                        @if($product->images && count($product->images) > 1)
                            <div class="grid grid-cols-3 gap-3 mb-4">
                                @foreach($product->images as $index => $image)
                                    @if($index > 0)
                                        @if(str_starts_with($image, 'http'))
                                            <img src="{{ $image }}" alt="Image {{ $index }}" class="aspect-square object-cover rounded-lg">
                                        @else
                                            <img src="{{ Storage::url($image) }}" alt="Image {{ $index }}" class="aspect-square object-cover rounded-lg">
                                        @endif
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        <p class="text-sm text-gray-500 mb-3">Upload new images to replace all existing images</p>
                        <label class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                            </svg>
                            <span class="text-sm text-gray-500 mt-2">Click to upload additional images</span>
                            <input type="file" name="images[]" multiple accept="image/*" class="sr-only" id="additional-images-input">
                        </label>
                    </div>
                </div>

                <!-- Vehicle Section (shown when vehicle category is selected) -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg vehicle-section" id="vehicleSection" style="display: none;">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><i class="fas fa-car mr-2"></i>Vehicle Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <x-input-label for="vehicle_make" :value="__('Make')" />
                            <x-text-input id="vehicle_make" class="block mt-1 w-full" type="text" name="vehicle_make" :value="old('vehicle_make', $product->vehicle_make)" placeholder="e.g., Toyota, BMW, Volkswagen" />
                            <x-input-error :messages="$errors->get('vehicle_make')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="vehicle_model" :value="__('Model')" />
                            <x-text-input id="vehicle_model" class="block mt-1 w-full" type="text" name="vehicle_model" :value="old('vehicle_model', $product->vehicle_model)" placeholder="e.g., Corolla, X5, Golf" />
                            <x-input-error :messages="$errors->get('vehicle_model')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="vehicle_year" :value="__('Year')" />
                            <x-text-input id="vehicle_year" class="block mt-1 w-full" type="number" name="vehicle_year" :value="old('vehicle_year', $product->vehicle_year)" min="1900" max="{{ date('Y') + 1 }}" placeholder="e.g., 2020" />
                            <x-input-error :messages="$errors->get('vehicle_year')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="vehicle_mileage" :value="__('Mileage (km)')" />
                            <x-text-input id="vehicle_mileage" class="block mt-1 w-full" type="number" name="vehicle_mileage" :value="old('vehicle_mileage', $product->vehicle_mileage)" min="0" placeholder="e.g., 50000" />
                            <x-input-error :messages="$errors->get('vehicle_mileage')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="vehicle_fuel_type" :value="__('Fuel Type')" />
                            <select id="vehicle_fuel_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="vehicle_fuel_type">
                                <option value="">Select fuel type</option>
                                <option value="petrol" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'petrol' ? 'selected' : '' }}>Petrol</option>
                                <option value="diesel" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                <option value="electric" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'electric' ? 'selected' : '' }}>Electric</option>
                                <option value="hybrid" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                <option value="lng" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'lng' ? 'selected' : '' }}>LNG</option>
                                <option value="cng" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'cng' ? 'selected' : '' }}>CNG</option>
                                <option value="other" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('vehicle_fuel_type')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="vehicle_transmission" :value="__('Transmission')" />
                            <select id="vehicle_transmission" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="vehicle_transmission">
                                <option value="">Select transmission</option>
                                <option value="manual" {{ old('vehicle_transmission', $product->vehicle_transmission) == 'manual' ? 'selected' : '' }}>Manual</option>
                                <option value="automatic" {{ old('vehicle_transmission', $product->vehicle_transmission) == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                <option value="semi_auto" {{ old('vehicle_transmission', $product->vehicle_transmission) == 'semi_auto' ? 'selected' : '' }}>Semi-Automatic</option>
                            </select>
                            <x-input-error :messages="$errors->get('vehicle_transmission')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="vehicle_color" :value="__('Color')" />
                            <x-text-input id="vehicle_color" class="block mt-1 w-full" type="text" name="vehicle_color" :value="old('vehicle_color', $product->vehicle_color)" placeholder="e.g., Black, Silver, Blue" />
                            <x-input-error :messages="$errors->get('vehicle_color')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="vehicle_engine_size" :value="__('Engine Size (L)')" />
                            <x-text-input id="vehicle_engine_size" class="block mt-1 w-full" type="number" name="vehicle_engine_size" :value="old('vehicle_engine_size', $product->vehicle_engine_size)" step="0.1" min="0" placeholder="e.g., 2.0" />
                            <x-input-error :messages="$errors->get('vehicle_engine_size')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="vehicle_power" :value="__('Power (HP)')" />
                            <x-text-input id="vehicle_power" class="block mt-1 w-full" type="number" name="vehicle_power" :value="old('vehicle_power', $product->vehicle_power)" min="0" placeholder="e.g., 150" />
                            <x-input-error :messages="$errors->get('vehicle_power')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="vehicle_doors" :value="__('Number of Doors')" />
                            <x-text-input id="vehicle_doors" class="block mt-1 w-full" type="number" name="vehicle_doors" :value="old('vehicle_doors', $product->vehicle_doors)" min="1" max="10" placeholder="e.g., 4" />
                            <x-input-error :messages="$errors->get('vehicle_doors')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="vehicle_weight" :value="__('Weight (kg)')" />
                            <x-text-input id="vehicle_weight" class="block mt-1 w-full" type="number" name="vehicle_weight" :value="old('vehicle_weight', $product->vehicle_weight)" min="0" placeholder="e.g., 1500" />
                            <x-input-error :messages="$errors->get('vehicle_weight')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="vehicle_registration_number" :value="__('Registration Number')" />
                            <x-text-input id="vehicle_registration_number" class="block mt-1 w-full" type="text" name="vehicle_registration_number" :value="old('vehicle_registration_number', $product->vehicle_registration_number)" placeholder="e.g., AB 12345" />
                            <x-input-error :messages="$errors->get('vehicle_registration_number')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="vehicle_vin" :value="__('VIN Number')" />
                            <x-text-input id="vehicle_vin" class="block mt-1 w-full" type="text" name="vehicle_vin" :value="old('vehicle_vin', $product->vehicle_vin)" maxlength="17" placeholder="17 character VIN" />
                            <x-input-error :messages="$errors->get('vehicle_vin')" class="mt-2" />
                        </div>
                        <div class="mb-4 col-span-2">
                            <x-input-label for="vehicle_features" :value="__('Features')" />
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-2">
                                @php
                                    $vehicleFeaturesList = [
                                        'sunroof' => 'Sunroof',
                                        'leather' => 'Leather Seats',
                                        'navigation' => 'Navigation',
                                        'parking_sensors' => 'Parking Sensors',
                                        'rear_camera' => 'Rear Camera',
                                        'heated_seats' => 'Heated Seats',
                                        'cruise_control' => 'Cruise Control',
                                        'bluetooth' => 'Bluetooth',
                                        'usb' => 'USB',
                                        'alloy_wheels' => 'Alloy Wheels',
                                        'abs' => 'ABS',
                                        'airbags' => 'Airbags',
                                        'climate_control' => 'Climate Control',
                                        'electric_windows' => 'Electric Windows'
                                    ];
                                    $selectedFeatures = old('vehicle_features', $product->vehicle_features ?? []);
                                @endphp
                                @foreach($vehicleFeaturesList as $value => $label)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="vehicle_features[]" value="{{ $value }}" {{ in_array($value, $selectedFeatures) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-600">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- House/Real Estate Section (shown when real estate category is selected) -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg house-section" id="houseSection" style="display: none;">
                    <h3 class="text-lg font-medium text-gray-900 mb-4"><i class="fas fa-home mr-2"></i>Property Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <x-input-label for="house_property_type" :value="__('Property Type')" />
                            <select id="house_property_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="house_property_type">
                                <option value="">Select property type</option>
                                <option value="apartment" {{ old('house_property_type', $product->house_property_type) == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="house" {{ old('house_property_type', $product->house_property_type) == 'house' ? 'selected' : '' }}>House</option>
                                <option value="villa" {{ old('house_property_type', $product->house_property_type) == 'villa' ? 'selected' : '' }}>Villa</option>
                                <option value="townhouse" {{ old('house_property_type', $product->house_property_type) == 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                                <option value="cottage" {{ old('house_property_type', $product->house_property_type) == 'cottage' ? 'selected' : '' }}>Cottage</option>
                                <option value="farm" {{ old('house_property_type', $product->house_property_type) == 'farm' ? 'selected' : '' }}>Farm</option>
                                <option value="plot" {{ old('house_property_type', $product->house_property_type) == 'plot' ? 'selected' : '' }}>Building Plot</option>
                                <option value="commercial" {{ old('house_property_type', $product->house_property_type) == 'commercial' ? 'selected' : '' }}>Commercial Property</option>
                                <option value="other" {{ old('house_property_type', $product->house_property_type) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('house_property_type')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="house_rooms" :value="__('Number of Rooms')" />
                            <x-text-input id="house_rooms" class="block mt-1 w-full" type="number" name="house_rooms" :value="old('house_rooms', $product->house_rooms)" min="0" placeholder="e.g., 5" />
                            <x-input-error :messages="$errors->get('house_rooms')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="house_bedrooms" :value="__('Bedrooms')" />
                            <x-text-input id="house_bedrooms" class="block mt-1 w-full" type="number" name="house_bedrooms" :value="old('house_bedrooms', $product->house_bedrooms)" min="0" placeholder="e.g., 3" />
                            <x-input-error :messages="$errors->get('house_bedrooms')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="house_bathrooms" :value="__('Bathrooms')" />
                            <x-text-input id="house_bathrooms" class="block mt-1 w-full" type="number" name="house_bathrooms" :value="old('house_bathrooms', $product->house_bathrooms)" min="0" placeholder="e.g., 2" />
                            <x-input-error :messages="$errors->get('house_bathrooms')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="house_living_area" :value="__('Living Area (m²)')" />
                            <x-text-input id="house_living_area" class="block mt-1 w-full" type="number" name="house_living_area" :value="old('house_living_area', $product->house_living_area)" step="0.01" min="0" placeholder="e.g., 120.50" />
                            <x-input-error :messages="$errors->get('house_living_area')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="house_plot_size" :value="__('Plot Size (m²)')" />
                            <x-text-input id="house_plot_size" class="block mt-1 w-full" type="number" name="house_plot_size" :value="old('house_plot_size', $product->house_plot_size)" step="0.01" min="0" placeholder="e.g., 500" />
                            <x-input-error :messages="$errors->get('house_plot_size')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="house_year_built" :value="__('Year Built')" />
                            <x-text-input id="house_year_built" class="block mt-1 w-full" type="number" name="house_year_built" :value="old('house_year_built', $product->house_year_built)" min="1800" max="{{ date('Y') + 1 }}" placeholder="e.g., 2010" />
                            <x-input-error :messages="$errors->get('house_year_built')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="house_energy_rating" :value="__('Energy Rating')" />
                            <select id="house_energy_rating" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="house_energy_rating">
                                <option value="">Select energy rating</option>
                                <option value="a" {{ old('house_energy_rating', $product->house_energy_rating) == 'a' ? 'selected' : '' }}>A</option>
                                <option value="b" {{ old('house_energy_rating', $product->house_energy_rating) == 'b' ? 'selected' : '' }}>B</option>
                                <option value="c" {{ old('house_energy_rating', $product->house_energy_rating) == 'c' ? 'selected' : '' }}>C</option>
                                <option value="d" {{ old('house_energy_rating', $product->house_energy_rating) == 'd' ? 'selected' : '' }}>D</option>
                                <option value="e" {{ old('house_energy_rating', $product->house_energy_rating) == 'e' ? 'selected' : '' }}>E</option>
                                <option value="f" {{ old('house_energy_rating', $product->house_energy_rating) == 'f' ? 'selected' : '' }}>F</option>
                                <option value="g" {{ old('house_energy_rating', $product->house_energy_rating) == 'g' ? 'selected' : '' }}>G</option>
                                <option value="unknown" {{ old('house_energy_rating', $product->house_energy_rating) == 'unknown' ? 'selected' : '' }}>Unknown</option>
                            </select>
                            <x-input-error :messages="$errors->get('house_energy_rating')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="house_ownership_type" :value="__('Ownership Type')" />
                            <select id="house_ownership_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="house_ownership_type">
                                <option value="">Select ownership type</option>
                                <option value="borettslag" {{ old('house_ownership_type', $product->house_ownership_type) == 'borettslag' ? 'selected' : '' }}>Borettslag (Cooperative)</option>
                                <option value="sameie" {{ old('house_ownership_type', $product->house_ownership_type) == 'sameie' ? 'selected' : '' }}>Sameie (Joint Ownership)</option>
                                <option value="freehold" {{ old('house_ownership_type', $product->house_ownership_type) == 'freehold' ? 'selected' : '' }}>Freehold (Selveier)</option>
                                <option value="leasehold" {{ old('house_ownership_type', $product->house_ownership_type) == 'leasehold' ? 'selected' : '' }}>Leasehold (Leie)</option>
                            </select>
                            <x-input-error :messages="$errors->get('house_ownership_type')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="house_floor" :value="__('Floor')" />
                            <x-text-input id="house_floor" class="block mt-1 w-full" type="number" name="house_floor" :value="old('house_floor', $product->house_floor)" min="0" placeholder="e.g., 3" />
                            <x-input-error :messages="$errors->get('house_floor')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="house_parking" :value="__('Parking')" />
                            <select id="house_parking" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="house_parking">
                                <option value="">Select parking</option>
                                <option value="none" {{ old('house_parking', $product->house_parking) == 'none' ? 'selected' : '' }}>No Parking</option>
                                <option value="garage" {{ old('house_parking', $product->house_parking) == 'garage' ? 'selected' : '' }}>Garage</option>
                                <option value="parking_space" {{ old('house_parking', $product->house_parking) == 'parking_space' ? 'selected' : '' }}>Parking Space</option>
                                <option value="street" {{ old('house_parking', $product->house_parking) == 'street' ? 'selected' : '' }}>Street Parking</option>
                                <option value="carport" {{ old('house_parking', $product->house_parking) == 'carport' ? 'selected' : '' }}>Carport</option>
                            </select>
                            <x-input-error :messages="$errors->get('house_parking')" class="mt-2" />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="house_heating_type" :value="__('Heating Type')" />
                            <select id="house_heating_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="house_heating_type">
                                <option value="">Select heating type</option>
                                <option value="electric" {{ old('house_heating_type', $product->house_heating_type) == 'electric' ? 'selected' : '' }}>Electric</option>
                                <option value="oil" {{ old('house_heating_type', $product->house_heating_type) == 'oil' ? 'selected' : '' }}>Oil</option>
                                <option value="gas" {{ old('house_heating_type', $product->house_heating_type) == 'gas' ? 'selected' : '' }}>Gas</option>
                                <option value="district_heating" {{ old('house_heating_type', $product->house_heating_type) == 'district_heating' ? 'selected' : '' }}>District Heating</option>
                                <option value="wood" {{ old('house_heating_type', $product->house_heating_type) == 'wood' ? 'selected' : '' }}>Wood/ Pellet</option>
                                <option value="heat_pump" {{ old('house_heating_type', $product->house_heating_type) == 'heat_pump' ? 'selected' : '' }}>Heat Pump</option>
                                <option value="other" {{ old('house_heating_type', $product->house_heating_type) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('house_heating_type')" class="mt-2" />
                        </div>
                        <div class="mb-4 col-span-2 grid grid-cols-3 gap-4">
                            <label class="inline-flex items-center mt-6">
                                <input type="checkbox" name="house_elevator" value="1" {{ old('house_elevator', $product->house_elevator) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Elevator</span>
                            </label>
                            <label class="inline-flex items-center mt-6">
                                <input type="checkbox" name="house_balcony" value="1" {{ old('house_balcony', $product->house_balcony) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Balcony</span>
                            </label>
                            <label class="inline-flex items-center mt-6">
                                <input type="checkbox" name="house_new_construction" value="1" {{ old('house_new_construction', $product->house_new_construction) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">New Construction</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 mt-6 pt-5 border-t border-gray-200">
                    <a href="{{ route('seller.products.index') }}" class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">Cancel</a>
                    <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the vehicle and real estate category IDs
    var vehicleCategoryId = null;
    var realEstateCategoryId = null;

    // Find the Vehicles and Real Estate category options
    var categorySelect = document.getElementById('category_id');
    var categoryOptions = categorySelect.options;
    for (var i = 0; i < categoryOptions.length; i++) {
        var text = categoryOptions[i].text.toLowerCase();
        if (text.includes('vehicle')) {
            vehicleCategoryId = categoryOptions[i].value;
        }
        if (text.includes('real estate') || text.includes('realestate')) {
            realEstateCategoryId = categoryOptions[i].value;
        }
    }

    // Check initial category and show/hide sections
    var initialCategoryId = categorySelect.value;
    if (vehicleCategoryId && initialCategoryId == vehicleCategoryId) {
        document.getElementById('vehicleSection').style.display = 'block';
    }
    if (realEstateCategoryId && initialCategoryId == realEstateCategoryId) {
        document.getElementById('houseSection').style.display = 'block';
    }

    // Handle category change to show/hide vehicle and house fields
    categorySelect.addEventListener('change', function() {
        var selectedCategoryId = this.value;
        var vehicleSection = document.getElementById('vehicleSection');
        var houseSection = document.getElementById('houseSection');

        // Check if selected category is a vehicle category
        if (vehicleCategoryId && selectedCategoryId == vehicleCategoryId) {
            vehicleSection.style.display = 'block';
        } else {
            vehicleSection.style.display = 'none';
        }

        // Check if selected category is a real estate category
        if (realEstateCategoryId && selectedCategoryId == realEstateCategoryId) {
            houseSection.style.display = 'block';
        } else {
            houseSection.style.display = 'none';
        }
    });
});
</script>
