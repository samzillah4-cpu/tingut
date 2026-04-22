@extends('adminlte::page')

@section('title', 'Create Product')

@section('content_header')
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-plus text-white"></i>
                    </div>
                    <div>
                        <h1 class="mb-1" style="color: var(--primary-color);">Create Product</h1>
                        <p class="text-muted mb-0">Add a new product to the exchange platform</p>
                    </div>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary" style="border-radius: 8px;">
                    <i class="fas fa-arrow-left me-2"></i>Back to Products
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card shadow-sm" style="border-radius: 12px; border: none;">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                    <i class="fas fa-plus text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0">Add New Product</h5>
                    <small class="text-muted">Fill in the details below to create a new product listing</small>
                </div>
            </div>
        </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf

                        <!-- Form Fields -->
                        <form id="productForm" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Product Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control form-control-sm border-0 bg-white" placeholder="Enter product title" required style="border-radius: 6px;">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control form-control-sm border-0 bg-white" required style="border-radius: 6px;">
                                        <option value="">Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Seller <span class="text-danger">*</span></label>
                                    <select name="user_id" id="user_id" class="form-control form-control-sm border-0 bg-white" required style="border-radius: 6px;">
                                        <option value="">Select a seller</option>
                                        @foreach(\App\Models\User::all() as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status" class="form-control form-control-sm border-0 bg-white" required style="border-radius: 6px;">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" id="description" class="form-control form-control-sm border-0 bg-white" rows="3" placeholder="Describe your product in detail..." required style="border-radius: 6px;"></textarea>
                                </div>

                                <!-- Listing Type -->
                                <div class="col-12">
                                    <div class="border rounded-3 p-3 bg-light">
                                        <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Listing Type</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="listing_type" value="sale" id="listing_sale" checked style="border-color: var(--primary-color);">
                                                    <label class="form-check-label fw-semibold" for="listing_sale">
                                                        <i class="fas fa-shopping-cart me-2 text-success"></i>Sale
                                                    </label>
                                                    <small class="text-muted d-block">Sell for a fixed price</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="listing_type" value="exchange" id="listing_exchange" style="border-color: var(--primary-color);">
                                                    <label class="form-check-label fw-semibold" for="listing_exchange">
                                                        <i class="fas fa-exchange-alt me-2 text-warning"></i>Exchange
                                                    </label>
                                                    <small class="text-muted d-block">Trade for other items</small>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="listing_type" value="giveaway" id="listing_giveaway" style="border-color: var(--primary-color);">
                                                    <label class="form-check-label fw-semibold" for="listing_giveaway">
                                                        <i class="fas fa-gift me-2 text-info"></i>Giveaway
                                                    </label>
                                                    <small class="text-muted d-block">Free to good home</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Exchange Categories -->
                                <div class="col-md-6 exchange-section" style="display: none;">
                                    <label class="form-label fw-semibold">Exchange Categories</label>
                                    <div class="border border-light rounded-2 p-3 bg-light" style="max-height: 200px; overflow-y: auto;">
                                        @foreach($categories as $category)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="exchange_categories[]" value="{{ $category->id }}" id="category_{{ $category->id }}">
                                                <label class="form-check-label" for="category_{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="text-muted">Select categories of items you're willing to exchange for</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Product Images</label>
                                    <input type="file" name="images[]" id="images" class="form-control form-control-sm border-0 bg-white" multiple accept="image/*" style="border-radius: 6px;">
                                    <small class="text-muted">You can select multiple images</small>
                                </div>

                                <!-- Sale Section -->
                                <div class="col-12">
                                    <div class="border rounded-3 p-3 bg-light">
                                        <h6 class="fw-bold mb-3" style="color: var(--primary-color);">Sale Options</h6>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input" type="checkbox" name="is_for_sale" value="1" id="is_for_sale" style="border-color: var(--primary-color);">
                                                    <label class="form-check-label fw-semibold" for="is_for_sale">
                                                        Available for sale
                                                    </label>
                                                </div>
                                                <small class="text-muted">Check this if you want to sell this product for a fixed price</small>
                                            </div>

                                            <div class="col-md-6 sale-price-section" style="display: none;">
                                                <label class="form-label fw-semibold">Sale Price (NOK)</label>
                                                <input type="number" name="sale_price" id="sale_price" class="form-control form-control-sm border-0 bg-white" step="0.01" min="0" placeholder="Enter price in NOK" style="border-radius: 6px;">
                                                <small class="text-muted">Set the price for this product in Norwegian Kroner</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vehicle Section (shown when vehicle category is selected) -->
                                <div class="col-12 vehicle-section" id="vehicleSection" style="display: none;">
                                    <div class="border rounded-3 p-3 bg-light">
                                        <h6 class="fw-bold mb-3" style="color: var(--primary-color);"><i class="fas fa-car me-2"></i>Vehicle Details</h6>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Make <span class="text-danger">*</span></label>
                                                <input type="text" name="vehicle_make" id="vehicle_make" class="form-control form-control-sm border-0 bg-white" placeholder="e.g., Toyota, BMW, Volkswagen" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Model <span class="text-danger">*</span></label>
                                                <input type="text" name="vehicle_model" id="vehicle_model" class="form-control form-control-sm border-0 bg-white" placeholder="e.g., Corolla, X5, Golf" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Year <span class="text-danger">*</span></label>
                                                <input type="number" name="vehicle_year" id="vehicle_year" class="form-control form-control-sm border-0 bg-white" min="1900" max="{{ date('Y') + 1 }}" placeholder="e.g., 2020" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Mileage (km) <span class="text-danger">*</span></label>
                                                <input type="number" name="vehicle_mileage" id="vehicle_mileage" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 50000" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Fuel Type <span class="text-danger">*</span></label>
                                                <select name="vehicle_fuel_type" id="vehicle_fuel_type" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                                                    <option value="">Select fuel type</option>
                                                    <option value="petrol">Petrol</option>
                                                    <option value="diesel">Diesel</option>
                                                    <option value="electric">Electric</option>
                                                    <option value="hybrid">Hybrid</option>
                                                    <option value="lng">LNG</option>
                                                    <option value="cng">CNG</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Transmission <span class="text-danger">*</span></label>
                                                <select name="vehicle_transmission" id="vehicle_transmission" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                                                    <option value="">Select transmission</option>
                                                    <option value="manual">Manual</option>
                                                    <option value="automatic">Automatic</option>
                                                    <option value="semi_auto">Semi-Automatic</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Color</label>
                                                <input type="text" name="vehicle_color" id="vehicle_color" class="form-control form-control-sm border-0 bg-white" placeholder="e.g., Black, Silver, Blue" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Engine Size (L)</label>
                                                <input type="number" name="vehicle_engine_size" id="vehicle_engine_size" class="form-control form-control-sm border-0 bg-white" step="0.1" min="0" placeholder="e.g., 2.0" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Power (HP)</label>
                                                <input type="number" name="vehicle_power" id="vehicle_power" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 150" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Number of Doors</label>
                                                <input type="number" name="vehicle_doors" id="vehicle_doors" class="form-control form-control-sm border-0 bg-white" min="1" max="10" placeholder="e.g., 4" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Weight (kg)</label>
                                                <input type="number" name="vehicle_weight" id="vehicle_weight" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 1500" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Registration Number</label>
                                                <input type="text" name="vehicle_registration_number" id="vehicle_registration_number" class="form-control form-control-sm border-0 bg-white" placeholder="e.g., AB 12345" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">VIN Number</label>
                                                <input type="text" name="vehicle_vin" id="vehicle_vin" class="form-control form-control-sm border-0 bg-white" maxlength="17" placeholder="17 character VIN" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Features</label>
                                                <div class="border border-light rounded-2 p-3 bg-white" style="max-height: 200px; overflow-y: auto;">
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="sunroof" id="feature_sunroof">
                                                        <label class="form-check-label" for="feature_sunroof">Sunroof</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="leather" id="feature_leather">
                                                        <label class="form-check-label" for="feature_leather">Leather Seats</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="navigation" id="feature_navigation">
                                                        <label class="form-check-label" for="feature_navigation">Navigation</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="parking_sensors" id="feature_parking_sensors">
                                                        <label class="form-check-label" for="feature_parking_sensors">Parking Sensors</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="rear_camera" id="feature_rear_camera">
                                                        <label class="form-check-label" for="feature_rear_camera">Rear Camera</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="heated_seats" id="feature_heated_seats">
                                                        <label class="form-check-label" for="feature_heated_seats">Heated Seats</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="cruise_control" id="feature_cruise_control">
                                                        <label class="form-check-label" for="feature_cruise_control">Cruise Control</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="bluetooth" id="feature_bluetooth">
                                                        <label class="form-check-label" for="feature_bluetooth">Bluetooth</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="usb" id="feature_usb">
                                                        <label class="form-check-label" for="feature_usb">USB</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="alloy_wheels" id="feature_alloy_wheels">
                                                        <label class="form-check-label" for="feature_alloy_wheels">Alloy Wheels</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="abs" id="feature_abs">
                                                        <label class="form-check-label" for="feature_abs">ABS</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="airbags" id="feature_airbags">
                                                        <label class="form-check-label" for="feature_airbags">Airbags</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="climate_control" id="feature_climate_control">
                                                        <label class="form-check-label" for="feature_climate_control">Climate Control</label>
                                                    </div>
                                                    <div class="form-check mb-2">
                                                        <input class="form-check-input" type="checkbox" name="vehicle_features[]" value="electric_windows" id="feature_electric_windows">
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
                                                    <option value="apartment">Apartment</option>
                                                    <option value="house">House</option>
                                                    <option value="villa">Villa</option>
                                                    <option value="townhouse">Townhouse</option>
                                                    <option value="cottage">Cottage</option>
                                                    <option value="farm">Farm</option>
                                                    <option value="plot">Building Plot</option>
                                                    <option value="commercial">Commercial Property</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Number of Rooms</label>
                                                <input type="number" name="house_rooms" id="house_rooms" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 5" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Bedrooms</label>
                                                <input type="number" name="house_bedrooms" id="house_bedrooms" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 3" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Bathrooms</label>
                                                <input type="number" name="house_bathrooms" id="house_bathrooms" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 2" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Living Area (m²)</label>
                                                <input type="number" name="house_living_area" id="house_living_area" class="form-control form-control-sm border-0 bg-white" step="0.01" min="0" placeholder="e.g., 120.50" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Plot Size (m²)</label>
                                                <input type="number" name="house_plot_size" id="house_plot_size" class="form-control form-control-sm border-0 bg-white" step="0.01" min="0" placeholder="e.g., 500" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Year Built</label>
                                                <input type="number" name="house_year_built" id="house_year_built" class="form-control form-control-sm border-0 bg-white" min="1800" max="{{ date('Y') + 1 }}" placeholder="e.g., 2010" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Energy Rating</label>
                                                <select name="house_energy_rating" id="house_energy_rating" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                                                    <option value="">Select energy rating</option>
                                                    <option value="a">A</option>
                                                    <option value="b">B</option>
                                                    <option value="c">C</option>
                                                    <option value="d">D</option>
                                                    <option value="e">E</option>
                                                    <option value="f">F</option>
                                                    <option value="g">G</option>
                                                    <option value="unknown">Unknown</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Ownership Type</label>
                                                <select name="house_ownership_type" id="house_ownership_type" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                                                    <option value="">Select ownership type</option>
                                                    <option value="borettslag">Borettslag (Cooperative)</option>
                                                    <option value="sameie">Sameie (Joint Ownership)</option>
                                                    <option value="freehold">Freehold (Selveier)</option>
                                                    <option value="leasehold">Leasehold (Leie)</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Floor</label>
                                                <input type="number" name="house_floor" id="house_floor" class="form-control form-control-sm border-0 bg-white" min="0" placeholder="e.g., 3" style="border-radius: 6px;">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check mt-4">
                                                    <input class="form-check-input" type="checkbox" name="house_elevator" value="1" id="house_elevator">
                                                    <label class="form-check-label" for="house_elevator">Elevator</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check mt-4">
                                                    <input class="form-check-input" type="checkbox" name="house_balcony" value="1" id="house_balcony">
                                                    <label class="form-check-label" for="house_balcony">Balcony</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check mt-4">
                                                    <input class="form-check-input" type="checkbox" name="house_new_construction" value="1" id="house_new_construction">
                                                    <label class="form-check-label" for="house_new_construction">New Construction</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Parking</label>
                                                <select name="house_parking" id="house_parking" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                                                    <option value="">Select parking</option>
                                                    <option value="none">No Parking</option>
                                                    <option value="garage">Garage</option>
                                                    <option value="parking_space">Parking Space</option>
                                                    <option value="street">Street Parking</option>
                                                    <option value="carport">Carport</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Heating Type</label>
                                                <select name="house_heating_type" id="house_heating_type" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                                                    <option value="">Select heating type</option>
                                                    <option value="electric">Electric</option>
                                                    <option value="oil">Oil</option>
                                                    <option value="gas">Gas</option>
                                                    <option value="district_heating">District Heating</option>
                                                    <option value="wood">Wood/ Pellet</option>
                                                    <option value="heat_pump">Heat Pump</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-end align-items-center pt-3 border-top mt-4">
                                <div class="d-flex gap-3">
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius: 6px;">
                                        <i class="fas fa-times me-1"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-sm px-3" style="border-radius: 6px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);" id="submitBtn">
                                        <i class="fas fa-save me-1"></i>Create Product
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Success Message Container -->
                        <div id="successMessage" class="alert alert-success alert-dismissible fade d-none" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                            <i class="fas fa-check-circle me-2"></i>
                            <span id="successText"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
    <style>
        :root {
            --primary-color: {{ config('settings.primary_color', '#1a6969') }};
        }

        .card {
            border-radius: 12px;
            border: none;
        }

        .btn:hover {
            background-color: #146060 !important;
            border-color: #146060 !important;
        }

        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(26, 105, 105, 0.25) !important;
        }

        .alert-success {
            border-left: 4px solid #198754;
        }

        .fade {
            transition: opacity 0.3s ease-in-out;
        }
    </style>
