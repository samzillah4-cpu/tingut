<?php $layoutHelper = app('JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper'); ?>

<nav class="main-header navbar
    <?php echo e(config('adminlte.classes_topnav_nav', 'navbar-expand')); ?>

    navbar-dark bg-primary">

    
    <ul class="navbar-nav">
        
        <?php echo $__env->make('adminlte::partials.navbar.menu-item-left-sidebar-toggler', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        
        <li class="nav-item">
            <div class="navbar-search ml-3">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar bg-light" type="search" placeholder="Search products, users..." aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar bg-light" type="submit">
                                <i class="fas fa-search text-dark"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        
        <?php echo $__env->renderEach('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-left'), 'item'); ?>

        
        <?php echo $__env->yieldContent('content_top_nav_left'); ?>
    </ul>

    
    <ul class="navbar-nav ml-auto">
        
        <?php echo $__env->yieldContent('content_top_nav_right'); ?>

        
        <?php echo $__env->renderEach('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item'); ?>

        
        <?php if(Auth::user()): ?>
            <?php if(config('adminlte.usermenu_enabled')): ?>
                <?php echo $__env->make('adminlte::partials.navbar.menu-item-dropdown-user-menu', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('adminlte::partials.navbar.menu-item-logout-link', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        <?php endif; ?>

        
        <?php if($layoutHelper->isRightSidebarEnabled()): ?>
            <?php echo $__env->make('adminlte::partials.navbar.menu-item-right-sidebar-toggler', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endif; ?>
    </ul>

</nav>
<?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/vendor/adminlte/partials/navbar/navbar.blade.php ENDPATH**/ ?>