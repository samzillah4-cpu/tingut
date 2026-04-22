@extends('adminlte::page')

@section('title', 'Products')

@section('content_header')
    <h1>Products</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-box text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Products Management</h5>
                        <small class="text-muted">{{ $products->total() }} total products</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <!-- Bulk Actions (shown when items selected) -->
                    <div id="bulkActionsTop" class="d-none me-3">
                        <div class="btn-group" role="group">
                            <button type="button" id="bulkActivateTop" class="btn btn-success btn-sm">
                                <i class="fas fa-check me-1"></i>Activate
                            </button>
                            <button type="button" id="bulkDeactivateTop" class="btn btn-warning btn-sm">
                                <i class="fas fa-pause me-1"></i>Deactivate
                            </button>
                            <button type="button" id="bulkDeleteTop" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </div>
                        <span id="selectedCountTop" class="text-muted ms-2 small"></span>
                    </div>

                    <!-- Export Button -->
                    <a href="{{ route('admin.products.export', ['format' => 'pdf']) }}" class="btn btn-outline-secondary btn-sm me-3" style="border-radius: 8px;">
                        <i class="fas fa-download me-2"></i>Export PDF
                    </a>

                    <a href="{{ route('admin.products.create') }}" class="btn btn-sm px-3" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-plus me-2"></i>Add Product
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <!-- Filters -->
            <form method="GET" class="mb-4 p-3 bg-light rounded" style="border-radius: 8px;">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Search</label>
                        <input type="text" name="search" class="form-control form-control-sm border-0 bg-white" placeholder="Product name/description" value="{{ request('search') }}" style="border-radius: 6px;">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Type</label>
                        <select name="listing_type" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                            <option value="">All Types</option>
                            <option value="sale" {{ request('listing_type') == 'sale' ? 'selected' : '' }}>Sale</option>
                            <option value="exchange" {{ request('listing_type') == 'exchange' ? 'selected' : '' }}>Exchange</option>
                            <option value="giveaway" {{ request('listing_type') == 'giveaway' ? 'selected' : '' }}>Giveaway</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select name="category_id" class="form-control form-control-sm border-0 bg-white" style="border-radius: 6px;">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">&nbsp;</label>
                        <button type="submit" class="btn btn-secondary btn-sm w-100" style="border-radius: 6px;">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">&nbsp;</label>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm w-100" style="border-radius: 6px;">
                            <i class="fas fa-times me-1"></i>Clear
                        </a>
                    </div>
                </div>
            </form>

            <div id="searchResults">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>User</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Images</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <input type="checkbox" class="product-checkbox form-check-input" value="{{ $product->id }}">
                                </td>
                                <td>{{ $product->id }}</td>
                                <td>{{ Str::limit($product->title, 30) }}</td>
                                <td>{{ $product->user->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>
                                    <span class="badge badge-info">
                                        {{ ucfirst($product->listing_type ?? 'sale') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $product->status == 'active' ? 'badge-success' : 'badge-secondary' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td>{{ count($product->images ?? []) }} images</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-info btn-sm" style="border-radius: 6px 0 0 6px;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-warning btn-sm" style="border-radius: 0;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius: 0 6px 6px 0;" onclick="return confirm('Are you sure you want to delete this product?')">
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
        </div>

        <div class="card-footer bg-light border-top-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </div>
                {{ $products->links() }}
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

        .table th {
            background-color: #217372;
            border-top: none;
            font-weight: 600;
            color: white;
        }

        .table td {
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .badge {
            font-size: 0.75rem;
        }

        .pagination {
            margin-bottom: 0;
        }

        .card-footer {
            border-radius: 0 0 12px 12px;
        }

        .btn-group .btn {
            border-color: #dee2e6 !important;
        }

        .btn-group .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
@stop

@section('js')
<script>
$(document).ready(function() {
    let searchTimeout;

    // Bulk selection functionality
    $('#selectAll').on('change', function() {
        const isChecked = $(this).is(':checked');
        $('.product-checkbox').prop('checked', isChecked);
        updateBulkActions();
    });

    $(document).on('change', '.product-checkbox', function() {
        const totalCheckboxes = $('.product-checkbox').length;
        const checkedCheckboxes = $('.product-checkbox:checked').length;

        $('#selectAll').prop('checked', checkedCheckboxes === totalCheckboxes);
        updateBulkActions();
    });

    function updateBulkActions() {
        const selectedCount = $('.product-checkbox:checked').length;
        if (selectedCount > 0) {
            $('#bulkActionsTop').removeClass('d-none');
            $('#selectedCountTop').text(selectedCount + ' product' + (selectedCount > 1 ? 's' : '') + ' selected');
        } else {
            $('#bulkActionsTop').addClass('d-none');
            $('#selectedCountTop').text('');
        }
    }

    $('#clearSelection').on('click', function() {
        $('.product-checkbox, #selectAll').prop('checked', false);
        updateBulkActions();
    });

    // Bulk actions (both top and bottom)
    $('#bulkActivate, #bulkActivateTop').on('click', function() {
        performBulkAction('activate', 'Are you sure you want to activate the selected products?');
    });

    $('#bulkDeactivate, #bulkDeactivateTop').on('click', function() {
        performBulkAction('deactivate', 'Are you sure you want to deactivate the selected products?');
    });

    $('#bulkDelete, #bulkDeleteTop').on('click', function() {
        performBulkAction('delete', 'Are you sure you want to delete the selected products? This action cannot be undone.');
    });

    function performBulkAction(action, confirmMessage) {
        const selectedIds = $('.product-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            alert('Please select at least one product.');
            return;
        }

        if (!confirm(confirmMessage)) {
            return;
        }

        // Show loading state
        const button = $('#bulk' + action.charAt(0).toUpperCase() + action.slice(1));
        const originalText = button.html();
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i>Processing...');

        $.ajax({
            url: '{{ route("admin.products.bulk") }}',
            method: 'POST',
            data: {
                action: action,
                ids: selectedIds,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Error: ' + (response.message || 'An error occurred.'));
                }
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON?.message || 'An error occurred.'));
            },
            complete: function() {
                button.prop('disabled', false).html(originalText);
            }
        });
    }

});
</script>
@stop