@stop

@section('js')
<script>
$(document).ready(function() {
    // Get the vehicle category ID (assumes Vehicles category exists)
    var vehicleCategoryId = null;
    var realEstateCategoryId = null;

    // Find the Vehicles and Real Estate category options
    $('#category_id option').each(function() {
        var text = $(this).text().toLowerCase();
        if (text.includes('vehicle')) {
            vehicleCategoryId = $(this).val();
        }
        if (text.includes('real estate') || text.includes('realestate')) {
            realEstateCategoryId = $(this).val();
        }
    });

    // Handle category change to show/hide vehicle and house fields
    $('#category_id').on('change', function() {
        var selectedCategoryId = $(this).val();
        var vehicleSection = $('#vehicleSection');
        var houseSection = $('#houseSection');

        // Check if selected category is a vehicle category
        if (vehicleCategoryId && selectedCategoryId == vehicleCategoryId) {
            vehicleSection.show();
        } else {
            vehicleSection.hide();
            // Clear vehicle fields when hiding
            vehicleSection.find('input, select').not(':checkbox, :radio').val('');
            vehicleSection.find('input[type=checkbox]').prop('checked', false);
        }

        // Check if selected category is a real estate category
        if (realEstateCategoryId && selectedCategoryId == realEstateCategoryId) {
            houseSection.show();
        } else {
            houseSection.hide();
            // Clear house fields when hiding
            houseSection.find('input, select').not(':checkbox, :radio').val('');
            houseSection.find('input[type=checkbox]').prop('checked', false);
        }
    });

    // Handle listing type changes
    $('input[name="listing_type"]').on('change', function() {
        const listingType = this.value;
        const exchangeSection = $('.exchange-section');
        const saleSection = $('.col-12 .border.rounded-3.p-3.bg-light').last(); // Sale section

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

    // Handle form submission with AJAX
    $('#productForm').on('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const submitBtn = $('#submitBtn');
        const originalText = submitBtn.html();

        // Show loading state
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Creating...');

        $.ajax({
            url: '{{ route("admin.products.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $('#successText').text('Product created successfully!');
                    $('#successMessage').removeClass('d-none').addClass('show');

                    // Reset form
                    $('#productForm')[0].reset();

                    // Hide success message after 3 seconds and redirect
                    setTimeout(function() {
                        $('#successMessage').removeClass('show').addClass('d-none');
                        window.location.href = '{{ route("admin.products.index") }}';
                    }, 2000);
                } else {
                    // Handle validation errors
                    if (response.errors) {
                        let errorMessage = 'Please fix the following errors:\n';
                        for (let field in response.errors) {
                            errorMessage += '- ' + response.errors[field][0] + '\n';
                        }
                        alert(errorMessage);
                    } else {
                        alert(response.message || 'An error occurred while creating the product.');
                    }
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred while creating the product.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = 'Please fix the following errors:\n';
                    for (let field in xhr.responseJSON.errors) {
                        errorMessage += '- ' + xhr.responseJSON.errors[field][0] + '\n';
                    }
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                alert(errorMessage);
            },
            complete: function() {
                // Restore button state
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    });
});
</script>
@stop
