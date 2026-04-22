@extends('adminlte::page')

@section('title', 'My Products')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/adminlte-custom.css') }}">
    <style>
        /* Hide sidebar - match seller dashboard */
        .main-sidebar { display: none !important; }
        .content-wrapper { margin-left: 0 !important; }
        .main-header { margin-left: 0 !important; }

        /* Website colors integration */
        :root {
            --primary: #0f5057;
            --primary-light: #147a8a;
            --primary-dark: #0a3540;
            --secondary: #faf4d7;
            --secondary-dark: #f5eac4;
            --success: #28a745;
            --warning: #ffc107;
            --info: #17a2b8;
            --royal: #6f42c1;
            --text-primary: #212529;
            --text-secondary: #6c757d;
            --border-color: #e9ecef;
            --bg-light: #f8f9fa;
            --shadow: 0 2px 8px rgba(15, 80, 87, 0.1);
            --shadow-lg: 0 4px 16px rgba(15, 80, 87, 0.15);
        }

        .content {
            background: var(--bg-light) !important;
            padding: 0 !important;
        }

        /* Page Header - Match Dashboard */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0 0 16px 16px;
            margin-bottom: 1rem;
            box-shadow: var(--shadow-lg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .page-header .page-title {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-header .page-title h1 {
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            color: white;
        }

        .page-header .page-title i {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .page-header-actions {
            display: flex;
            gap: 0.5rem;
        }

        .page-header-actions .btn {
            border-radius: 20px;
            padding: 0.35rem 0.75rem;
            font-weight: 600;
            font-size: 0.8rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .page-header-actions .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .page-header-actions .btn-outline-light {
            background: transparent;
            color: white;
        }

        /* Main Content Container */
        .products-container {
            padding: 0 1.5rem 1.5rem;
        }

        /* Card Styling */
        .products-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .products-card .card-header {
            background: var(--bg-light);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .products-card .card-header h3 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .products-card .card-body {
            padding: 1.25rem;
        }

        /* Search & Filter Form */
        .search-filter-form {
            margin-bottom: 1.5rem;
        }

        .search-filter-form .row {
            gap: 0.75rem;
        }

        .search-filter-form .form-control {
            border-radius: 10px;
            border: 1px solid var(--border-color);
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .search-filter-form .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 80, 87, 0.1);
        }

        .search-filter-form .btn {
            border-radius: 10px;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Table Styling */
        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            font-size: 0.9rem;
        }

        .table thead th {
            background: var(--bg-light);
            border-bottom: 2px solid var(--border-color);
            color: var(--text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: var(--border-color);
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(15, 80, 87, 0.03);
        }

        .table tbody tr td:first-child {
            font-weight: 500;
            color: var(--text-primary);
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-badge.active {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .status-badge.draft {
            background: #fff3cd;
            color: #856404;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .action-buttons .btn {
            padding: 0.35rem 0.75rem;
            font-size: 0.8rem;
            border-radius: 8px;
            font-weight: 500;
        }

        .action-buttons .btn-info {
            background: var(--info);
            border: none;
            color: white;
        }

        .action-buttons .btn-warning {
            background: var(--warning);
            border: none;
            color: #212529;
        }

        .action-buttons .btn-danger {
            background: #dc3545;
            border: none;
            color: white;
        }

        .action-buttons .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            opacity: 0.4;
            color: var(--primary);
        }

        .empty-state h4 {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
            color: var(--text-primary);
        }

        .empty-state p {
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        /* Pagination */
        .pagination-wrapper {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
        }

        .pagination-wrapper .pagination {
            gap: 0.25rem;
        }

        .pagination-wrapper .page-link {
            border-radius: 8px;
            border: 1px solid var(--border-color);
            color: var(--primary);
            padding: 0.4rem 0.75rem;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .pagination-wrapper .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* Stats Row */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .stat-card .stat-icon.primary { background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%); }
        .stat-card .stat-icon.success { background: linear-gradient(135deg, var(--success) 0%, #20c997 100%); }
        .stat-card .stat-icon.warning { background: linear-gradient(135deg, var(--warning) 0%, #fd7e14 100%); }
        .stat-card .stat-icon.secondary { background: linear-gradient(135deg, #6c757d 0%, #495057 100%); }

        .stat-card .stat-info .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .stat-card .stat-info .stat-label {
            font-size: 0.75rem;
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Badge styling */
        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
        }

        .badge i {
            margin-right: 3px;
        }

        /* Text muted small */
        .text-muted.small,
        .small.text-muted {
            font-size: 0.85rem;
        }

        /* Product image in table */
        .table td .d-flex.align-items-center.gap-3 img,
        .table td .d-flex.align-items-center.gap-3 div {
            width: 50px;
            height: 50px;
        }

        /* Buttons */
        .btn {
            border-radius: 8px !important;
            font-weight: 600 !important;
            transition: all 0.3s ease !important;
        }

        .btn:hover {
            transform: translateY(-1px) !important;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 0.75rem 1rem;
                border-radius: 0 0 12px 12px;
                flex-direction: column;
                text-align: center;
            }

            .page-header .page-title {
                flex-direction: column;
                gap: 0.5rem;
            }

            .page-header-actions {
                justify-content: center;
                flex-wrap: wrap;
            }

            .products-container {
                padding: 0 1rem 1.5rem;
            }

            .products-card .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-row {
                grid-template-columns: 1fr;
                margin: 0 1rem 1.5rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.75rem;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
@stop

@section('content_header')
    <div class="page-header">
        <div class="page-title">
            <i class="fas fa-box-open"></i>
            <h1>My Products</h1>
        </div>
        <div class="page-header-actions">
            <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Add New Product
            </a>
            <a href="{{ route('seller.dashboard') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
            </a>
        </div>
    </div>
@stop

@section('content')
    <div class="products-container">
        <!-- Stats Row -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ \App\Models\Product::where('user_id', auth()->id())->count() }}</div>
                    <div class="stat-label">Total Products</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ \App\Models\Product::where('user_id', auth()->id())->where('status', 'active')->count() }}</div>
                    <div class="stat-label">Active</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="fas fa-pause-circle"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ \App\Models\Product::where('user_id', auth()->id())->where('status', 'inactive')->count() }}</div>
                    <div class="stat-label">Inactive</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon secondary">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">{{ \App\Models\Product::where('user_id', auth()->id())->where('status', 'draft')->count() }}</div>
                    <div class="stat-label">Drafts</div>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="products-card">
            <div class="card-header">
                <h3><i class="fas fa-list me-2"></i>Products Management</h3>
                <span class="text-muted small">{{ $products->total() }} products found</span>
            </div>

            <div class="card-body">
                <!-- Search and Filter -->
                <form method="GET" class="search-filter-form">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products by title..." class="form-control">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-redo me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>

                @if($products->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width: 35%;">Product Title</th>
                                    <th style="width: 15%;">Category</th>
                                    <th style="width: 12%;">Listing Type</th>
                                    <th style="width: 12%;">Status</th>
                                    <th style="width: 15%;">Created</th>
                                    <th style="width: 11%;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                @if($product->images && count($product->images) > 0)
                                                    <img src="{{ Storage::url($product->images[0]) }}" alt="{{ $product->title }}" class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <span>{{ Str::limit($product->title, 40) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                        </td>
                                        <td>
                                            @if($product->listing_type === 'sale')
                                                <span class="badge bg-success"><i class="fas fa-tag me-1"></i>For Sale</span>
                                            @elseif($product->listing_type === 'exchange')
                                                <span class="badge bg-warning text-dark"><i class="fas fa-exchange-alt me-1"></i>Exchange</span>
                                            @else
                                                <span class="badge bg-info"><i class="fas fa-gift me-1"></i>Give Away</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge {{ $product->status }}">{{ ucfirst($product->status) }}</span>
                                        </td>
                                        <td>
                                            <span class="text-muted small">{{ $product->created_at->format('M d, Y') }}</span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('seller.products.show', $product) }}" class="btn btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('seller.products.edit', $product) }}" class="btn btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('seller.products.destroy', $product) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-box-open"></i>
                        <h4>No Products Found</h4>
                        <p>You haven't added any products yet. Start by creating your first product to begin trading.</p>
                        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create Your First Product
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
