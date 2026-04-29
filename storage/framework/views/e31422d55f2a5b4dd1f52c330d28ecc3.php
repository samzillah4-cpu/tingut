<?php $__env->startSection('title', 'Edit Home Sale'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Edit Home Sale</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; background-color: var(--primary-color);">
                    <i class="fas fa-edit text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0">Edit Home Sale</h5>
                    <small class="text-muted">Update the details below</small>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="<?php echo e(route('admin.home-sales.update', $homeSale)); ?>" method="POST" enctype="multipart/form-data" id="homeSaleForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="title" name="title" value="<?php echo e(old('title', $homeSale->title)); ?>" required>
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status">
                                <option value="active" <?php echo e(old('status', $homeSale->status) === 'active' ? 'selected' : ''); ?>>Active</option>
                                <option value="inactive" <?php echo e(old('status', $homeSale->status) === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="description" name="description" rows="4" required><?php echo e(old('description', $homeSale->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="invalid-feedback" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sale_date_from">Sale Date From <span class="text-danger">*</span></label>
                            <input type="date" class="form-control <?php $__errorArgs = ['sale_date_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="sale_date_from" name="sale_date_from" value="<?php echo e(old('sale_date_from', $homeSale->sale_date_from->format('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['sale_date_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sale_date_to">Sale Date To <span class="text-danger">*</span></label>
                            <input type="date" class="form-control <?php $__errorArgs = ['sale_date_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="sale_date_to" name="sale_date_to" value="<?php echo e(old('sale_date_to', $homeSale->sale_date_to->format('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['sale_date_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="location">Location <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="location" name="location" value="<?php echo e(old('location', $homeSale->location)); ?>" placeholder="e.g., Oslo" required>
                            <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="address" name="address" value="<?php echo e(old('address', $homeSale->address)); ?>" placeholder="Street address">
                            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="city" name="city" value="<?php echo e(old('city', $homeSale->city)); ?>" placeholder="City">
                            <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback" role="alert">
                                    <strong><?php echo e($message); ?></strong>
                                </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="images">Images (Leave empty to keep existing images)</label>
                    <?php if($homeSale->images && count($homeSale->images) > 0): ?>
                        <div class="row mb-3">
                            <?php $__currentLoopData = $homeSale->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-3">
                                    <?php if(str_starts_with($image, 'http')): ?>
                                        <img src="<?php echo e($image); ?>" alt="Home Sale Image" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="Home Sale Image" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="images" name="images[]" multiple accept="image/*">
                        <label class="custom-file-label" for="images">Choose new images</label>
                    </div>
                    <small class="form-text text-muted">Upload new images to replace existing ones (max 2MB each)</small>
                    <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-danger" role="alert">
                            <strong><?php echo e($message); ?></strong>
                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" value="1" <?php echo e(old('is_featured', $homeSale->is_featured) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="is_featured">
                            Feature this home sale (will be displayed prominently)
                        </label>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Available Items Section -->
                <div class="items-section">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Available Items</h4>
                        <button type="button" class="btn" style="background-color: var(--primary-color); color: white;" onclick="addItem()">
                            <i class="fas fa-plus mr-1"></i>Add Item
                        </button>
                    </div>

                    <p class="text-muted mb-3">Add or update items that will be available at this home sale. Each item can have an image, name, description, category, condition, and price.</p>

                    <!-- Existing Items -->
                    <?php if($homeSale->items->count() > 0): ?>
                        <div class="mb-4">
                            <h5 class="mb-3">Current Items</h5>
                            <?php $__currentLoopData = $homeSale->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="item-card" id="existing-item-<?php echo e($index); ?>">
                                    <button type="button" class="remove-item-btn" onclick="removeExistingItem(<?php echo e($index); ?>, <?php echo e($item->id); ?>)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <input type="hidden" name="existing_item_ids[]" value="<?php echo e($item->id); ?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <?php if($item->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $item->image)); ?>" class="item-image-preview" alt="<?php echo e($item->name); ?>">
                                            <?php else: ?>
                                                <div class="image-upload-area" onclick="document.getElementById('existing-item-image-<?php echo e($index); ?>').click()">
                                                    <i class="fas fa-camera"></i>
                                                </div>
                                            <?php endif; ?>
                                            <input type="file" class="d-none" id="existing-item-image-<?php echo e($index); ?>" name="existing_item_images[]" accept="image/*" onchange="previewItemImage(event, 'existing-<?php echo e($index); ?>')">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label>Item Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="existing_item_names[]" value="<?php echo e($item->name); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Price (NOK)</label>
                                                        <input type="number" class="form-control" name="existing_item_prices[]" step="0.01" min="0" value="<?php echo e($item->price); ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Category</label>
                                                        <select class="form-control" name="existing_item_categories[]">
                                                            <option value="">Select category</option>
                                                            <option value="Furniture" <?php echo e($item->category === 'Furniture' ? 'selected' : ''); ?>>Furniture</option>
                                                            <option value="Electronics" <?php echo e($item->category === 'Electronics' ? 'selected' : ''); ?>>Electronics</option>
                                                            <option value="Clothing" <?php echo e($item->category === 'Clothing' ? 'selected' : ''); ?>>Clothing</option>
                                                            <option value="Books" <?php echo e($item->category === 'Books' ? 'selected' : ''); ?>>Books</option>
                                                            <option value="Toys" <?php echo e($item->category === 'Toys' ? 'selected' : ''); ?>>Toys</option>
                                                            <option value="Kitchenware" <?php echo e($item->category === 'Kitchenware' ? 'selected' : ''); ?>>Kitchenware</option>
                                                            <option value="Garden" <?php echo e($item->category === 'Garden' ? 'selected' : ''); ?>>Garden</option>
                                                            <option value="Sports" <?php echo e($item->category === 'Sports' ? 'selected' : ''); ?>>Sports</option>
                                                            <option value="Other" <?php echo e($item->category === 'Other' ? 'selected' : ''); ?>>Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Condition</label>
                                                        <select class="form-control" name="existing_item_conditions[]">
                                                            <option value="">Select condition</option>
                                                            <option value="New" <?php echo e($item->condition === 'New' ? 'selected' : ''); ?>>New</option>
                                                            <option value="Like New" <?php echo e($item->condition === 'Like New' ? 'selected' : ''); ?>>Like New</option>
                                                            <option value="Good" <?php echo e($item->condition === 'Good' ? 'selected' : ''); ?>>Good</option>
                                                            <option value="Fair" <?php echo e($item->condition === 'Fair' ? 'selected' : ''); ?>>Fair</option>
                                                            <option value="Poor" <?php echo e($item->condition === 'Poor' ? 'selected' : ''); ?>>Poor</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea class="form-control" name="existing_item_descriptions[]" rows="2"><?php echo e($item->description); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                    <div id="items-container">
                        <!-- New items will be added here dynamically -->
                    </div>

                    <div id="no-items-message" class="text-center py-4 bg-light rounded" style="<?php echo e($homeSale->items->count() > 0 ? 'display: none;' : ''); ?>">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <p class="text-muted mb-0">No items added yet. Click "Add Item" to add items.</p>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn px-4" style="border-radius: 8px; background-color: var(--primary-color); color: white; border-color: var(--primary-color);">
                        <i class="fas fa-save me-2"></i>Update Home Sale
                    </button>
                    <a href="<?php echo e(route('admin.home-sales.index')); ?>" class="btn btn-outline-secondary ml-2">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </form>
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

        .form-control:focus, .custom-file-input:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(26, 105, 105, 0.25) !important;
        }

        .btn:hover {
            background-color: #146060 !important;
            border-color: #146060 !important;
        }

        .item-card {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .item-card .item-image-preview {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
            background: #e9ecef;
        }

        .item-card .image-upload-area {
            width: 100%;
            height: 150px;
            border: 2px dashed #ccc;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: #f8f9fa;
            transition: all 0.2s;
        }

        .item-card .image-upload-area:hover {
            border-color: var(--primary-color);
            background: rgba(26, 105, 105, 0.05);
        }

        .item-card .image-upload-area i {
            font-size: 2rem;
            color: #ccc;
        }

        .remove-item-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0.8;
            z-index: 10;
        }

        .remove-item-btn:hover {
            opacity: 1;
        }

        .item-card {
            position: relative;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script>
        let itemCounter = 0;
        const existingItemCount = <?php echo e($homeSale->items->count()); ?>;

        function addItem() {
            const container = document.getElementById('items-container');
            const noItemsMessage = document.getElementById('no-items-message');

            noItemsMessage.style.display = 'none';

            const newItemCounter = existingItemCount + itemCounter;

            const itemHtml = `
                <div class="item-card" id="item-${newItemCounter}">
                    <button type="button" class="remove-item-btn" onclick="removeItem(${newItemCounter})">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="image-upload-area" onclick="document.getElementById('item-image-${newItemCounter}').click()">
                                <i class="fas fa-camera"></i>
                            </div>
                            <input type="file" class="d-none" id="item-image-${newItemCounter}" name="item_images[]" accept="image/*" onchange="previewItemImage(event, ${newItemCounter})">
                            <input type="hidden" id="item-image-name-${newItemCounter}" name="item_image_names[]">
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Item Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="item_names[]" placeholder="Enter item name" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Price (NOK)</label>
                                        <input type="number" class="form-control" name="item_prices[]" step="0.01" min="0" placeholder="0.00">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-control" name="item_categories[]">
                                            <option value="">Select category</option>
                                            <option value="Furniture">Furniture</option>
                                            <option value="Electronics">Electronics</option>
                                            <option value="Clothing">Clothing</option>
                                            <option value="Books">Books</option>
                                            <option value="Toys">Toys</option>
                                            <option value="Kitchenware">Kitchenware</option>
                                            <option value="Garden">Garden</option>
                                            <option value="Sports">Sports</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Condition</label>
                                        <select class="form-control" name="item_conditions[]">
                                            <option value="">Select condition</option>
                                            <option value="New">New</option>
                                            <option value="Like New">Like New</option>
                                            <option value="Good">Good</option>
                                            <option value="Fair">Fair</option>
                                            <option value="Poor">Poor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="item_descriptions[]" rows="2" placeholder="Describe the item"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', itemHtml);
            itemCounter++;
        }

        function removeItem(id) {
            const itemCard = document.getElementById(`item-${id}`);
            itemCard.remove();

            checkItemsDisplay();
        }

        function removeExistingItem(index, itemId) {
            // Mark item for deletion
            if (confirm('Are you sure you want to remove this item?')) {
                const itemCard = document.getElementById(`existing-item-${index}`);

                // Add a hidden input to mark this item for deletion
                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'delete_item_ids[]';
                deleteInput.value = itemId;
                itemCard.appendChild(deleteInput);

                itemCard.style.display = 'none';
                checkItemsDisplay();
            }
        }

        function checkItemsDisplay() {
            const container = document.getElementById('items-container');
            const noItemsMessage = document.getElementById('no-items-message');
            const existingItems = document.querySelectorAll('[id^="existing-item-"]:not([style*="display: none"])');

            if (container.children.length === 0 && existingItems.length === 0) {
                noItemsMessage.style.display = 'block';
            } else {
                noItemsMessage.style.display = 'none';
            }
        }

        function previewItemImage(event, id) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const uploadArea = event.target.parentElement;
                    uploadArea.innerHTML = `<img src="${e.target.result}" class="item-image-preview" alt="Item preview">`;
                    document.getElementById(`item-image-name-${id}`).value = file.name;
                };
                reader.readAsDataURL(file);
            }
        }

        // Update custom file input label
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = e.target.files.length + ' file(s) selected';
            e.target.nextElementSibling.innerText = fileName;
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/admin/home-sales/edit.blade.php ENDPATH**/ ?>