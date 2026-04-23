<!-- Signup Modal -->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down" role="document" style="max-width: 480px;">
        <div class="modal-content" style="border: none; border-radius: 20px; box-shadow: 0 25px 60px rgba(0,0,0,0.15); overflow: hidden; backdrop-filter: blur(20px);">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color, #0f5057) 0%, #1a6b6d 100%); color: white; border: none; padding: 25px 30px 20px; position: relative; overflow: hidden;">
                <!-- Subtle background pattern -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(255,255,255,0.05) 0%, transparent 50%);"></div>
                <div style="position: relative; z-index: 2;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <div style="background: rgba(255,255,255,0.2); border-radius: 12px; padding: 10px; backdrop-filter: blur(10px);">
                            <i class="fas fa-user-plus fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="modal-title mb-0" id="signupModalLabel" style="font-weight: 700; font-size: 1.4rem; letter-spacing: -0.02em; color: white;">Join TingUt.no</h4>
                            <p style="margin: 0; opacity: 0.9; font-size: 0.9rem;">Start your sustainable journey</p>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="position: relative; z-index: 3; filter: drop-shadow(0 2px 8px rgba(0,0,0,0.2));"></button>
            </div>

            <!-- Body -->
            <div class="modal-body" style="padding: 25px; background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 50%, #ffffff 100%); max-height: 70vh; overflow-y: auto;">
                <form method="POST" action="<?php echo e(route('register')); ?>" id="signupForm" data-otp-enabled="true">
                    <?php echo csrf_field(); ?>

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="signupName" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                            <i class="fas fa-user me-2" style="color: var(--primary-color, #0f5057);"></i>Full Name
                        </label>
                        <div style="position: relative;">
                            <input id="signupName" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" aria-describedby="nameHelp"
                                    style="border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 16px; font-size: 0.95rem; transition: all 0.3s ease; padding-left: 45px; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px);"
                                    placeholder="Enter your full name">
                            <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary-color, #0f5057); font-size: 0.9rem;">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-2" style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px;">
                                <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Email & Phone Row -->
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <label for="signupEmail" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                                <i class="fas fa-envelope me-2" style="color: var(--primary-color, #0f5057);"></i>Email Address
                            </label>
                            <div style="position: relative;">
                                <input id="signupEmail" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username"
                                        style="border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 16px; font-size: 0.95rem; transition: all 0.3s ease; padding-left: 45px; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px);"
                                        placeholder="Enter your email">
                                <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary-color, #0f5057); font-size: 0.9rem;">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-2" style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-4">
                            <label for="signupPhone" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                                <i class="fas fa-phone me-2" style="color: var(--primary-color, #0f5057);"></i>Phone
                            </label>
                            <div style="position: relative;">
                                <input id="signupPhone" class="form-control" type="tel" name="phone" :value="old('phone')" autocomplete="tel"
                                        style="border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 16px; font-size: 0.95rem; transition: all 0.3s ease; padding-left: 45px; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px);"
                                        placeholder="+47">
                                <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary-color, #0f5057); font-size: 0.9rem;">
                                    <i class="fas fa-phone"></i>
                                </div>
                            </div>
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-2" style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="mb-3">
                        <label for="signupLocation" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                            <i class="fas fa-map-marker-alt me-2" style="color: var(--primary-color, #0f5057);"></i>Location
                        </label>
                        <div style="position: relative;">
                            <select id="signupLocation" class="form-select" name="location" required aria-describedby="locationHelp"
                                    style="border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 16px; font-size: 0.95rem; transition: all 0.3s ease; padding-left: 45px; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); appearance: none; background-image: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"%230f5057\" viewBox=\"0 0 16 16\"><path d=\"M8 11L3 6h10z\"/></svg>'); background-repeat: no-repeat; background-position: right 16px center; background-size: 12px;">
                                <option value="">Select your location</option>
                                <option value="Agder" <?php echo e(old('location') == 'Agder' ? 'selected' : ''); ?>>Agder</option>
                                <option value="Innlandet" <?php echo e(old('location') == 'Innlandet' ? 'selected' : ''); ?>>Innlandet</option>
                                <option value="Møre og Romsdal" <?php echo e(old('location') == 'Møre og Romsdal' ? 'selected' : ''); ?>>Møre og Romsdal</option>
                                <option value="Nordland" <?php echo e(old('location') == 'Nordland' ? 'selected' : ''); ?>>Nordland</option>
                                <option value="Oslo" <?php echo e(old('location') == 'Oslo' ? 'selected' : ''); ?>>Oslo</option>
                                <option value="Rogaland" <?php echo e(old('location') == 'Rogaland' ? 'selected' : ''); ?>>Rogaland</option>
                                <option value="Troms og Finnmark" <?php echo e(old('location') == 'Troms og Finnmark' ? 'selected' : ''); ?>>Troms og Finnmark</option>
                                <option value="Trøndelag" <?php echo e(old('location') == 'Trøndelag' ? 'selected' : ''); ?>>Trøndelag</option>
                                <option value="Vestfold og Telemark" <?php echo e(old('location') == 'Vestfold og Telemark' ? 'selected' : ''); ?>>Vestfold og Telemark</option>
                                <option value="Vestland" <?php echo e(old('location') == 'Vestland' ? 'selected' : ''); ?>>Vestland</option>
                                <option value="Viken" <?php echo e(old('location') == 'Viken' ? 'selected' : ''); ?>>Viken</option>
                            </select>
                            <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary-color, #0f5057); font-size: 0.9rem; pointer-events: none;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                        </div>
                        <?php $__errorArgs = ['location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-2" style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px;">
                                <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Password Fields Row -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="signupPassword" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                                <i class="fas fa-lock me-2" style="color: var(--primary-color, #0f5057);"></i>Password
                            </label>
                            <div style="position: relative;">
                                <input id="signupPassword" class="form-control" type="password" name="password" required autocomplete="new-password"
                                        style="border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 50px 12px 45px; font-size: 0.95rem; transition: all 0.3s ease; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px);"
                                        placeholder="Create password">
                                <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary-color, #0f5057); font-size: 0.9rem;">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <button type="button" id="toggleSignupPassword" class="btn" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); border: none; background: rgba(15, 80, 87, 0.1); color: var(--primary-color, #0f5057); border-radius: 8px; padding: 6px 10px; transition: all 0.3s ease;">
                                    <i class="fas fa-eye" id="signupPasswordIcon"></i>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-2" style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label for="signupConfirmPassword" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                                <i class="fas fa-lock me-2" style="color: var(--primary-color, #0f5057);"></i>Confirm Password
                            </label>
                            <div style="position: relative;">
                                <input id="signupConfirmPassword" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password"
                                        style="border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 50px 12px 45px; font-size: 0.95rem; transition: all 0.3s ease; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px);"
                                        placeholder="Confirm password">
                                <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary-color, #0f5057); font-size: 0.9rem;">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <button type="button" id="toggleSignupConfirmPassword" class="btn" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); border: none; background: rgba(15, 80, 87, 0.1); color: var(--primary-color, #0f5057); border-radius: 8px; padding: 6px 10px; transition: all 0.3s ease;">
                                    <i class="fas fa-eye" id="signupConfirmPasswordIcon"></i>
                                </button>
                            </div>
                            <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-2" style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px;">
                                    <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 12px;">
                            <i class="fas fa-user-tag me-2" style="color: var(--primary-color, #0f5057);"></i>I want to join as
                        </label>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input d-none" type="radio" name="role" id="roleCustomer" value="Customer" <?php echo e(old('role', 'Customer') == 'Customer' ? 'checked' : ''); ?> required>
                                    <label class="form-check-label" for="roleCustomer" style="cursor: pointer; width: 100%;">
                                        <div class="role-card p-3 border rounded-3 text-center" style="border: 2px solid #e9ecef; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); transition: all 0.3s ease;">
                                            <i class="fas fa-shopping-cart fa-2x mb-2" style="color: var(--primary-color, #0f5057);"></i>
                                            <div class="fw-bold" style="font-size: 0.95rem;">Customer</div>
                                            <small class="text-muted" style="font-size: 0.8rem;">Browse & exchange</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input d-none" type="radio" name="role" id="roleSeller" value="Seller" <?php echo e(old('role') == 'Seller' ? 'checked' : ''); ?> required>
                                    <label class="form-check-label" for="roleSeller" style="cursor: pointer; width: 100%;">
                                        <div class="role-card p-3 border rounded-3 text-center" style="border: 2px solid #e9ecef; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); transition: all 0.3s ease;">
                                            <i class="fas fa-store fa-2x mb-2" style="color: var(--primary-color, #0f5057);"></i>
                                            <div class="fw-bold" style="font-size: 0.95rem;">Seller</div>
                                            <small class="text-muted" style="font-size: 0.8rem;">List & sell items</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-2" style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px;">
                                <i class="fas fa-exclamation-circle"></i><?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Actions -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn fw-bold w-100" id="signupSubmitBtn" style="border-radius: 12px; background: linear-gradient(135deg, var(--primary-color, #0f5057) 0%, #1a6b6d 100%); border: none; padding: 14px 20px; font-size: 1rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(15, 80, 87, 0.3); color: white; position: relative; overflow: hidden;">
                            <span style="position: relative; z-index: 2;">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </span>
                            <div style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.5s;"></div>
                        </button>
                    </div>
                </form>


            </div>

            <!-- Footer -->
            <div class="modal-footer justify-content-center border-0" style="background: linear-gradient(145deg, rgba(248, 249, 250, 0.8) 0%, rgba(255, 255, 255, 0.9) 100%); padding: 20px 30px; backdrop-filter: blur(10px);">
                <p class="mb-0" style="font-size: 0.9rem; color: #6b7280;">
                    Already have an account?
                    <a href="#" class="text-decoration-none fw-bold ms-1" style="color: var(--primary-color, #0f5057); transition: all 0.3s ease;" onmouseover="this.style.color='#0a3d42'; this.style.textDecoration='underline';" onmouseout="this.style.color='var(--primary-color, #0f5057)'; this.style.textDecoration='none';" onclick="switchToLogin()">
                        <i class="fas fa-sign-in-alt me-1"></i>Sign in here
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add focus/blur effects to inputs
    const inputs = document.querySelectorAll('#signupModal .form-control, #signupModal .form-select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.borderColor = 'var(--primary-color, #0f5057)';
            this.style.boxShadow = '0 0 0 3px rgba(15, 80, 87, 0.1)';
            this.style.transform = 'translateY(-1px)';
        });

        input.addEventListener('blur', function() {
            this.style.borderColor = '#e9ecef';
            this.style.boxShadow = 'none';
            this.style.transform = 'translateY(0)';
        });
    });

    // Role card selection
    const roleCards = document.querySelectorAll('.role-card');
    roleCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove active class from all cards
            roleCards.forEach(c => {
                c.style.borderColor = '#e9ecef';
                c.style.background = 'rgba(255,255,255,0.8)';
                c.style.transform = 'translateY(0)';
                c.style.boxShadow = 'none';
            });

            // Add active class to clicked card
            this.style.borderColor = 'var(--primary-color, #0f5057)';
            this.style.background = 'rgba(15, 80, 87, 0.05)';
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 4px 15px rgba(15, 80, 87, 0.1)';

            // Check the corresponding radio button
            const radioId = this.parentElement.querySelector('input[type="radio"]').id;
            document.getElementById(radioId).checked = true;
        });
    });

    // Password toggle functionality with animation
    const toggleSignupPassword = document.getElementById('toggleSignupPassword');
    const signupPasswordInput = document.getElementById('signupPassword');
    const signupPasswordIcon = document.getElementById('signupPasswordIcon');

    const toggleSignupConfirmPassword = document.getElementById('toggleSignupConfirmPassword');
    const signupConfirmPasswordInput = document.getElementById('signupConfirmPassword');
    const signupConfirmPasswordIcon = document.getElementById('signupConfirmPasswordIcon');

    if (toggleSignupPassword) {
        toggleSignupPassword.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => this.style.transform = 'scale(1)', 150);

            const type = signupPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            signupPasswordInput.setAttribute('type', type);

            if (type === 'password') {
                signupPasswordIcon.classList.remove('fa-eye-slash');
                signupPasswordIcon.classList.add('fa-eye');
            } else {
                signupPasswordIcon.classList.remove('fa-eye');
                signupPasswordIcon.classList.add('fa-eye-slash');
            }
        });
    }

    if (toggleSignupConfirmPassword) {
        toggleSignupConfirmPassword.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => this.style.transform = 'scale(1)', 150);

            const type = signupConfirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            signupConfirmPasswordInput.setAttribute('type', type);

            if (type === 'password') {
                signupConfirmPasswordIcon.classList.remove('fa-eye-slash');
                signupConfirmPasswordIcon.classList.add('fa-eye');
            } else {
                signupConfirmPasswordIcon.classList.remove('fa-eye');
                signupConfirmPasswordIcon.classList.add('fa-eye-slash');
            }
        });
    }

    // Button hover effects
    const buttons = document.querySelectorAll('#signupModal .btn');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            const shine = this.querySelector('div:last-child');
            if (shine) shine.style.left = '100%';
        });

        button.addEventListener('mouseleave', function() {
            const shine = this.querySelector('div:last-child');
            if (shine) shine.style.left = '-100%';
        });
    });

    // Form validation with animations
    const signupForm = document.getElementById('signupForm');
    const submitBtn = document.getElementById('signupSubmitBtn');

    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            const name = document.getElementById('signupName');
            const email = document.getElementById('signupEmail');
            const phone = document.getElementById('signupPhone');
            const location = document.getElementById('signupLocation');
            const password = document.getElementById('signupPassword');
            const confirmPassword = document.getElementById('signupConfirmPassword');
            const role = document.querySelector('input[name="role"]:checked');

            let isValid = true;

            // Reset previous errors with animation
            [name, email, phone, location, password, confirmPassword].forEach(field => {
                field.style.borderColor = '#e9ecef';
                field.style.transform = 'translateY(0)';
                const errorDiv = field.parentElement.parentElement?.querySelector('.text-danger') || field.parentElement?.querySelector('.text-danger');
                if (errorDiv) {
                    errorDiv.style.opacity = '0';
                    setTimeout(() => errorDiv.remove(), 300);
                }
            });

            // Validate name
            if (!name.value.trim()) {
                showFieldError(name, 'Full name is required');
                isValid = false;
            } else if (name.value.trim().length < 2) {
                showFieldError(name, 'Name must be at least 2 characters');
                isValid = false;
            }

            // Validate email
            if (!email.value.trim()) {
                showFieldError(email, 'Email is required');
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                showFieldError(email, 'Please enter a valid email address');
                isValid = false;
            }

            // Validate location
            if (!location.value) {
                showFieldError(location, 'Please select your location');
                isValid = false;
            }

            // Validate password
            if (!password.value.trim()) {
                showFieldError(password, 'Password is required');
                isValid = false;
            } else if (password.value.length < 8) {
                showFieldError(password, 'Password must be at least 8 characters');
                isValid = false;
            }

            // Validate confirm password
            if (!confirmPassword.value.trim()) {
                showFieldError(confirmPassword, 'Please confirm your password');
                isValid = false;
            } else if (password.value !== confirmPassword.value) {
                showFieldError(confirmPassword, 'Passwords do not match');
                isValid = false;
            }

            // Validate role
            if (!role) {
                const roleContainer = document.querySelector('#signupModal .row.g-3');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-danger mt-2';
                errorDiv.style.fontSize = '0.8rem';
                errorDiv.style.textAlign = 'center';
                errorDiv.style.opacity = '0';
                errorDiv.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>Please select a role';
                roleContainer.appendChild(errorDiv);

                setTimeout(() => {
                    errorDiv.style.opacity = '1';
                }, 10);
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                // Shake animation for invalid form
                submitBtn.style.animation = 'shake 0.5s ease-in-out';
                setTimeout(() => submitBtn.style.animation = '', 500);
            } else {
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Creating Account...';
            }
        });
    }

    function showFieldError(field, message) {
        field.style.borderColor = '#dc3545';
        field.style.transform = 'translateY(-1px)';
        field.style.animation = 'shake 0.3s ease-in-out';

        const errorDiv = document.createElement('div');
        errorDiv.className = 'text-danger mt-2';
        errorDiv.style.fontSize = '0.8rem';
        errorDiv.style.opacity = '0';
        errorDiv.style.transform = 'translateY(-10px)';
        errorDiv.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>' + message;

        if (field.classList.contains('form-select')) {
            field.parentElement.appendChild(errorDiv);
        } else {
            field.parentElement.parentElement.appendChild(errorDiv);
        }

        // Animate error in
        setTimeout(() => {
            errorDiv.style.opacity = '1';
            errorDiv.style.transform = 'translateY(0)';
        }, 10);

        setTimeout(() => field.style.animation = '', 300);
    }

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        #signupModal .btn:hover div:last-child {
            left: 100% !important;
        }
    `;
    document.head.appendChild(style);
});

function switchToLogin() {
    const signupModal = bootstrap.Modal.getInstance(document.getElementById('signupModal'));
    if (signupModal) {
        // Add fade out effect
        signupModal._element.style.transition = 'opacity 0.3s ease';
        signupModal._element.style.opacity = '0';

        signupModal.hide();

        // Small delay to ensure signup modal is hidden before showing login
        setTimeout(() => {
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            if (loginModal) {
                loginModal.show();
            }
        }, 300);
    }
}
</script>
<?php /**PATH /var/www/html/resources/views/components/signup-modal.blade.php ENDPATH**/ ?>