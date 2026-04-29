<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <div style="padding-top: 2rem;"></div>


    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Users -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <div class="card border-0 shadow-xl stat-card glass-effect" style="background: linear-gradient(135deg, #165c60 0%, #1a6b6d 100%); color: white; border-radius: 16px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body p-3 text-center position-relative">
                    <div class="stat-bg-shape"></div>
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon-wrapper">
                            <i class="fas fa-users stat-icon"></i>
                        </div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up text-white-70"></i>
                        </div>
                    </div>
                    <h4 class="mb-2 fw-bold display-6"><?php echo e($totalUsers); ?></h4>
                    <p class="mb-2 opacity-90 small fw-medium">Total Users</p>
                    <div class="progress mt-2" style="height: 4px; border-radius: 2px;">
                        <div class="progress-bar bg-white opacity-90" style="width: 75%; border-radius: 2px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Products -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <div class="card border-0 shadow-xl stat-card glass-effect" style="background: linear-gradient(135deg, #1a6b6d 0%, #165c60 100%); color: white; border-radius: 16px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body p-3 text-center position-relative">
                    <div class="stat-bg-shape"></div>
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon-wrapper">
                            <i class="fas fa-box stat-icon"></i>
                        </div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up text-white-70"></i>
                        </div>
                    </div>
                    <h4 class="mb-2 fw-bold display-6"><?php echo e($activeProducts); ?></h4>
                    <p class="mb-2 opacity-90 small fw-medium">Active Products</p>
                    <div class="progress mt-2" style="height: 4px; border-radius: 2px;">
                        <div class="progress-bar bg-white opacity-90" style="width: 85%; border-radius: 2px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Exchanges -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <div class="card border-0 shadow-xl stat-card glass-effect" style="background: linear-gradient(135deg, #f9f2d6 0%, #f0e8c9 100%); color: #165c60; border-radius: 16px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); backdrop-filter: blur(20px); border: 1px solid rgba(249,242,214,0.2);">
                <div class="card-body p-3 text-center position-relative">
                    <div class="stat-bg-shape" style="background: rgba(22,92,96,0.1);"></div>
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon-wrapper" style="background: rgba(22,92,96,0.2);">
                            <i class="fas fa-exchange-alt stat-icon" style="color: #165c60;"></i>
                        </div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up text-muted"></i>
                        </div>
                    </div>
                    <h4 class="mb-2 fw-bold display-6"><?php echo e($totalExchanges); ?></h4>
                    <p class="mb-2 opacity-90 small fw-medium">Total Exchanges</p>
                    <div class="progress mt-2" style="height: 4px; border-radius: 2px;">
                        <div class="progress-bar" style="width: 65%; background-color: #165c60; border-radius: 2px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Exchanges -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <div class="card border-0 shadow-xl stat-card glass-effect" style="background: linear-gradient(135deg, #ffa726 0%, #fb8c00 100%); color: white; border-radius: 16px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body p-3 text-center position-relative">
                    <div class="stat-bg-shape"></div>
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon-wrapper">
                            <i class="fas fa-clock stat-icon"></i>
                        </div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up text-white-70"></i>
                        </div>
                    </div>
                    <h4 class="mb-2 fw-bold display-6"><?php echo e($pendingExchanges); ?></h4>
                    <p class="mb-2 opacity-90 small fw-medium">Pending Exchanges</p>
                    <div class="progress mt-2" style="height: 4px; border-radius: 2px;">
                        <div class="progress-bar bg-white opacity-90" style="width: 60%; border-radius: 2px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Rentals -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <div class="card border-0 shadow-xl stat-card glass-effect" style="background: linear-gradient(135deg, #42a5f5 0%, #1976d2 100%); color: white; border-radius: 16px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body p-3 text-center position-relative">
                    <div class="stat-bg-shape"></div>
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon-wrapper">
                            <i class="fas fa-calendar-alt stat-icon"></i>
                        </div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up text-white-70"></i>
                        </div>
                    </div>
                    <h4 class="mb-2 fw-bold display-6"><?php echo e($totalRentals); ?></h4>
                    <p class="mb-2 opacity-90 small fw-medium">Total Rentals</p>
                    <div class="progress mt-2" style="height: 4px; border-radius: 2px;">
                        <div class="progress-bar bg-white opacity-90" style="width: 70%; border-radius: 2px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="col-xl-2 col-lg-4 col-md-6">
            <div class="card border-0 shadow-xl stat-card glass-effect" style="background: linear-gradient(135deg, #165c60 0%, #165c60 100%); color: white; border-radius: 16px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-body p-3 text-center position-relative">
                    <div class="stat-bg-shape"></div>
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon-wrapper">
                            <i class="fas fa-tags stat-icon"></i>
                        </div>
                        <div class="stat-trend">
                            <i class="fas fa-arrow-up text-white-70"></i>
                        </div>
                    </div>
                    <h4 class="mb-2 fw-bold display-6"><?php echo e($totalCategories); ?></h4>
                    <p class="mb-2 opacity-90 small fw-medium">Categories</p>
                    <div class="progress mt-2" style="height: 4px; border-radius: 2px;">
                        <div class="progress-bar bg-white opacity-90" style="width: 90%; border-radius: 2px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics and Activity Section -->
    <div class="row g-4 mb-4">
        <!-- Enhanced User Distribution Chart -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-xl h-100 chart-card glass-effect" style="border-radius: 20px; backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-header bg-transparent border-0 py-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold text-primary">
                                <i class="fas fa-chart-pie me-2 text-primary"></i>User Distribution Analytics
                            </h5>
                            <p class="text-muted mb-0 small">Breakdown of user roles and activity</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle sleek-btn" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i>This Month
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">This Week</a></li>
                                <li><a class="dropdown-item" href="#">This Month</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center p-4 position-relative">
                    <div class="chart-bg-pattern"></div>
                    <div class="chart-container">
                        <canvas id="userChart" style="max-width: 100%; max-height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Growth Chart -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-xl h-100 chart-card glass-effect" style="border-radius: 20px; backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-header bg-transparent border-0 py-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold text-primary">
                                <i class="fas fa-chart-line me-2 text-primary"></i>Monthly Growth Trends
                            </h5>
                            <p class="text-muted mb-0 small">User, product, and exchange growth over time</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle sleek-btn" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-calendar me-1"></i>Last 12 Months
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                                <li><a class="dropdown-item" href="#">Last 12 Months</a></li>
                                <li><a class="dropdown-item" href="#">This Year</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center p-4 position-relative">
                    <div class="chart-bg-pattern"></div>
                    <div class="chart-container">
                        <canvas id="growthChart" style="max-width: 100%; max-height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Analytics Section -->
    <div class="row g-4 mb-4">
        <!-- Exchange Status Chart -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-xl h-100 chart-card glass-effect" style="border-radius: 20px; backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-header bg-transparent border-0 py-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold text-primary">
                                <i class="fas fa-exchange-alt me-2 text-primary"></i>Exchange Status Overview
                            </h5>
                            <p class="text-muted mb-0 small">Current status of all exchanges</p>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center p-4 position-relative">
                    <div class="chart-bg-pattern"></div>
                    <div class="chart-container">
                        <canvas id="exchangeChart" style="max-width: 100%; max-height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Status Chart -->
        <div class="col-xl-6">
            <div class="card border-0 shadow-xl h-100 chart-card glass-effect" style="border-radius: 20px; backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1);">
                <div class="card-header bg-transparent border-0 py-4 px-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-1 fw-bold text-primary">
                                <i class="fas fa-box me-2 text-primary"></i>Product Status Distribution
                            </h5>
                            <p class="text-muted mb-0 small">Active vs inactive products</p>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center p-4 position-relative">
                    <div class="chart-bg-pattern"></div>
                    <div class="chart-container">
                        <canvas id="productChart" style="max-width: 100%; max-height: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Section -->
    <div class="row g-4">

        <!-- Recent Activity Feed -->
        <div class="col-xl-4">
            <div class="card border-0 shadow-lg h-100" style="border-radius: 16px;">
                <div class="card-header bg-white border-0 py-4 px-4">
                    <h5 class="mb-1 fw-bold" style="color: var(--primary-color);">
                        <i class="fas fa-bolt me-2"></i>Recent Activity
                    </h5>
                    <p class="text-muted mb-0 small">Latest platform updates</p>
                </div>
                <div class="card-body p-4">
                    <div class="activity-feed">
                        <!-- Recent Users -->
                        <div class="activity-item mb-4">
                            <div class="d-flex align-items-start">
                                <div class="activity-icon bg-primary text-white me-3">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small fw-bold">New User Registration</h6>
                                    <?php if($recentUsers->count() > 0): ?>
                                        <p class="mb-1 small text-muted"><?php echo e($recentUsers->first()->name); ?> joined as <?php echo e($recentUsers->first()->roles->first()?->name ?? 'User'); ?></p>
                                        <small class="text-muted"><?php echo e($recentUsers->first()->created_at->diffForHumans()); ?></small>
                                    <?php else: ?>
                                        <p class="mb-1 small text-muted">No recent registrations</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Products -->
                        <div class="activity-item mb-4">
                            <div class="d-flex align-items-start">
                                <div class="activity-icon bg-success text-white me-3">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small fw-bold">New Product Listed</h6>
                                    <?php if($recentProducts->count() > 0): ?>
                                        <p class="mb-1 small text-muted">"<?php echo e(Str::limit($recentProducts->first()->title, 20)); ?>" by <?php echo e($recentProducts->first()->user->name); ?></p>
                                        <small class="text-muted"><?php echo e($recentProducts->first()->created_at->diffForHumans()); ?></small>
                                    <?php else: ?>
                                        <p class="mb-1 small text-muted">No recent listings</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Exchanges -->
                        <div class="activity-item">
                            <div class="d-flex align-items-start">
                                <div class="activity-icon bg-warning text-white me-3">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small fw-bold">Exchange Initiated</h6>
                                    <?php if($recentExchanges->count() > 0): ?>
                                        <p class="mb-1 small text-muted"><?php echo e(Str::limit($recentExchanges->first()->offeredProduct->title, 15)); ?> ↔ <?php echo e(Str::limit($recentExchanges->first()->requestedProduct->title, 15)); ?></p>
                                        <small class="text-muted"><?php echo e($recentExchanges->first()->created_at->diffForHumans()); ?></small>
                                    <?php else: ?>
                                        <p class="mb-1 small text-muted">No recent exchanges</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top">
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-outline-primary btn-sm me-2">
                            <i class="fas fa-users me-1"></i>View Users
                        </a>
                        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-success btn-sm me-2">
                            <i class="fas fa-box me-1"></i>View Products
                        </a>
                        <a href="<?php echo e(route('admin.exchanges.index')); ?>" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-exchange-alt me-1"></i>View Exchanges
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-xl glass-effect" style="border-radius: 20px; backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.8);">
                <div class="card-header bg-transparent border-0 py-4 px-4">
                    <h5 class="mb-1 fw-bold text-primary">
                        <i class="fas fa-rocket me-2 text-primary"></i>Quick Actions
                    </h5>
                    <p class="text-muted mb-0 small">Common administrative tasks</p>
                </div>
                <div class="card-body p-4 position-relative">
                    <div class="quick-actions-bg-pattern"></div>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="<?php echo e(route('admin.users.create')); ?>" class="text-decoration-none">
                                <div class="quick-action-card text-center p-3 sleek-action" style="border-radius: 16px; background: linear-gradient(135deg, #165c60 0%, #1a6b6d 100%); color: white; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                                    <i class="fas fa-user-plus fa-2x mb-2"></i>
                                    <h6 class="mb-0 fw-medium">Add User</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo e(route('admin.categories.create')); ?>" class="text-decoration-none">
                                <div class="quick-action-card text-center p-3 sleek-action" style="border-radius: 16px; background: linear-gradient(135deg, #1a6b6d 0%, #165c60 100%); color: white; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                                    <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                    <h6 class="mb-0 fw-medium">Add Category</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo e(route('admin.settings')); ?>" class="text-decoration-none">
                                <div class="quick-action-card text-center p-3 sleek-action" style="border-radius: 16px; background: linear-gradient(135deg, #f9f2d6 0%, #f0e8c9 100%); color: #165c60; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); backdrop-filter: blur(10px); border: 1px solid rgba(249,242,214,0.3);">
                                    <i class="fas fa-cog fa-2x mb-2"></i>
                                    <h6 class="mb-0 fw-medium">Settings</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="<?php echo e(route('admin.blogs.index')); ?>" class="text-decoration-none">
                                <div class="quick-action-card text-center p-3 sleek-action" style="border-radius: 16px; background: linear-gradient(135deg, #165c60 0%, #165c60 100%); color: white; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1);">
                                    <i class="fas fa-blog fa-2x mb-2"></i>
                                    <h6 class="mb-0 fw-medium">Manage Blog</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/adminlte-custom.css')); ?>">
    <style>
        :root {
            --primary-color: #165c60;
            --secondary-color: #1a6b6d;
            --shadow-light: 0 2px 10px rgba(0,0,0,0.08);
            --shadow-medium: 0 4px 20px rgba(0,0,0,0.12);
            --shadow-heavy: 0 8px 30px rgba(0,0,0,0.15);
        }

        body {
            background: linear-gradient(135deg, #f9f2d6 0%, #f0e8c9 100%);
            min-height: 100vh;
        }

        .main-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
        }

        .main-header .navbar-nav .nav-link {
            color: white !important;
        }

        .main-header .navbar-brand {
            color: white !important;
        }



        .card {
            border-radius: 16px;
            border: none;
            box-shadow: var(--shadow-light);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            box-shadow: var(--shadow-medium);
            transform: translateY(-2px);
        }

        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 120px;
            height: 120px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            transform: translate(40px, -40px);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card:hover::before {
            transform: translate(30px, -30px);
        }

        .stat-bg-shape {
            position: absolute;
            top: -20px;
            right: -20px;
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .welcome-banner {
            position: relative;
            overflow: hidden;
        }

        .welcome-bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255,255,255,0.05) 0%, transparent 50%);
            animation: patternShift 20s ease-in-out infinite;
        }

        .welcome-icon-container {
            position: relative;
            display: inline-block;
        }

        .welcome-icon {
            font-size: 4rem;
            opacity: 0.2;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
            animation: iconPulse 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(180deg); }
        }

        @keyframes patternShift {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(10px, -10px) scale(1.05); }
            66% { transform: translate(-10px, 10px) scale(0.95); }
        }

        @keyframes iconPulse {
            0%, 100% { transform: scale(1); opacity: 0.2; }
            50% { transform: scale(1.1); opacity: 0.3; }
        }

        .stat-icon-wrapper {
            background: rgba(255,255,255,0.2);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon {
            font-size: 1.2rem;
            opacity: 0.9;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        .stat-trend {
            font-size: 0.8rem;
        }

        .progress {
            background: rgba(255,255,255,0.2);
            border-radius: 2px;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
            z-index: 2;
        }

        .chart-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .chart-bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 25% 25%, rgba(22, 92, 96, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(249, 242, 214, 0.03) 0%, transparent 50%);
            animation: patternShift 15s ease-in-out infinite;
            z-index: 1;
        }

        .sleek-btn {
            border-radius: 12px;
            border: 2px solid;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
        }

        .sleek-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(22, 92, 96, 0.15);
            background: rgba(22, 92, 96, 0.1);
        }

        .activity-feed {
            max-height: 400px;
            overflow-y: auto;
        }

        .activity-item {
            border-left: 3px solid transparent;
            padding-left: 15px;
            margin-bottom: 20px;
            transition: border-left-color 0.3s ease;
        }

        .activity-item:hover {
            border-left-color: var(--primary-color);
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .quick-action-card {
            height: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .quick-action-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-heavy);
        }

        .sleek-action {
            position: relative;
            overflow: hidden;
        }

        .sleek-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sleek-action:hover::before {
            left: 100%;
        }

        .quick-actions-bg-pattern {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(22, 92, 96, 0.02) 0%, transparent 50%),
                radial-gradient(circle at 90% 80%, rgba(249, 242, 214, 0.02) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(255, 167, 38, 0.01) 0%, transparent 50%);
            animation: patternShift 25s ease-in-out infinite;
            z-index: 1;
        }

        .quick-action-card {
            position: relative;
            z-index: 2;
        }

        .btn {
            border-radius: 10px !important;
            font-weight: 600;
            padding: 8px 16px;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-medium);
        }

        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 6px;
        }

        .dropdown-menu {
            border-radius: 12px;
            border: none;
            box-shadow: var(--shadow-medium);
        }

        .dropdown-item {
            padding: 10px 16px;
            transition: background-color 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(102, 126, 234, 0.1);
        }

        /* Custom scrollbar */
        .activity-feed::-webkit-scrollbar {
            width: 6px;
        }

        .activity-feed::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .activity-feed::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 3px;
        }

        .activity-feed::-webkit-scrollbar-thumb:hover {
            background: #5a67d8;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .chart-container {
                height: 250px;
            }

            .stat-card .card-body {
                padding: 20px !important;
            }

            .welcome-banner .card-body {
                padding: 24px !important;
            }

            .welcome-icon {
                font-size: 3rem !important;
            }

            .quick-action-card {
                padding: 16px !important;
            }

            .quick-action-card i {
                font-size: 1.5rem !important;
                margin-bottom: 8px !important;
            }

            .sleek-action {
                margin-bottom: 8px;
            }

            .chart-card {
                margin-bottom: 16px;
            }
        }

        @media (max-width: 480px) {
            .stat-card {
                margin-bottom: 12px;
            }

            .welcome-banner h2 {
                font-size: 1.5rem !important;
            }

            .welcome-icon {
                font-size: 2.5rem !important;
            }

            .quick-action-card {
                padding: 12px !important;
            }

            .quick-action-card i {
                font-size: 1.2rem !important;
                margin-bottom: 6px !important;
            }
        }

        /* Animation for loading */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card {
            animation: fadeInUp 0.6s ease-out;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        /* Custom tab styles */
        .nav-tabs .nav-link {
            border: none;
            border-radius: 12px 12px 0 0;
            margin-right: 4px;
            padding: 12px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.tab-users {
            background: linear-gradient(135deg, #165c60 0%, #1a6b6d 100%);
            color: white;
        }

        .nav-tabs .nav-link.tab-users:hover,
        .nav-tabs .nav-link.tab-users.active {
            background: linear-gradient(135deg, #1a6b6d 0%, #165c60 100%);
            color: white;
            box-shadow: 0 4px 8px rgba(22, 92, 96, 0.3);
        }

        .nav-tabs .nav-link.tab-products {
            background: linear-gradient(135deg, #1a6b6d 0%, #165c60 100%);
            color: white;
        }

        .nav-tabs .nav-link.tab-products:hover,
        .nav-tabs .nav-link.tab-products.active {
            background: linear-gradient(135deg, #165c60 0%, #165c60 100%);
            color: white;
            box-shadow: 0 4px 8px rgba(26, 107, 109, 0.3);
        }

        .nav-tabs .nav-link.tab-exchanges {
            background: linear-gradient(135deg, #f9f2d6 0%, #f0e8c9 100%);
            color: #165c60;
        }

        .nav-tabs .nav-link.tab-exchanges:hover,
        .nav-tabs .nav-link.tab-exchanges.active {
            background: linear-gradient(135deg, #f0e8c9 0%, #e8dcc0 100%);
            color: #165c60;
            box-shadow: 0 4px 8px rgba(249, 242, 214, 0.3);
        }

        .nav-tabs .nav-link.tab-categories {
            background: linear-gradient(135deg, #165c60 0%, #165c60 100%);
            color: white;
        }

        .nav-tabs .nav-link.tab-categories:hover,
        .nav-tabs .nav-link.tab-categories.active {
            background: linear-gradient(135deg, #165c60 0%, #1a6b6d 100%);
            color: white;
            box-shadow: 0 4px 8px rgba(22, 92, 96, 0.3);
        }

        .stat-content {
            transition: all 0.3s ease;
            box-shadow: var(--shadow-light);
        }

        .stat-content:hover {
            box-shadow: var(--shadow-medium);
            transform: translateY(-2px);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    // Enhanced User Statistics Chart
    const ctx = document.getElementById('userChart');
    if (ctx) {
        const gradient1 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient1.addColorStop(0, '#165c60');
        gradient1.addColorStop(1, '#1a6b6d');

        const gradient2 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient2.addColorStop(0, '#1a6b6d');
        gradient2.addColorStop(1, '#165c60');

        const gradient3 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        gradient3.addColorStop(0, '#f9f2d6');
        gradient3.addColorStop(1, '#f0e8c9');

        const userChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Admins', 'Sellers', 'Buyers'],
                datasets: [{
                    data: <?php echo e(json_encode([$adminCount, $sellerCount, $buyerCount])); ?>,
                    backgroundColor: [
                        gradient1,
                        gradient2,
                        gradient3
                    ],
                    borderWidth: 0,
                    hoverBorderWidth: 3,
                    hoverBorderColor: '#fff',
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 25,
                            usePointStyle: true,
                            font: {
                                size: 14,
                                weight: '600',
                                family: "'Inter', sans-serif"
                            },
                            color: '#4a5568'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.9)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        cornerRadius: 12,
                        displayColors: true,
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '65%',
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 2000,
                    easing: 'easeInOutQuart'
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                }
            }
        });

        // Add click interaction
        ctx.onclick = function(evt) {
            const activePoints = userChart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
            if (activePoints.length > 0) {
                const clickedElementIndex = activePoints[0].index;
                const label = userChart.data.labels[clickedElementIndex];
                // You can add navigation or modal logic here
                console.log('Clicked on:', label);
            }
        };
    }

    // Monthly Growth Chart
    const growthCtx = document.getElementById('growthChart');
    if (growthCtx) {
        const months = [];
        const currentDate = new Date();
        for (let i = 11; i >= 0; i--) {
            const date = new Date(currentDate.getFullYear(), currentDate.getMonth() - i, 1);
            months.push(date.toLocaleString('default', { month: 'short', year: '2-digit' }));
        }

        const growthChart = new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'New Users',
                    data: <?php echo e(json_encode($monthlyUsers)); ?>,
                    borderColor: '#165c60',
                    backgroundColor: 'rgba(22, 92, 96, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'New Products',
                    data: <?php echo e(json_encode($monthlyProducts)); ?>,
                    borderColor: '#1a6b6d',
                    backgroundColor: 'rgba(26, 107, 109, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'New Exchanges',
                    data: <?php echo e(json_encode($monthlyExchanges)); ?>,
                    borderColor: '#f9f2d6',
                    backgroundColor: 'rgba(249, 242, 214, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    }

    // Exchange Status Chart
    const exchangeCtx = document.getElementById('exchangeChart');
    if (exchangeCtx) {
        const exchangeChart = new Chart(exchangeCtx, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Completed', 'Cancelled'],
                datasets: [{
                    label: 'Exchanges',
                    data: <?php echo e(json_encode([$pendingExchanges, $completedExchanges, $rejectedExchanges])); ?>,
                    backgroundColor: [
                        'rgba(255, 167, 38, 0.8)',
                        'rgba(76, 175, 80, 0.8)',
                        'rgba(244, 67, 54, 0.8)'
                    ],
                    borderColor: [
                        '#ffa726',
                        '#4caf50',
                        '#f44336'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Product Status Chart
    const productCtx = document.getElementById('productChart');
    if (productCtx) {
        const productChart = new Chart(productCtx, {
            type: 'pie',
            data: {
                labels: ['Active', 'Inactive'],
                datasets: [{
                    data: <?php echo e(json_encode([$activeProducts, $inactiveProducts])); ?>,
                    backgroundColor: [
                        'rgba(76, 175, 80, 0.8)',
                        'rgba(158, 158, 158, 0.8)'
                    ],
                    borderColor: [
                        '#4caf50',
                        '#9e9e9e'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                }
            }
        });
    }

    // Add smooth scrolling for activity feed
    $('.activity-feed').on('scroll', function() {
        // Add any scroll-based animations here if needed
    });

    // Add hover effects for quick action cards
    $('.quick-action-card').hover(
        function() {
            $(this).find('i').addClass('fa-bounce');
        },
        function() {
            $(this).find('i').removeClass('fa-bounce');
        }
    );

    // Animate stat cards on load
    $('.stat-card').each(function(index) {
        $(this).css('animation-delay', (index * 0.1) + 's');
    });

    // Add loading animation for charts
    setTimeout(function() {
        $('.chart-container').addClass('loaded');
    }, 500);
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>