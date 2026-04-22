<?php $__env->startSection('title', 'Website Management'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Website Management</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                    <?php echo e(session('success')); ?>

                    <?php if(session('refresh_frontend')): ?>
                        <br><small><a href="<?php echo e(url('/')); ?>?refresh=1" target="_blank" class="alert-link">Click here to view the updated frontend</a></small>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Menu Management -->
        <div class="col-lg-6 col-md-12">
            <!-- Menu Management -->
            <div class="card">
                <div class="card-header" data-widget="collapse">
                    <h3 class="card-title">
                        <i class="fas fa-bars mr-2"></i>Navigation Menu
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addMenuModal">
                            <i class="fas fa-plus"></i> Add Menu Item
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <form id="menuForm" action="<?php echo e(route('admin.website.menus.update')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div id="menuItems">
                            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                             <div class="menu-item mb-3 p-3 border rounded" data-id="<?php echo e($menu->id); ?>">
                                 <input type="hidden" name="menus[<?php echo e($menu->id); ?>][id]" value="<?php echo e($menu->id); ?>">
                                 <div class="row">
                                     <div class="col-md-4">
                                         <div class="form-group">
                                             <label>Menu Name</label>
                                             <input type="text" class="form-control form-control-sm" name="menus[<?php echo e($menu->id); ?>][name]" value="<?php echo e($menu->name); ?>" required>
                                         </div>
                                     </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Link to Page</label>
                                            <select class="form-control form-control-sm menu-page-select" data-menu-id="<?php echo e($menu->id); ?>">
                                                <option value="">Select a page...</option>
                                                <?php $__currentLoopData = $allPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($page['url']); ?>" <?php echo e($menu->url == $page['url'] ? 'selected' : ''); ?>><?php echo e($page['title']); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>URL</label>
                                            <input type="text" class="form-control form-control-sm menu-url-input" name="menus[<?php echo e($menu->id); ?>][url]" value="<?php echo e($menu->url); ?>" placeholder="/" data-menu-id="<?php echo e($menu->id); ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Order</label>
                                            <input type="number" class="form-control form-control-sm" name="menus[<?php echo e($menu->id); ?>][order]" value="<?php echo e($menu->order); ?>" min="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="menus[<?php echo e($menu->id); ?>][is_active]" value="1" <?php echo e($menu->is_active ? 'checked' : ''); ?>>
                                            <label class="form-check-label">Active</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" name="menus[<?php echo e($menu->id); ?>][open_in_new_tab]" value="1" <?php echo e($menu->open_in_new_tab ? 'checked' : ''); ?>>
                                            <label class="form-check-label">Open in new tab</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-danger btn-sm delete-menu" data-id="<?php echo e($menu->id); ?>">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Menu Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Column - Hero Section -->
        <div class="col-lg-6 col-md-12">
            <!-- Hero Section Management -->
            <div class="card">
                <div class="card-header" data-widget="collapse">
                    <h3 class="card-title">
                        <i class="fas fa-image mr-2"></i>Hero Section
                    </h3>
                </div>
                <div class="card-body" style="display: none;">
                    <form action="<?php echo e(route('admin.hero.update')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('POST'); ?>

                        <div class="form-group">
                            <label for="heading">Heading</label>
                            <input type="text" class="form-control" id="heading" name="heading"
                                   value="<?php echo e($hero->heading ?? 'Welcome to TingUt.no'); ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="paragraph">Paragraph Text</label>
                            <textarea class="form-control" id="paragraph" name="paragraph" rows="3"><?php echo e($hero->paragraph ?? ''); ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="background_image">Background Image</label>
                            <input type="file" class="form-control" id="background_image" name="background_image" accept="image/*">
                            <small class="form-text text-muted">Upload a background image for the hero section (recommended: 1920x1080px)</small>
                            <?php if($hero && $hero->background_image): ?>
                                <div class="mt-2">
                                    <img src="<?php echo e(asset('storage/' . $hero->background_image)); ?>" alt="Current Hero Image" style="max-height: 150px; max-width: 100%;">
                                    <p class="text-muted small mt-1">Current background image</p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button1_text">Button 1 Text</label>
                                    <input type="text" class="form-control" id="button1_text" name="button1_text"
                                           value="<?php echo e($hero->button1_text ?? 'Browse Products'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button1_url">Button 1 URL</label>
                                    <input type="text" class="form-control" id="button1_url" name="button1_url"
                                           value="<?php echo e($hero->button1_url ?? '/products'); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button2_text">Button 2 Text</label>
                                    <input type="text" class="form-control" id="button2_text" name="button2_text"
                                           value="<?php echo e($hero->button2_text ?? 'Become a Seller'); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button2_url">Button 2 URL</label>
                                    <input type="text" class="form-control" id="button2_url" name="button2_url"
                                           value="<?php echo e($hero->button2_url ?? '/register'); ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" <?php echo e(($hero && $hero->is_active) ? 'checked' : 'checked'); ?>>
                            <label class="form-check-label" for="is_active">Enable Hero Section</label>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Hero Section
                            </button>
                            <a href="<?php echo e(url('/')); ?>" target="_blank" class="btn btn-info ml-2">
                                <i class="fas fa-external-link-alt"></i> View Frontend
                            </a>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> Changes are applied immediately. Refresh the frontend page to see updates.
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Pages Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header" data-widget="collapse">
                    <h3 class="card-title">
                        <i class="fas fa-file-alt mr-2"></i>Custom Pages
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addPageModal">
                            <i class="fas fa-plus"></i> Add Custom Page
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Predefined Pages -->
                        <div class="col-md-8">
                            <h5>Standard Pages</h5>
                            <p class="text-muted">Create and manage standard website pages like Contact, About, Terms & Conditions.</p>
                            <div class="row">
                                <?php
                                    $standardPages = ['contact', 'about', 'terms', 'privacy'];
                                    $pageLabels = [
                                        'contact' => 'Contact Us',
                                        'about' => 'About Us',
                                        'terms' => 'Terms & Conditions',
                                        'privacy' => 'Privacy Policy'
                                    ];
                                ?>
                                <?php $__currentLoopData = $standardPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pageKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $page = \App\Models\CustomPage::where('slug', $pageKey)->first();
                                    ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card border">
                                            <div class="card-body p-3">
                                                <h6 class="card-title mb-2"><?php echo e($pageLabels[$pageKey] ?? ucfirst($pageKey)); ?></h6>
                                                <?php if($page): ?>
                                                    <p class="card-text small text-muted mb-2"><?php echo e(Str::limit($page->content, 50)); ?></p>
                                                    <div class="d-flex gap-1">
                                                        <a href="<?php echo e(route('admin.pages.edit', $page)); ?>" class="btn btn-outline-primary btn-sm">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        <a href="<?php echo e(route('pages.show', $page->slug)); ?>" target="_blank" class="btn btn-outline-info btn-sm">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <p class="card-text small text-muted mb-2">Page not created yet</p>
                                                    <button type="button" class="btn btn-outline-success btn-sm" onclick="createStandardPage('<?php echo e($pageKey); ?>', '<?php echo e($pageLabels[$pageKey]); ?>')">
                                                        <i class="fas fa-plus"></i> Create
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>

                        <!-- Custom Pages List -->
                        <div class="col-md-4">
                            <h6>Custom Pages</h6>
                            <div class="list-group">
                                <?php
                                    $customPages = \App\Models\CustomPage::whereNotIn('slug', $standardPages)->get();
                                ?>
                                <?php $__empty_1 = true; $__currentLoopData = $customPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?php echo e($page->title); ?></strong>
                                            <br><small class="text-muted">/<?php echo e($page->slug); ?></small>
                                        </div>
                                        <div>
                                            <a href="<?php echo e(route('admin.pages.edit', $page)); ?>" class="btn btn-sm btn-outline-primary me-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?php echo e(route('pages.show', $page->slug)); ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="list-group-item text-center text-muted">
                                        <i class="fas fa-file-alt fa-2x mb-2"></i>
                                        <br>No custom pages yet
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header" data-widget="collapse">
                    <h3 class="card-title">
                        <i class="fas fa-comments mr-2"></i>Customer Testimonials
                    </h3>
                    <div class="card-tools">
                        <a href="<?php echo e(route('admin.testimonials')); ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-cog"></i> Manage Testimonials
                        </a>
                        <a href="<?php echo e(route('admin.testimonials.create')); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Testimonial
                        </a>
                    </div>
                </div>
                <div class="card-body" style="display: none;">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Testimonials Management</h5>
                            <p class="text-muted">Manage customer testimonials that appear on your website to build trust and credibility.</p>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success mr-2"></i> Add customer photos and details</li>
                                <li><i class="fas fa-check text-success mr-2"></i> Control display order with drag & drop</li>
                                <li><i class="fas fa-check text-success mr-2"></i> Enable/disable testimonials</li>
                                <li><i class="fas fa-check text-success mr-2"></i> Full CRUD operations</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6>Quick Actions</h6>
                            <div class="d-flex flex-column gap-2">
                                <a href="<?php echo e(route('admin.testimonials')); ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-list"></i> View All Testimonials
                                </a>
                                <a href="<?php echo e(route('admin.testimonials.create')); ?>" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-plus"></i> Create New Testimonial
                                </a>
                                <a href="<?php echo e(url('/')); ?>" target="_blank" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-external-link-alt"></i> View Website
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Page Modal -->
    <div class="modal fade" id="addPageModal" tabindex="-1" role="dialog" aria-labelledby="addPageModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPageModalLabel">Add New Custom Page</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.pages.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="page_title">Page Title</label>
                            <input type="text" class="form-control" id="page_title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="page_slug">URL Slug</label>
                            <input type="text" class="form-control" id="page_slug" name="slug" placeholder="my-custom-page" required>
                            <small class="form-text text-muted">URL will be: /pages/your-slug</small>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="page_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="page_active">Active</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Page</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Menu Modal -->
    <div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="addMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMenuModalLabel">Add New Menu Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.website.menus.create')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="menu_name">Menu Name</label>
                            <input type="text" class="form-control" id="menu_name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="menu_page">Link to Page (optional)</label>
                            <select class="form-control" id="menu_page">
                                <option value="">Select a page...</option>
                                <?php $__currentLoopData = $allPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($page['url']); ?>"><?php echo e($page['title']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="form-text text-muted">Selecting a page will automatically set the URL</small>
                        </div>
                        <div class="form-group">
                            <label for="menu_url">URL</label>
                            <input type="text" class="form-control" id="menu_url" name="url" placeholder="/">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="menu_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="menu_active">Active</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="menu_new_tab" name="open_in_new_tab" value="1">
                            <label class="form-check-label" for="menu_new_tab">Open in new tab</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Menu Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
$(document).ready(function() {
    // Handle menu item deletion
    $('.delete-menu').on('click', function() {
        var menuId = $(this).data('id');
        if (confirm('Are you sure you want to delete this menu item?')) {
            $.ajax({
                url: '<?php echo e(url("admin/website/menus")); ?>/' + menuId,
                type: 'DELETE',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error deleting menu item');
                }
            });
        }
    });

    // Handle page selection for add menu modal
    $('#menu_page').on('change', function() {
        var selectedUrl = $(this).val();
        $('#menu_url').val(selectedUrl);
    });

    // Handle page selection for edit menu items
    $('.menu-page-select').on('change', function() {
        var selectedUrl = $(this).val();
        var menuId = $(this).data('menu-id');
        $('.menu-url-input[data-menu-id="' + menuId + '"]').val(selectedUrl);
    });

    // Initialize collapsible sections
    $('.card-header[data-widget="collapse"]').on('click', function() {
        var $header = $(this);
        var $card = $header.closest('.card');
        var $body = $card.find('.card-body');

        $body.slideToggle(300, function() {
            $card.toggleClass('collapsed');
        });
    });

    // Add collapse icons to headers (start with plus since sections are collapsed by default)
    $('.card-header[data-widget="collapse"]').each(function() {
        var $header = $(this);
        if (!$header.find('.collapse-icon').length) {
            $header.append('<span class="collapse-icon float-right"><i class="fas fa-plus"></i></span>');
        }
    });

    // Update collapse icons on toggle
    $('.card-header[data-widget="collapse"]').on('click', function() {
        var $icon = $(this).find('.collapse-icon i');
        if ($(this).closest('.card').hasClass('collapsed')) {
            $icon.removeClass('fa-minus').addClass('fa-plus');
        } else {
            $icon.removeClass('fa-plus').addClass('fa-minus');
        }
    });
});

