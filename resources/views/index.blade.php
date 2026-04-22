@extends('layouts.public')

@section('title', config('settings.site_name', 'Bytte.no') . ' - ' . __('Exchange & Trade Platform'))

@section('head')
    <!-- Enhanced Home Page Meta Tags -->
    <meta name="description" content="Discover amazing products for sale, exchange, and rent on {{ config('settings.site_name', 'Bytte.no') }}. Buy, sell, trade, and rent items in your local community.">
    <meta name="keywords" content="buy, sell, exchange, trade, rent, local marketplace, {{ config('settings.site_name', 'Bytte.no') }}, products, items, community">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ config('settings.site_name', 'Bytte.no') }} - Exchange & Trade Platform">
    <meta property="og:description" content="Discover amazing products for sale, exchange, and rent on {{ config('settings.site_name', 'Bytte.no') }}. Buy, sell, trade, and rent items in your local community.">
    @if($hero && $hero->background_image)
        <meta property="og:image" content="{{ asset('storage/' . $hero->background_image) }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
    @endif
    <meta property="og:site_name" content="{{ config('settings.site_name', 'Bytte.no') }}">
    <meta property="og:locale" content="en_US">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('settings.site_name', 'Bytte.no') }} - Exchange & Trade Platform">
    <meta name="twitter:description" content="Discover amazing products for sale, exchange, and rent on {{ config('settings.site_name', 'Bytte.no') }}. Buy, sell, trade, and rent items in your local community.">
    @if($hero && $hero->background_image)
        <meta name="twitter:image" content="{{ asset('storage/' . $hero->background_image) }}">
        <meta name="twitter:image:alt" content="Hero image">
    @endif

    <!-- Organization Structured Data (JSON-LD) -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "{{ config('settings.site_name', 'Bytte.no') }}",
        "url": "{{ url('/') }}",
        "description": "Exchange and trade platform for buying, selling, and renting items",
        "sameAs": [
            "{{ config('settings.facebook_url') }}",
            "{{ config('settings.twitter_url') }}",
            "{{ config('settings.instagram_url') }}"
        ],
        "contactPoint": {
            "@@type": "ContactPoint",
            "telephone": "{{ config('settings.phone') }}",
            "contactType": "customer service",
            "availableLanguage": "Norwegian"
        }
    }
    </script>
@endsection

