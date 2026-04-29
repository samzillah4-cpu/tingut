<?php $__env->startSection('title', 'Verify Your Email - ' . config('settings.site_name', 'Bytte.no')); ?>

<?php $__env->startSection('content'); ?>
<div class="main-content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-4">
                <!-- Header Section -->
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-3"
                         style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;">
                        <i class="fas fa-shield-alt fa-2x"></i>
                    </div>
                    <h2 class="h3 fw-bold mb-2" style="color: var(--primary-color); font-weight: 700;">Verify Your Email</h2>
                    <p class="text-muted mb-0">
                        We've sent a 6-digit code to <strong style="color: var(--primary-color); font-weight: 600;"><?php echo e(session('otp_email')); ?></strong>
                    </p>
                </div>

                <!-- Success/Error Messages -->
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($error); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- OTP Card -->
                <div class="freecycle-card p-4">
                    <form method="POST" action="<?php echo e(route('otp.verify')); ?>" id="otpForm">
                        <?php echo csrf_field(); ?>

                        <!-- Code Input -->
                        <div class="mb-4">
                            <label for="code" class="form-label fw-semibold">Enter Verification Code</label>
                            <input type="text"
                                   id="code"
                                   name="code"
                                   class="form-control form-control-lg text-center fw-bold <?php echo e($errors->has('code') ? 'is-invalid' : ''); ?>"
                                   maxlength="6"
                                   pattern="[0-9]{6}"
                                   inputmode="numeric"
                                   placeholder="000000"
                                   autocomplete="one-time-code"
                                   required
                                   value="<?php echo e(old('code')); ?>"
                                   style="font-size: 1.5rem; letter-spacing: 0.5rem; padding: 1rem;">
                            <div class="form-text text-center mt-2">
                                <i class="fas fa-info-circle me-1"></i>
                                Code expires in 10 minutes
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-primary btn-lg" id="verifyBtn" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); border: none;">
                                <span class="spinner-border spinner-border-sm d-none me-2" role="status" aria-hidden="true"></span>
                                <i class="fas fa-check me-1"></i>Verify & Continue
                            </button>

                            <button type="button" class="btn btn-outline-primary btn-lg" id="resendBtn" onclick="resendOtp()">
                                <i class="fas fa-redo me-1"></i>Resend Code
                            </button>
                        </div>
                    </form>

                    <!-- Additional Links -->
                    <hr class="my-4">
                    <div class="text-center">
                        <div class="row g-2">
                            <div class="col-6">
                                <a href="<?php echo e(route('login')); ?>" onclick="clearOtpSession()" class="btn btn-sm btn-outline-secondary w-100">
                                    <i class="fas fa-arrow-left me-1"></i>Use Different Email
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?php echo e(route('password.request')); ?>" class="btn btn-sm btn-outline-secondary w-100">
                                    <i class="fas fa-key me-1"></i>Forgot Password?
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Help Text -->
                <div class="text-center mt-4">
                    <small class="text-muted">
                        Didn't receive the code?
                        <a href="javascript:void(0)" onclick="resendOtp()" class="text-primary fw-semibold">Click here to resend</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInput = document.getElementById('code');
    const verifyBtn = document.getElementById('verifyBtn');
    const resendBtn = document.getElementById('resendBtn');

    // Auto-focus on input
    if (otpInput) {
        otpInput.focus();
    }

    // Format OTP input (only allow numbers)
    if (otpInput) {
        otpInput.addEventListener('input', function(e) {
            // Remove any non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');

            // Auto-submit when 6 digits are entered
            if (this.value.length === 6) {
                setTimeout(() => {
                    document.getElementById('otpForm').submit();
                }, 500);
            }
        });

        // Handle paste event for OTP
        otpInput.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
            this.value = pastedData.substring(0, 6);
        });
    }

    // Form submission
    const otpForm = document.getElementById('otpForm');
    if (otpForm) {
        otpForm.addEventListener('submit', function(e) {
            const spinner = verifyBtn.querySelector('.spinner-border');
            if (spinner) {
                spinner.classList.remove('d-none');
            }
            verifyBtn.disabled = true;
            verifyBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Verifying...';
        });
    }
});

// Resend OTP function
function resendOtp() {
    const resendBtn = document.getElementById('resendBtn');
    if (!resendBtn) return;

    const originalText = resendBtn.innerHTML;

    // Show loading state
    resendBtn.disabled = true;
    resendBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Sending...';

    fetch('<?php echo e(route("otp.resend")); ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showAlert('A new verification code has been sent to your email.', 'success');

            // Disable resend button for 30 seconds
            let countdown = 30;
            const countdownInterval = setInterval(() => {
                resendBtn.innerHTML = `<i class="fas fa-clock me-1"></i>Resend in ${countdown}s`;
                countdown--;

                if (countdown < 0) {
                    clearInterval(countdownInterval);
                    resendBtn.disabled = false;
                    resendBtn.innerHTML = '<i class="fas fa-redo me-1"></i>Resend Code';
                }
            }, 1000);
        } else {
            showAlert(data.message || 'Failed to resend code.', 'error');
            resendBtn.disabled = false;
            resendBtn.innerHTML = originalText;
        }
    })
    .catch(error => {
        showAlert('An error occurred. Please try again.', 'error');
        resendBtn.disabled = false;
        resendBtn.innerHTML = originalText;
    });
}

// Clear OTP session
function clearOtpSession() {
    fetch('<?php echo e(route("otp.clear-session")); ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        }
    });
}

// Alert function using Bootstrap alerts
function showAlert(message, type = 'info') {
    const alertClass = type === 'success' ? 'alert-success' :
                      type === 'error' ? 'alert-danger' : 'alert-info';
    const iconClass = type === 'success' ? 'fa-check-circle' :
                     type === 'error' ? 'fa-exclamation-triangle' : 'fa-info-circle';

    const alert = document.createElement('div');
    alert.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
    alert.style.cssText = `
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 350px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    `;
    alert.innerHTML = `
        <i class="fas ${iconClass} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    document.body.appendChild(alert);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.parentNode.removeChild(alert);
        }
    }, 5000);
}

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    const otpInput = document.getElementById('code');
    if (e.key === 'Enter' && document.activeElement === otpInput) {
        if (otpInput.value.length === 6) {
            document.getElementById('otpForm').submit();
        }
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bytte.no\resources\views/auth/verify-otp.blade.php ENDPATH**/ ?>