
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<?php echo $__env->yieldContent('head'); ?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Basic Meta Tags -->
    <meta name="description" content="<?php echo e(config('settings.site_description', 'Exchange and trade platform for buying, selling, and renting items')); ?>">
    <meta name="keywords" content="exchange, trade, buy, sell, rent, <?php echo e(config('settings.site_name', 'Bytte.no')); ?>">
    <meta name="author" content="<?php echo e(config('settings.site_name', 'Bytte.no')); ?>">

    <!-- Open Graph / Facebook (Default) -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?php echo e(config('settings.site_name', 'Bytte.no')); ?>">
    <meta property="og:title" content="<?php echo e(config('settings.site_name', 'Bytte.no')); ?>">
    <meta property="og:description" content="<?php echo e(config('settings.site_description', 'Exchange and trade platform for buying, selling, and renting items')); ?>">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:locale" content="en_US">

    <!-- Twitter Card (Default) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e(config('settings.site_name', 'Bytte.no')); ?>">
    <meta name="twitter:description" content="<?php echo e(config('settings.site_description', 'Exchange and trade platform for buying, selling, and renting items')); ?>">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">

    <!-- Favicon -->
    <?php
        $favicon = \App\Models\Setting::where('key', 'favicon')->first()->value ?? null;
    ?>
    <link rel="icon" href="<?php echo e($favicon ? asset('storage/' . $favicon) : '/favicon.ico'); ?>" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer">

    <!-- Custom CSS -->
    <style>
        :root {
            --finn-blue: #0069C2;
            --finn-blue-dark: #0056a3;
            --finn-bg: #f5f5f5;
            --finn-card-bg: #ffffff;
            --finn-text: #333333;
            --finn-text-light: #666666;
            --finn-border: #e0e0e0;
            --primary-color: #0f5057;
            --secondary-color: #faf4d7;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background-color: var(--finn-bg);
            color: var(--finn-text);
            line-height: 1.5;
        }

        /* Clean Header - Finn Style */
        .finn-header {
            background: var(--primary-color);
            border-bottom: 1px solid var(--finn-border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-main {
            display: flex;
            align-items: center;
            gap: 24px;
            padding: 16px 0;
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Logo */
        .header-logo {
            flex-shrink: 0;
        }

        .header-logo a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
            font-size: 24px;
            font-weight: 700;
        }

        .header-logo img {
            height: 40px;
            border-radius: 8px;
            margin-right: 8px;
        }

        /* Prominent Search Bar - Finn Style */
        .header-search {
            flex-grow: 1;
            max-width: 600px;
        }

        .search-form {
            display: flex;
        }

        .search-input-wrapper {
            position: relative;
            flex-grow: 1;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px;
            padding-left: 40px;
            border: 2px solid var(--finn-border);
            border-radius: 4px;
            font-size: 15px;
            transition: border-color 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--finn-blue);
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--finn-text-light);
        }

        .search-btn {
            padding: 12px 24px;
            background: var(--secondary-color);
            color: var(--primary-color);
            border: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-left: -4px;
        }

        .search-btn:hover {
            background: rgba(250, 244, 215, 0.8);
        }

        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }

        .header-action-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .header-action-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            text-decoration: none;
        }

        .header-action-btn i {
            font-size: 18px;
        }

        .btn-primary-finn {
            padding: 10px 20px;
            background: transparent;
            color: var(--secondary-color);
            border: 2px solid var(--secondary-color);
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-primary-finn:hover {
            background: var(--secondary-color);
            color: #0f5057;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(250, 244, 215, 0.3);
        }

        .btn-outline-finn {
            padding: 10px 20px;
            background: var(--secondary-color);
            color: var(--primary-color);
            border: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-outline-finn:hover {
            background: rgba(250, 244, 215, 0.8);
            color: var(--primary-color);
        }

        /* Navigation Bar - Finn Style */
        .nav-bar {
            background: var(--secondary-color);
            border-bottom: 1px solid rgba(15, 80, 87, 0.1);
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .nav-items {
            display: flex;
            gap: 4px;
            overflow-x: auto;
            padding: 8px 0;
        }

        .nav-items::-webkit-scrollbar {
            display: none;
        }

        .nav-item {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border-radius: 20px;
            white-space: nowrap;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            background: rgba(15, 80, 87, 0.1);
            color: var(--primary-color);
            text-decoration: none;
        }

        .nav-item.active {
            background: rgba(15, 80, 87, 0.15);
            color: var(--primary-color);
        }

        /* Hero Section - Minimal */
        .hero-section {
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            height: 50vh;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .hero-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: #ffffff;
        }

        .hero-text {
            font-size: 1.1rem;
            color: #ffffff;
            margin-bottom: 2rem;
        }

        /* Clean footer */
        footer {
            background-color: white;
            border-top: 1px solid var(--finn-border);
            padding: 40px 0 20px;
            margin-top: 40px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 32px;
            margin-bottom: 32px;
        }

        .footer-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--finn-text);
            margin-bottom: 16px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 8px;
        }

        .footer-links a {
            color: var(--finn-text-light);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--finn-blue);
        }

        .footer-bottom {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            text-align: center;
            font-size: 13px;
            padding: 20px 15px;
        }

        .footer-bottom a {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        .footer-bottom a:hover {
            opacity: 0.8;
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 15px;
            min-height: calc(100vh - 400px);
        }

        /* Clean card design */
        .freecycle-card {
            background: #ffffff;
            border: 1px solid var(--finn-border);
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .freecycle-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Sleek modal styling */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        /* Center modals properly on desktop */
        @media (min-width: 768px) {
            .modal-dialog {
                position: fixed !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                margin: 0 !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: auto !important;
                max-width: none !important;
            }

            .modal-dialog-centered {
                transform: translate(-50%, -50%) !important;
            }

            .modal.fade .modal-dialog {
                transform: translate(-50%, -50%) !important;
            }
        }

        .modal-header {
            border-bottom: 1px solid #f0f0f0;
            padding: 1.5rem 2rem 1rem;
        }

        .modal-title {
            font-weight: 600;
            color: var(--finn-text);
        }

        .modal-body {
            padding: 2rem;
        }

        .form-control {
            border: 1px solid var(--finn-border);
            border-radius: 4px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--finn-blue);
            box-shadow: 0 0 0 3px rgba(0, 105, 194, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: var(--finn-text);
            margin-bottom: 0.5rem;
            font-size: 14px;
        }

        .btn-primary {
            background-color: var(--finn-blue);
            border-color: var(--finn-blue);
            border-radius: 4px;
            padding: 12px 24px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--finn-blue-dark);
            border-color: var(--finn-blue-dark);
        }

        .btn-outline-primary {
            border-radius: 4px;
            padding: 12px 24px;
            font-weight: 500;
            font-size: 14px;
            border-color: var(--finn-border);
            color: var(--finn-text);
        }

        .btn-outline-primary:hover {
            border-color: var(--finn-blue);
            color: var(--finn-blue);
            background: rgba(0, 105, 194, 0.05);
        }

        .text-muted {
            color: var(--finn-text-light) !important;
        }

        .form-check-input:checked {
            background-color: var(--finn-blue);
            border-color: var(--finn-blue);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .header-actions {
                gap: 8px;
            }

            .header-action-btn span {
                display: none;
            }

            .header-action-btn {
                padding: 8px 12px;
            }
        }

        /* Auth buttons responsive */
        @media (max-width: 767px) {
            .desktop-auth-buttons {
                display: none;
            }

            .mobile-auth-button {
                display: block;
            }

            .header-actions .btn-outline-finn {
                padding: 8px 12px !important;
                font-size: 13px;
            }

            .header-actions .btn-outline-finn i {
                font-size: 16px;
            }

            .header-actions .btn-outline-finn span {
                display: none;
            }
        }

        @media (min-width: 768px) {
            .desktop-auth-buttons {
                display: flex;
                gap: 8px;
                justify-content: center;
                width: 100%;
            }

            .mobile-auth-button {
                display: none;
            }
        }

        /* Mobile Search Icon */
        @media (max-width: 767px) {
            .header-main {
                gap: 8px;
                padding: 12px 10px;
            }

            .header-logo a {
                font-size: 18px;
            }

            .header-logo img {
                height: 32px;
            }

            /* Hide search bar on mobile, show icon */
            .header-search {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: var(--primary-color);
                z-index: 2000;
                display: none;
                padding: 80px 15px 20px;
                max-width: 100%;
            }

            .header-search.active {
                display: block;
            }

            .mobile-search-icon {
                display: flex !important;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
                background: rgba(255,255,255,0.1);
                border-radius: 8px;
                color: white;
                font-size: 18px;
                cursor: pointer;
                border: none;
                transition: all 0.2s ease;
            }

            .mobile-search-icon:hover {
                background: rgba(255,255,255,0.2);
            }

            .mobile-search-close {
                position: absolute;
                top: 20px;
                right: 15px;
                width: 40px;
                height: 40px;
                background: rgba(255,255,255,0.1);
                border-radius: 50%;
                color: white;
                font-size: 20px;
                cursor: pointer;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .mobile-search-close:hover {
                background: rgba(255,255,255,0.2);
            }

            /* Mobile search form */
            .mobile-search-form {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .mobile-search-input-wrapper {
                position: relative;
            }

            .mobile-search-input {
                width: 100%;
                padding: 16px 20px 16px 50px;
                border: 2px solid rgba(255,255,255,0.2);
                border-radius: 12px;
                font-size: 16px;
                background: rgba(255,255,255,0.1);
                color: white;
                transition: all 0.2s ease;
            }

            .mobile-search-input::placeholder {
                color: rgba(255,255,255,0.6);
            }

            .mobile-search-input:focus {
                outline: none;
                border-color: var(--secondary-color);
                background: rgba(255,255,255,0.15);
            }

            .mobile-search-icon-input {
                position: absolute;
                left: 16px;
                top: 50%;
                transform: translateY(-50%);
                color: rgba(255,255,255,0.6);
                font-size: 20px;
            }

            .mobile-search-btn {
                padding: 16px 24px;
                background: var(--secondary-color);
                color: var(--primary-color);
                border: none;
                border-radius: 12px;
                font-weight: 600;
                font-size: 16px;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .mobile-search-btn:hover {
                background: rgba(250, 244, 215, 0.8);
            }

            .header-search-desktop {
                display: none;
            }
        }

        @media (min-width: 768px) {
            .mobile-search-icon,
            .mobile-search-close,
            .mobile-search-form {
                display: none !important;
            }

            .header-search-desktop {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .header-main {
                gap: 12px;
            }

            .header-search-desktop {
                max-width: none;
            }

            .search-btn span {
                display: none;
            }

            .search-btn {
                padding: 12px 16px;
            }

            .hero-title {
                font-size: 1.5rem;
            }

            .hero-text {
                font-size: 1rem;
            }

            /* Mobile Navigation */
            .nav-bar {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 999;
                background: white;
                border-top: 1px solid var(--finn-border);
                box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
            }

            .nav-container {
                padding: 0;
            }

            .nav-items {
                justify-content: space-around;
                padding: 8px 0;
                gap: 0;
            }

            .nav-item {
                flex-direction: column;
                padding: 8px 12px;
                font-size: 10px;
                gap: 4px;
            }

            .nav-item i {
                font-size: 18px;
            }

            .nav-item span {
                display: block;
            }

            .main-content {
                padding: 15px 10px;
                padding-bottom: 80px;
            }

            /* Footer mobile */
            footer {
                padding: 30px 0 80px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }
        }

        @media (max-width: 576px) {
            .header-logo a {
                font-size: 16px;
            }

            .header-logo img {
                height: 28px;
            }

            .btn-primary-finn, .btn-outline-finn {
                padding: 8px 12px;
                font-size: 13px;
            }

            .hero-section {
                padding: 40px 0;
            }

            .hero-title {
                font-size: 1.25rem;
            }
        }

        /* Focus styles for accessibility */
        .search-input:focus,
        .btn-primary:focus,
        .btn-outline:focus {
            outline: 2px solid var(--finn-blue);
            outline-offset: 2px;
        }

        /* Live Search Results Dropdown */
        .search-results-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid var(--finn-border);
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.15);
            max-height: 400px;
            overflow-y: auto;
            z-index: 1001;
            display: none;
            margin-top: 4px;
        }

        .search-results-dropdown.show {
            display: block;
        }

        .search-result-section {
            padding: 8px 12px;
            border-bottom: 1px solid #f0f0f0;
        }

        .search-result-section:last-child {
            border-bottom: none;
        }

        .search-result-section-title {
            font-size: 11px;
            font-weight: 600;
            color: var(--finn-text-light);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .search-result-item {
            display: flex;
            align-items: center;
            padding: 8px;
            border-radius: 6px;
            text-decoration: none;
            color: var(--finn-text);
            transition: background-color 0.15s ease;
        }

        .search-result-item:hover {
            background-color: #f5f5f5;
        }

        .search-result-image {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 6px;
            background-color: #e0e0e0;
            flex-shrink: 0;
        }

        .search-result-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f0f0;
            border-radius: 6px;
            color: var(--finn-text-light);
            font-size: 18px;
            flex-shrink: 0;
        }

        .search-result-content {
            flex: 1;
            margin-left: 12px;
            min-width: 0;
        }

        .search-result-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--finn-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .search-result-meta {
            font-size: 12px;
            color: var(--finn-text-light);
            margin-top: 2px;
        }

        .search-result-price {
            font-size: 14px;
            font-weight: 600;
            color: var(--finn-blue);
            white-space: nowrap;
        }

        .search-loading {
            padding: 20px;
            text-align: center;
            color: var(--finn-text-light);
        }

        .search-no-results {
            padding: 16px;
            text-align: center;
            color: var(--finn-text-light);
            font-size: 14px;
        }

        .search-view-all {
            display: block;
            padding: 12px;
            text-align: center;
            background-color: #f9f9f9;
            border-top: 1px solid var(--finn-border);
            color: var(--finn-blue);
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            border-radius: 0 0 8px 8px;
        }

        .search-view-all:hover {
            background-color: #f0f0f0;
        }
    </style>

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <!-- Defer non-critical JavaScript -->
    <script>
        // Force refresh on page load to ensure latest content
        if (window.location.search.includes('refresh')) {
            window.location.href = window.location.pathname;
        }

        // Preload critical resources
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                // Service worker for caching (if implemented)
            });
        }
    </script>