// Function to create standard pages
function createStandardPage(slug, title) {
    // Create form data
    var formData = new FormData();
    formData.append('_token', '<?php echo e(csrf_token()); ?>');
    formData.append('title', title);
    formData.append('slug', slug);
    formData.append('is_active', '1');

    // Add default content based on page type
    var defaultContent = getDefaultContent(slug);
    formData.append('content', defaultContent);

    // Submit the form
    $.ajax({
        url: '<?php echo e(route("admin.pages.store")); ?>',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                location.reload();
            } else {
                alert('Error creating page: ' + (response.message || 'Unknown error'));
            }
        },
        error: function(xhr) {
            alert('Error creating page');
        }
    });
}

function getDefaultContent(slug) {
    var contents = {
        'contact': '<h2>Contact Us</h2>\n<p>Get in touch with us for any questions or inquiries.</p>\n\n<h3>Our Contact Information</h3>\n<p><strong>Email:</strong> contact@tingut.no</p>\n<p><strong>Phone:</strong> +47 123 456 789</p>\n<p><strong>Address:</strong> Oslo, Norway</p>\n\n<h3>Send us a Message</h3>\n<p>Use the contact form on our website or reach out directly using the information above.</p>',
        'about': '<h2>About Us</h2>\n<p>Welcome to TingUt.no, your trusted platform for bartering goods and services.</p>\n\n<h3>Our Mission</h3>\n<p>To create a sustainable community where people can exchange items they no longer need for things they want, reducing waste and promoting reuse.</p>\n\n<h3>What We Do</h3>\n<p>TingUt.no connects people who want to trade goods and services in a safe, easy, and environmentally friendly way. Our platform makes it simple to find what you need and give new life to items you no longer use.</p>',
        'terms': '<h2>Terms & Conditions</h2>\n<p>These terms and conditions outline the rules and regulations for the use of TingUt.no.</p>\n\n<h3>Acceptance of Terms</h3>\n<p>By accessing this website, you accept these terms and conditions in full. If you disagree with any part of these terms, you must not use our website.</p>\n\n<h3>User Responsibilities</h3>\n<p>Users are responsible for maintaining the confidentiality of their account information and for all activities that occur under their account.</p>\n\n<h3>Prohibited Activities</h3>\n<p>Users may not engage in illegal activities, post false information, or violate the rights of others through our platform.</p>',
        'privacy': '<h2>Privacy Policy</h2>\n<p>This privacy policy explains how we collect, use, and protect your personal information.</p>\n\n<h3>Information We Collect</h3>\n<p>We collect information you provide directly to us, such as when you create an account, list products, or contact us.</p>\n\n<h3>How We Use Your Information</h3>\n<p>We use your information to provide our services, communicate with you, and improve our platform.</p>\n\n<h3>Information Sharing</h3>\n<p>We do not sell, trade, or rent your personal information to third parties without your consent, except as described in this policy.</p>'
    };

    return contents[slug] || '<h2>' + slug.charAt(0).toUpperCase() + slug.slice(1) + '</h2>\n<p>Content for this page will be added soon.</p>';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/admin/website/index.blade.php ENDPATH**/ ?>