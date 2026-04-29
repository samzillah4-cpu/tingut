<?php $__env->startSection('title', 'Messages'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-inbox me-2"></i>Messages
                    </h4>
                    <div>
                        <a href="<?php echo e(route('messages.sent')); ?>" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-paper-plane me-1"></i>Sent Messages
                        </a>
                        <a href="<?php echo e(route('messages.create')); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-1"></i>New Message
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <?php if($messages->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('messages.show', $message)); ?>" class="list-group-item list-group-item-action <?php echo e($message->is_read ? '' : 'bg-light'); ?>">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-1">
                                                <h6 class="mb-0 me-2"><?php echo e($message->sender->name); ?></h6>
                                                <?php if(!$message->is_read): ?>
                                                    <span class="badge bg-primary">New</span>
                                                <?php endif; ?>
                                            </div>
                                            <p class="mb-1 text-truncate"><?php echo e($message->subject); ?></p>
                                            <?php if($message->product): ?>
                                                <small class="text-muted">
                                                    <i class="fas fa-box me-1"></i>Regarding: <?php echo e($message->product->title); ?>

                                                </small>
                                            <?php endif; ?>
                                        </div>
                                        <small class="text-muted"><?php echo e($message->created_at->diffForHumans()); ?></small>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="mt-3">
                            <?php echo e($messages->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No messages yet</h5>
                            <p class="text-muted">When someone contacts you about your products, messages will appear here.</p>
                            <a href="<?php echo e(route('messages.create')); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Send First Message
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/messages/inbox.blade.php ENDPATH**/ ?>