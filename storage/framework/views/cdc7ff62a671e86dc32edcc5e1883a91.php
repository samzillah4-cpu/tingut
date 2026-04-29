<?php $__env->startSection('title', 'Subscriptions'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Subscriptions</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                        <i class="fas fa-crown text-white"></i>
                    </div>
                    <div>
                        <h5 class="mb-0">Subscription Management</h5>
                        <small class="text-muted"><?php echo e($plans->count()); ?> plans, <?php echo e($subscriptions->count()); ?> subscriptions</small>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <a href="<?php echo e(route('admin.subscriptions.create')); ?>" class="btn px-3" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-plus me-2"></i>Add Plan
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <!-- Subscription Plans Section -->
            <h6 class="mb-3">Subscription Plans</h6>
            <div class="row mb-4">
                <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo e($plan->name); ?></h5>
                                <p class="card-text"><?php echo e($plan->description); ?></p>
                                <p class="text-primary fw-bold">NOK <?php echo e($plan->price); ?> / <?php echo e($plan->duration); ?></p>
                                <p class="small">Max Products: <?php echo e($plan->max_products == 0 ? 'Unlimited' : $plan->max_products); ?></p>
                                <p class="small">Category: <?php echo e($plan->category ? $plan->category->name : 'General'); ?></p>
                                <div class="d-flex justify-content-between">
                                    <a href="<?php echo e(route('admin.subscriptions.edit', $plan)); ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form action="<?php echo e(route('admin.subscriptions.destroy', $plan)); ?>" method="POST" style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12">
                        <div class="text-center py-4">
                            <i class="fas fa-crown fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No subscription plans found.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Active Subscriptions Section -->
            <h6 class="mb-3">Active Subscriptions</h6>
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($subscription->user->name); ?></td>
                                <td><?php echo e($subscription->plan->name); ?></td>
                                <td><?php echo e($subscription->start_date->format('M d, Y')); ?></td>
                                <td><?php echo e($subscription->end_date->format('M d, Y')); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($subscription->status == 'active' ? 'success' : 'secondary'); ?>">
                                        <?php echo e(ucfirst($subscription->status)); ?>

                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <i class="fas fa-users fa-2x text-muted mb-2"></i>
                                    <p class="text-muted">No active subscriptions.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/admin/subscriptions/index.blade.php ENDPATH**/ ?>