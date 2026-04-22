<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 420px;">
        <div class="modal-content" style="border: none; border-radius: 20px; box-shadow: 0 25px 60px rgba(0,0,0,0.15); overflow: hidden; backdrop-filter: blur(20px);">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color, #0f5057) 0%, #1a6b6d 100%); color: white; border: none; padding: 25px 30px 20px; position: relative; overflow: hidden;">
                <!-- Subtle background pattern -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(255,255,255,0.05) 0%, transparent 50%);"></div>
                <div style="position: relative; z-index: 2;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <div style="background: rgba(255,255,255,0.2); border-radius: 12px; padding: 10px; backdrop-filter: blur(10px);">
                            <i class="fas fa-sign-in-alt fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="modal-title mb-0" id="loginModalLabel" style="font-weight: 700; font-size: 1.4rem; letter-spacing: -0.02em; color: white;">Welcome Back</h4>
                            <p style="margin: 0; opacity: 0.9; font-size: 0.9rem;">Sign in to continue your journey</p>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="position: relative; z-index: 3; filter: drop-shadow(0 2px 8px rgba(0,0,0,0.2));"></button>
            </div>

            <!-- Body -->
            <div class="modal-body" style="padding: 30px; background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 50%, #ffffff 100%);">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: none; background: linear-gradient(135deg, rgba(25, 135, 84, 0.15) 0%, rgba(25, 135, 84, 0.05) 100%); color: #198754; font-size: 0.85rem; padding: 12px 16px; margin-bottom: 20px; backdrop-filter: blur(10px);">
                        <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.8rem;"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm" data-otp-enabled="false">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                            <i class="fas fa-envelope me-2" style="color: var(--primary-color, #0f5057);"></i>Email Address
                        </label>
                        <div style="position: relative;">
                            <input id="loginEmail" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" aria-describedby="emailHelp"
                                    style="border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 16px; font-size: 0.95rem; transition: all 0.3s ease; padding-left: 45px; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px);"
                                    placeholder="Enter your email">
                            <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary-color, #0f5057); font-size: 0.9rem;">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                        @error('email')
                            <div class="text-danger mt-2" style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px;">
                                <i class="fas fa-exclamation-circle"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                            <i class="fas fa-lock me-2" style="color: var(--primary-color, #0f5057);"></i>Password
                        </label>
                        <div style="position: relative;">
                            <input id="loginPassword" class="form-control" type="password" name="password" required autocomplete="current-password" aria-describedby="passwordHelp"
                                    style="border: 2px solid #e9ecef; border-radius: 12px; padding: 12px 50px 12px 45px; font-size: 0.95rem; transition: all 0.3s ease; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px);"
                                    placeholder="Enter your password">
                            <div style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--primary-color, #0f5057); font-size: 0.9rem;">
                                <i class="fas fa-lock"></i>
                            </div>
                            <button type="button" id="toggleLoginPassword" class="btn" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); border: none; background: rgba(15, 80, 87, 0.1); color: var(--primary-color, #0f5057); border-radius: 8px; padding: 6px 10px; transition: all 0.3s ease;">
                                <i class="fas fa-eye" id="loginPasswordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger mt-2" style="font-size: 0.8rem; display: flex; align-items: center; gap: 6px;">
                                <i class="fas fa-exclamation-circle"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div class="form-check" style="margin: 0;">
                            <input id="loginRemember" type="checkbox" class="form-check-input" name="remember" style="border: 2px solid var(--primary-color, #0f5057); border-radius: 4px; margin-right: 8px;">
                            <label for="loginRemember" class="form-check-label" style="color: #6b7280; font-size: 0.85rem; cursor: pointer;">
                                Remember me
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="text-decoration-none" href="{{ route('password.request') }}" style="color: var(--primary-color, #0f5057); font-size: 0.85rem; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.color='#0a3d42'; this.style.textDecoration='underline';" onmouseout="this.style.color='var(--primary-color, #0f5057)'; this.style.textDecoration='none';">
                                <i class="fas fa-key me-1"></i>Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn fw-bold w-100" id="loginSubmitBtn" style="border-radius: 12px; background: linear-gradient(135deg, var(--primary-color, #0f5057) 0%, #1a6b6d 100%); border: none; padding: 14px 20px; font-size: 1rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(15, 80, 87, 0.3); color: white; position: relative; overflow: hidden;">
                            <span style="position: relative; z-index: 2;">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </span>
                            <div style="position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.5s;"></div>
                        </button>
                    </div>
                </form>


            </div>

            <!-- Footer -->
            <div class="modal-footer justify-content-center border-0" style="background: linear-gradient(145deg, rgba(248, 249, 250, 0.8) 0%, rgba(255, 255, 255, 0.9) 100%); padding: 20px 30px; backdrop-filter: blur(10px);">
                <p class="mb-0" style="font-size: 0.9rem; color: #6b7280;">
                    New to TingUt.no?
                    <a href="#" class="text-decoration-none fw-bold ms-1" style="color: var(--primary-color, #0f5057); transition: all 0.3s ease;" onmouseover="this.style.color='#0a3d42'; this.style.textDecoration='underline';" onmouseout="this.style.color='var(--primary-color, #0f5057)'; this.style.textDecoration='none';" onclick="switchToSignup()">
                        <i class="fas fa-user-plus me-1"></i>Create Account
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add focus/blur effects to inputs
    const inputs = document.querySelectorAll('#loginModal .form-control');
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

    // Password toggle functionality with animation
    const toggleLoginPassword = document.getElementById('toggleLoginPassword');
    const loginPasswordInput = document.getElementById('loginPassword');
    const loginPasswordIcon = document.getElementById('loginPasswordIcon');

    if (toggleLoginPassword) {
        toggleLoginPassword.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => this.style.transform = 'scale(1)', 150);

            const type = loginPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            loginPasswordInput.setAttribute('type', type);

            if (type === 'password') {
                loginPasswordIcon.classList.remove('fa-eye-slash');
                loginPasswordIcon.classList.add('fa-eye');
            } else {
                loginPasswordIcon.classList.remove('fa-eye');
                loginPasswordIcon.classList.add('fa-eye-slash');
            }
        });
    }

    // Button hover effects
    const buttons = document.querySelectorAll('#loginModal .btn');
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
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('loginSubmitBtn');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const email = document.getElementById('loginEmail');
            const password = document.getElementById('loginPassword');
            let isValid = true;

            // Reset previous errors with animation
            [email, password].forEach(field => {
                field.style.borderColor = '#e9ecef';
                field.style.transform = 'translateY(0)';
                const errorDiv = field.parentElement.parentElement.querySelector('.text-danger');
                if (errorDiv) {
                    errorDiv.style.opacity = '0';
                    setTimeout(() => errorDiv.remove(), 300);
                }
            });

            // Validate email
            if (!email.value.trim()) {
                showFieldError(email, 'Email is required');
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                showFieldError(email, 'Please enter a valid email address');
                isValid = false;
            }

            // Validate password
            if (!password.value.trim()) {
                showFieldError(password, 'Password is required');
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
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Signing In...';
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

        field.parentElement.parentElement.appendChild(errorDiv);

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

        #loginModal .btn:hover div:last-child {
            left: 100% !important;
        }
    `;
    document.head.appendChild(style);
});

function switchToSignup() {
    const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
    if (loginModal) {
        // Add fade out effect
        loginModal._element.style.transition = 'opacity 0.3s ease';
        loginModal._element.style.opacity = '0';

        loginModal.hide();

        // Small delay to ensure login modal is hidden before showing signup
        setTimeout(() => {
            const signupModal = new bootstrap.Modal(document.getElementById('signupModal'));
            if (signupModal) {
                signupModal.show();
            }
        }, 300);
    }
}
</script>
