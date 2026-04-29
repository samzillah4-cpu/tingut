<?php $__env->startSection('title', 'System Settings'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>System Settings</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('POST'); ?>

        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
                    <i class="fas fa-globe mr-2"></i>General
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="branding-tab" data-toggle="tab" href="#branding" role="tab" aria-controls="branding" aria-selected="false">
                    <i class="fas fa-image mr-2"></i>Branding
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="social-tab" data-toggle="tab" href="#social" role="tab" aria-controls="social" aria-selected="false">
                    <i class="fas fa-share-alt mr-2"></i>Social & Login
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">
                    <i class="fas fa-users-cog mr-2"></i>Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="email-tab" data-toggle="tab" href="#email" role="tab" aria-controls="email" aria-selected="false">
                    <i class="fas fa-envelope mr-2"></i>Email & Payment
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="bankid-tab" data-toggle="tab" href="#bankid" role="tab" aria-controls="bankid" aria-selected="false">
                    <i class="fas fa-id-card mr-2"></i>Bank ID
                </a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="settingsTabContent">
            <!-- General Settings Tab -->
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-globe mr-2"></i>General Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="site_name" class="form-label">Site Name</label>
                                            <input type="text" class="form-control form-control-sm" id="site_name" name="site_name"
                                                   value="<?php echo e($settings['site_name'] ?? 'TingUt.no'); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="contact_email" class="form-label">Contact Email</label>
                                            <input type="email" class="form-control form-control-sm" id="contact_email" name="contact_email"
                                                   value="<?php echo e($settings['contact_email'] ?? 'admin@tingut.no'); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="contact_phone" class="form-label">Contact Phone</label>
                                            <input type="text" class="form-control form-control-sm" id="contact_phone" name="contact_phone"
                                                   value="<?php echo e($settings['contact_phone'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="site_description" class="form-label">Site Description</label>
                                            <textarea class="form-control form-control-sm" id="site_description" name="site_description"
                                                      rows="2"><?php echo e($settings['site_description'] ?? 'Barter Trading Platform'); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="currency" class="form-label">System Currency</label>
                                            <select class="form-control form-control-sm" id="currency" name="currency">
                                                <option value="USD" <?php echo e(($settings['currency'] ?? 'USD') == 'USD' ? 'selected' : ''); ?>>USD ($)</option>
                                                <option value="EUR" <?php echo e(($settings['currency'] ?? 'USD') == 'EUR' ? 'selected' : ''); ?>>EUR (€)</option>
                                                <option value="GBP" <?php echo e(($settings['currency'] ?? 'USD') == 'GBP' ? 'selected' : ''); ?>>GBP (£)</option>
                                                <option value="NOK" <?php echo e(($settings['currency'] ?? 'USD') == 'NOK' ? 'selected' : ''); ?>>NOK (kr)</option>
                                                <option value="SEK" <?php echo e(($settings['currency'] ?? 'USD') == 'SEK' ? 'selected' : ''); ?>>SEK (kr)</option>
                                                <option value="DKK" <?php echo e(($settings['currency'] ?? 'USD') == 'DKK' ? 'selected' : ''); ?>>DKK (kr)</option>
                                            </select>
                                            <small class="form-text text-muted">Changes currency display across the entire system</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="ecommerce_commission_rate" class="form-label">E-commerce Commission Rate (%)</label>
                                            <input type="number" class="form-control form-control-sm" id="ecommerce_commission_rate" name="ecommerce_commission_rate"
                                                   min="0" max="100" step="0.01" value="<?php echo e($settings['ecommerce_commission_rate'] ?? '5.00'); ?>">
                                            <small class="form-text text-muted">Commission percentage deducted from each sale</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Branding & Media Tab -->
            <div class="tab-pane fade" id="branding" role="tabpanel" aria-labelledby="branding-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-image mr-2"></i>Branding & Media
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="site_logo" class="form-label">Website Logo</label>
                                            <input type="file" class="form-control form-control-sm" id="site_logo" name="site_logo" accept="image/*">
                                            <small class="form-text text-muted">Upload PNG, JPG, or SVG (max 2MB)</small>
                                            <?php if(isset($settings['site_logo']) && $settings['site_logo']): ?>
                                                <div class="mt-2">
                                                    <img src="<?php echo e(asset('storage/' . $settings['site_logo'])); ?>" alt="Current Logo" style="max-height: 50px;">
                                                    <p class="text-muted small mt-1">Current logo</p>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="remove_logo" name="remove_logo" value="1">
                                                        <label class="form-check-label" for="remove_logo">
                                                            Remove current logo
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="favicon" class="form-label">Favicon</label>
                                            <input type="file" class="form-control form-control-sm" id="favicon" name="favicon" accept="image/*">
                                            <small class="form-text text-muted">Upload ICO or PNG (32x32 recommended)</small>
                                            <?php if(isset($settings['favicon']) && $settings['favicon']): ?>
                                                <div class="mt-2">
                                                    <img src="<?php echo e(asset('storage/' . $settings['favicon'])); ?>" alt="Current Favicon" style="max-height: 32px;">
                                                    <p class="text-muted small mt-1">Current favicon</p>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="remove_favicon" name="remove_favicon" value="1">
                                                        <label class="form-check-label" for="remove_favicon">
                                                            Remove current favicon
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="topbar_bg_color" class="form-label">Topbar Background Color</label>
                                            <input type="color" class="form-control form-control-sm" id="topbar_bg_color" name="topbar_bg_color"
                                                   value="<?php echo e($settings['topbar_bg_color'] ?? '#1a6969'); ?>">
                                            <small class="form-text text-muted">Choose the background color for the top navigation bar</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="primary_color" class="form-label">Primary Theme Color</label>
                                            <input type="color" class="form-control form-control-sm" id="primary_color" name="primary_color"
                                                   value="<?php echo e($settings['primary_color'] ?? '#1a6969'); ?>">
                                            <small class="form-text text-muted">Main theme color used throughout the site</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social & Login Tab -->
            <div class="tab-pane fade" id="social" role="tabpanel" aria-labelledby="social-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-share-alt mr-2"></i>Social Media Links
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="facebook_url" class="form-label">
                                                <i class="fab fa-facebook text-primary mr-1"></i>Facebook
                                            </label>
                                            <input type="url" class="form-control form-control-sm" id="facebook_url" name="facebook_url"
                                                   value="<?php echo e($settings['facebook_url'] ?? ''); ?>" placeholder="https://facebook.com/yourpage">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="twitter_url" class="form-label">
                                                <i class="fab fa-twitter text-info mr-1"></i>X (Twitter)
                                            </label>
                                            <input type="url" class="form-control form-control-sm" id="twitter_url" name="twitter_url"
                                                   value="<?php echo e($settings['twitter_url'] ?? ''); ?>" placeholder="https://twitter.com/yourhandle">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="instagram_url" class="form-label">
                                                <i class="fab fa-instagram text-danger mr-1"></i>Instagram
                                            </label>
                                            <input type="url" class="form-control form-control-sm" id="instagram_url" name="instagram_url"
                                                   value="<?php echo e($settings['instagram_url'] ?? ''); ?>" placeholder="https://instagram.com/youraccount">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="linkedin_url" class="form-label">
                                                <i class="fab fa-linkedin text-primary mr-1"></i>LinkedIn
                                            </label>
                                            <input type="url" class="form-control form-control-sm" id="linkedin_url" name="linkedin_url"
                                                   value="<?php echo e($settings['linkedin_url'] ?? ''); ?>" placeholder="https://linkedin.com/company/yourcompany">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Social Login Configuration
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5><i class="fab fa-facebook text-primary mr-2"></i>Facebook Login</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="facebook_login_enabled" class="form-label">Enable Facebook Login</label>
                                            <div class="custom-control custom-switch">
                                                <input type="hidden" name="facebook_login_enabled" value="0">
                                                <input type="checkbox" class="custom-control-input" id="facebook_login_enabled"
                                                       name="facebook_login_enabled" value="1"
                                                       <?php echo e(($settings['facebook_login_enabled'] ?? '0') == '1' ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="facebook_login_enabled"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="facebook_app_id" class="form-label">Facebook App ID</label>
                                            <input type="text" class="form-control form-control-sm" id="facebook_app_id" name="facebook_app_id"
                                                   value="<?php echo e($settings['facebook_app_id'] ?? ''); ?>" placeholder="Your Facebook App ID">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="facebook_app_secret" class="form-label">Facebook App Secret</label>
                                            <input type="password" class="form-control form-control-sm" id="facebook_app_secret" name="facebook_app_secret"
                                                   value="<?php echo e($settings['facebook_app_secret'] ?? ''); ?>" placeholder="Your Facebook App Secret">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5><i class="fab fa-google text-danger mr-2"></i>Google Login</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="google_login_enabled" class="form-label">Enable Google Login</label>
                                            <div class="custom-control custom-switch">
                                                <input type="hidden" name="google_login_enabled" value="0">
                                                <input type="checkbox" class="custom-control-input" id="google_login_enabled"
                                                       name="google_login_enabled" value="1"
                                                       <?php echo e(($settings['google_login_enabled'] ?? '0') == '1' ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="google_login_enabled"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="google_client_id" class="form-label">Google Client ID</label>
                                            <input type="text" class="form-control form-control-sm" id="google_client_id" name="google_client_id"
                                                   value="<?php echo e($settings['google_client_id'] ?? ''); ?>" placeholder="Your Google Client ID">
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="google_client_secret" class="form-label">Google Client Secret</label>
                                            <input type="password" class="form-control form-control-sm" id="google_client_secret" name="google_client_secret"
                                                   value="<?php echo e($settings['google_client_secret'] ?? ''); ?>" placeholder="Your Google Client Secret">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Tab -->
            <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="users-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-users-cog mr-2"></i>User Management Settings
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="default_user_role" class="form-label">Default User Role</label>
                                            <select class="form-control form-control-sm" id="default_user_role" name="default_user_role">
                                                <option value="Customer" <?php echo e(($settings['default_user_role'] ?? 'Customer') == 'Customer' ? 'selected' : ''); ?>>Customer</option>
                                                <option value="Seller" <?php echo e(($settings['default_user_role'] ?? 'Customer') == 'Seller' ? 'selected' : ''); ?>>Seller</option>
                                            </select>
                                            <small class="form-text text-muted">Default role assigned to new users</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="session_timeout" class="form-label">Session Timeout (minutes)</label>
                                            <input type="number" class="form-control form-control-sm" id="session_timeout"
                                                   name="session_timeout" min="15" max="1440"
                                                   value="<?php echo e($settings['session_timeout'] ?? 480); ?>">
                                            <small class="form-text text-muted">User session timeout in minutes</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch mt-4">
                                                <input type="hidden" name="email_verification_required" value="0">
                                                <input type="checkbox" class="custom-control-input" id="email_verification_required"
                                                       name="email_verification_required" value="1"
                                                       <?php echo e(($settings['email_verification_required'] ?? '1') == '1' ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="email_verification_required">
                                                    Email Verification Required
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">Require email verification for new accounts</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="hidden" name="auto_approve_sellers" value="0">
                                                <input type="checkbox" class="custom-control-input" id="auto_approve_sellers"
                                                       name="auto_approve_sellers" value="1"
                                                       <?php echo e(($settings['auto_approve_sellers'] ?? '0') == '1' ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="auto_approve_sellers">
                                                    Auto-approve Sellers
                                                </label>
                                            </div>
                                            <small class="form-text text-muted">Automatically approve seller applications</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email & Payment Tab -->
            <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-envelope mr-2"></i>Email/SMTP Configuration
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="smtp_host" class="form-label">SMTP Host</label>
                                            <input type="text" class="form-control form-control-sm" id="smtp_host" name="smtp_host"
                                                   value="<?php echo e($settings['smtp_host'] ?? ''); ?>" placeholder="smtp.gmail.com">
                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="smtp_port" class="form-label">SMTP Port</label>
                                            <input type="number" class="form-control form-control-sm" id="smtp_port" name="smtp_port"
                                                   value="<?php echo e($settings['smtp_port'] ?? '587'); ?>" placeholder="587">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="smtp_encryption" class="form-label">Encryption</label>
                                            <select class="form-control form-control-sm" id="smtp_encryption" name="smtp_encryption">
                                                <option value="tls" <?php echo e(($settings['smtp_encryption'] ?? 'tls') == 'tls' ? 'selected' : ''); ?>>TLS</option>
                                                <option value="ssl" <?php echo e(($settings['smtp_encryption'] ?? 'tls') == 'ssl' ? 'selected' : ''); ?>>SSL</option>
                                                <option value="none" <?php echo e(($settings['smtp_encryption'] ?? 'tls') == 'none' ? 'selected' : ''); ?>>None</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="smtp_username" class="form-label">SMTP Username</label>
                                            <input type="text" class="form-control form-control-sm" id="smtp_username" name="smtp_username"
                                                   value="<?php echo e($settings['smtp_username'] ?? ''); ?>" placeholder="your-email@gmail.com">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="smtp_password" class="form-label">SMTP Password</label>
                                            <input type="password" class="form-control form-control-sm" id="smtp_password" name="smtp_password"
                                                   value="<?php echo e($settings['smtp_password'] ?? ''); ?>" placeholder="App password or SMTP password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="from_email" class="form-label">From Email</label>
                                            <input type="email" class="form-control form-control-sm" id="from_email" name="from_email"
                                                   value="<?php echo e($settings['from_email'] ?? ''); ?>" placeholder="noreply@yourdomain.com">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="from_name" class="form-label">From Name</label>
                                            <input type="text" class="form-control form-control-sm" id="from_name" name="from_name"
                                                   value="<?php echo e($settings['from_name'] ?? ''); ?>" placeholder="TingUt.no">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-credit-card mr-2"></i>Payment Gateway Configuration
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-12">
                                        <h5><i class="fas fa-mobile-alt text-primary mr-2"></i>Vipps MobilePay</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="vipps_environment" class="form-label">Environment</label>
                                            <select class="form-control form-control-sm" id="vipps_environment" name="vipps_environment">
                                                <option value="test" <?php echo e(($settings['vipps_environment'] ?? 'test') == 'test' ? 'selected' : ''); ?>>Test</option>
                                                <option value="production" <?php echo e(($settings['vipps_environment'] ?? 'test') == 'production' ? 'selected' : ''); ?>>Production</option>
                                            </select>
                                            <small class="form-text text-muted">Vipps API environment</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="vipps_client_id" class="form-label">Client ID</label>
                                            <input type="text" class="form-control form-control-sm" id="vipps_client_id" name="vipps_client_id"
                                                   value="<?php echo e($settings['vipps_client_id'] ?? ''); ?>" placeholder="Your Vipps Client ID">
                                            <small class="form-text text-muted">From Vipps Developer Portal</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="vipps_client_secret" class="form-label">Client Secret</label>
                                            <input type="password" class="form-control form-control-sm" id="vipps_client_secret" name="vipps_client_secret"
                                                   value="<?php echo e($settings['vipps_client_secret'] ?? ''); ?>" placeholder="Your Vipps Client Secret">
                                            <small class="form-text text-muted">From Vipps Developer Portal</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="vipps_subscription_key" class="form-label">Subscription Key</label>
                                            <input type="text" class="form-control form-control-sm" id="vipps_subscription_key" name="vipps_subscription_key"
                                                   value="<?php echo e($settings['vipps_subscription_key'] ?? ''); ?>" placeholder="Your Vipps Subscription Key">
                                            <small class="form-text text-muted">From Vipps Developer Portal</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="vipps_merchant_serial_number" class="form-label">Merchant Serial Number</label>
                                            <input type="text" class="form-control form-control-sm" id="vipps_merchant_serial_number" name="vipps_merchant_serial_number"
                                                   value="<?php echo e($settings['vipps_merchant_serial_number'] ?? ''); ?>" placeholder="Your Merchant Serial Number">
                                            <small class="form-text text-muted">From Vipps Merchant Portal</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="vipps_webhook_secret" class="form-label">Webhook Secret</label>
                                            <input type="password" class="form-control form-control-sm" id="vipps_webhook_secret" name="vipps_webhook_secret"
                                                   value="<?php echo e($settings['vipps_webhook_secret'] ?? ''); ?>" placeholder="Your Webhook Secret">
                                            <small class="form-text text-muted">For webhook verification</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>How to get your Vipps credentials:</strong>
                                    <ol class="mb-0 mt-2">
                                        <li>Go to <a href="https://portal.vipps.no" target="_blank">Vipps Developer Portal</a> and create an account</li>
                                        <li>Create a new application for your platform</li>
                                        <li>Copy the Client ID, Client Secret, and Subscription Key</li>
                                        <li>Get your Merchant Serial Number from the merchant portal</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bank ID Tab -->
            <div class="tab-pane fade" id="bankid" role="tabpanel" aria-labelledby="bankid-tab">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-id-card mr-2"></i>Bank ID Configuration
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="bankid_enabled" class="form-label">Enable Bank ID</label>
                                            <div class="custom-control custom-switch">
                                                <input type="hidden" name="bankid_enabled" value="0">
                                                <input type="checkbox" class="custom-control-input" id="bankid_enabled"
                                                       name="bankid_enabled" value="1"
                                                       <?php echo e(($settings['bankid_enabled'] ?? '0') == '1' ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="bankid_enabled"></label>
                                            </div>
                                            <small class="form-text text-muted">Enable Bank ID verification on the site</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="bankid_environment" class="form-label">Environment</label>
                                            <select class="form-control form-control-sm" id="bankid_environment" name="bankid_environment">
                                                <option value="test" <?php echo e(($settings['bankid_environment'] ?? 'test') == 'test' ? 'selected' : ''); ?>>Test</option>
                                                <option value="production" <?php echo e(($settings['bankid_environment'] ?? 'test') == 'production' ? 'selected' : ''); ?>>Production</option>
                                            </select>
                                            <small class="form-text text-muted">BankID API environment</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-group">
                                            <label for="bankid_required_for_login" class="form-label">Required for Login</label>
                                            <div class="custom-control custom-switch">
                                                <input type="hidden" name="bankid_required_for_login" value="0">
                                                <input type="checkbox" class="custom-control-input" id="bankid_required_for_login"
                                                       name="bankid_required_for_login" value="1"
                                                       <?php echo e(($settings['bankid_required_for_login'] ?? '0') == '1' ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="bankid_required_for_login"></label>
                                            </div>
                                            <small class="form-text text-muted">Require BankID verification to login</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="bankid_required_for_registration" class="form-label">Required for Registration</label>
                                            <div class="custom-control custom-switch">
                                                <input type="hidden" name="bankid_required_for_registration" value="0">
                                                <input type="checkbox" class="custom-control-input" id="bankid_required_for_registration"
                                                       name="bankid_required_for_registration" value="1"
                                                       <?php echo e(($settings['bankid_required_for_registration'] ?? '0') == '1' ? 'checked' : ''); ?>>
                                                <label class="custom-control-label" for="bankid_required_for_registration"></label>
                                            </div>
                                            <small class="form-text text-muted">Require BankID verification for new user registration</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-key mr-2"></i>Bank ID API Credentials
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="bankid_client_id" class="form-label">Client ID</label>
                                            <input type="text" class="form-control form-control-sm" id="bankid_client_id" name="bankid_client_id"
                                                   value="<?php echo e($settings['bankid_client_id'] ?? ''); ?>" placeholder="Your BankID Client ID">
                                            <small class="form-text text-muted">From BankID Developer Portal</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="bankid_client_secret" class="form-label">Client Secret</label>
                                            <input type="password" class="form-control form-control-sm" id="bankid_client_secret" name="bankid_client_secret"
                                                   value="<?php echo e($settings['bankid_client_secret'] ?? ''); ?>" placeholder="Your BankID Client Secret">
                                            <small class="form-text text-muted">From BankID Developer Portal</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="bankid_rp_client_id" class="form-label">RP Client ID</label>
                                            <input type="text" class="form-control form-control-sm" id="bankid_rp_client_id" name="bankid_rp_client_id"
                                                   value="<?php echo e($settings['bankid_rp_client_id'] ?? ''); ?>" placeholder="Your BankID RP Client ID">
                                            <small class="form-text text-muted">Relying Party Client ID</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="bankid_rp_client_secret" class="form-label">RP Client Secret</label>
                                            <input type="password" class="form-control form-control-sm" id="bankid_rp_client_secret" name="bankid_rp_client_secret"
                                                   value="<?php echo e($settings['bankid_rp_client_secret'] ?? ''); ?>" placeholder="Your BankID RP Client Secret">
                                            <small class="form-text text-muted">Relying Party Client Secret</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>How to get your BankID credentials:</strong>
                                    <ol class="mb-0 mt-2">
                                        <li>Go to <a href="https://bankid.no" target="_blank">BankID Portal</a> and register as a developer</li>
                                        <li>Create a new application for your platform</li>
                                        <li>Copy the Client ID and Client Secret</li>
                                        <li>Configure the allowed redirect URIs for your application</li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-info-circle mr-2"></i>Integration Information
                                </h3>
                            </div>
                            <div class="card-body">
                                <p>BankID integration allows users to verify their identity using BankID, which is the most common electronic ID in Norway.</p>
                                <ul>
                                    <li><strong>Login:</strong> Users can optionally verify their identity with BankID when logging in</li>
                                    <li><strong>Registration:</strong> New users can verify their identity during registration</li>
                                    <li><strong>Security:</strong> BankID provides strong two-factor authentication</li>
                                </ul>
                                <p class="mb-0"><strong>Note:</strong> BankID integration requires proper SSL/TLS configuration and API credentials from BankID.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save"></i> Save Settings
                        </button>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary btn-block mt-2">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/adminlte-custom.css')); ?>">
    <style>
        :root {
            --primary-color: #155e60;
            --secondary-color: #f7efd3;
        }
        .custom-control-label { font-weight: normal; }
        .info-box { box-shadow: none; border-radius: 8px; }
        .info-box-content { padding: 15px; }
        .info-box-text { font-size: 14px; color: #6c757d; }
        .info-box-number { font-size: 18px; font-weight: bold; color: var(--primary-color); }
        .btn-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        .btn-primary:hover {
            background-color: #0e4a4d !important;
            border-color: #0e4a4d !important;
        }
        .card-header {
            background: linear-gradient(135deg, var(--primary-color), #0e4a4d) !important;
            color: white !important;
            border-bottom: none !important;
        }
        .card-header .card-title {
            color: white !important;
            margin: 0;
        }
        .card-header .card-title i {
            color: var(--secondary-color) !important;
        }
        .text-primary { color: var(--primary-color) !important; }
        .bg-primary { background-color: var(--primary-color) !important; }
        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(21, 94, 96, 0.25) !important;
        }
        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }
        a:hover { color: var(--primary-color) !important; }
        .info-box.bg-light { border-left: 4px solid var(--primary-color) !important; }
        .nav-tabs .nav-link {
            border: none;
            border-bottom: 2px solid transparent;
            color: #6c757d;
            font-weight: 500;
            padding: 12px 20px;
        }
        .nav-tabs .nav-link:hover {
            border-color: rgba(21, 94, 96, 0.3);
            color: var(--primary-color);
        }
        .nav-tabs .nav-link.active {
            background-color: transparent;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        .nav-tabs .nav-link i { margin-right: 8px; }
        .tab-content { margin-top: 20px; }
        @media (max-width: 767.98px) {
            .nav-tabs { flex-direction: column; }
            .nav-tabs .nav-link { text-align: left; padding: 10px 15px; }
            .card-body .row .col-md-6, .card-body .row .col-md-4, .card-body .row .col-md-12 { margin-bottom: 15px; }
            .card-body .row .col-md-6:last-child, .card-body .row .col-md-4:last-child, .card-body .row .col-md-12:last-child { margin-bottom: 0; }
        }
        .card { margin-bottom: 20px; }
        .card:last-child { margin-bottom: 0; }
        @media (max-width: 767.98px) {
            .btn-block { width: 100%; margin-bottom: 10px; }
        }
        .form-group { margin-bottom: 1rem; }
        .mb-3 { margin-bottom: 1rem !important; }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            var isValid = true;
            $(this).find('input[required], select[required], textarea[required]').each(function() {
                if ($(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                    isValid = false;
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/admin/settings.blade.php ENDPATH**/ ?>