</head>
<body>
<!-- Worldclass Preloader -->
<?php echo $__env->make('components.preloader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Header - Finn Style -->
<header class="finn-header">
    <div class="header-main">
        <!-- Logo -->
        <div class="header-logo">
            <a href="/">
                <?php if(config('settings.site_logo')): ?>
                    <img src="<?php echo e(asset('storage/' . config('settings.site_logo'))); ?>" alt="<?php echo e(config('settings.site_name', 'TingUt.no')); ?>">
                <?php endif; ?>
                <span><?php echo e(config('settings.site_name', 'TingUt.no')); ?></span>
            </a>
        </div>

        <!-- Desktop Search Bar -->
        <div class="header-search header-search-desktop">
            <form action="<?php echo e(route('products.index')); ?>" method="GET" class="search-form" id="desktopSearchForm">
                <div class="search-input-wrapper" style="position: relative;">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" id="desktopSearchInput" class="search-input" placeholder="Search for items..." value="<?php echo e(request('search')); ?>" autocomplete="off">
                    <div class="search-results-dropdown" id="desktopSearchResults"></div>
                </div>
                <button type="submit" class="search-btn">
                    <span>Search</span> <i class="fas fa-search ms-1"></i>
                </button>
            </form>
        </div>

        <!-- Mobile Search Icon -->
        <button class="mobile-search-icon" onclick="toggleMobileSearch()">
            <i class="fas fa-search"></i>
        </button>

        <!-- Header Actions -->
        <div class="header-actions">
            <a href="#" class="header-action-btn">
                <i class="fas fa-heart"></i>
                <span>Saved</span>
            </a>
            <a href="<?php echo e(route('messages.inbox')); ?>" class="header-action-btn">
                <i class="fas fa-envelope"></i>
                <span>Messages</span>
            </a>
            <?php if(auth()->guard()->check()): ?>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border: 1px solid var(--finn-border); color: var(--finn-text); background: white; border-radius: 4px; padding: 8px 12px;">
                        <i class="fas fa-user me-2"></i>
                        <span><?php echo e(Auth::user()->name); ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown" style="border: none; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.12); margin-top: 8px; min-width: 180px;">
                        <li><a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>" style="padding: 10px 16px; border-radius: 4px;"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>" style="padding: 10px 16px; border-radius: 4px;"><i class="fas fa-user-edit me-2"></i>Profile</a></li>
                        <li><hr class="dropdown-divider my-2"></li>
                        <li>
                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-inline w-100">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item" style="padding: 10px 16px; border-radius: 4px; color: #dc3545;">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <!-- Desktop buttons -->
                <div class="desktop-auth-buttons">
                    <button type="button" class="btn-outline-finn" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                    <button type="button" class="btn-primary-finn" data-bs-toggle="modal" data-bs-target="#signupModal">Get Started</button>
                </div>

                <!-- Mobile combined button -->
                <div class="mobile-auth-button">
                    <button type="button" class="btn-outline-finn" data-bs-toggle="modal" data-bs-target="#authModal" style="display: flex; align-items: center; gap: 8px; padding: 10px 16px;">
                        <i class="fas fa-user-circle" style="font-size: 18px;"></i>
                        <span>Login</span>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="nav-bar">
        <div class="nav-container">
            <?php
                $menus = \App\Models\WebsiteMenu::active()->ordered()->get();
            ?>
            <div class="nav-items">
                <a href="/" class="nav-item <?php echo e(request()->is('/') ? 'active' : ''); ?>">
                    <i class="fas fa-home"></i><span>Home</span>
                </a>
                <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(strtolower($menu->name) !== 'products' && strtolower($menu->name) !== 'categories' && strtolower($menu->name) !== 'about'): ?>
                        <a href="<?php echo e($menu->url); ?>" <?php if($menu->open_in_new_tab): ?> target="_blank" <?php endif; ?>
                           class="nav-item <?php echo e(request()->is(trim($menu->url, '/')) ? 'active' : ''); ?>">
                            <?php if(strtolower($menu->name) === 'about'): ?>
                                <i class="fas fa-info-circle"></i>
                            <?php elseif(strtolower($menu->name) === 'contact'): ?>
                                <i class="fas fa-envelope"></i>
                            <?php endif; ?>
                            <span><?php echo e($menu->name); ?></span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('products.index')); ?>" class="nav-item <?php echo e(request()->routeIs('products.*') ? 'active' : ''); ?>">
                    <i class="fas fa-box"></i><span>Browse</span>
                </a>
                <a href="<?php echo e(route('categories.index')); ?>" class="nav-item <?php echo e(request()->routeIs('categories.*') ? 'active' : ''); ?>">
                    <i class="fas fa-tags"></i><span>Categories</span>
                </a>
                <a href="<?php echo e(route('home-sales.index')); ?>" class="nav-item <?php echo e(request()->routeIs('home-sales.*') ? 'active' : ''); ?>">
                    <i class="fas fa-home"></i><span>Home Sales</span>
                </a>
            </div>
        </div>
    </nav>
