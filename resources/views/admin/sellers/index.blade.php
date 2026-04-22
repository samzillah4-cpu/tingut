@extends('adminlte::page')

@section('title', 'Sellers')

@section('content_header')
    <h1>Sellers</h1>
@stop

@section('content')
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Sellers Management</h5>
                        <small class="text-muted">{{ $sellers->total() }} total sellers</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <!-- Bulk Actions -->
                    <div class="btn-group me-3" id="bulkActions" style="display: none;">
                        <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn" style="border-radius: 8px;">
                            <i class="fas fa-trash me-2"></i>Delete Selected (<span id="selectedCount">0</span>)
                        </button>
                    </div>

                    <!-- Search Bar -->
                    <div class="input-group input-group-sm me-3" style="width: 250px;">
                        <input type="text" id="sellerSearch" class="form-control border-0 bg-light" placeholder="Search by name or email..." style="border-radius: 8px 0 0 8px; padding: 8px 12px;">
                        <span class="input-group-text border-0" style="background-color: var(--primary-color); color: white; border-radius: 0 8px 8px 0;">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>

                    <!-- Export Buttons -->
                    <div class="btn-group me-3" role="group">
                        <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                            <i class="fas fa-download me-2"></i>Export
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('admin.sellers.export', ['format' => 'pdf']) }}" target="_blank"><i class="fas fa-file-pdf text-danger me-2"></i>Export as PDF</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.sellers.export', ['format' => 'csv']) }}"><i class="fas fa-file-csv text-success me-2"></i>Export as CSV</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.sellers.export', ['format' => 'xlsx']) }}"><i class="fas fa-file-excel text-primary me-2"></i>Export as Excel</a></li>
                        </ul>
                    </div>

                    <a href="{{ route('admin.sellers.create') }}" class="btn px-3" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-plus me-2"></i>Add Seller
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <div id="searchResults">
                    @include('admin.sellers.partials.table')
                </div>
            </div>
        </div>
        <div class="card-footer bg-light border-top-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing {{ $sellers->firstItem() ?? 0 }} to {{ $sellers->lastItem() ?? 0 }} of {{ $sellers->total() }} sellers
                </div>
                {{ $sellers->links() }}
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
            background-color: #f8f9fa;
            border-top: none;
            font-weight: 600;
            color: #495057;
            font-size: 0.875rem;
            padding: 12px 8px;
        }

        .table td {
            vertical-align: middle;
            border-color: #e9ecef;
            padding: 12px 8px;
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        .avatar-circle {
            font-size: 14px;
            font-weight: 600;
        }

        .pagination {
            margin-bottom: 0;
        }

        .card-footer {
            border-radius: 0 0 12px 12px;
        }

        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .table-responsive {
            border-radius: 0 0 12px 12px;
        }

        /* Mobile optimizations */
        @media (max-width: 576px) {
            .card-body {
                padding: 0 !important;
            }

            .table td, .table th {
                padding: 8px 4px;
            }

            .btn-group-sm .btn {
                padding: 0.2rem 0.3rem;
                font-size: 0.7rem;
            }

            .avatar-circle {
                width: 28px !important;
                height: 28px !important;
                font-size: 12px !important;
            }
        }
    </style>
@stop

@section('js')
<script>
$(document).ready(function() {
    let searchTimeout;

    // Bulk selection functionality
    $('#selectAll').on('change', function() {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
        updateBulkActions();
    });

    $(document).on('change', '.row-checkbox', function() {
        const totalCheckboxes = $('.row-checkbox').length;
        const checkedCheckboxes = $('.row-checkbox:checked').length;

        $('#selectAll').prop('checked', checkedCheckboxes === totalCheckboxes);
        updateBulkActions();
    });

    function updateBulkActions() {
        const selectedCount = $('.row-checkbox:checked').length;
        $('#selectedCount').text(selectedCount);

        if (selectedCount > 0) {
            $('#bulkActions').show();
        } else {
            $('#bulkActions').hide();
        }
    }

    // Bulk delete functionality
    $('#bulkDeleteBtn').on('click', function() {
        const selectedIds = $('.row-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        if (selectedIds.length === 0) {
            alert('Please select sellers to delete.');
            return;
        }

        if (confirm(`Are you sure you want to delete ${selectedIds.length} seller(s)? This action cannot be undone.`)) {
            // Create form and submit
            const form = $('<form>', {
                'method': 'POST',
                'action': '{{ route("admin.sellers.bulk-delete") }}'
            });

            // Add CSRF token
            form.append($('<input>', {
                'type': 'hidden',
                'name': '_token',
                'value': '{{ csrf_token() }}'
            }));

            // Add selected IDs
            selectedIds.forEach(function(id) {
                form.append($('<input>', {
                    'type': 'hidden',
                    'name': 'ids[]',
                    'value': id
                }));
            });

            $('body').append(form);
            form.submit();
        }
    });

    // Live search functionality
    $('#sellerSearch').on('input', function() {
        const query = $(this).val().trim();
        clearTimeout(searchTimeout);

        if (query.length >= 2) {
            // Show loading state
            $('#searchResults').html('<div class="text-center py-4"><i class="fas fa-spinner fa-spin"></i> Searching...</div>');

            searchTimeout = setTimeout(() => {
                performSearch(query);
            }, 300);
        } else if (query.length === 0) {
            // Clear search and show all results
            location.reload();
        }
    });

    // Clear search when input is empty
    $('#sellerSearch').on('input', function() {
        if ($(this).val().trim() === '') {
            location.reload();
        }
    });

    function performSearch(query) {
        $.ajax({
            url: '{{ route("admin.sellers.index") }}',
            method: 'GET',
            data: {
                search: query,
                ajax: 1
            },
            success: function(response) {
                $('#searchResults').html(response);
                // Re-initialize bulk selection after AJAX load
                updateBulkActions();
            },
            error: function() {
                $('#searchResults').html('<div class="alert alert-danger">Search failed. Please try again.</div>');
            }
        });
    }
});
</script>
@stop
