<?php $__env->startSection('title', 'Buyers'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Buyers</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-shopping-cart text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Buyers Management</h5>
                        <small class="text-muted"><?php echo e($buyers->total()); ?> total buyers</small>
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
                        <input type="text" id="buyerSearch" class="form-control border-0 bg-light" placeholder="Search by name or email..." style="border-radius: 8px 0 0 8px; padding: 8px 12px;">
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
                            <li><a class="dropdown-item" href="<?php echo e(route('admin.buyers.export', ['format' => 'pdf'])); ?>" target="_blank"><i class="fas fa-file-pdf text-danger me-2"></i>Export as PDF</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('admin.buyers.export', ['format' => 'csv'])); ?>"><i class="fas fa-file-csv text-success me-2"></i>Export as CSV</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('admin.buyers.export', ['format' => 'xlsx'])); ?>"><i class="fas fa-file-excel text-primary me-2"></i>Export as Excel</a></li>
                        </ul>
                    </div>

                    <a href="<?php echo e(route('admin.buyers.create')); ?>" class="btn btn-sm px-3" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-plus me-2"></i>Add Buyer
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div id="searchResults">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th style="width: 40px;">
                                <input type="checkbox" id="selectAll" class="form-check-input">
                            </th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Location</th>
                            <th>Exchanges Count</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $buyers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $buyer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="form-check-input row-checkbox" value="<?php echo e($buyer->id); ?>">
                                </td>
                                <td><?php echo e($buyer->id); ?></td>
                                <td><?php echo e($buyer->name); ?></td>
                                <td><?php echo e($buyer->email); ?></td>
                                <td><?php echo e($buyer->phone ?: '-'); ?></td>
                                <td><?php echo e($buyer->location ?: 'Not specified'); ?></td>
                                <td><?php echo e(($buyer->proposed_exchanges_count ?? 0) + ($buyer->received_exchanges_count ?? 0)); ?></td>
                                <td><?php echo e($buyer->created_at->format('M d, Y')); ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.buyers.show', $buyer)); ?>" class="btn btn-outline-info btn-sm" style="border-radius: 6px 0 0 6px;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.buyers.edit', $buyer)); ?>" class="btn btn-outline-warning btn-sm" style="border-radius: 0;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.buyers.login-as', $buyer)); ?>" class="btn btn-outline-success btn-sm" style="border-radius: 0;" onclick="return confirm('Are you sure you want to login as this buyer?')">
                                            <i class="fas fa-sign-in-alt"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.buyers.destroy', $buyer)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius: 0 6px 6px 0;" onclick="return confirm('Are you sure you want to delete this buyer?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light border-top-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing <?php echo e($buyers->firstItem() ?? 0); ?> to <?php echo e($buyers->lastItem() ?? 0); ?> of <?php echo e($buyers->total()); ?> buyers
                </div>
                <?php echo e($buyers->links()); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/adminlte-custom.css')); ?>">
    <style>
        :root {
            --primary-color: <?php echo e(config('settings.primary_color', '#1a6969')); ?>;
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
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
            alert('Please select buyers to delete.');
            return;
        }

        if (confirm(`Are you sure you want to delete ${selectedIds.length} buyer(s)? This action cannot be undone.`)) {
            // Create form and submit
            const form = $('<form>', {
                'method': 'POST',
                'action': '<?php echo e(route("admin.buyers.bulk-delete")); ?>'
            });

            // Add CSRF token
            form.append($('<input>', {
                'type': 'hidden',
                'name': '_token',
                'value': '<?php echo e(csrf_token()); ?>'
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
    $('#buyerSearch').on('input', function() {
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
    $('#buyerSearch').on('input', function() {
        if ($(this).val().trim() === '') {
            location.reload();
        }
    });

    function performSearch(query) {
        $.ajax({
            url: '<?php echo e(route("admin.buyers.index")); ?>',
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/admin/buyers/index.blade.php ENDPATH**/ ?>