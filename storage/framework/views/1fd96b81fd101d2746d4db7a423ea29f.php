<?php $__env->startSection('content'); ?>
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">Propose Exchange</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
                            <div class="freecycle-card">
                                <div class="card-body p-4">
                                    <h1 class="card-title text-center mb-4" style="color: var(--primary-color);">Propose Exchange</h1>

                                    <?php if($requestedProduct): ?>
                                        <div class="mb-4 p-3" style="background-color: var(--secondary-color); border-radius: 8px;">
                                            <h5 class="mb-3" style="color: var(--primary-color);">You want to exchange for:</h5>
                                            <div class="d-flex align-items-center">
                                                <?php if($requestedProduct->images && count($requestedProduct->images) > 0): ?>
                                                    <img src="<?php echo e(asset('storage/' . $requestedProduct->images[0])); ?>" alt="<?php echo e($requestedProduct->title); ?>" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                                <?php endif; ?>
                                                <div>
                                                    <h6 class="mb-1"><?php echo e($requestedProduct->title); ?></h6>
                                                    <p class="text-muted small mb-0"><?php echo e($requestedProduct->category->name); ?> • by <?php echo e($requestedProduct->user->name); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <form method="POST" action="<?php echo e(route('buyer.exchanges.store')); ?>">
                                        <?php echo csrf_field(); ?>

                                        <?php if($requestedProduct): ?>
                                            <input type="hidden" name="requested_product_id" value="<?php echo e($requestedProduct->id); ?>">
                                        <?php else: ?>
                                            <div class="mb-3">
                                                <label for="requested_product_id" class="form-label" style="color: var(--primary-color);">Product to Request</label>
                                                <select name="requested_product_id" id="requested_product_id" class="form-control" style="border-color: #e0e0e0; focus: border-color: var(--primary-color);" required>
                                                    <option value="">Select a product...</option>
                                                    <!-- This would need to be populated with available products -->
                                                </select>
                                                <?php if($errors->has('requested_product_id')): ?>
                                                    <div class="text-danger small mt-1"><?php echo e($errors->first('requested_product_id')); ?></div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="mb-3">
                                            <label for="offered_product_id" class="form-label" style="color: var(--primary-color);">Your Product to Offer</label>
                                            <select name="offered_product_id" id="offered_product_id" class="form-control" style="border-color: #e0e0e0;" required>
                                                <option value="">Select your product...</option>
                                                <?php $__currentLoopData = $userProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($product->id); ?>"><?php echo e($product->title); ?> (<?php echo e($product->category->name); ?>)</option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php if($errors->has('offered_product_id')): ?>
                                                <div class="text-danger small mt-1"><?php echo e($errors->first('offered_product_id')); ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <?php if($userProducts->count() === 0): ?>
                                            <div class="mb-3 p-3" style="background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px;">
                                                <p class="text-warning-emphasis mb-2">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>You don't have any active products to offer.
                                                </p>
                                                <a href="<?php echo e(route('seller.products.create')); ?>" class="btn-freecycle-outline btn-sm">Create a product first</a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if($errors->any()): ?>
                                            <div class="mb-3 p-3" style="background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 8px;">
                                                <ul class="text-danger-emphasis mb-0">
                                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><?php echo e($error); ?></li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>

                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
                                            <button type="submit" class="btn-freecycle" :disabled="$userProducts->count() === 0">
                                                <i class="fas fa-exchange-alt me-2"></i>Propose Exchange
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/buyer/exchanges/create.blade.php ENDPATH**/ ?>