</header>

<!-- Mobile Search Overlay -->
<div class="header-search" id="mobileSearch">
    <button class="mobile-search-close" onclick="toggleMobileSearch()">
        <i class="fas fa-times"></i>
    </button>
    <form action="<?php echo e(route('products.index')); ?>" method="GET" class="mobile-search-form" id="mobileSearchForm">
        <div class="mobile-search-input-wrapper" style="position: relative;">
            <i class="fas fa-search mobile-search-icon-input"></i>
            <input type="text" name="search" id="mobileSearchInput" class="mobile-search-input" placeholder="Search for items..." value="<?php echo e(request('search')); ?>" autofocus autocomplete="off">
            <div class="search-results-dropdown show" id="mobileSearchResults" style="position: fixed; top: auto; left: 15px; right: 15px; bottom: 80px; max-height: 50vh;"></div>
        </div>
        <button type="submit" class="mobile-search-btn">
            Search
        </button>
    </form>
</div>

<!-- Spacer for Fixed Header -->
<div style="height: 20px;"></div>

<!-- Hero Section - Only on Home Page -->
<?php if($hero && request()->is('/')): ?>
    <?php
        $heroBackgroundStyle = $hero->background_image ? 'background-image: url(' . asset('storage/' . $hero->background_image) . ');' : '';
    ?>
    <section class="hero-section" style="<?php echo e($heroBackgroundStyle); ?>">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo e($hero->heading); ?></h1>
                <p class="hero-text"><?php echo e($hero->paragraph); ?></p>
                <div>
                    <?php if($hero->button1_text && $hero->button1_url): ?>
                        <a href="<?php echo e($hero->button1_url); ?>" class="btn-primary-finn" style="display: inline-block; margin: 0 10px 10px 0;"><?php echo e($hero->button1_text); ?></a>
                    <?php endif; ?>
                    <?php if($hero->button2_text && $hero->button2_url): ?>
                        <a href="<?php echo e($hero->button2_url); ?>" class="btn-outline-finn" style="display: inline-block; border-color: var(--primary-color); color: var(--primary-color);"><?php echo e($hero->button2_text); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Main Content -->
