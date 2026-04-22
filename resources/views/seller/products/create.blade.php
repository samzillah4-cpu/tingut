<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add New Product') }}
            </h2>
            <a href="{{ route('seller.products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                ← Back to Products
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">

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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Title -->
                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus autocomplete="title" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <!-- Short Description -->
                        <div class="mb-4">
                            <x-input-label for="short_description" :value="__('Short Description')" />
                            <textarea id="short_description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="short_description" rows="2" placeholder="Brief description that appears in product listings">{{ old('short_description') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">This appears in product cards and search results (max 200 characters)</p>
                            <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                        </div>

                        <!-- Long Description -->
                        <div class="mb-4">
                            <x-input-label for="long_description" :value="__('Long Description')" />
                            <textarea id="long_description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="long_description" rows="6" placeholder="Detailed description that appears on the product detail page">{{ old('long_description') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">This appears on the product detail page with full formatting</p>
                            <x-input-error :messages="$errors->get('long_description')" class="mt-2" />
                        </div>

                        <!-- Legacy Description (for backward compatibility) -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Legacy Description')" />
                            <textarea id="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="description" rows="3">{{ old('description') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Legacy field - will be populated from short description if empty</p>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category_id" :value="__('Category')" />
                            <select id="category_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="category_id" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <!-- Listing Type -->
                        <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Listing Type</h3>
                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="radio" name="listing_type" value="sale" {{ old('listing_type', 'sale') == 'sale' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700">Garage Sale - Sell for a fixed price</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="listing_type" value="exchange" {{ old('listing_type') == 'exchange' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700">Exchange - Trade for other items</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="listing_type" value="giveaway" {{ old('listing_type') == 'giveaway' ? 'checked' : '' }} class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-3 text-sm font-medium text-gray-700">Give Away - Free to good home</span>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('listing_type')" class="mt-2" />
                        </div>

                        <!-- Exchange Categories -->
                        <div class="mb-4 exchange-section" style="{{ old('listing_type') == 'exchange' ? '' : 'display: none;' }}">
                            <x-input-label for="exchange_categories" :value="__('Exchange Categories')" />
                            <select id="exchange_categories" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="exchange_categories[]" multiple>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id, old('exchange_categories', [])) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <p class="text-sm text-gray-500 mt-1">Select categories of items you're willing to exchange for (hold Ctrl/Cmd to select multiple)</p>
                            <x-input-error :messages="$errors->get('exchange_categories')" class="mt-2" />
                        </div>

                        <!-- Sale Section -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg sale-section" style="{{ old('listing_type', 'sale') == 'sale' ? '' : 'display: none;' }}">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Sale Options</h3>

                            <!-- Available for Sale -->
                            <div class="mb-4">
                                <label class="inline-flex items-center">
                                    <input id="is_for_sale" type="checkbox" name="is_for_sale" value="1" {{ old('is_for_sale') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-600">Available for sale</span>
                                </label>
                                <p class="text-sm text-gray-500 mt-1">Check this if you want to sell this product for a fixed price</p>
                                <x-input-error :messages="$errors->get('is_for_sale')" class="mt-2" />
                            </div>

                            <!-- Sale Price -->
                            <div class="mb-4 sale-price-section" style="{{ old('is_for_sale') ? '' : 'display: none;' }}">
                                <x-input-label for="sale_price" :value="__('Sale Price (NOK)')" />
                                <x-text-input id="sale_price" class="block mt-1 w-full" type="number" name="sale_price" :value="old('sale_price')" step="0.01" min="0" placeholder="Enter price in NOK" />
                                <p class="text-sm text-gray-500 mt-1">Set the price for this product in Norwegian Kroner</p>
                                <x-input-error :messages="$errors->get('sale_price')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="mb-4">
                            <x-input-label for="images" :value="__('Images')" />
                            <input id="images" class="block mt-1 w-full" type="file" name="images[]" multiple accept="image/*" />
                            <p class="text-sm text-gray-500 mt-1">You can upload multiple images. Max 2MB each.</p>
                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                        </div>

                        <!-- Vehicle Section (shown when vehicle category is selected) -->
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg vehicle-section" id="vehicleSection" style="display: none;">
                            <h3 class="text-lg font-medium text-gray-900 mb-4"><i class="fas fa-car mr-2"></i>Vehicle Details</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <x-input-label for="vehicle_make" :value="__('Make')" />
                                    <x-text-input id="vehicle_make" class="block mt-1 w-full" type="text" name="vehicle_make" :value="old('vehicle_make')" placeholder="e.g., Toyota, BMW, Volkswagen" />
                                    <x-input-error :messages="$errors->get('vehicle_make')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="vehicle_model" :value="__('Model')" />
                                    <x-text-input id="vehicle_model" class="block mt-1 w-full" type="text" name="vehicle_model" :value="old('vehicle_model')" placeholder="e.g., Corolla, X5, Golf" />
                                    <x-input-error :messages="$errors->get('vehicle_model')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="vehicle_year" :value="__('Year')" />
                                    <x-text-input id="vehicle_year" class="block mt-1 w-full" type="number" name="vehicle_year" :value="old('vehicle_year')" min="1900" max="{{ date('Y') + 1 }}" placeholder="e.g., 2020" />
                                    <x-input-error :messages="$errors->get('vehicle_year')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="vehicle_mileage" :value="__('Mileage (km)')" />
                                    <x-text-input id="vehicle_mileage" class="block mt-1 w-full" type="number" name="vehicle_mileage" :value="old('vehicle_mileage')" min="0" placeholder="e.g., 50000" />
                                    <x-input-error :messages="$errors->get('vehicle_mileage')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="vehicle_fuel_type" :value="__('Fuel Type')" />
                                    <select id="vehicle_fuel_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="vehicle_fuel_type">
                                        <option value="">Select fuel type</option>
                                        <option value="petrol" {{ old('vehicle_fuel_type') == 'petrol' ? 'selected' : '' }}>Petrol</option>
                                        <option value="diesel" {{ old('vehicle_fuel_type') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                        <option value="electric" {{ old('vehicle_fuel_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                                        <option value="hybrid" {{ old('vehicle_fuel_type') == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                        <option value="lng" {{ old('vehicle_fuel_type') == 'lng' ? 'selected' : '' }}>LNG</option>
                                        <option value="cng" {{ old('vehicle_fuel_type') == 'cng' ? 'selected' : '' }}>CNG</option>
                                        <option value="other" {{ old('vehicle_fuel_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('vehicle_fuel_type')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="vehicle_transmission" :value="__('Transmission')" />
                                    <select id="vehicle_transmission" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="vehicle_transmission">
                                        <option value="">Select transmission</option>
                                        <option value="manual" {{ old('vehicle_transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                                        <option value="automatic" {{ old('vehicle_transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                        <option value="semi_auto" {{ old('vehicle_transmission') == 'semi_auto' ? 'selected' : '' }}>Semi-Automatic</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('vehicle_transmission')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="vehicle_color" :value="__('Color')" />
                                    <x-text-input id="vehicle_color" class="block mt-1 w-full" type="text" name="vehicle_color" :value="old('vehicle_color')" placeholder="e.g., Black, Silver, Blue" />
                                    <x-input-error :messages="$errors->get('vehicle_color')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="vehicle_engine_size" :value="__('Engine Size (L)')" />
                                    <x-text-input id="vehicle_engine_size" class="block mt-1 w-full" type="number" name="vehicle_engine_size" :value="old('vehicle_engine_size')" step="0.1" min="0" placeholder="e.g., 2.0" />
                                    <x-input-error :messages="$errors->get('vehicle_engine_size')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="vehicle_power" :value="__('Power (HP)')" />
                                    <x-text-input id="vehicle_power" class="block mt-1 w-full" type="number" name="vehicle_power" :value="old('vehicle_power')" min="0" placeholder="e.g., 150" />
                                    <x-input-error :messages="$errors->get('vehicle_power')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="vehicle_doors" :value="__('Number of Doors')" />
                                    <x-text-input id="vehicle_doors" class="block mt-1 w-full" type="number" name="vehicle_doors" :value="old('vehicle_doors')" min="1" max="10" placeholder="e.g., 4" />
                                    <x-input-error :messages="$errors->get('vehicle_doors')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="vehicle_weight" :value="__('Weight (kg)')" />
                                    <x-text-input id="vehicle_weight" class="block mt-1 w-full" type="number" name="vehicle_weight" :value="old('vehicle_weight')" min="0" placeholder="e.g., 1500" />
                                    <x-input-error :messages="$errors->get('vehicle_weight')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="vehicle_registration_number" :value="__('Registration Number')" />
                                    <x-text-input id="vehicle_registration_number" class="block mt-1 w-full" type="text" name="vehicle_registration_number" :value="old('vehicle_registration_number')" placeholder="e.g., AB 12345" />
                                    <x-input-error :messages="$errors->get('vehicle_registration_number')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="vehicle_vin" :value="__('VIN Number')" />
                                    <x-text-input id="vehicle_vin" class="block mt-1 w-full" type="text" name="vehicle_vin" :value="old('vehicle_vin')" maxlength="17" placeholder="17 character VIN" />
                                    <x-input-error :messages="$errors->get('vehicle_vin')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Vehicle Features -->
                            <div class="mt-4">
                                <x-input-label for="vehicle_features" :value="__('Features')" />
                                <div class="mt-2 grid grid-cols-2 md:grid-cols-4 gap-2">
                                    @php
                                    $features = [
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
                                        'electric_windows' => 'Electric Windows',
                                    ];
                                    @endphp
                                    @foreach($features as $value => $label)
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="vehicle_features[]" value="{{ $value }}" {{ in_array($value, old('vehicle_features', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            <span class="ml-2 text-sm text-gray-600">{{ $label }}</span>
                                        </label>
                                    @endforeach
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
                                        <option value="apartment" {{ old('house_property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                                        <option value="house" {{ old('house_property_type') == 'house' ? 'selected' : '' }}>House</option>
                                        <option value="villa" {{ old('house_property_type') == 'villa' ? 'selected' : '' }}>Villa</option>
                                        <option value="townhouse" {{ old('house_property_type') == 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                                        <option value="cottage" {{ old('house_property_type') == 'cottage' ? 'selected' : '' }}>Cottage</option>
                                        <option value="farm" {{ old('house_property_type') == 'farm' ? 'selected' : '' }}>Farm</option>
                                        <option value="plot" {{ old('house_property_type') == 'plot' ? 'selected' : '' }}>Building Plot</option>
                                        <option value="commercial" {{ old('house_property_type') == 'commercial' ? 'selected' : '' }}>Commercial Property</option>
                                        <option value="other" {{ old('house_property_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('house_property_type')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="house_rooms" :value="__('Number of Rooms')" />
                                    <x-text-input id="house_rooms" class="block mt-1 w-full" type="number" name="house_rooms" :value="old('house_rooms')" min="0" placeholder="e.g., 5" />
                                    <x-input-error :messages="$errors->get('house_rooms')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="house_bedrooms" :value="__('Bedrooms')" />
                                    <x-text-input id="house_bedrooms" class="block mt-1 w-full" type="number" name="house_bedrooms" :value="old('house_bedrooms')" min="0" placeholder="e.g., 3" />
                                    <x-input-error :messages="$errors->get('house_bedrooms')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="house_bathrooms" :value="__('Bathrooms')" />
                                    <x-text-input id="house_bathrooms" class="block mt-1 w-full" type="number" name="house_bathrooms" :value="old('house_bathrooms')" min="0" placeholder="e.g., 2" />
                                    <x-input-error :messages="$errors->get('house_bathrooms')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="house_living_area" :value="__('Living Area (m²)')" />
                                    <x-text-input id="house_living_area" class="block mt-1 w-full" type="number" name="house_living_area" :value="old('house_living_area')" step="0.01" min="0" placeholder="e.g., 120.50" />
                                    <x-input-error :messages="$errors->get('house_living_area')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="house_plot_size" :value="__('Plot Size (m²)')" />
                                    <x-text-input id="house_plot_size" class="block mt-1 w-full" type="number" name="house_plot_size" :value="old('house_plot_size')" step="0.01" min="0" placeholder="e.g., 500" />
                                    <x-input-error :messages="$errors->get('house_plot_size')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="house_year_built" :value="__('Year Built')" />
                                    <x-text-input id="house_year_built" class="block mt-1 w-full" type="number" name="house_year_built" :value="old('house_year_built')" min="1800" max="{{ date('Y') + 1 }}" placeholder="e.g., 2010" />
                                    <x-input-error :messages="$errors->get('house_year_built')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="house_energy_rating" :value="__('Energy Rating')" />
                                    <select id="house_energy_rating" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="house_energy_rating">
                                        <option value="">Select energy rating</option>
                                        <option value="a" {{ old('house_energy_rating') == 'a' ? 'selected' : '' }}>A</option>
                                        <option value="b" {{ old('house_energy_rating') == 'b' ? 'selected' : '' }}>B</option>
                                        <option value="c" {{ old('house_energy_rating') == 'c' ? 'selected' : '' }}>C</option>
                                        <option value="d" {{ old('house_energy_rating') == 'd' ? 'selected' : '' }}>D</option>
                                        <option value="e" {{ old('house_energy_rating') == 'e' ? 'selected' : '' }}>E</option>
                                        <option value="f" {{ old('house_energy_rating') == 'f' ? 'selected' : '' }}>F</option>
                                        <option value="g" {{ old('house_energy_rating') == 'g' ? 'selected' : '' }}>G</option>
                                        <option value="unknown" {{ old('house_energy_rating') == 'unknown' ? 'selected' : '' }}>Unknown</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('house_energy_rating')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="house_ownership_type" :value="__('Ownership Type')" />
                                    <select id="house_ownership_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="house_ownership_type">
                                        <option value="">Select ownership type</option>
                                        <option value="borettslag" {{ old('house_ownership_type') == 'borettslag' ? 'selected' : '' }}>Borettslag (Cooperative)</option>
                                        <option value="sameie" {{ old('house_ownership_type') == 'sameie' ? 'selected' : '' }}>Sameie (Joint Ownership)</option>
                                        <option value="freehold" {{ old('house_ownership_type') == 'freehold' ? 'selected' : '' }}>Freehold (Selveier)</option>
                                        <option value="leasehold" {{ old('house_ownership_type') == 'leasehold' ? 'selected' : '' }}>Leasehold (Leie)</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('house_ownership_type')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="house_floor" :value="__('Floor')" />
                                    <x-text-input id="house_floor" class="block mt-1 w-full" type="number" name="house_floor" :value="old('house_floor')" min="0" placeholder="e.g., 3" />
                                    <x-input-error :messages="$errors->get('house_floor')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="house_parking" :value="__('Parking')" />
                                    <select id="house_parking" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="house_parking">
                                        <option value="">Select parking</option>
                                        <option value="none" {{ old('house_parking') == 'none' ? 'selected' : '' }}>No Parking</option>
                                        <option value="garage" {{ old('house_parking') == 'garage' ? 'selected' : '' }}>Garage</option>
                                        <option value="parking_space" {{ old('house_parking') == 'parking_space' ? 'selected' : '' }}>Parking Space</option>
                                        <option value="street" {{ old('house_parking') == 'street' ? 'selected' : '' }}>Street Parking</option>
                                        <option value="carport" {{ old('house_parking') == 'carport' ? 'selected' : '' }}>Carport</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('house_parking')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="house_heating_type" :value="__('Heating Type')" />
                                    <select id="house_heating_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" name="house_heating_type">
                                        <option value="">Select heating type</option>
                                        <option value="electric" {{ old('house_heating_type') == 'electric' ? 'selected' : '' }}>Electric</option>
                                        <option value="oil" {{ old('house_heating_type') == 'oil' ? 'selected' : '' }}>Oil</option>
                                        <option value="gas" {{ old('house_heating_type') == 'gas' ? 'selected' : '' }}>Gas</option>
                                        <option value="district_heating" {{ old('house_heating_type') == 'district_heating' ? 'selected' : '' }}>District Heating</option>
                                        <option value="wood" {{ old('house_heating_type') == 'wood' ? 'selected' : '' }}>Wood/ Pellet</option>
                                        <option value="heat_pump" {{ old('house_heating_type') == 'heat_pump' ? 'selected' : '' }}>Heat Pump</option>
                                        <option value="other" {{ old('house_heating_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('house_heating_type')" class="mt-2" />
                                </div>
                                <div class="mb-4">
                                    <label class="inline-flex items-center mt-6">
                                        <input type="checkbox" name="house_elevator" value="1" {{ old('house_elevator') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-600">Elevator</span>
                                    </label>
                                </div>
                                <div class="mb-4">
                                    <label class="inline-flex items-center mt-6">
                                        <input type="checkbox" name="house_balcony" value="1" {{ old('house_balcony') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-600">Balcony</span>
                                    </label>
                                </div>
                                <div class="mb-4">
                                    <label class="inline-flex items-center mt-6">
                                        <input type="checkbox" name="house_new_construction" value="1" {{ old('house_new_construction') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-600">New Construction</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('seller.products.index') }}" class="px-6 py-3 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                Create Product
                            </button>
                        </div>

                        <script>
                            // Handle category change to show/hide vehicle and house fields
                            document.getElementById('category_id').addEventListener('change', function() {
                                const selectedCategoryId = this.value;
                                const vehicleSection = document.getElementById('vehicleSection');
                                const houseSection = document.getElementById('houseSection');

                                // Check if selected category is a vehicle category
                                const categoryOptions = this.options;
                                let isVehicleCategory = false;
                                let isRealEstateCategory = false;
                                for (let i = 0; i < categoryOptions.length; i++) {
                                    const text = categoryOptions[i].text.toLowerCase();
                                    if (categoryOptions[i].value === selectedCategoryId && text.includes('vehicle')) {
                                        isVehicleCategory = true;
                                    }
                                    if (categoryOptions[i].value === selectedCategoryId && (text.includes('real estate') || text.includes('realestate'))) {
                                        isRealEstateCategory = true;
                                    }
                                }

                                if (isVehicleCategory) {
                                    vehicleSection.style.display = 'block';
                                } else {
                                    vehicleSection.style.display = 'none';
                                    // Clear vehicle fields when hiding
                                    vehicleSection.querySelectorAll('input, select').forEach(function(field) {
                                        if (field.type === 'checkbox' || field.type === 'radio') {
                                            field.checked = false;
                                        } else {
                                            field.value = '';
                                        }
                                    });
                                }

                                if (isRealEstateCategory) {
                                    houseSection.style.display = 'block';
                                } else {
                                    houseSection.style.display = 'none';
                                    // Clear house fields when hiding
                                    houseSection.querySelectorAll('input, select').forEach(function(field) {
                                        if (field.type === 'checkbox' || field.type === 'radio') {
                                            field.checked = false;
                                        } else {
                                            field.value = '';
                                        }
                                    });
                                }
                            });

                            // Handle listing type changes
                            document.querySelectorAll('input[name="listing_type"]').forEach(radio => {
                                radio.addEventListener('change', function() {
                                    const listingType = this.value;
                                    const exchangeSection = document.querySelector('.exchange-section');
                                    const saleSection = document.querySelector('.sale-section');

                                    if (listingType === 'exchange') {
                                        exchangeSection.style.display = 'block';
                                        saleSection.style.display = 'none';
                                        document.getElementById('is_for_sale').checked = false;
                                        document.getElementById('sale_price').value = '';
                                        document.getElementById('sale_price').required = false;
                                    } else if (listingType === 'sale') {
                                        exchangeSection.style.display = 'none';
                                        saleSection.style.display = 'block';
                                        document.getElementById('is_for_sale').checked = true;
                                        document.getElementById('sale_price').required = true;
                                    } else if (listingType === 'giveaway') {
                                        exchangeSection.style.display = 'none';
                                        saleSection.style.display = 'none';
                                        document.getElementById('is_for_sale').checked = false;
                                        document.getElementById('sale_price').value = '';
                                        document.getElementById('sale_price').required = false;
                                    }
                                });
                            });

                            document.getElementById('is_for_sale').addEventListener('change', function() {
                                const salePriceSection = document.querySelector('.sale-price-section');
                                if (this.checked) {
                                    salePriceSection.style.display = 'block';
                                    document.getElementById('sale_price').required = true;
                                } else {
                                    salePriceSection.style.display = 'none';
                                    document.getElementById('sale_price').required = false;
                                    document.getElementById('sale_price').value = '';
                                }
                            });

                            // Initialize on page load
                            document.addEventListener('DOMContentLoaded', function() {
                                const selectedType = document.querySelector('input[name="listing_type"]:checked');
                                if (selectedType) {
                                    selectedType.dispatchEvent(new Event('change'));
                                }

                                const checkbox = document.getElementById('is_for_sale');
                                const salePriceSection = document.querySelector('.sale-price-section');
                                if (checkbox.checked) {
                                    salePriceSection.style.display = 'block';
                                    document.getElementById('sale_price').required = true;
                                }
                            });
                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
