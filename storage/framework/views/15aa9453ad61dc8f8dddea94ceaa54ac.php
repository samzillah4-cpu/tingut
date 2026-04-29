<?php $__env->startSection('title', 'Exchanges'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Exchanges</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-exchange-alt text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Exchange Management</h5>
                        <small class="text-muted"><?php echo e($exchanges->total()); ?> total exchanges</small>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-center flex-grow-1">
                    <!-- Search Bar -->
                    <div class="input-group input-group-sm" style="width: 400px;">
                        <form method="GET" class="d-flex w-100">
                            <input type="text" name="search" class="form-control border-0 bg-light" placeholder="Search by user name..." value="<?php echo e(request('search')); ?>" style="border-radius: 8px 0 0 8px; padding: 8px 12px;">
                            <select name="status" class="form-control border-0 bg-light" style="border-radius: 0; padding: 8px 12px; max-width: 140px;">
                                <option value="">All Statuses</option>
                                <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="accepted" <?php echo e(request('status') == 'accepted' ? 'selected' : ''); ?>>Accepted</option>
                                <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Rejected</option>
                                <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                            </select>
                            <button type="submit" class="btn border-0" style="background-color: var(--primary-color); color: white; border-radius: 0 8px 8px 0;">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="<?php echo e(route('admin.exchanges.export-pdf', request()->query())); ?>" class="btn btn-outline-primary btn-sm" style="border-radius: 6px;" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i>Export PDF
                    </a>
                    <a href="<?php echo e(route('admin.exchanges.create')); ?>" class="btn px-3" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-plus me-2"></i>Add Exchange
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr class="border-bottom">
                            <th>ID</th>
                            <th>Proposer</th>
                            <th>Offered Product</th>
                            <th>Receiver</th>
                            <th>Requested Product</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $exchanges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exchange): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="border-bottom border-light">
                                <td><strong><?php echo e($exchange->id); ?></strong></td>
                                <td>
                                    <div>
                                        <div class="fw-semibold"><?php echo e($exchange->proposer->name); ?></div>
                                        <small class="text-muted"><?php echo e($exchange->proposer->email); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <?php if($exchange->offeredProduct): ?>
                                        <a href="<?php echo e(route('products.show', $exchange->offeredProduct)); ?>" target="_blank" class="text-decoration-none">
                                            <strong><?php echo e(Str::limit($exchange->offeredProduct->title, 25)); ?></strong>
                                        </a>
                                    <?php else: ?>
                                        <em class="text-muted">Product removed</em>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-semibold"><?php echo e($exchange->receiver->name); ?></div>
                                        <small class="text-muted"><?php echo e($exchange->receiver->email); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <?php if($exchange->requestedProduct): ?>
                                        <a href="<?php echo e(route('products.show', $exchange->requestedProduct)); ?>" target="_blank" class="text-decoration-none">
                                            <strong><?php echo e(Str::limit($exchange->requestedProduct->title, 25)); ?></strong>
                                        </a>
                                    <?php else: ?>
                                        <em class="text-muted">Product removed</em>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge
                                        <?php if($exchange->status === 'completed'): ?> bg-success
                                        <?php elseif($exchange->status === 'pending'): ?> bg-warning
                                        <?php elseif($exchange->status === 'accepted'): ?> bg-info
                                        <?php else: ?> bg-danger
                                        <?php endif; ?>">
                                        <?php echo e(ucfirst($exchange->status)); ?>

                                    </span>
                                </td>
                                <td><small class="text-muted"><?php echo e($exchange->created_at->format('M d, Y')); ?></small></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?php echo e(route('admin.exchanges.show', $exchange)); ?>" class="btn btn-outline-info" title="View Exchange">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.exchanges.edit', $exchange)); ?>" class="btn btn-outline-warning" title="Edit Exchange">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.exchanges.destroy', $exchange)); ?>" method="POST" style="display:inline;">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger" title="Delete Exchange" onclick="return confirm('Are you sure you want to delete this exchange?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-exchange-alt fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No exchanges found.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-light border-top-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Showing <?php echo e($exchanges->firstItem() ?? 0); ?> to <?php echo e($exchanges->lastItem() ?? 0); ?> of <?php echo e($exchanges->total()); ?> exchanges
                </div>
                <?php echo e($exchanges->links()); ?>

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

        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(26, 105, 105, 0.25) !important;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    // Enhanced search functionality
    $('input[name="search"], select[name="status"]').on('change input', function() {
        $(this).closest('form').submit();
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/admin/exchanges/index.blade.php ENDPATH**/ ?>