<?php $__env->startSection('head'); ?>
    <title><?php echo e($product->title); ?> - <?php echo e(config('settings.site_name', 'Bytte.no')); ?></title>

    <!-- Meta Description -->
    <meta name="description" content="<?php echo e(Str::limit(strip_tags($product->description), 160)); ?>">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="product">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:title" content="<?php echo e($product->title); ?>">
    <meta property="og:description" content="<?php echo e(Str::limit(strip_tags($product->description), 160)); ?>">
    <?php if($product->images && count($product->images) > 0): ?>
        <meta property="og:image" content="<?php echo e(asset('storage/' . $product->images[0])); ?>">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
        <meta property="og:image:alt" content="<?php echo e($product->title); ?>">
    <?php endif; ?>
    <meta property="og:site_name" content="<?php echo e(config('settings.site_name', 'Bytte.no')); ?>">
    <meta property="og:locale" content="en_US">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($product->title); ?>">
    <meta name="twitter:description" content="<?php echo e(Str::limit(strip_tags($product->description), 160)); ?>">
    <?php if($product->images && count($product->images) > 0): ?>
        <meta name="twitter:image" content="<?php echo e(asset('storage/' . $product->images[0])); ?>">
        <meta name="twitter:image:alt" content="<?php echo e($product->title); ?>">
    <?php endif; ?>

    <!-- Product Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "<?php echo e($product->title); ?>",
        "description": "<?php echo e(strip_tags($product->description)); ?>",
        <?php if($product->images && count($product->images) > 0): ?>
        "image": [
            <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                "<?php echo e(asset('storage/' . $image)); ?>"<?php if($index < count($product->images) - 1): ?>,<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ],
        <?php endif; ?>
        <?php if($product->is_for_sale && $product->sale_price): ?>
        "offers": {
            "@type": "Offer",
            "priceCurrency": "NOK",
            "price": "<?php echo e($product->sale_price); ?>",
            "availability": "https://schema.org/InStock",
            "seller": {
                "@type": "Person",
                "name": "<?php echo e($product->user->name ?? 'Seller'); ?>"
            }
        },
        <?php elseif($product->is_available_for_rent && $product->rent_price): ?>
        "offers": {
            "@type": "Offer",
            "priceCurrency": "NOK",
            "price": "<?php echo e($product->rent_price); ?>",
            "availability": "https://schema.org/InStock",
            "priceValidUntil": "<?php echo e(now()->addDays(30)->format('Y-m-d')); ?>"
        },
        <?php endif; ?>
        "brand": {
            "@type": "Brand",
            "name": "<?php echo e(config('settings.site_name', 'Bytte.no')); ?>"
        },
        "category": "<?php echo e($product->category->name ?? 'General'); ?>",
        "url": "<?php echo e(url()->current()); ?>",
        "datePublished": "<?php echo e($product->created_at->format('Y-m-d')); ?>",
        "dateModified": "<?php echo e($product->updated_at->format('Y-m-d')); ?>"
    }
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <style>
        /* Purchase Button - Primary */
        .purchase-product {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0e4a52 100%) !important;
            border: 2px solid var(--primary-color) !important;
            color: white !important;
            font-weight: 600;
            font-size: 14px !important;
            padding: 10px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
        }

        .purchase-product:hover {
            background: linear-gradient(135deg, #0e4a52 0%, var(--primary-color) 100%) !important;
            border-color: #0a3f46 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 80, 87, 0.3);
            color: white !important;
            text-decoration: none;
        }

        /* Contact Seller Button - Green */
        .contact-seller-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
            border: 2px solid #28a745 !important;
            color: white !important;
            font-weight: 600;
            font-size: 14px !important;
            padding: 10px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
        }

        .contact-seller-btn:hover {
            background: linear-gradient(135deg, #20c997 0%, #28a745 100%) !important;
            border-color: #1e7e34 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
            color: white !important;
            text-decoration: none;
        }

        /* Propose Exchange Button - Yellow */
        .propose-exchange-btn {
            background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%) !important;
            border: 2px solid #ffc107 !important;
            color: #212529 !important;
            font-weight: 600;
            font-size: 14px !important;
            padding: 10px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
        }

        .propose-exchange-btn:hover {
            background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%) !important;
            border-color: #e0a800 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
            color: #212529 !important;
            text-decoration: none;
        }

        .product-action-btn:active {
            transform: translateY(0);
        }

        .product-action-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(15, 80, 87, 0.2);
        }

        /* Secondary action buttons */
        .product-action-btn-outline {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color) !important;
            font-weight: 600;
            font-size: 14px !important;
            padding: 10px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 44px;
        }

        .product-action-btn-outline:hover {
            background: var(--primary-color);
            color: white !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 80, 87, 0.3);
            text-decoration: none;
        }

        .product-action-btn-outline:active {
            transform: translateY(0);
        }

        .product-action-btn-outline:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(15, 80, 87, 0.2);
        }

        /* Modal Send Button - Primary Color */
        .modal-send-btn {
            background: linear-gradient(135deg, var(--primary-color, #0f5057) 0%, #0e4a52 100%) !important;
            border: 1px solid var(--primary-color, #0f5057) !important;
            color: white !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            padding: 12px 24px !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            min-height: 44px !important;
            box-shadow: 0 2px 8px rgba(15, 80, 87, 0.2) !important;
        }

        .modal-send-btn:hover {
            background: linear-gradient(135deg, #0e4a52 0%, var(--primary-color, #0f5057) 100%) !important;
            border-color: #0a3f46 !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(15, 80, 87, 0.4);
            color: white !important;
            text-decoration: none !important;
        }

        .modal-send-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(15, 80, 87, 0.3);
        }

        .modal-send-btn:disabled {
            background: #6c757d !important;
            border-color: #6c757d !important;
            cursor: not-allowed;
            transform: none !important;
            box-shadow: none !important;
        }

        /* Override Bootstrap button styles */
        .btn-freecycle {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0e4a52 100%) !important;
            border: 2px solid var(--primary-color) !important;
            color: white !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            padding: 10px 16px !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            min-height: 44px !important;
        }

        .btn-freecycle:hover {
            background: linear-gradient(135deg, #0e4a52 0%, var(--primary-color) 100%) !important;
            border-color: #0a3f46 !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(15, 80, 87, 0.3) !important;
            color: white !important;
            text-decoration: none !important;
        }

        .btn-freecycle-outline {
            background: transparent !important;
            border: 2px solid var(--primary-color) !important;
            color: var(--primary-color) !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            padding: 10px 16px !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            min-height: 44px !important;
        }

        .btn-freecycle-outline:hover {
            background: var(--primary-color) !important;
            color: white !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 4px 12px rgba(15, 80, 87, 0.3) !important;
            text-decoration: none !important;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .product-action-btn,
            .product-action-btn-outline,
            .btn-freecycle,
            .btn-freecycle-outline {
                font-size: 13px !important;
                padding: 8px 12px !important;
                min-height: 40px !important;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo e(Str::limit($product->title, 30)); ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <?php if($product->images && count($product->images) > 0): ?>
                <div class="product-image-container mb-3">
                    <?php if(str_starts_with($product->images[0], 'http')): ?>
                        <img src="<?php echo e($product->images[0]); ?>" alt="<?php echo e($product->title); ?>" class="product-image-zoom" loading="eager">
                    <?php else: ?>
                        <img src="<?php echo e(asset('storage/' . $product->images[0])); ?>" alt="<?php echo e($product->title); ?>" class="product-image-zoom" loading="eager">
                    <?php endif; ?>
                </div>
                <?php if(count($product->images) > 1): ?>
                    <div class="row">
                        <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-3 mb-2">
                                <div class="thumbnail-container">
                                    <?php if(str_starts_with($image, 'http')): ?>
                                        <img src="<?php echo e($image); ?>" alt="<?php echo e($product->title); ?> <?php echo e($index + 1); ?>" class="thumbnail-image" loading="lazy">
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="<?php echo e($product->title); ?> <?php echo e($index + 1); ?>" class="thumbnail-image" loading="lazy">
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="product-image-container d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="fas fa-image fa-3x text-secondary"></i>
                </div>
            <?php endif; ?>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="freecycle-card">
                <div class="card-body p-4">
                    <h1 class="card-title mb-3" style="color: var(--primary-color);"><?php echo e($product->title); ?></h1>

                    <div class="mb-3">
                        <span class="badge" style="background-color: var(--primary-color); color: white;"><?php echo e($product->category->name); ?></span>
                        <?php if($product->is_giveaway): ?>
                            <span class="badge bg-danger ms-1" style="animation: pulse 2s infinite;">
                                <i class="fas fa-gift me-1"></i>GIVEAWAY
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Vehicle Details Section -->
                    <?php if($product->category && $product->category->is_vehicle && $product->vehicle_make): ?>
                        <div class="mb-4 p-3 bg-light rounded">
                            <h5 class="mb-3" style="color: var(--primary-color);"><i class="fas fa-car me-2"></i>Vehicle Details</h5>
                            <div class="row">
                                <?php if($product->vehicle_make): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Make</small>
                                        <strong><?php echo e($product->vehicle_make); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->vehicle_model): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Model</small>
                                        <strong><?php echo e($product->vehicle_model); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->vehicle_year): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Year</small>
                                        <strong><?php echo e($product->vehicle_year); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->vehicle_mileage): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Mileage</small>
                                        <strong><?php echo e(number_format($product->vehicle_mileage)); ?> km</strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->vehicle_fuel_type): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Fuel Type</small>
                                        <strong><?php echo e(ucfirst($product->vehicle_fuel_type)); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->vehicle_transmission): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Transmission</small>
                                        <strong><?php echo e(ucfirst($product->vehicle_transmission)); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->vehicle_color): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Color</small>
                                        <strong><?php echo e($product->vehicle_color); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->vehicle_engine_size): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Engine Size</small>
                                        <strong><?php echo e($product->vehicle_engine_size); ?> L</strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->vehicle_power): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Power</small>
                                        <strong><?php echo e($product->vehicle_power); ?> HP</strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->vehicle_doors): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Doors</small>
                                        <strong><?php echo e($product->vehicle_doors); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->vehicle_weight): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Weight</small>
                                        <strong><?php echo e(number_format($product->vehicle_weight)); ?> kg</strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->vehicle_registration_number): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Registration</small>
                                        <strong><?php echo e($product->vehicle_registration_number); ?></strong>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php if($product->vehicle_features && count($product->vehicle_features) > 0): ?>
                                <div class="mt-3">
                                    <small class="text-muted d-block mb-2">Features</small>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php
                                        $featureLabels = [
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
                                        ?>
                                        <?php $__currentLoopData = $product->vehicle_features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-secondary"><?php echo e($featureLabels[$feature] ?? $feature); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- House/Real Estate Details Section -->
                    <?php if($product->category && $product->category->is_real_estate && $product->house_property_type): ?>
                        <div class="mb-4 p-3 bg-light rounded">
                            <h5 class="mb-3" style="color: var(--primary-color);"><i class="fas fa-home me-2"></i>Property Details</h5>
                            <div class="row">
                                <?php if($product->house_property_type): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Property Type</small>
                                        <strong><?php echo e(ucfirst($product->house_property_type)); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->house_rooms): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Rooms</small>
                                        <strong><?php echo e($product->house_rooms); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->house_bedrooms): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Bedrooms</small>
                                        <strong><?php echo e($product->house_bedrooms); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->house_bathrooms): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Bathrooms</small>
                                        <strong><?php echo e($product->house_bathrooms); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->house_living_area): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Living Area</small>
                                        <strong><?php echo e(number_format($product->house_living_area, 2, ',', ' ')); ?> m²</strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->house_plot_size): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Plot Size</small>
                                        <strong><?php echo e(number_format($product->house_plot_size, 2, ',', ' ')); ?> m²</strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->house_year_built): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Year Built</small>
                                        <strong><?php echo e($product->house_year_built); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->house_energy_rating): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Energy Rating</small>
                                        <strong><?php echo e(strtoupper($product->house_energy_rating)); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->house_ownership_type): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Ownership Type</small>
                                        <strong><?php echo e(ucfirst(str_replace('_', ' ', $product->house_ownership_type))); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->house_floor): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Floor</small>
                                        <strong><?php echo e($product->house_floor); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->house_parking): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Parking</small>
                                        <strong><?php echo e(ucfirst(str_replace('_', ' ', $product->house_parking))); ?></strong>
                                    </div>
                                <?php endif; ?>
                                <?php if($product->house_heating_type): ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <small class="text-muted d-block">Heating Type</small>
                                        <strong><?php echo e(ucfirst(str_replace('_', ' ', $product->house_heating_type))); ?></strong>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="mt-2">
                                <?php if($product->house_elevator): ?><span class="badge bg-info me-1">Elevator</span><?php endif; ?>
                                <?php if($product->house_balcony): ?><span class="badge bg-info me-1">Balcony</span><?php endif; ?>
                                <?php if($product->house_new_construction): ?><span class="badge bg-info me-1">New Construction</span><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($product->exchange_categories && count($product->exchange_categories) > 0): ?>
                        <div class="mb-3">
                            <small class="text-muted d-block mb-2"><i class="fas fa-exchange-alt me-1"></i>Willing to exchange for:</small>
                            <div>
                                <?php $__currentLoopData = $product->exchange_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $exchangeCategory = \App\Models\Category::find($categoryId);
                                    ?>
                                    <?php if($exchangeCategory): ?>
                                        <span class="badge bg-light text-dark me-1 mb-1"><?php echo e($exchangeCategory->name); ?></span>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Sale Information -->
                    <?php if($product->is_for_sale && !$product->is_giveaway): ?>
                        <div class="mb-3 p-3 bg-success bg-opacity-10 border border-success rounded">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-shopping-cart text-success me-2"></i>
                                    <strong class="text-success">Available for Purchase</strong>
                                </div>
                                <div class="text-end">
                                    <div class="h4 text-success fw-bold mb-0"><?php echo e(number_format($product->sale_price, 2, ',', ' ')); ?> <?php echo e(config('settings.currency', 'NOK')); ?></div>
                                    <small class="text-muted">Price</small>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Giveaway Information -->
                    <?php if($product->listing_type == 'giveaway'): ?>
                        <div class="mb-3 p-3 bg-warning bg-opacity-10 border border-warning rounded">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-gift text-warning me-2"></i>
                                    <strong class="text-warning">Free Giveaway</strong>
                                </div>
                                <div class="text-end">
                                    <div class="h4 text-warning fw-bold mb-0">FREE</div>
                                    <small class="text-muted">No cost to you</small>
                                </div>
                            </div>
                            <p class="mb-0 small text-muted">This item is being given away for free. First come, first served!</p>
                        </div>
                    <?php endif; ?>

                    <!-- Renting Information -->
                    <?php if($product->is_available_for_rent): ?>
                        <div class="mb-3 p-3 bg-light rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-handshake text-success me-2"></i>
                                <strong class="text-success">Available for Rent</strong>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <small class="text-muted">Rental Price:</small>
                                    <div class="fw-bold"><?php echo e(number_format($product->rent_price, 2, ',', ' ')); ?> kr per <?php echo e($product->rent_duration_unit); ?></div>
                                </div>
                                <?php if($product->rent_deposit): ?>
                                <div class="col-sm-6">
                                    <small class="text-muted">Security Deposit:</small>
                                    <div class="fw-bold"><?php echo e(number_format($product->rent_deposit, 2, ',', ' ')); ?> kr</div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php if($product->rent_terms): ?>
                                <div class="mt-2">
                                    <small class="text-muted">Rental Terms:</small>
                                    <div class="small"><?php echo e(Str::limit($product->rent_terms, 100)); ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Short Description (appears in right section) -->
                    <?php if($product->short_description): ?>
                        <p class="card-text mb-3 fw-bold" style="font-size: 1.1rem; color: #374151;"><?php echo e($product->short_description); ?></p>
                    <?php else: ?>
                        <p class="card-text mb-3 fw-bold" style="font-size: 1.1rem; color: #374151;"><?php echo e(Str::limit($product->description, 150)); ?></p>
                    <?php endif; ?>

                    <!-- Long Description (appears below) -->
                    <?php if($product->long_description): ?>
                        <div class="mt-4">
                            <h5 class="mb-3" style="color: var(--primary-color); font-weight: 600;">Product Details</h5>
                            <div class="product-long-description" style="line-height: 1.7; color: #4b5563;">
                                <?php echo nl2br(e($product->long_description)); ?>

                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i>Posted by <a href="<?php echo e(route('sellers.products', $product->user)); ?>" class="text-decoration-none" style="color: var(--primary-color);"><?php echo e($product->user->name); ?></a>
                            <?php if($product->user->location): ?>
                                <span class="ms-2 me-2">•</span>
                                <i class="fas fa-map-marker-alt me-1"></i><a href="<?php echo e(route('products.location', $product->user->location)); ?>" class="text-decoration-none" style="color: var(--primary-color);"><?php echo e($product->user->location); ?></a>
                            <?php endif; ?>
                            <span class="ms-2 me-2">•</span>
                            <i class="fas fa-calendar me-1"></i><?php echo e($product->created_at->format('M d, Y')); ?>

                        </small>
                    </div>

                    <!-- Social Share -->
                    <div class="mb-4">
                        <small class="text-muted d-block mb-2">Share this product:</small>
                        <div class="social-share">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(urlencode(url()->current())); ?>" target="_blank" title="Share on Facebook" style="color: #1877f2;">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(url()->current())); ?>&text=<?php echo e(urlencode($product->title)); ?>" target="_blank" title="Share on Twitter" style="color: #000000;">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text=<?php echo e(urlencode($product->title . ' - ' . url()->current())); ?>" target="_blank" title="Share on WhatsApp" style="color: #25d366;">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="mailto:?subject=<?php echo e(urlencode($product->title)); ?>&body=<?php echo e(urlencode('Check out this product: ' . url()->current())); ?>" title="Share via Email" style="color: #ea4335;">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>

                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->id() !== $product->user_id): ?>
                            <div class="d-flex gap-2 flex-wrap">
                                <?php if($product->is_for_sale && !$product->is_giveaway): ?>
                                    <button type="button" class="purchase-product" data-product-id="<?php echo e($product->id); ?>">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Purchase Product</span>
                                    </button>
                                <?php endif; ?>
                                <?php if($product->is_giveaway || $product->listing_type == 'giveaway'): ?>
                                    <?php if($userGiveawayRequest): ?>
                                        <?php if($userGiveawayRequest->status == 'pending'): ?>
                                            <button type="button" class="btn btn-secondary" style="font-size: 75%;" disabled>
                                                <i class="fas fa-clock me-2"></i>Request Pending
                                            </button>
                                        <?php elseif($userGiveawayRequest->status == 'approved'): ?>
                                            <button type="button" class="btn btn-success" style="font-size: 75%;" disabled>
                                                <i class="fas fa-check-circle me-2"></i>Request Approved!
                                            </button>
                                        <?php elseif($userGiveawayRequest->status == 'rejected'): ?>
                                            <button type="button" class="btn btn-danger" style="font-size: 75%;" disabled>
                                                <i class="fas fa-times-circle me-2"></i>Request Rejected
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <button type="button" class="product-action-btn-outline request-giveaway" data-product-id="<?php echo e($product->id); ?>">
                                            <i class="fas fa-gift"></i>
                                            <span>Request Giveaway</span>
                                        </button>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <button type="button" class="contact-seller-btn" data-bs-toggle="modal" data-bs-target="#contactModal">
                                    <i class="fas fa-envelope"></i>
                                    <span>Contact Seller</span>
                                </button>
                                <a href="<?php echo e(route('buyer.exchanges.create', ['product_id' => $product->id])); ?>" class="propose-exchange-btn">
                                    <i class="fas fa-exchange-alt"></i>
                                    <span>Propose Exchange</span>
                                </a>
                                <?php if($product->is_available_for_rent): ?>
                                    <button type="button" class="product-action-btn-outline" data-bs-toggle="modal" data-bs-target="#rentModal">
                                        <i class="fas fa-handshake"></i>
                                        <span>Rent This Item</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>This is your product.
                                <a href="<?php echo e(route('seller.products.edit', $product)); ?>" class="alert-link">Edit it here</a>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="d-flex gap-2 flex-wrap">
                            <?php if($product->is_for_sale && !$product->is_giveaway): ?>
                                <a href="#" class="product-action-btn" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    <i class="fas fa-cart-plus"></i>
                                    <span>Login to Buy</span>
                                </a>
                            <?php endif; ?>
                            <?php if($product->is_giveaway || $product->listing_type == 'giveaway'): ?>
                                <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#loginModal" style="font-size: 75%;">
                                    <i class="fas fa-gift me-2"></i>Login to Claim Giveaway
                                </a>
                            <?php endif; ?>
                            <button type="button" class="btn-freecycle" style="font-size: 75%;" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign in to Contact Seller
                            </button>
                            <button type="button" class="btn-freecycle-outline" style="font-size: 75%;" data-bs-toggle="modal" data-bs-target="#signupModal">
                                <i class="fas fa-user-plus me-2"></i>Sign Up to Exchange
                            </button>
                            <?php if($product->is_available_for_rent): ?>
                                <button type="button" class="btn btn-success" style="font-size: 75%;" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    <i class="fas fa-handshake me-2"></i>Sign in to Rent
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    <?php if($relatedProducts->count() > 0): ?>
        <div class="mt-5">
            <h3 class="mb-4" style="color: var(--primary-color);">Related Products</h3>
            <div class="row">
                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-6 col-lg-4 col-xl-3 mb-4">
                        <div class="related-product-card h-100">
                            <?php if($relatedProduct->images && count($relatedProduct->images) > 0): ?>
                                <?php if(str_starts_with($relatedProduct->images[0], 'http')): ?>
                                    <img src="<?php echo e($relatedProduct->images[0]); ?>" class="related-product-image" alt="<?php echo e($relatedProduct->title); ?>">
                                <?php else: ?>
                                    <img src="<?php echo e(asset('storage/' . $relatedProduct->images[0])); ?>" class="related-product-image" alt="<?php echo e($relatedProduct->title); ?>">
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="bg-secondary d-flex align-items-center justify-content-center text-white related-product-image">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column p-3">
                                <h5 class="card-title mb-2">
                                    <a href="<?php echo e(route('products.show', $relatedProduct)); ?>" class="text-decoration-none" style="color: var(--primary-color);"><?php echo e(Str::limit($relatedProduct->title, 50)); ?></a>
                                </h5>
                                <p class="card-text text-muted small mb-3"><?php echo e(Str::limit($relatedProduct->description, 80)); ?></p>
                                <div class="mt-auto">
                                    <small class="text-muted d-block mb-2">
                                        <i class="fas fa-tag me-1"></i><?php echo e($relatedProduct->category->name); ?> •
                                        <i class="fas fa-user me-1"></i><?php echo e($relatedProduct->user->name); ?>

                                    </small>
                                    <a href="<?php echo e(route('products.show', $relatedProduct)); ?>" class="btn-freecycle btn-sm w-100 text-center">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Contact Seller Modal -->
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="contactModalLabel">Contact Seller</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="contactForm">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        <input type="hidden" name="seller_id" value="<?php echo e($product->user_id); ?>">

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="Inquiry about <?php echo e(Str::limit($product->title, 30)); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required>Hi <?php echo e($product->user->name); ?>,

