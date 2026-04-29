<?php $__env->startSection('title', 'Categories'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Categories</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-tags text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Categories Management</h5>
                        <small class="text-muted"><?php echo e($categories->total()); ?> total categories</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <!-- Search Bar -->
                    <div class="input-group input-group-sm me-3" style="width: 250px;">
                        <input type="text" id="categorySearch" class="form-control border-0 bg-light" placeholder="Search categories..." style="border-radius: 8px 0 0 8px; padding: 8px 12px;">
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
                            <li><a class="dropdown-item" href="<?php echo e(route('admin.categories.export', ['format' => 'pdf'])); ?>" target="_blank"><i class="fas fa-file-pdf text-danger me-2"></i>Export as PDF</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('admin.categories.export', ['format' => 'csv'])); ?>"><i class="fas fa-file-csv text-success me-2"></i>Export as CSV</a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('admin.categories.export', ['format' => 'xlsx'])); ?>"><i class="fas fa-file-excel text-primary me-2"></i>Export as Excel</a></li>
                        </ul>
                    </div>

                    <a href="<?php echo e(route('admin.categories.create')); ?>" class="btn px-3" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-plus me-2"></i>Add Category
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div id="searchResults">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Products</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($category->id); ?></td>
                                <td><?php echo e($category->name); ?></td>
                                <td><?php echo e(Str::limit($category->description, 50)); ?></td>
                                <td><?php echo e($category->products_count); ?></td>
                                <td>
                                    <?php if($category->image): ?>
                                        <?php if(str_starts_with($category->image, 'http')): ?>
                                            <img src="<?php echo e($category->image); ?>" alt="<?php echo e($category->name); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('storage/' . $category->image)); ?>" alt="<?php echo e($category->name); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="text-muted small">No Image</div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.categories.show', $category)); ?>" class="btn btn-outline-info btn-sm" style="border-radius: 6px 0 0 6px;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn btn-outline-warning btn-sm" style="border-radius: 0;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius: 0 6px 6px 0;" onclick="return confirm('Are you sure you want to delete this category?')">
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
                    Showing <?php echo e($categories->firstItem() ?? 0); ?> to <?php echo e($categories->lastItem() ?? 0); ?> of <?php echo e($categories->total()); ?> categories
                </div>
                <?php echo e($categories->links()); ?>

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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    let searchTimeout;

    // Live search functionality
    $('#categorySearch').on('input', function() {
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
    $('#categorySearch').on('input', function() {
        if ($(this).val().trim() === '') {
            location.reload();
        }
    });

    function performSearch(query) {
        $.ajax({
            url: '<?php echo e(route("admin.categories.index")); ?>',
            method: 'GET',
            data: {
                search: query,
                ajax: 1
            },
            success: function(response) {
                $('#searchResults').html(response);
            },
            error: function() {
                $('#searchResults').html('<div class="alert alert-danger">Search failed. Please try again.</div>');
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>