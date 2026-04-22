<table class="table table-hover mb-0">
    <thead class="table-light">
        <tr>
            <th width="30" class="text-center">
                <input type="checkbox" id="selectAll" class="form-check-input" style="margin: 0;">
            </th>
            <th class="d-none d-md-table-cell">#</th>
            <th>Name</th>
            <th class="d-none d-lg-table-cell">Email</th>
            <th class="d-none d-xl-table-cell">Phone</th>
            <th class="d-none d-xl-table-cell">Location</th>
            <th class="text-center">Products</th>
            <th class="text-center d-none d-sm-table-cell">Exchanges</th>
            <th class="d-none d-lg-table-cell">Subscription</th>
            <th class="d-none d-md-table-cell">Joined</th>
            <th width="180" class="text-center">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="form-check-input row-checkbox" value="<?php echo e($seller->id); ?>" style="margin: 0;">
                </td>
                <td class="d-none d-md-table-cell"><?php echo e($seller->id); ?></td>
                <td>
                    <div>
                        <div class="fw-semibold"><?php echo e($seller->name); ?></div>
                        <small class="text-muted d-block d-lg-none"><?php echo e($seller->email); ?></small>
                    </div>
                </td>
                <td class="d-none d-lg-table-cell"><?php echo e($seller->email); ?></td>
                <td class="d-none d-xl-table-cell">
                    <small class="text-muted"><?php echo e($seller->phone ?: '-'); ?></small>
                </td>
                <td class="d-none d-xl-table-cell">
                    <span class="badge bg-light text-dark"><?php echo e($seller->location ?: 'Not set'); ?></span>
                </td>
                <td class="text-center">
                    <span class="badge bg-info"><?php echo e($seller->products_count); ?></span>
                </td>
                <td class="text-center d-none d-sm-table-cell">
                    <span class="badge bg-success"><?php echo e(($seller->proposed_exchanges_count ?? 0) + ($seller->received_exchanges_count ?? 0)); ?></span>
                </td>
                <td class="d-none d-lg-table-cell">
                    <?php if($seller->subscriptions->where('status', 'active')->where('end_date', '>', now())->first()): ?>
                        <span class="badge bg-primary"><?php echo e($seller->subscriptions->where('status', 'active')->where('end_date', '>', now())->first()->plan->name); ?></span>
                        <br><small class="text-muted">Expires: <?php echo e($seller->subscriptions->where('status', 'active')->where('end_date', '>', now())->first()->end_date->format('M d')); ?></small>
                    <?php else: ?>
                        <span class="badge bg-secondary">No Subscription</span>
                    <?php endif; ?>
                </td>
                <td class="d-none d-md-table-cell">
                    <small class="text-muted"><?php echo e($seller->created_at->format('M d, Y')); ?></small>
                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="<?php echo e(route('admin.sellers.show', $seller)); ?>" class="btn btn-outline-info btn-sm" title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?php echo e(route('admin.sellers.edit', $seller)); ?>" class="btn btn-outline-warning btn-sm" title="Edit Seller">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?php echo e(route('admin.sellers.login-as', $seller)); ?>" class="btn btn-outline-success btn-sm" title="Login as Seller" onclick="return confirm('Are you sure you want to login as this seller?')">
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                        <form action="<?php echo e(route('admin.sellers.destroy', $seller)); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Seller" onclick="return confirm('Are you sure?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/admin/sellers/partials/table.blade.php ENDPATH**/ ?>