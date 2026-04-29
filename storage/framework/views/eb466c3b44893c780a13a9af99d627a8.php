<?php $__env->startSection('title', 'Home Sales'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Home Sales</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-home text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Home Sales Management</h5>
                        <small class="text-muted"><?php echo e($homeSales->total()); ?> total home sales</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="<?php echo e(route('admin.home-sales.create')); ?>" class="btn px-3" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-plus me-2"></i>Add Home Sale
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div id="searchResults">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Sale Date</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $homeSales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $homeSale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($homeSale->id); ?></td>
                                <td>
                                    <?php if($homeSale->images && count($homeSale->images) > 0): ?>
                                        <?php if(str_starts_with($homeSale->images[0], 'http')): ?>
                                            <img src="<?php echo e($homeSale->images[0]); ?>" alt="<?php echo e($homeSale->title); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('storage/' . $homeSale->images[0])); ?>" alt="<?php echo e($homeSale->title); ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="text-muted small">No Image</div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e(Str::limit($homeSale->title, 40)); ?></td>
                                <td>
                                    <?php echo e($homeSale->sale_date_from->format('M d, Y')); ?> - <?php echo e($homeSale->sale_date_to->format('M d, Y')); ?>

                                </td>
                                <td><?php echo e($homeSale->location); ?></td>
                                <td>
                                    <span class="badge <?php echo e($homeSale->status === 'active' ? 'badge-success' : 'badge-secondary'); ?>">
                                        <?php echo e(ucfirst($homeSale->status)); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($homeSale->is_featured): ?>
                                        <i class="fas fa-star text-warning"></i>
                                    <?php else: ?>
                                        <i class="fas fa-star text-muted"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('admin.home-sales.show', $homeSale)); ?>" class="btn btn-outline-info btn-sm" style="border-radius: 6px 0 0 6px;">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.home-sales.edit', $homeSale)); ?>" class="btn btn-outline-warning btn-sm" style="border-radius: 0;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.home-sales.destroy', $homeSale)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger btn-sm" style="border-radius: 0 6px 6px 0;" onclick="return confirm('Are you sure you want to delete this home sale?')">
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
                    Showing <?php echo e($homeSales->firstItem() ?? 0); ?> to <?php echo e($homeSales->lastItem() ?? 0); ?> of <?php echo e($homeSales->total()); ?> home sales
                </div>
                <?php echo e($homeSales->links()); ?>

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

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/admin/home-sales/index.blade.php ENDPATH**/ ?>