<main class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>
</main>

<!-- Include Auth Modals -->
<?php echo $__env->make('components.login-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.signup-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('components.auth-modal', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- GDPR Cookie Consent Banner -->
<?php echo $__env->make('components.gdpr-banner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Footer -->
<footer>
    <div class="footer-content">
        <div class="footer-grid">
            <!-- Company Info -->
            <div>
                <div class="footer-title">
                    <?php if(config('settings.site_logo')): ?>
                        <img src="<?php echo e(asset('storage/' . config('settings.site_logo'))); ?>" alt="<?php echo e(config('settings.site_name', 'TingUt.no')); ?>" height="40" class="mb-3" style="border-radius: 8px;">
                    <?php else: ?>
                        <h5 class="fw-bold"><?php echo e(config('settings.site_name', 'TingUt.no')); ?></h5>
                    <?php endif; ?>
                </div>
                <p style="font-size: 14px; color: var(--finn-text-light); margin-bottom: 16px;">
                    <?php echo e(config('settings.footer_description', 'Exchange items, reduce waste, and build connections in your local community.')); ?>

                </p>
                <?php if(config('settings.contact_email')): ?>
                    <div class="mb-2">
                        <i class="fas fa-envelope me-2" style="color: var(--finn-blue);"></i>
                        <a href="mailto:<?php echo e(config('settings.contact_email')); ?>" class="footer-links" style="display: inline;"><?php echo e(config('settings.contact_email')); ?></a>
                    </div>
                <?php endif; ?>
                <?php if(config('settings.contact_phone')): ?>
                    <div>
                        <i class="fas fa-phone me-2" style="color: var(--finn-blue);"></i>
                        <span style="color: var(--finn-text-light);"><?php echo e(config('settings.contact_phone')); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Quick Links -->
            <div>
                <h6 class="footer-title">Quick Links</h6>
                <ul class="footer-links">
                    <li><a href="<?php echo e(route('home')); ?>">Home</a></li>
                    <li><a href="<?php echo e(route('products.index')); ?>">Browse Items</a></li>
                    <li><a href="<?php echo e(route('categories.index')); ?>">Categories</a></li>
                    <li><a href="<?php echo e(route('blogs.index')); ?>">Blog</a></li>
                </ul>
            </div>

            <!-- Account Links -->
            <div>
                <h6 class="footer-title">Account</h6>
                <ul class="footer-links">
                    <?php if(auth()->guard()->check()): ?>
                        <li><a href="<?php echo e(route('dashboard')); ?>">Dashboard</a></li>
                        <li><a href="<?php echo e(route('profile.edit')); ?>">Profile</a></li>
                        <li><a href="<?php echo e(route('subscriptions')); ?>">My Subscriptions</a></li>
                    <?php else: ?>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
                        <li><a href="#" data-bs-toggle="modal" data-bs-target="#signupModal">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Legal Links -->
            <div>
                <h6 class="footer-title">Legal</h6>
                <ul class="footer-links">
                    <?php if(config('settings.privacy_policy_url')): ?>
                        <li><a href="<?php echo e(config('settings.privacy_policy_url')); ?>">Privacy Policy</a></li>
                    <?php endif; ?>
                    <?php if(config('settings.terms_of_service_url')): ?>
                        <li><a href="<?php echo e(config('settings.terms_of_service_url')); ?>">Terms of Service</a></li>
                    <?php endif; ?>
                    <?php if(config('settings.contact_page_url')): ?>
                        <li><a href="<?php echo e(config('settings.contact_page_url')); ?>">Contact Us</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            </div>
    </div>

    <div class="footer-bottom">
        <p class="mb-2">
            © <?php echo e(date('Y')); ?> TingUt.no. All rights reserved.
        </p>
        <small>Developed by <a href="https://zillahtechnologies.co.ke" target="_blank" rel="noopener noreferrer">Zillah Technologies LTD</a></small>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Modal Enhancement Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Modal backdrop enhancement
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('show.bs.modal', function() {
                document.body.style.overflow = 'hidden';
            });

            modal.addEventListener('hidden.bs.modal', function() {
                document.body.style.overflow = '';
            });
        });

        // Enhanced form interactions
        const forms = document.querySelectorAll('.modal form');
        forms.forEach(form => {
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });

                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = '';
                });
            });
        });
    });

    // Mobile Search Toggle
    function toggleMobileSearch() {
        const mobileSearch = document.getElementById('mobileSearch');
        if (mobileSearch) {
            mobileSearch.classList.toggle('active');
            if (mobileSearch.classList.contains('active')) {
                const input = mobileSearch.querySelector('.mobile-search-input');
                if (input) {
                    setTimeout(() => input.focus(), 100);
                }
            }
        }
    }

    // Close mobile search on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const mobileSearch = document.getElementById('mobileSearch');
            if (mobileSearch && mobileSearch.classList.contains('active')) {
                mobileSearch.classList.remove('active');
            }
            // Close search dropdowns
            document.getElementById('desktopSearchResults').classList.remove('show');
            document.getElementById('mobileSearchResults').classList.remove('show');
        }
    });

    // Live Search Functionality
    (function() {
        const desktopSearchInput = document.getElementById('desktopSearchInput');
        const desktopSearchResults = document.getElementById('desktopSearchResults');
        const mobileSearchInput = document.getElementById('mobileSearchInput');
        const mobileSearchResults = document.getElementById('mobileSearchResults');
        let searchTimeout = null;

        // Desktop search
        if (desktopSearchInput) {
            desktopSearchInput.addEventListener('input', function(e) {
                handleSearchInput(e.target.value, desktopSearchResults);
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!desktopSearchInput.contains(e.target) && !desktopSearchResults.contains(e.target)) {
                    desktopSearchResults.classList.remove('show');
                }
            });
        }

        // Mobile search
        if (mobileSearchInput) {
            mobileSearchInput.addEventListener('input', function(e) {
                handleSearchInput(e.target.value, mobileSearchResults);
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!mobileSearchInput.contains(e.target) && !mobileSearchResults.contains(e.target)) {
                    mobileSearchResults.classList.remove('show');
                }
            });
        }

        function handleSearchInput(query, resultsContainer) {
            clearTimeout(searchTimeout);

            if (query.trim().length < 2) {
                resultsContainer.classList.remove('show');
                resultsContainer.innerHTML = '';
                return;
            }

            // Show loading
            resultsContainer.innerHTML = '<div class="search-loading"><i class="fas fa-spinner fa-spin"></i> Searching...</div>';
            resultsContainer.classList.add('show');

            // Debounce search
            searchTimeout = setTimeout(() => {
                performSearch(query, resultsContainer);
            }, 300);
        }

        function performSearch(query, resultsContainer) {
            fetch(`<?php echo e(route('api.search')); ?>?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.products.length === 0 && data.categories.length === 0 && data.sellers.length === 0) {
                        resultsContainer.innerHTML = '<div class="search-no-results">No results found</div>';
                        return;
                    }

                    let html = '';

                    // Categories
                    if (data.categories.length > 0) {
                        html += '<div class="search-result-section">';
                        html += '<div class="search-result-section-title">Categories</div>';
                        data.categories.forEach(category => {
                            html += `<a href="${category.url}" class="search-result-item">`;
                            html += '<div class="search-result-icon"><i class="fas fa-folder"></i></div>';
                            html += '<div class="search-result-content">';
                            html += `<div class="search-result-title">${category.name}</div>`;
                            html += '</div></a>';
                        });
                        html += '</div>';
                    }

                    // Products
                    if (data.products.length > 0) {
                        html += '<div class="search-result-section">';
                        html += '<div class="search-result-section-title">Products</div>';
                        data.products.forEach(product => {
                            html += `<a href="${product.url}" class="search-result-item">`;
                            if (product.image) {
                                html += `<img src="${product.image}" alt="${product.title}" class="search-result-image">`;
                            } else {
                                html += '<div class="search-result-icon"><i class="fas fa-box"></i></div>';
                            }
                            html += '<div class="search-result-content">';
                            html += `<div class="search-result-title">${product.title}</div>`;
                            if (product.category) {
                                html += `<div class="search-result-meta">${product.category.name}</div>`;
                            }
                            html += '</div>';
                            if (product.sale_price) {
                                html += `<div class="search-result-price">${product.sale_price}</div>`;
                            }
                            html += '</a>';
                        });
                        html += '</div>';
                    }

                    // Sellers
                    if (data.sellers.length > 0) {
                        html += '<div class="search-result-section">';
                        html += '<div class="search-result-section-title">Sellers</div>';
                        data.sellers.forEach(seller => {
                            html += `<a href="${seller.url}" class="search-result-item">`;
                            if (seller.avatar) {
                                html += `<img src="${seller.avatar}" alt="${seller.name}" class="search-result-image">`;
                            } else {
                                html += '<div class="search-result-icon"><i class="fas fa-user"></i></div>';
                            }
                            html += '<div class="search-result-content">';
                            html += `<div class="search-result-title">${seller.name}</div>`;
                            html += `<div class="search-result-meta">${seller.products_count} products</div>`;
                            html += '</div></a>';
                        });
                        html += '</div>';
                    }

                    // View all link
                    html += `<a href="<?php echo e(route('products.index')); ?>?search=${encodeURIComponent(query)}" class="search-view-all">View all results</a>`;

                    resultsContainer.innerHTML = html;
                })
                .catch(error => {
                    console.error('Search error:', error);
                    resultsContainer.innerHTML = '<div class="search-no-results">Search failed. Please try again.</div>';
                });
        }
    })();

    // OTP Form Handling
    (function() {
        document.addEventListener('DOMContentLoaded', function() {
            // Handle forms with OTP enabled
            const otpForms = document.querySelectorAll('form[data-otp-enabled="true"]');

            otpForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Show loading state
                    const submitBtn = form.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                    submitBtn.disabled = true;

                    // Submit form via AJAX
                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success === false) {
                            // Show error
                            showAlert('danger', data.message || 'An error occurred. Please try again.');
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        } else {
                            // Success - redirect to OTP verification
                            window.location.href = '<?php echo e(route("otp.verify")); ?>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showAlert('danger', 'An error occurred. Please try again.');
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    });
                });
            });
        });

        function showAlert(type, message) {
            // Remove existing alerts
            const existingAlerts = document.querySelectorAll('.alert');
            existingAlerts.forEach(alert => alert.remove());

            // Create new alert
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            // Insert at top of body
            document.body.insertBefore(alertDiv, document.body.firstChild);

            // Auto hide after 5 seconds
            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    })();
</script>

<?php echo $__env->yieldContent('js'); ?>

<?php echo $__env->make('partials.chat-widget', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html>
<?php /**PATH /var/www/html/resources/views/layouts/public.blade.php ENDPATH**/ ?>