@section('content')
<style>
    /* Finn.no Inspired Styles */
    :root {
        --primary-color: #0f5057;
        --primary-dark: #0a3d42;
        --secondary-color: #faf4d7;
        --finn-blue: #0f5057;
        --finn-blue-dark: #0a3d42;
        --finn-bg: #faf4d7;
        --finn-card-bg: #ffffff;
        --finn-text: #333333;
        --finn-text-light: #666666;
        --finn-border: #e0e0e0;
        --finn-success: #28a745;
    }

    body {
        background-color: var(--secondary-color);
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    }

    /* Main Layout */
    .finn-main-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px 15px;
    }

    /* Horizontal Category Bar */
    .category-bar {
        background: var(--finn-card-bg);
        border-bottom: 1px solid var(--finn-border);
        padding: 12px 0;
        margin-bottom: 20px;
        overflow-x: auto;
        white-space: nowrap;
    }

    .category-bar::-webkit-scrollbar {
        display: none;
    }

    .category-bar-items {
        display: flex;
        gap: 8px;
        padding: 0 15px;
    }

    .category-bar-item {
        display: inline-flex;
        align-items: center;
        padding: 8px 16px;
        background: #f5f5f5;
        border-radius: 20px;
        color: var(--finn-text);
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .category-bar-item:hover {
        background: var(--finn-blue);
        color: white;
        text-decoration: none;
    }

    .category-bar-item.active {
        background: var(--finn-blue);
        color: white;
    }

    /* Two Column Layout */
    .finn-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 24px;
    }

    @media (max-width: 991px) {
        .finn-layout {
            grid-template-columns: 1fr;
        }
    }

    /* Sidebar */
    .finn-sidebar {
        background: var(--finn-card-bg);
        border-radius: 8px;
        padding: 20px;
        border: 1px solid var(--finn-border);
        height: fit-content;
        position: sticky;
        top: 140px;
    }

    .sidebar-section {
        margin-bottom: 24px;
    }

    .sidebar-section:last-child {
        margin-bottom: 0;
    }

    .sidebar-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--finn-text);
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .filter-group {
        margin-bottom: 16px;
    }

    .filter-label {
        display: block;
        font-size: 13px;
        color: var(--finn-text-light);
        margin-bottom: 6px;
    }

    .filter-input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--finn-border);
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.2s ease;
    }

    .filter-input:focus {
        outline: none;
        border-color: var(--finn-blue);
    }

    .filter-checkbox {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 0;
        cursor: pointer;
    }

    .filter-checkbox input {
        width: 16px;
        height: 16px;
        accent-color: var(--finn-blue);
    }

    .filter-checkbox span {
        font-size: 14px;
        color: var(--finn-text);
    }

    /* Category List in Sidebar */
    .category-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .category-list li {
        margin-bottom: 4px;
    }

    .category-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        border-radius: 4px;
        color: var(--finn-text);
        text-decoration: none;
        font-size: 14px;
        transition: background-color 0.2s ease;
    }

    .category-link:hover {
        background: #f5f5f5;
        text-decoration: none;
        color: var(--finn-blue);
    }

    .category-link.active {
        background: rgba(0, 105, 194, 0.1);
        color: var(--finn-blue);
        font-weight: 500;
    }

    .category-count {
        font-size: 12px;
        color: var(--finn-text-light);
        background: #f0f0f0;
        padding: 2px 8px;
        border-radius: 10px;
    }

    /* Main Content */
    .finn-content {
        min-width: 0;
    }

    /* Section Header */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 24px;
        font-weight: 600;
        color: var(--finn-text);
        margin: 0;
    }

    .section-count {
        font-size: 14px;
        color: var(--finn-text-light);
        margin-top: 4px;
    }

    /* Listings Grid */
    .listings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 16px;
    }

    /* Product Card - Finn Style */
    .product-card {
        background: var(--finn-card-bg);
        border: 1px solid var(--finn-border);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .product-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: var(--finn-blue);
    }

    .product-image-container {
        position: relative;
        padding-top: 75%;
        background: #f5f5f5;
        overflow: hidden;
    }

    .product-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    .product-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        z-index: 1;
    }

    .badge-exchange {
        background: var(--finn-blue);
        color: white;
    }

    .badge-sale {
        background: var(--finn-success);
        color: white;
    }

    .badge-giveaway {
        background: #6c757d;
        color: white;
    }

    .product-content {
        padding: 12px;
    }

    .product-price {
        font-size: 18px;
        font-weight: 600;
        color: var(--finn-text);
        margin-bottom: 4px;
    }

    .product-price.free {
        color: var(--finn-success);
    }

    .product-title {
        font-size: 14px;
        font-weight: 500;
        color: var(--finn-text);
        margin-bottom: 8px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 12px;
        color: var(--finn-text-light);
    }

    .product-meta-item {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .product-location {
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid #f0f0f0;
    }

    .product-location span {
        font-size: 12px;
        color: var(--finn-text-light);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Home Sale Card */
    .home-sale-card {
        background: var(--finn-card-bg);
        border: 1px solid var(--finn-border);
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .home-sale-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-color: var(--finn-blue);
    }

    .home-sale-image-container {
        position: relative;
        padding-top: 60%;
        background: #f5f5f5;
        overflow: hidden;
    }

    .home-sale-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .home-sale-content {
        padding: 12px;
    }

    .home-sale-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--finn-text);
        margin-bottom: 8px;
    }

    .home-sale-date {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: rgba(0, 105, 194, 0.1);
        color: var(--finn-blue);
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .home-sale-location {
        font-size: 12px;
        color: var(--finn-text-light);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Features Section - Finn Style */
    .features-section {
        background: var(--finn-card-bg);
        border: 1px solid var(--finn-border);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 24px;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
    }

    .feature-item {
        text-align: center;
        padding: 12px 16px;
        border-radius: 8px;
        border: 2px solid transparent;
        transition: all 0.2s ease;
    }

    .feature-item:hover {
        background: #f5f5f5;
        border-color: var(--primary-color);
    }

    .feature-item:hover .feature-icon {
        transform: scale(1.15);
    }

    .feature-icon {
        font-size: 32px;
        margin-bottom: 12px;
        transition: transform 0.2s ease;
        display: inline-block;
    }

    .feature-title {
        font-size: 14px;
        font-weight: 600;
        color: var(--finn-text);
        margin-bottom: 4px;
    }

    .feature-desc {
        font-size: 12px;
        color: var(--finn-text-light);
    }

    /* CTA Section */
    .cta-section {
        background: var(--finn-blue);
        border-radius: 8px;
        padding: 32px;
        text-align: center;
        color: white;
        margin-top: 32px;
    }

    .cta-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .cta-desc {
        font-size: 14px;
        opacity: 0.9;
        margin-bottom: 20px;
    }

    .btn-finn {
        display: inline-flex;
        align-items: center;
        padding: 12px 24px;
        background: white;
        color: var(--finn-blue);
        border-radius: 4px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-finn:hover {
        background: #f5f5f5;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Section Dividers */
    .section-divider {
        border: none;
        border-top: 1px solid var(--finn-border);
        margin: 32px 0;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .finn-main-container {
            padding: 12px;
        }

        .finn-sidebar {
            display: none;
        }

        .listings-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .product-content {
            padding: 10px;
        }

        .product-price {
            font-size: 16px;
        }

        .section-title {
            font-size: 20px;
        }

        /* Home Sale Slider Responsive */
        .home-sale-slider-container {
            padding: 0 40px;
        }

        .home-sale-slide {
            min-width: 280px;
        }

        /* Features Grid - Keep 4 items in row */
        .features-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .feature-item {
            padding: 10px 8px;
        }

        .feature-icon {
            font-size: 24px;
            margin-bottom: 6px;
        }

        .feature-title {
            font-size: 13px;
        }

        .feature-desc {
            font-size: 11px;
        }
    }

    @media (max-width: 576px) {
        .listings-grid {
            grid-template-columns: 1fr;
        }

        /* Upcoming Home Sales - Show as slider on mobile */
        .upcoming-sales-grid {
            display: none;
        }

        .upcoming-sales-slider {
            display: block !important;
        }

        /* Home Sale Slider Mobile */
        .home-sale-slider-container {
            padding: 0 30px;
        }

        .home-sale-slide {
            min-width: 100%;
        }

        /* Features Grid on mobile - 2x2 layout */
        .features-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .feature-item {
            padding: 12px 8px;
        }

        .feature-icon {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .feature-title {
            font-size: 13px;
            font-weight: 600;
        }

        .feature-desc {
            font-size: 11px;
            display: none;
        }
    }

    /* Upcoming Home Sales Slider - Hidden by default, shown on mobile */
    .upcoming-sales-slider {
        display: none;
    }

    @media (max-width: 576px) {
        .upcoming-sales-slider {
            display: block;
        }
    }

    /* Home Sale Slider Styles */
    .home-sale-slider-section {
        margin-bottom: 40px;
    }

    .home-sale-slider-container {
        position: relative;
        overflow: hidden;
        padding: 20px 0;
        border: 1px solid transparent; /* Debug: make container visible */
    }

    .home-sale-slider {
        display: flex;
        gap: 16px;
        transition: transform 0.3s ease;
        width: max-content; /* Allow slider to be wider than container for scrolling */
        min-height: 300px; /* Ensure minimum height */
    }

    .home-sale-slide {
        flex: 0 0 320px;
        min-width: 320px;
        width: 320px;
        opacity: 1; /* Ensure slides are visible */
        transform: translateX(0); /* Ensure proper positioning */
    }

    .home-sale-slider-card {
        background: var(--finn-card-bg);
        border: 1px solid var(--finn-border);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .home-sale-slider-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        transform: translateY(-4px);
    }

    .slider-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .slider-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .home-sale-slider-card:hover .slider-image {
        transform: scale(1.05);
    }

    .slider-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 50%, rgba(0,0,0,0.6) 100%);
    }

    .slider-content {
        padding: 16px;
    }

    .slider-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--finn-text);
        margin-bottom: 8px;
    }

    .slider-date {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        background: rgba(0, 105, 194, 0.1);
        color: var(--finn-blue);
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .slider-location {
        font-size: 13px;
        color: var(--finn-text-light);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .slider-items {
        margin-top: 8px;
        padding-top: 8px;
        border-top: 1px solid #f0f0f0;
        font-size: 12px;
        color: var(--finn-text-light);
    }

    /* Slider Navigation */
    .slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid var(--finn-border);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        backdrop-filter: blur(10px);
    }

    .slider-nav:hover {
        background: var(--finn-blue);
        color: white;
        border-color: var(--finn-blue);
    }

    .slider-nav.prev {
        left: 0;
    }

    .slider-nav.next {
        right: 0;
    }

    .slider-nav.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .featured-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 6px 12px;
        background: #ffc107;
        color: #333;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        z-index: 2;
    }

    /* Blog Slider Styles */
    .blog-slider-section {
        margin-bottom: 40px;
    }

    /* Full Width Blog Section */
    .blog-fullwidth-section {
        margin-top: 48px;
        margin-bottom: 40px;
        padding-top: 20px;
    }

    .blog-fullwidth-section .section-header {
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
        padding: 0 15px;
    }

    .blog-slider-container {
        position: relative;
        overflow: hidden;
        padding: 20px 0;
    }

    .blog-slider {
        display: flex;
        gap: 20px;
        transition: transform 0.4s ease;
        width: max-content; /* Allow slider to be wider than container for scrolling */
        min-height: 400px; /* Ensure minimum height */
    }

    .blog-slide {
        flex: 0 0 360px;
        min-width: 360px;
        width: 360px;
        opacity: 1; /* Ensure slides are visible */
        transform: translateX(0); /* Ensure proper positioning */
    }

    .blog-slider-card {
        background: var(--finn-card-bg);
        border: 1px solid var(--finn-border);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .blog-slider-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        transform: translateY(-4px);
    }

    .blog-slider-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .blog-slider-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .blog-slider-card:hover .blog-slider-image {
        transform: scale(1.05);
    }

    .blog-slider-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,0.7) 100%);
    }

    .blog-slider-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .blog-slider-category {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        background: rgba(15, 80, 87, 0.1);
        color: var(--finn-blue);
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 12px;
        width: fit-content;
    }

    .blog-slider-title {
        font-size: 18px;
        font-weight: 600;
        color: var(--finn-text);
        margin-bottom: 12px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .blog-slider-excerpt {
        font-size: 14px;
        color: var(--finn-text-light);
        line-height: 1.6;
        margin-bottom: 16px;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .blog-slider-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px solid #f0f0f0;
        font-size: 12px;
        color: var(--finn-text-light);
    }

    .blog-slider-date {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .blog-slider-author {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .blog-slider-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        background: white;
        border: 1px solid var(--finn-border);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .blog-slider-nav:hover {
        background: var(--finn-blue);
        color: white;
        border-color: var(--finn-blue);
    }

    .blog-slider-nav.prev {
        left: -22px;
    }

    .blog-slider-nav.next {
        right: -22px;
    }

    .blog-slider-nav.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    @media (max-width: 1200px) {
        .blog-slider-nav.prev {
            left: 10px;
        }
        .blog-slider-nav.next {
            right: 10px;
        }
    }

    @media (max-width: 576px) {
        .blog-slide {
            flex: 0 0 300px;
            min-width: 300px;
        }
    }
</style>

<!-- Main Container -->
<div class="finn-main-container">

    <!-- Horizontal Category Bar -->
    <div class="category-bar">
        <div class="category-bar-items">
            <a href="{{ route('products.index') }}" class="category-bar-item {{ !request()->category ? 'active' : '' }}">
                <i class="fas fa-th-large me-2"></i>All
            </a>
            @foreach($categories->take(10) as $category)
                <a href="{{ route('categories.show', $category) }}"
                   class="category-bar-item {{ request()->route('category') == $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="finn-layout">
        <!-- Left Sidebar -->
        <aside class="finn-sidebar d-none d-lg-block">
            <!-- Categories Section -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">Categories</h3>
                <ul class="category-list">
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('categories.show', $category) }}" class="category-link">
                                <span>{{ $category->name }}</span>
                                <span class="category-count">{{ $category->products_count ?? 0 }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Listing Type Filter -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">Listing Type</h3>
                <div class="filter-group">
                    <label class="filter-checkbox">
                        <input type="checkbox" checked>
                        <span>Exchange</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" checked>
                        <span>For Sale</span>
                    </label>
                    <label class="filter-checkbox">
                        <input type="checkbox" checked>
                        <span>Give Away</span>
                    </label>
                </div>
            </div>

            <!-- Location Filter -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">Location</h3>
                <div class="filter-group">
                    <label class="filter-label">City / Area</label>
                    <input type="text" class="filter-input" placeholder="Enter location...">
                </div>
            </div>

            <!-- Price Filter -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">Price Range</h3>
                <div class="filter-group">
                    <div style="display: flex; gap: 8px;">
                        <input type="number" class="filter-input" placeholder="Min">
                        <input type="number" class="filter-input" placeholder="Max">
                    </div>
                </div>
            </div>

            <!-- Apply Filters Button -->
            <div class="sidebar-section">
                <button class="btn-finn w-100" style="background: var(--primary-color); color: white; justify-content: center;">
                    <i class="fas fa-filter me-2"></i>Apply Filters
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="finn-content">

            <!-- Upcoming Home Sales Section (4 cards) -->
            @if($upcomingHomeSales->count() > 0)
            <section class="mb-5 upcoming-sales-section">
                <div class="section-header">
                    <div>
                        <h2 class="section-title"><i class="fas fa-home me-2" style="color: var(--finn-blue);"></i> Upcoming Home Sales</h2>
                        <p class="section-count">{{ $upcomingHomeSales->count() }} sales near you</p>
                    </div>
                    <a href="{{ route('home-sales.index') }}" class="btn-finn" style="font-size: 14px; padding: 8px 16px;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>

                <!-- Desktop Grid View -->
                <div class="listings-grid upcoming-sales-grid" style="grid-template-columns: repeat(4, 1fr); gap: 20px;">
                    @foreach($upcomingHomeSales as $homeSale)
                        <a href="{{ route('home-sales.show', $homeSale) }}" class="home-sale-card text-decoration-none">
                            <div class="home-sale-image-container">
                                @if($homeSale->images && count($homeSale->images) > 0)
                                    @if(strpos($homeSale->images[0], 'http') === 0)
                                        <img src="{{ $homeSale->images[0] }}" alt="{{ $homeSale->title }}" class="home-sale-image">
                                    @else
                                        <img src="{{ asset('storage/' . $homeSale->images[0]) }}" alt="{{ $homeSale->title }}" class="home-sale-image">
                                    @endif
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, var(--finn-blue), #004a80);">
                                        <i class="fas fa-home fa-3x text-white"></i>
                                    </div>
                                @endif
                                @if($homeSale->is_featured)
                                    <span class="product-badge badge-exchange" style="top: auto; bottom: 8px; left: 8px; background: #ffc107; color: #333;">
                                        <i class="fas fa-star me-1"></i>Featured
                                    </span>
                                @endif
                            </div>
                            <div class="home-sale-content">
                                <h5 class="home-sale-title">{{ Str::limit($homeSale->title, 50) }}</h5>
                                <div class="home-sale-date">
                                    <i class="fas fa-calendar"></i>
                                    {{ $homeSale->sale_date_from->format('M d') }} - {{ $homeSale->sale_date_to->format('M d, Y') }}
                                </div>
                                <p class="home-sale-location mt-2">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $homeSale->location }}{{ $homeSale->city ? ', ' . $homeSale->city : '' }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Mobile Slider View -->
                <div class="home-sale-slider-container upcoming-sales-slider" id="upcomingSalesSliderContainer">
                    <button class="slider-nav prev" id="upcomingPrev" onclick="slideUpcoming('prev')">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <div class="home-sale-slider" id="upcomingSalesSlider">
                        @foreach($upcomingHomeSales as $homeSale)
                            <div class="home-sale-slide">
                                <a href="{{ route('home-sales.show', $homeSale) }}" class="home-sale-slider-card text-decoration-none">
                                    <div class="slider-image-container">
                                        @if($homeSale->images && count($homeSale->images) > 0)
                                            @if(str_starts_with($homeSale->images[0], 'http'))
                                                <img src="{{ $homeSale->images[0] }}" alt="{{ $homeSale->title }}" class="slider-image">
                                            @else
                                                <img src="{{ asset('storage/' . $homeSale->images[0]) }}" alt="{{ $homeSale->title }}" class="slider-image">
                                            @endif
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, var(--finn-blue), #004a80);">
                                                <i class="fas fa-home fa-3x text-white"></i>
                                            </div>
                                        @endif
                                        <div class="slider-overlay"></div>
                                        @if($homeSale->is_featured)
                                            <span class="featured-badge">
                                                <i class="fas fa-star me-1"></i>Featured
                                            </span>
                                        @endif
                                    </div>
                                    <div class="slider-content">
                                        <h5 class="slider-title">{{ Str::limit($homeSale->title, 40) }}</h5>
                                        <div class="slider-date">
                                            <i class="fas fa-calendar"></i>
                                            {{ $homeSale->sale_date_from->format('M d') }} - {{ $homeSale->sale_date_to->format('M d, Y') }}
                                        </div>
                                        <p class="slider-location">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $homeSale->location }}{{ $homeSale->city ? ', ' . $homeSale->city : '' }}
                                        </p>
                                        @if($homeSale->available_items)
                                            <div class="slider-items">
                                                <i class="fas fa-box"></i> {{ Str::limit($homeSale->available_items, 50) }}
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <button class="slider-nav next" id="upcomingNext" onclick="slideUpcoming('next')">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </section>

            <hr class="section-divider">
            @endif

            <!-- Featured Home Sales Slider -->
            @if($featuredHomeSales && $featuredHomeSales->count() > 0)
            <section class="home-sale-slider-section featured-sales-section">
                <div class="section-header">
                    <div>
                        <h2 class="section-title"><i class="fas fa-star me-2" style="color: #ffc107;"></i> Featured Home Sales</h2>
                        <p class="section-count">Special sales you don't want to miss</p>
                    </div>
                    <a href="{{ route('home-sales.index') }}" class="btn-finn" style="font-size: 14px; padding: 8px 16px;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="home-sale-slider-container">
                    <button class="slider-nav prev" id="featuredPrev" onclick="slideFeatured('prev')">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <div class="home-sale-slider" id="featuredSlider">
                        @foreach($featuredHomeSales as $homeSale)
                            <div class="home-sale-slide">
                                <a href="{{ route('home-sales.show', $homeSale) }}" class="home-sale-slider-card text-decoration-none">
                                    <div class="slider-image-container">
                                        @if($homeSale->images && count($homeSale->images) > 0)
                                            @if(str_starts_with($homeSale->images[0], 'http'))
                                                <img src="{{ $homeSale->images[0] }}" alt="{{ $homeSale->title }}" class="slider-image">
                                            @else
                                                <img src="{{ asset('storage/' . $homeSale->images[0]) }}" alt="{{ $homeSale->title }}" class="slider-image">
                                            @endif
                                        @else
                                            <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, var(--finn-blue), #004a80);">
                                                <i class="fas fa-home fa-3x text-white"></i>
                                            </div>
                                        @endif
                                        <div class="slider-overlay"></div>
                                        <span class="featured-badge">
                                            <i class="fas fa-star me-1"></i>Featured
                                        </span>
                                    </div>
                                    <div class="slider-content">
                                        <h5 class="slider-title">{{ Str::limit($homeSale->title, 40) }}</h5>
                                        <div class="slider-date">
                                            <i class="fas fa-calendar"></i>
                                            {{ $homeSale->sale_date_from->format('M d') }} - {{ $homeSale->sale_date_to->format('M d, Y') }}
                                        </div>
                                        <p class="slider-location">
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $homeSale->location }}{{ $homeSale->city ? ', ' . $homeSale->city : '' }}
                                        </p>
                                        @if($homeSale->available_items)
                                            <div class="slider-items">
                                                <i class="fas fa-box"></i> {{ Str::limit($homeSale->available_items, 50) }}
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <button class="slider-nav next" id="featuredNext" onclick="slideFeatured('next')">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </section>

            <hr class="section-divider">
            @endif

            <!-- Features/Action Types Section -->
            <section class="features-section">
                <div class="features-grid">
                    <a href="{{ route('products.index', ['listing_type' => 'exchange']) }}" class="feature-item text-decoration-none">
                        <div class="feature-icon" style="color: var(--finn-blue);"><i class="fas fa-exchange-alt fa-2x"></i></div>
                        <div class="feature-title">Exchange</div>
                        <div class="feature-desc">Trade items with others</div>
                    </a>
                    <a href="{{ route('products.index', ['listing_type' => 'sale']) }}" class="feature-item text-decoration-none">
                        <div class="feature-icon" style="color: var(--finn-success);"><i class="fas fa-tag fa-2x"></i></div>
                        <div class="feature-title">For Sale</div>
                        <div class="feature-desc">Buy items directly</div>
                    </a>
                    <a href="{{ route('products.index', ['listing_type' => 'giveaway']) }}" class="feature-item text-decoration-none">
                        <div class="feature-icon" style="color: #6c757d;"><i class="fas fa-gift fa-2x"></i></div>
                        <div class="feature-title">Give Away</div>
                        <div class="feature-desc">Free items for those in need</div>
                    </a>
                    <a href="{{ route('home-sales.index') }}" class="feature-item text-decoration-none">
                        <div class="feature-icon" style="color: var(--finn-blue);"><i class="fas fa-home fa-2x"></i></div>
                        <div class="feature-title">Home Sales</div>
                        <div class="feature-desc">Garage & estate sales</div>
                    </a>
                </div>
            </section>

            <hr class="section-divider">

            <!-- Featured Products Section -->
            <section class="mb-5 featured-items-section">
                <div class="section-header">
                    <div>
                        <h2 class="section-title"><i class="fas fa-gem me-2" style="color: var(--finn-blue);"></i> Featured Items</h2>
                        <p class="section-count">{{ $featuredProducts->count() }} items available</p>
                    </div>
                    <a href="{{ route('products.index') }}" class="btn-finn" style="font-size: 14px; padding: 8px 16px;">
                        View All <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>

                @if($featuredProducts->count() > 0)
                    <div class="listings-grid">
                        @foreach($featuredProducts as $product)
                            <a href="{{ route('products.show', $product) }}" class="product-card text-decoration-none">
                                <div class="product-image-container">
                                    @if($product->images && count($product->images) > 0)
                                        @if(str_starts_with($product->images[0], 'http'))
                                            <img src="{{ $product->images[0] }}" alt="{{ $product->title }}" class="product-image">
                                        @else
                                            <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->title }}" class="product-image">
                                        @endif
                                    @else
                                        <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, var(--finn-blue), #004a80);">
                                            <i class="fas fa-image fa-2x text-white"></i>
                                        </div>
                                    @endif

                                    <!-- Badge based on listing type -->
                                    @if($product->listing_type == 'exchange')
                                        <span class="product-badge badge-exchange">Exchange</span>
                                    @elseif($product->listing_type == 'sale')
                                        <span class="product-badge badge-sale">{{ number_format($product->price, 0, ',', ' ') }} NOK</span>
                                    @elseif($product->listing_type == 'giveaway')
                                        <span class="product-badge badge-giveaway">FREE</span>
                                    @endif
                                </div>
                                <div class="product-content">
                                    @if($product->listing_type == 'sale')
                                        <div class="product-price">{{ number_format($product->price, 0, ',', ' ') }} kr</div>
                                    @elseif($product->listing_type == 'giveaway')
                                        <div class="product-price free">Free</div>
                                    @else
                                        <div class="product-price">Exchange</div>
                                    @endif

                                    <h5 class="product-title">{{ Str::limit($product->title, 60) }}</h5>

                                    <div class="product-meta">
                                        <span class="product-meta-item">
                                            <i class="fas fa-tag"></i> {{ $product->category->name }}
                                        </span>
                                        <span class="product-meta-item">
                                            <i class="fas fa-clock"></i> {{ $product->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <div class="product-location">
                                        <span>
                                            <i class="fas fa-map-marker-alt"></i>
                                            {{ $product->location ?? 'Norway' }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5" style="background: var(--finn-card-bg); border-radius: 8px; border: 1px solid var(--finn-border);">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-3">No items listed yet</p>
                        <button class="btn-finn" data-bs-toggle="modal" data-bs-target="#signupModal">
                            <i class="fas fa-plus me-2"></i>List Your First Item
                        </button>
                    </div>
                @endif
            </section>

            <!-- CTA Section -->
            <div class="cta-section">
                <h3 class="cta-title">Ready to start exchanging?</h3>
                <p class="cta-desc">Join thousands of users trading, selling, and giving away items every day.</p>
                <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                    <button class="btn-finn" data-bs-toggle="modal" data-bs-target="#signupModal" style="background: white; color: var(--primary-color);">
                        <i class="fas fa-user-plus me-2"></i>Create Free Account
                    </button>
                    <a href="{{ route('products.index') }}" class="btn-finn" style="background: transparent; color: white; border: 2px solid white;">
                        <i class="fas fa-search me-2"></i>Browse Items
                    </a>
                </div>
            </div>

        </main>
    </div>

    <!-- Latest Blogs Slider Section - Full Width -->
    @if($latestBlogs && $latestBlogs->count() > 0)
    <div class="blog-fullwidth-section blog-fullwidth-section">
        <div class="section-header">
            <div>
                <h2 class="section-title"><i class="fas fa-newspaper me-2" style="color: var(--finn-blue);"></i> Latest from Our Blog</h2>
                <p class="section-count">{{ $latestBlogs->count() }} articles to read</p>
            </div>
            <a href="{{ route('blogs.index') }}" class="btn-finn" style="font-size: 14px; padding: 8px 16px;">
                View All <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="blog-slider-container" id="blogSliderContainer">
            <button class="blog-slider-nav prev" id="blogPrev" onclick="slideBlog('prev')">
                <i class="fas fa-chevron-left"></i>
            </button>

            <div class="blog-slider" id="blogSlider">
                @foreach($latestBlogs as $blog)
                    <div class="blog-slide">
                        <a href="{{ route('blogs.show', $blog) }}" class="blog-slider-card text-decoration-none">
                            <div class="blog-slider-image-container">
                                @if($blog->image)
                                    <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="blog-slider-image">
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, var(--finn-blue), #0a3d42);">
                                        <i class="fas fa-newspaper fa-3x text-white"></i>
                                    </div>
                                @endif
                                <div class="blog-slider-overlay"></div>
                            </div>
                            <div class="blog-slider-content">
                                <span class="blog-slider-category">
                                    <i class="fas fa-tag"></i> Blog
                                </span>
                                <h5 class="blog-slider-title">{{ Str::limit($blog->title, 60) }}</h5>
                                <p class="blog-slider-excerpt">{{ Str::limit(strip_tags($blog->content), 120) }}</p>
                                <div class="blog-slider-meta">
                                    <span class="blog-slider-date">
                                        <i class="fas fa-calendar"></i>
                                        {{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}
                                    </span>
                                    @if($blog->comments && $blog->comments->count() > 0)
                                        <span class="blog-slider-author">
                                            <i class="fas fa-comments"></i>
                                            {{ $blog->comments->count() }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <button class="blog-slider-nav next" id="blogNext" onclick="slideBlog('next')">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
    @endif
</div>

<style>
/* ========================================
   TRANSITION EFFECTS FOR HOME PAGE SECTIONS
   ======================================== */

/* Base Animation Keyframes */
@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInScale {
    0% {
        opacity: 0;
        transform: scale(0.95);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes slideInLeft {
    0% {
        opacity: 0;
        transform: translateX(-30px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    0% {
        opacity: 0;
        transform: translateX(30px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes bounceIn {
    0% {
        opacity: 0;
        transform: scale(0.3);
    }
    50% {
        opacity: 1;
        transform: scale(1.05);
    }
    70% {
        transform: scale(0.9);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

/* Section Entrance Animations */
.upcoming-sales-section {
    animation: fadeInUp 0.8s ease-out;
}

.featured-sales-section {
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

.featured-items-section {
    animation: fadeInUp 0.8s ease-out 0.4s both;
}

.blog-fullwidth-section {
    animation: fadeInUp 0.8s ease-out 0.6s both;
}

/* Section Header Animations */
.section-header {
    animation: slideInLeft 0.6s ease-out;
}

.section-header .section-title {
    animation: fadeInScale 0.8s ease-out 0.1s both;
}

.section-header .section-count {
    animation: fadeInUp 0.6s ease-out 0.3s both;
}

.section-header .btn-finn {
    animation: bounceIn 0.8s ease-out 0.5s both;
}

/* ========================================
   UPCOMING HOME SALES ANIMATIONS
   ======================================== */

.upcoming-sales-grid .home-sale-card {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.upcoming-sales-grid .home-sale-card:nth-child(1) {
    animation: fadeInUp 0.6s ease-out 0.1s both;
}

.upcoming-sales-grid .home-sale-card:nth-child(2) {
    animation: fadeInUp 0.6s ease-out 0.2s both;
}

.upcoming-sales-grid .home-sale-card:nth-child(3) {
    animation: fadeInUp 0.6s ease-out 0.3s both;
}

.upcoming-sales-grid .home-sale-card:nth-child(4) {
    animation: fadeInUp 0.6s ease-out 0.4s both;
}

.home-sale-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.home-sale-image-container {
    transition: all 0.3s ease;
    overflow: hidden;
}

.home-sale-card:hover .home-sale-image-container {
    transform: scale(1.05);
}

.home-sale-image {
    transition: all 0.3s ease;
}

.home-sale-card:hover .home-sale-image {
    transform: scale(1.1);
}

/* ========================================
   FEATURED HOME SALES SLIDER ANIMATIONS
   ======================================== */

.home-sale-slider .home-sale-slide {
    opacity: 0;
    transform: translateX(30px);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.home-sale-slider .home-sale-slide.animate-in {
    opacity: 1;
    transform: translateX(0);
}

.home-sale-slider-card {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.home-sale-slider-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}

.slider-image-container {
    transition: all 0.4s ease;
    overflow: hidden;
}

.home-sale-slider-card:hover .slider-image-container {
    transform: scale(1.08);
}

.slider-image {
    transition: all 0.4s ease;
}

.home-sale-slider-card:hover .slider-image {
    transform: scale(1.15);
}

.slider-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 80, 87, 0.1) 0%, rgba(15, 80, 87, 0.3) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.home-sale-slider-card:hover .slider-overlay {
    opacity: 1;
}

.slider-content {
    transition: all 0.3s ease;
}

.home-sale-slider-card:hover .slider-content {
    transform: translateY(-2px);
}

/* ========================================
   FEATURED ITEMS ANIMATIONS
   ======================================== */

.listings-grid .product-card {
    opacity: 0;
    transform: translateY(25px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Staggered entrance animations */
.listings-grid .product-card:nth-child(1) { animation: fadeInUp 0.5s ease-out 0.1s both; }
.listings-grid .product-card:nth-child(2) { animation: fadeInUp 0.5s ease-out 0.2s both; }
.listings-grid .product-card:nth-child(3) { animation: fadeInUp 0.5s ease-out 0.3s both; }
.listings-grid .product-card:nth-child(4) { animation: fadeInUp 0.5s ease-out 0.4s both; }
.listings-grid .product-card:nth-child(5) { animation: fadeInUp 0.5s ease-out 0.5s both; }
.listings-grid .product-card:nth-child(6) { animation: fadeInUp 0.5s ease-out 0.6s both; }
.listings-grid .product-card:nth-child(7) { animation: fadeInUp 0.5s ease-out 0.7s both; }
.listings-grid .product-card:nth-child(8) { animation: fadeInUp 0.5s ease-out 0.8s both; }

.product-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
}

.product-image-container {
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.product-card:hover .product-image-container {
    transform: scale(1.05);
}

.product-image {
    transition: all 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.1);
}

.product-badge {
    transition: all 0.3s ease;
}

.product-card:hover .product-badge {
    transform: scale(1.1);
}

.product-content {
    transition: all 0.3s ease;
}

.product-card:hover .product-content {
    transform: translateY(-3px);
}

/* ========================================
   LATEST BLOG ANIMATIONS
   ======================================== */

.blog-slider .blog-slide {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.blog-slider .blog-slide.animate-in {
    opacity: 1;
    transform: translateY(0);
}

.blog-slider-card {
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.blog-slider-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.blog-slider-image-container {
    transition: all 0.4s ease;
    overflow: hidden;
    position: relative;
}

.blog-slider-card:hover .blog-slider-image-container {
    transform: scale(1.05);
}

.blog-slider-image {
    transition: all 0.4s ease;
}

.blog-slider-card:hover .blog-slider-image {
    transform: scale(1.1);
}

.blog-slider-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(15, 80, 87, 0.2) 0%, rgba(15, 80, 87, 0.4) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.blog-slider-card:hover .blog-slider-overlay {
    opacity: 1;
}

.blog-slider-content {
    transition: all 0.3s ease;
    padding: 20px;
}

.blog-slider-card:hover .blog-slider-content {
    transform: translateY(-5px);
}

.blog-slider-category {
    display: inline-block;
    background: var(--secondary-color);
    color: var(--primary-color);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.blog-slider-card:hover .blog-slider-category {
    background: var(--primary-color);
    color: var(--secondary-color);
    transform: scale(1.05);
}

.blog-slider-title {
    transition: all 0.3s ease;
    margin: 12px 0;
    color: var(--finn-text);
}

.blog-slider-card:hover .blog-slider-title {
    color: var(--primary-color);
}

.blog-slider-meta {
    display: flex;
    gap: 15px;
    margin-top: 15px;
    font-size: 14px;
    color: var(--finn-text-light);
}

.blog-slider-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

/* ========================================
   SLIDER NAVIGATION ANIMATIONS
   ======================================== */

.slider-nav, .blog-slider-nav {
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(0, 0, 0, 0.1);
}

.slider-nav:hover, .blog-slider-nav:hover {
    background: white;
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.slider-nav:active, .blog-slider-nav:active {
    transform: scale(0.95);
}

/* ========================================
   RESPONSIVE ANIMATIONS
   ======================================== */

@media (max-width: 768px) {
    .upcoming-sales-grid .home-sale-card,
    .listings-grid .product-card {
        animation-duration: 0.4s;
    }

    .home-sale-card:hover,
    .product-card:hover,
    .home-sale-slider-card:hover,
    .blog-slider-card:hover {
        transform: translateY(-5px) scale(1.01);
    }

    /* Responsive slider adjustments */
    .home-sale-slide {
        flex: 0 0 280px;
        min-width: 280px;
        width: 280px;
    }

    .blog-slide {
        flex: 0 0 300px;
        min-width: 300px;
        width: 300px;
    }

    .slider-nav {
        width: 35px;
        height: 35px;
    }

    .slider-nav i {
        font-size: 14px;
    }
}

@media (max-width: 576px) {
    .home-sale-slide {
        flex: 0 0 250px;
        min-width: 250px;
        width: 250px;
    }

    .blog-slide {
        flex: 0 0 280px;
        min-width: 280px;
        width: 280px;
    }

    .home-sale-slider-container,
    .blog-slider-container {
        padding: 15px 0;
    }
}

/* Intersection Observer for Scroll Animations */
</style>

<script>
    // Featured Home Sales Slider
    const featuredSlider = document.getElementById('featuredSlider');
    const featuredPrev = document.getElementById('featuredPrev');
    const featuredNext = document.getElementById('featuredNext');

    let featuredScrollAmount = 0;
    const slideWidth = 336; // 320px + 16px gap

    function updateSliderButtons() {
        if (featuredPrev && featuredNext) {
            featuredPrev.classList.toggle('disabled', featuredScrollAmount <= 0);
            featuredNext.classList.toggle('disabled', featuredScrollAmount >= featuredSlider.scrollWidth - featuredSlider.clientWidth);
        }
    }

    function slideFeatured(direction) {
        if (!featuredSlider) return;

        if (direction === 'prev') {
            featuredScrollAmount = Math.max(0, featuredScrollAmount - slideWidth);
        } else {
            featuredScrollAmount = Math.min(
                featuredSlider.scrollWidth - featuredSlider.clientWidth,
                featuredScrollAmount + slideWidth
            );
        }

        featuredSlider.style.transform = `translateX(-${featuredScrollAmount}px)`;
        updateSliderButtons();
    }

    // Initialize slider buttons state
    if (featuredSlider) {
        updateSliderButtons();

        // Update on window resize
        window.addEventListener('resize', updateSliderButtons);

        // Auto-slide functionality - slide every 3 seconds
        let autoSlideInterval = setInterval(() => {
            slideFeatured('next');
        }, 3000);

        // Pause auto-slide on hover, resume on mouse leave
        const sliderContainer = featuredSlider.closest('.home-sale-slider-container');
        if (sliderContainer) {
            sliderContainer.addEventListener('mouseenter', () => {
                clearInterval(autoSlideInterval);
            });

            sliderContainer.addEventListener('mouseleave', () => {
                autoSlideInterval = setInterval(() => {
                    slideFeatured('next');
                }, 3000);
            });
        }
    }

    // Upcoming Home Sales Slider
    const upcomingSlider = document.getElementById('upcomingSalesSlider');
    const upcomingPrev = document.getElementById('upcomingPrev');
    const upcomingNext = document.getElementById('upcomingNext');

    let upcomingScrollAmount = 0;
    const upcomingSlideWidth = 336; // 320px + 16px gap

    function updateUpcomingSliderButtons() {
        if (upcomingPrev && upcomingNext && upcomingSlider) {
            upcomingPrev.classList.toggle('disabled', upcomingScrollAmount <= 0);
            upcomingNext.classList.toggle('disabled', upcomingScrollAmount >= upcomingSlider.scrollWidth - upcomingSlider.clientWidth);
        }
    }

    function slideUpcoming(direction) {
        if (!upcomingSlider) return;

        if (direction === 'prev') {
            upcomingScrollAmount = Math.max(0, upcomingScrollAmount - upcomingSlideWidth);
        } else {
            upcomingScrollAmount = Math.min(
                upcomingSlider.scrollWidth - upcomingSlider.clientWidth,
                upcomingScrollAmount + upcomingSlideWidth
            );
        }

        upcomingSlider.style.transform = `translateX(-${upcomingScrollAmount}px)`;
        updateUpcomingSliderButtons();
    }

    // Initialize upcoming slider
    if (upcomingSlider) {
        updateUpcomingSliderButtons();

        // Update on window resize
        window.addEventListener('resize', updateUpcomingSliderButtons);

        // Auto-slide functionality - slide every 3 seconds
        let upcomingAutoSlideInterval = setInterval(() => {
            slideUpcoming('next');
        }, 3000);

        // Pause auto-slide on hover, resume on mouse leave
        const upcomingSliderContainer = document.getElementById('upcomingSalesSliderContainer');
        if (upcomingSliderContainer) {
            upcomingSliderContainer.addEventListener('mouseenter', () => {
                clearInterval(upcomingAutoSlideInterval);
            });

            upcomingSliderContainer.addEventListener('mouseleave', () => {
                upcomingAutoSlideInterval = setInterval(() => {
                    slideUpcoming('next');
                }, 3000);
            });
        }
    }

    // Blog Slider
    const blogSlider = document.getElementById('blogSlider');
    const blogPrev = document.getElementById('blogPrev');
    const blogNext = document.getElementById('blogNext');

    let blogScrollAmount = 0;
    const blogSlideWidth = 380; // 360px + 20px gap

    function updateBlogSliderButtons() {
        if (blogPrev && blogNext) {
            blogPrev.classList.toggle('disabled', blogScrollAmount <= 0);
            blogNext.classList.toggle('disabled', blogScrollAmount >= blogSlider.scrollWidth - blogSlider.clientWidth);
        }
    }

    function slideBlog(direction) {
        if (!blogSlider) return;

        if (direction === 'prev') {
            blogScrollAmount = Math.max(0, blogScrollAmount - blogSlideWidth);
        } else {
            blogScrollAmount = Math.min(
                blogSlider.scrollWidth - blogSlider.clientWidth,
                blogScrollAmount + blogSlideWidth
            );
        }

        blogSlider.style.transform = `translateX(-${blogScrollAmount}px)`;
        updateBlogSliderButtons();
    }

    // Initialize blog slider
    if (blogSlider) {
        updateBlogSliderButtons();

        // Update on window resize
        window.addEventListener('resize', updateBlogSliderButtons);

        // Auto-slide functionality - slide every 4 seconds
        let blogAutoSlideInterval = setInterval(() => {
            slideBlog('next');
        }, 4000);

        // Pause auto-slide on hover, resume on mouse leave
        const blogSliderContainer = document.getElementById('blogSliderContainer');
        if (blogSliderContainer) {
            blogSliderContainer.addEventListener('mouseenter', () => {
                clearInterval(blogAutoSlideInterval);
            });

            blogSliderContainer.addEventListener('mouseleave', () => {
                blogAutoSlideInterval = setInterval(() => {
                    slideBlog('next');
                }, 4000);
            });
        }
    }

    // ========================================
    // TRANSITION EFFECTS & SCROLL ANIMATIONS
    // ========================================

    // Intersection Observer for scroll-triggered animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');

                // Add staggered animation for slider items
                if (entry.target.classList.contains('home-sale-slide') || entry.target.classList.contains('blog-slide')) {
                    setTimeout(() => {
                        entry.target.style.transitionDelay = '0s';
                    }, 100);
                }
            }
        });
    }, observerOptions);

    // Observe slider items for entrance animations
    document.querySelectorAll('.home-sale-slide, .blog-slide').forEach(slide => {
        observer.observe(slide);
    });

    // Add section classes for entrance animations
    document.addEventListener('DOMContentLoaded', function() {
        // Add classes to sections for entrance animations
        const upcomingSection = document.querySelector('section:has(.upcoming-sales-grid)');
        const featuredSection = document.querySelector('.home-sale-slider-section');
        const itemsSection = document.querySelector('section:has(.listings-grid)');
        const blogSection = document.querySelector('.blog-fullwidth-section');

        if (upcomingSection) upcomingSection.classList.add('upcoming-sales-section');
        if (featuredSection) featuredSection.classList.add('featured-sales-section');
        if (itemsSection) itemsSection.classList.add('featured-items-section');
        if (blogSection) blogSection.classList.add('blog-fullwidth-section');

        // Smooth scroll for section headers
        document.querySelectorAll('.section-header .btn-finn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Enhanced hover effects for cards
        document.querySelectorAll('.home-sale-card, .product-card, .home-sale-slider-card, .blog-slider-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.zIndex = '10';
            });

            card.addEventListener('mouseleave', function() {
                this.style.zIndex = '';
            });
        });

        // Auto-trigger animations on load for visible elements
        setTimeout(() => {
            const visibleSlides = document.querySelectorAll('.home-sale-slide:not(.hidden), .blog-slide:not(.hidden)');
            visibleSlides.forEach((slide, index) => {
                setTimeout(() => {
                    slide.classList.add('animate-in');
                }, index * 100);
            });
        }, 300);

        // Debug: Log slider information
        console.log('Featured slider:', featuredSlider);
        console.log('Blog slider:', blogSlider);
        console.log('Featured slides:', document.querySelectorAll('.home-sale-slide').length);
        console.log('Blog slides:', document.querySelectorAll('.blog-slide').length);
    });

    // Performance optimization: Use requestAnimationFrame for smooth animations
    let ticking = false;
    function updateAnimations() {
        if (!ticking) {
            requestAnimationFrame(() => {
                // Add any performance-critical animations here
                ticking = false;
            });
            ticking = true;
        }
    }

    // Throttle scroll events
    window.addEventListener('scroll', updateAnimations, { passive: true });
</script>

@endsection