I'm interested in your product "<?php echo e($product->title); ?>". Could you please provide more details?

Thank you!</textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="modal-send-btn" id="sendMessageBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                <span class="btn-text">Send Message</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Rent Product Modal -->
    <?php if($product->is_available_for_rent): ?>
    <div class="modal fade" id="rentModal" tabindex="-1" aria-labelledby="rentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rentModalLabel">Rent "<?php echo e($product->title); ?>"</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="rentForm">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">

                        <!-- Rental Information -->
                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i>Rental Information</h6>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong>Price:</strong> <?php echo e(number_format($product->rent_price, 2, ',', ' ')); ?> kr per <?php echo e($product->rent_duration_unit); ?>

                                </div>
                                <?php if($product->rent_deposit): ?>
                                <div class="col-sm-6">
                                    <strong>Security Deposit:</strong> <?php echo e(number_format($product->rent_deposit, 2, ',', ' ')); ?> kr
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php if($product->rent_terms): ?>
                            <div class="mt-2">
                                <strong>Rental Terms:</strong>
                                <div class="small"><?php echo e($product->rent_terms); ?></div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" required>
                                <div class="form-text">When do you want to start renting?</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" min="<?php echo e(date('Y-m-d', strtotime('+1 day'))); ?>" required>
                                <div class="form-text">When do you want to return the item?</div>
                            </div>
                        </div>

                        <!-- Price Calculation -->
                        <div id="priceCalculation" class="alert alert-success" style="display: none;">
                            <h6><i class="fas fa-calculator me-2"></i>Price Calculation</h6>
                            <div id="priceDetails"></div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total Amount:</strong>
                                <strong id="totalAmount">$0.00</strong>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success" id="submitRentBtn">
                                <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                <span class="btn-text">Submit Rental Request</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    <?php if(auth()->guard()->check()): ?>
    // Handle purchase product functionality
    document.querySelectorAll('.purchase-product').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const btn = this;

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding to Cart...';

            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', 1);

            fetch('/cart', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect to checkout
                    window.location.href = '/checkout';
                } else {
                    alert(data.error || 'Failed to add to cart');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Purchase Product';
                }
            })
            .catch(error => {
                alert('An error occurred. Please try again.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Purchase Product';
            });
        });
    });

    // Handle giveaway request functionality
    document.querySelectorAll('.request-giveaway').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const btn = this;

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Requesting...';

            const formData = new FormData();
            formData.append('product_id', productId);

            fetch('/products/' + productId + '/giveaway-request', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    btn.innerHTML = '<i class="fas fa-check me-2"></i>Requested!';
                    btn.classList.remove('btn-warning');
                    btn.classList.add('btn-success');

                    // Show success tooltip
                    const tooltip = bootstrap.Tooltip.getInstance(btn) || new bootstrap.Tooltip(btn, {
                        title: 'Giveaway request submitted!',
                        placement: 'top',
                        trigger: 'manual'
                    });
                    tooltip.show();

                    // Hide tooltip after 3 seconds
                    setTimeout(() => {
                        tooltip.hide();
                    }, 3000);
                    // Keep button disabled
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-check me-2"></i>Requested!';
                    btn.classList.remove('btn-warning');
                    btn.classList.add('btn-success');
                } else {
                    alert(data.error || 'Failed to request giveaway');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fas fa-gift me-2"></i>Request Giveaway';
                }
            })
            .catch(error => {
                alert('An error occurred. Please try again.');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-gift me-2"></i>Request Giveaway';
            });
        });
    });

    function updateCartBadge(count) {
        const cartBadge = document.getElementById('cartBadge');
        if (cartBadge) {
            if (count > 0) {
                cartBadge.textContent = count > 99 ? '99+' : count;
                cartBadge.style.display = 'inline-block';
            } else {
                cartBadge.style.display = 'none';
            }
        }
    }
    <?php endif; ?>
    // Handle contact form submission
    document.getElementById('contactForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('sendMessageBtn');
        const spinner = submitBtn.querySelector('.spinner-border');
        const btnText = submitBtn.querySelector('.btn-text');

        // Show loading state
        submitBtn.disabled = true;
        spinner.classList.remove('d-none');
        btnText.textContent = 'Sending...';

        const formData = new FormData(this);

        fetch('/contact-seller', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Success - show enhanced success message
                submitBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Message Sent!';
                submitBtn.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
                submitBtn.style.borderColor = '#28a745';

                // Create success toast notification
                const successToast = document.createElement('div');
                successToast.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                    color: white;
                    padding: 16px 24px;
                    border-radius: 12px;
                    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
                    z-index: 9999;
                    font-weight: 600;
                    max-width: 350px;
                    transform: translateX(100%);
                    transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                `;
                successToast.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="background: rgba(255,255,255,0.2); border-radius: 50%; padding: 8px;">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                        <div>
                            <div style="font-size: 14px; margin-bottom: 2px;">Message Sent Successfully!</div>
                            <div style="font-size: 12px; opacity: 0.9;">The seller will respond to you soon.</div>
                        </div>
                    </div>
                `;

                document.body.appendChild(successToast);

                // Animate toast in
                setTimeout(() => {
                    successToast.style.transform = 'translateX(0)';
                }, 100);

                // Close modal and remove toast after delay
                setTimeout(() => {
                    bootstrap.Modal.getInstance(document.getElementById('contactModal')).hide();
                    document.getElementById('contactForm').reset();

                    // Animate toast out
                    successToast.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        if (successToast.parentNode) {
                            successToast.parentNode.removeChild(successToast);
                        }
                    }, 400);
                }, 2500);
            } else {
                // Show error message
                submitBtn.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>Failed to Send';
                submitBtn.style.background = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
                submitBtn.style.borderColor = '#dc3545';

                // Create error toast notification
                const errorToast = document.createElement('div');
                errorToast.style.cssText = `
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                    color: white;
                    padding: 16px 24px;
                    border-radius: 12px;
                    box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3);
                    z-index: 9999;
                    font-weight: 600;
                    max-width: 350px;
                    transform: translateX(100%);
                    transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                `;
                errorToast.innerHTML = `
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="background: rgba(255,255,255,0.2); border-radius: 50%; padding: 8px;">
                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                        </div>
                        <div>
                            <div style="font-size: 14px; margin-bottom: 2px;">Failed to Send Message</div>
                            <div style="font-size: 12px; opacity: 0.9;">${data.message || 'Please try again later.'}</div>
                        </div>
                    </div>
                `;

                document.body.appendChild(errorToast);

                // Animate toast in
                setTimeout(() => {
                    errorToast.style.transform = 'translateX(0)';
                }, 100);

                // Reset button and remove toast after delay
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span><span class="btn-text">Send Message</span>';
                    submitBtn.style.background = '';
                    submitBtn.style.borderColor = '';

                    // Animate toast out
                    errorToast.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        if (errorToast.parentNode) {
                            errorToast.parentNode.removeChild(errorToast);
                        }
                    }, 400);
                }, 3000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error message
            const errorAlert = document.createElement('div');
            errorAlert.className = 'alert alert-danger alert-dismissible fade show';
            errorAlert.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>An error occurred. Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            const modalBody = document.querySelector('#contactModal .modal-body');
            modalBody.insertBefore(errorAlert, modalBody.firstChild);
        })
        .finally(() => {
            // Reset loading state
            submitBtn.disabled = false;
            spinner.classList.add('d-none');
            btnText.textContent = 'Send Message';
        });
    });

    // Handle rent form submission and price calculation
    document.getElementById('rentForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitRentBtn');
        const spinner = submitBtn.querySelector('.spinner-border');
        const btnText = submitBtn.querySelector('.btn-text');

        // Show loading state
        submitBtn.disabled = true;
        spinner.classList.remove('d-none');
        btnText.textContent = 'Submitting...';

        const formData = new FormData(this);

        fetch('/products/<?php echo e($product->id); ?>/rent', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Success - show success message and close modal
                const successAlert = document.createElement('div');
                successAlert.className = 'alert alert-success alert-dismissible fade show';
                successAlert.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>Rental request submitted successfully!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;

                // Insert success message at top of modal body
                const modalBody = document.querySelector('#rentModal .modal-body');
                modalBody.insertBefore(successAlert, modalBody.firstChild);

                // Reset form and close modal after delay
                setTimeout(() => {
                    bootstrap.Modal.getInstance(document.getElementById('rentModal')).hide();
                    document.getElementById('rentForm').reset();
                    successAlert.remove();
                    // Optionally reload page to show updated status
                    location.reload();
                }, 2000);
            } else {
                // Show error message
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger alert-dismissible fade show';
                errorAlert.innerHTML = `
                    <i class="fas fa-exclamation-triangle me-2"></i>${data.message || 'Failed to submit rental request. Please try again.'}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;

                const modalBody = document.querySelector('#rentModal .modal-body');
                modalBody.insertBefore(errorAlert, modalBody.firstChild);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error message
            const errorAlert = document.createElement('div');
            errorAlert.className = 'alert alert-danger alert-dismissible fade show';
            errorAlert.innerHTML = `
                <i class="fas fa-exclamation-triangle me-2"></i>An error occurred. Please try again.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            const modalBody = document.querySelector('#rentModal .modal-body');
            modalBody.insertBefore(errorAlert, modalBody.firstChild);
        })
        .finally(() => {
            // Reset loading state
            submitBtn.disabled = false;
            spinner.classList.add('d-none');
            btnText.textContent = 'Submit Rental Request';
        });
    });

    // Calculate price when dates change
    function calculateRentalPrice() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);

            if (start <= end) {
                // Calculate days
                const timeDiff = end.getTime() - start.getTime();
                const days = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // Include both start and end dates

                const pricePerUnit = <?php echo e($product->rent_price); ?>;
                const unit = '<?php echo e($product->rent_duration_unit); ?>';
                const deposit = <?php echo e($product->rent_deposit ?? 0); ?>;

                let totalPrice = 0;
                let calculationText = '';

                switch (unit) {
                    case 'day':
                        totalPrice = pricePerUnit * days;
                        calculationText = `${pricePerUnit.toFixed(2)} kr × ${days} days`;
                        break;
                    case 'week':
                        const weeks = Math.ceil(days / 7);
                        totalPrice = pricePerUnit * weeks;
                        calculationText = `${pricePerUnit.toFixed(2)} kr × ${weeks} week(s)`;
                        break;
                    case 'month':
                        const months = Math.ceil(days / 30);
                        totalPrice = pricePerUnit * months;
                        calculationText = `${pricePerUnit.toFixed(2)} kr × ${months} month(s)`;
                        break;
                }

                // Show calculation
                document.getElementById('priceDetails').innerHTML = `
                    <div class="mb-2">${calculationText} = ${totalPrice.toFixed(2)} kr</div>
                    ${deposit > 0 ? `<div class="mb-2">Security Deposit: ${deposit.toFixed(2)} kr</div>` : ''}
                `;

                const finalTotal = totalPrice + deposit;
                document.getElementById('totalAmount').textContent = `${finalTotal.toFixed(2)} kr`;
                document.getElementById('priceCalculation').style.display = 'block';
            }
        }
    }

    // Attach event listeners
    document.getElementById('start_date')?.addEventListener('change', calculateRentalPrice);
    document.getElementById('end_date')?.addEventListener('change', calculateRentalPrice);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/products/show.blade.php ENDPATH**/ ?>