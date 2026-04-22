@extends('adminlte::page')

@section('title', 'Edit Product')

@section('content_header')
    <h1>Edit Product</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Product: {{ $product->title }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control form-control-sm" value="{{ old('title', $product->title) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id">Category</label>
                            <select name="category_id" class="form-control form-control-sm" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control form-control-sm" rows="2" required>{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="user_id">User</label>
                            <select name="user_id" class="form-control form-control-sm" required>
                                <option value="">Select User</option>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $product->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control form-control-sm" required>
                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Listing Type -->
                <div class="form-group">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Listing Type</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="listing_type" value="sale" id="listing_sale" {{ old('listing_type', $product->listing_type ?? 'sale') == 'sale' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="listing_sale">
                                            <i class="fas fa-shopping-cart me-2 text-success"></i>Sale
                                        </label>
                                        <small class="form-text text-muted">Sell for a fixed price</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="listing_type" value="exchange" id="listing_exchange" {{ old('listing_type', $product->listing_type ?? 'sale') == 'exchange' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="listing_exchange">
                                            <i class="fas fa-exchange-alt me-2 text-warning"></i>Exchange
                                        </label>
                                        <small class="form-text text-muted">Trade for other items</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="listing_type" value="giveaway" id="listing_giveaway" {{ old('listing_type', $product->listing_type ?? 'sale') == 'giveaway' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="listing_giveaway">
                                            <i class="fas fa-gift me-2 text-info"></i>Giveaway
                                        </label>
                                        <small class="form-text text-muted">Free to good home</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group exchange-section" style="{{ old('listing_type', $product->listing_type ?? 'sale') == 'exchange' ? '' : 'display: none;' }}">
                    <label for="exchange_categories">Exchange Categories</label>
                    <select name="exchange_categories[]" class="form-control form-control-sm" multiple>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, old('exchange_categories', $product->exchange_categories ?? [])) ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Select categories of items you're willing to exchange for (hold Ctrl/Cmd to select multiple)</small>
                </div>

                <!-- Sale Section -->
                <div class="form-group">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Sale Options</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_for_sale" value="1" id="is_for_sale" {{ old('is_for_sale', $product->is_for_sale) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_for_sale">
                                            Available for sale
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Check this if you want to sell this product for a fixed price</small>
                                </div>
                                <div class="col-md-6 sale-price-section" style="{{ old('is_for_sale', $product->is_for_sale) ? '' : 'display: none;' }}">
                                    <label for="sale_price">Sale Price (NOK)</label>
                                    <input type="number" name="sale_price" id="sale_price" class="form-control form-control-sm" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0" placeholder="Enter price in NOK">
                                    <small class="form-text text-muted">Set the price for this product in Norwegian Kroner</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="images">Images (up to 5)</label>
                    <input type="file" name="images[]" class="form-control form-control-sm" multiple accept="image/*">
                    <small class="form-text text-muted">Leave empty to keep current images. Selecting new images will replace all existing ones.</small>
                    @if($product->images && count($product->images) > 0)
                        <div class="row mt-2">
                            @foreach($product->images as $image)
                                <div class="col-md-3 mb-2">
                                    @if(str_starts_with($image, 'http'))
                                        <img src="{{ $image }}" alt="Current Image" class="img-fluid" style="max-height: 100px;">
                                    @else
                                        <img src="{{ asset('storage/' . $image) }}" alt="Current Image" class="img-fluid" style="max-height: 100px;">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Vehicle Section (shown when vehicle category is selected) -->
                <div class="col-12 vehicle-section" id="vehicleSection" style="display: none;">
                    <div class="border rounded-3 p-3 bg-light">
                        <h6 class="fw-bold mb-3" style="color: var(--primary-color);"><i class="fas fa-car me-2"></i>Vehicle Details</h6>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Make <span class="text-danger">*</span></label>
                                <input type="text" name="vehicle_make" id="vehicle_make" class="form-control form-control-sm border-0 bg-white" placeholder="e.g., Toyota, BMW, Volkswagen" style="border-radius: 6px;" value="{{ old('vehicle_make', $product->vehicle_make) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Model <span class="text-danger">*</span></label>
                                <input type="text" name="vehicle_model" id="vehicle_model" class="form-control form-control-sm border-0 bg-white" placeholder="e.g., Corolla, X5, Golf" style="border-radius: 6px;" value="{{ old('vehicle_model', $product->vehicle_model) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Year <span class="text-danger">*</span></label>
                                <input type="number" name="vehicle_year" id="vehicle_year" class="form-control form-control-sm border-0 bg-white" min="1900" max="{{ date('Y') + 1 }}" placeholder="e.g., 2020" style="border-radius: 6px;" value="{{ old('vehicle_year', $product->vehicle_year) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mileage (km) <span class="text-danger">*</span></label>
                                <input type="number" name="vehicle_mileage" id="vehicle_mileage" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 50000" style="border-radius: 6px;" value="{{ old('vehicle_mileage', $product->vehicle_mileage) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Fuel Type <span class="text-danger">*</span></label>
                                <select name="vehicle_fuel_type" id="vehicle_fuel_type" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                                    <option value="">Select fuel type</option>
                                    <option value="petrol" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'petrol' ? 'selected' : '' }}>Petrol</option>
                                    <option value="diesel" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'diesel' ? 'selected' : '' }}>Diesel</option>
                                    <option value="electric" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'electric' ? 'selected' : '' }}>Electric</option>
                                    <option value="hybrid" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    <option value="lng" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'lng' ? 'selected' : '' }}>LNG</option>
                                    <option value="cng" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'cng' ? 'selected' : '' }}>CNG</option>
                                    <option value="other" {{ old('vehicle_fuel_type', $product->vehicle_fuel_type) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Transmission <span class="text-danger">*</span></label>
                                <select name="vehicle_transmission" id="vehicle_transmission" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                                    <option value="">Select transmission</option>
                                    <option value="manual" {{ old('vehicle_transmission', $product->vehicle_transmission) == 'manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="automatic" {{ old('vehicle_transmission', $product->vehicle_transmission) == 'automatic' ? 'selected' : '' }}>Automatic</option>
                                    <option value="semi_auto" {{ old('vehicle_transmission', $product->vehicle_transmission) == 'semi_auto' ? 'selected' : '' }}>Semi-Automatic</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Color</label>
                                <input type="text" name="vehicle_color" id="vehicle_color" class="form-control form-control-sm border-0 bg-white" placeholder="e.g., Black, Silver, Blue" style="border-radius: 6px;" value="{{ old('vehicle_color', $product->vehicle_color) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Engine Size (L)</label>
                                <input type="number" name="vehicle_engine_size" id="vehicle_engine_size" class="form-control form-control-sm border-0 bg-white" step="0.1" min="0" placeholder="e.g., 2.0" style="border-radius: 6px;" value="{{ old('vehicle_engine_size', $product->vehicle_engine_size) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Power (HP)</label>
                                <input type="number" name="vehicle_power" id="vehicle_power" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 150" style="border-radius: 6px;" value="{{ old('vehicle_power', $product->vehicle_power) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Number of Doors</label>
                                <input type="number" name="vehicle_doors" id="vehicle_doors" class="form-control form-control-sm border-0 bg-white" min="1" max="10" placeholder="e.g., 4" style="border-radius: 6px;" value="{{ old('vehicle_doors', $product->vehicle_doors) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Weight (kg)</label>
                                <input type="number" name="vehicle_weight" id="vehicle_weight" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 1500" style="border-radius: 6px;" value="{{ old('vehicle_weight', $product->vehicle_weight) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Registration Number</label>
                                <input type="text" name="vehicle_registration_number" id="vehicle_registration_number" class="form-control form-control-sm border-0 bg-white" placeholder="e.g., AB 12345" style="border-radius: 6px;" value="{{ old('vehicle_registration_number', $product->vehicle_registration_number) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">VIN Number</label>
                                <input type="text" name="vehicle_vin" id="vehicle_vin" class="form-control form-control-sm border-0 bg-white" maxlength="17" placeholder="17 character VIN" style="border-radius: 6px;" value="{{ old('vehicle_vin', $product->vehicle_vin) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Features</label>
                                <div class="border border-light rounded-2 p-3 bg-white" style="max-height: 200px; overflow-y: auto;">
                                    @php
                                        $selectedFeatures = old('vehicle_features', $product->vehicle_features ?? []);
                                    @endphp
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="sunroof" id="feature_sunroof" {{ in_array('sunroof', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_sunroof">Sunroof</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="leather" id="feature_leather" {{ in_array('leather', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_leather">Leather Seats</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="navigation" id="feature_navigation" {{ in_array('navigation', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_navigation">Navigation</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="parking_sensors" id="feature_parking_sensors" {{ in_array('parking_sensors', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_parking_sensors">Parking Sensors</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="rear_camera" id="feature_rear_camera" {{ in_array('rear_camera', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_rear_camera">Rear Camera</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="heated_seats" id="feature_heated_seats" {{ in_array('heated_seats', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_heated_seats">Heated Seats</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="cruise_control" id="feature_cruise_control" {{ in_array('cruise_control', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_cruise_control">Cruise Control</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="bluetooth" id="feature_bluetooth" {{ in_array('bluetooth', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_bluetooth">Bluetooth</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="usb" id="feature_usb" {{ in_array('usb', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_usb">USB</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="alloy_wheels" id="feature_alloy_wheels" {{ in_array('alloy_wheels', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_alloy_wheels">Alloy Wheels</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="abs" id="feature_abs" {{ in_array('abs', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_abs">ABS</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="airbags" id="feature_airbags" {{ in_array('airbags', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_airbags">Airbags</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="climate_control" id="feature_climate_control" {{ in_array('climate_control', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_climate_control">Climate Control</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="electric_windows" id="feature_electric_windows" {{ in_array('electric_windows', $selectedFeatures) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="feature_electric_windows">Electric Windows</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- House/Real Estate Section (shown when real estate category is selected) -->
                <div class="col-12 house-section" id="houseSection" style="display: none;">
                    <div class="border rounded-3 p-3 bg-light">
                        <h6 class="fw-bold mb-3" style="color: var(--primary-color);"><i class="fas fa-home me-2"></i>Property Details</h6>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Property Type <span class="text-danger">*</span></label>
                                <select name="house_property_type" id="house_property_type" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
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
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Number of Rooms</label>
                                <input type="number" name="house_rooms" id="house_rooms" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 5" style="border-radius: 6px;" value="{{ old('house_rooms', $product->house_rooms) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bedrooms</label>
                                <input type="number" name="house_bedrooms" id="house_bedrooms" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 3" style="border-radius: 6px;" value="{{ old('house_bedrooms', $product->house_bedrooms) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Bathrooms</label>
                                <input type="number" name="house_bathrooms" id="house_bathrooms" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 2" style="border-radius: 6px;" value="{{ old('house_bathrooms', $product->house_bathrooms) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Living Area (m²)</label>
                                <input type="number" name="house_living_area" id="house_living_area" class="form-control form-control-sm border-0 bg-white" step="0.01" min="0" placeholder="e.g., 120.50" style="border-radius: 6px;" value="{{ old('house_living_area', $product->house_living_area) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Plot Size (m²)</label>
                                <input type="number" name="house_plot_size" id="house_plot_size" class="form-control form-control-sm border-0 bg-white" step="0.01" min="0" placeholder="e.g., 500" style="border-radius: 6px;" value="{{ old('house_plot_size', $product->house_plot_size) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Year Built</label>
                                <input type="number" name="house_year_built" id="house_year_built" class="form-control form-control-sm border-0 bg-white" min="1800" max="{{ date('Y') + 1 }}" placeholder="e.g., 2010" style="border-radius: 6px;" value="{{ old('house_year_built', $product->house_year_built) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Energy Rating</label>
                                <select name="house_energy_rating" id="house_energy_rating" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
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
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ownership Type</label>
                                <select name="house_ownership_type" id="house_ownership_type" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                                    <option value="">Select ownership type</option>
                                    <option value="borettslag" {{ old('house_ownership_type', $product->house_ownership_type) == 'borettslag' ? 'selected' : '' }}>Borettslag (Cooperative)</option>
                                    <option value="sameie" {{ old('house_ownership_type', $product->house_ownership_type) == 'sameie' ? 'selected' : '' }}>Sameie (Joint Ownership)</option>
                                    <option value="freehold" {{ old('house_ownership_type', $product->house_ownership_type) == 'freehold' ? 'selected' : '' }}>Freehold (Selveier)</option>
                                    <option value="leasehold" {{ old('house_ownership_type', $product->house_ownership_type) == 'leasehold' ? 'selected' : '' }}>Leasehold (Leie)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Floor</label>
                                <input type="number" name="house_floor" id="house_floor" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 3" style="border-radius: 6px;" value="{{ old('house_floor', $product->house_floor) }}">
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="house_elevator" value="1" id="house_elevator" {{ old('house_elevator', $product->house_elevator) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="house_elevator">Elevator</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="house_balcony" value="1" id="house_balcony" {{ old('house_balcony', $product->house_balcony) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="house_balcony">Balcony</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="house_new_construction" value="1" id="house_new_construction" {{ old('house_new_construction', $product->house_new_construction) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="house_new_construction">New Construction</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Parking</label>
                                <select name="house_parking" id="house_parking" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                                    <option value="">Select parking</option>
                                    <option value="none" {{ old('house_parking', $product->house_parking) == 'none' ? 'selected' : '' }}>No Parking</option>
                                    <option value="garage" {{ old('house_parking', $product->house_parking) == 'garage' ? 'selected' : '' }}>Garage</option>
                                    <option value="parking_space" {{ old('house_parking', $product->house_parking) == 'parking_space' ? 'selected' : '' }}>Parking Space</option>
                                    <option value="street" {{ old('house_parking', $product->house_parking) == 'street' ? 'selected' : '' }}>Street Parking</option>
                                    <option value="carport" {{ old('house_parking', $product->house_parking) == 'carport' ? 'selected' : '' }}>Carport</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Heating Type</label>
                                <select name="house_heating_type" id="house_heating_type" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                                    <option value="">Select heating type</option>
                                    <option value="electric" {{ old('house_heating_type', $product->house_heating_type) == 'electric' ? 'selected' : '' }}>Electric</option>
                                    <option value="oil" {{ old('house_heating_type', $product->house_heating_type) == 'oil' ? 'selected' : '' }}>Oil</option>
                                    <option value="gas" {{ old('house_heating_type', $product->house_heating_type) == 'gas' ? 'selected' : '' }}>Gas</option>
                                    <option value="district_heating" {{ old('house_heating_type', $product->house_heating_type) == 'district_heating' ? 'selected' : '' }}>District Heating</option>
                                    <option value="wood" {{ old('house_heating_type', $product->house_heating_type) == 'wood' ? 'selected' : '' }}>Wood/ Pellet</option>
                                    <option value="heat_pump" {{ old('house_heating_type', $product->house_heating_type) == 'heat_pump' ? 'selected' : '' }}>Heat Pump</option>
                                    <option value="other" {{ old('house_heating_type', $product->house_heating_type) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

@stop

@section('js')
<script>
$(document).ready(function() {
    // Get the vehicle and real estate category IDs
    var vehicleCategoryId = null;
    var realEstateCategoryId = null;

    // Find the Vehicles and Real Estate category options
    $('select[name="category_id"] option').each(function() {
        var text = $(this).text().toLowerCase();
        if (text.includes('vehicle')) {
            vehicleCategoryId = $(this).val();
        }
        if (text.includes('real estate') || text.includes('realestate')) {
            realEstateCategoryId = $(this).val();
        }
    });

    // Check initial category and show/hide sections
    var initialCategoryId = $('select[name="category_id"]').val();
    if (vehicleCategoryId && initialCategoryId == vehicleCategoryId) {
        $('#vehicleSection').show();
    }
    if (realEstateCategoryId && initialCategoryId == realEstateCategoryId) {
        $('#houseSection').show();
    }

    // Handle category change to show/hide vehicle and house fields
    $('select[name="category_id"]').on('change', function() {
        var selectedCategoryId = $(this).val();
        var vehicleSection = $('#vehicleSection');
        var houseSection = $('#houseSection');

        // Check if selected category is a vehicle category
        if (vehicleCategoryId && selectedCategoryId == vehicleCategoryId) {
            vehicleSection.show();
        } else {
            vehicleSection.hide();
        }

        // Check if selected category is a real estate category
        if (realEstateCategoryId && selectedCategoryId == realEstateCategoryId) {
            houseSection.show();
        } else {
            houseSection.hide();
        }
    });

    // Handle listing type changes
    $('input[name="listing_type"]').on('change', function() {
        const listingType = this.value;
        const exchangeSection = $('.exchange-section');
        const saleSection = $('.form-group .card').last(); // Sale section

        if (listingType === 'exchange') {
            exchangeSection.show();
            saleSection.hide();
            $('#is_for_sale').prop('checked', false).trigger('change');
        } else if (listingType === 'sale') {
            exchangeSection.hide();
            saleSection.show();
            $('#is_for_sale').prop('checked', true).trigger('change');
        } else if (listingType === 'giveaway') {
            exchangeSection.hide();
            saleSection.hide();
            $('#is_for_sale').prop('checked', false).trigger('change');
        }
    });

    // Handle sale checkbox toggle
    $('#is_for_sale').on('change', function() {
        const salePriceSection = $('.sale-price-section');
        if (this.checked) {
            salePriceSection.show();
            $('#sale_price').attr('required', true);
        } else {
            salePriceSection.hide();
            $('#sale_price').attr('required', false).val('');
        }
    });

    // Initialize on page load
    const selectedListingType = $('input[name="listing_type"]:checked').val();
    if (selectedListingType) {
        $('input[name="listing_type"][value="' + selectedListingType + '"]').trigger('change');
    }

    if ($('#is_for_sale').is(':checked')) {
        $('.sale-price-section').show();
        $('#sale_price').attr('required', true);
    }
});
</script>
@stop
