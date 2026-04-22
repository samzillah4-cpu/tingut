<!-- Combined Auth Modal -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down" role="document" style="max-width: 480px;">
        <div class="modal-content" style="border: none; border-radius: 20px; box-shadow: 0 25px 60px rgba(0,0,0,0.15); overflow: hidden; backdrop-filter: blur(20px);">
            <!-- Header -->
            <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-color, #0f5057) 0%, #1a6b6d 100%); color: white; border: none; padding: 25px 30px 20px; position: relative; overflow: hidden;">
                <!-- Subtle background pattern -->
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: radial-gradient(circle at 30% 20%, rgba(255,255,255,0.1) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(255,255,255,0.05) 0%, transparent 50%);"></div>
                <div style="position: relative; z-index: 2;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                        <div style="background: rgba(255,255,255,0.2); border-radius: 12px; padding: 10px; backdrop-filter: blur(10px);">
                            <i class="fas fa-user-circle fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="modal-title mb-0" id="authModalLabel" style="font-weight: 700; font-size: 1.4rem; letter-spacing: -0.02em; color: white;">Welcome to TingUt.no</h4>
                            <p style="margin: 0; opacity: 0.9; font-size: 0.9rem;">Login or create your account</p>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="position: relative; z-index: 3; filter: drop-shadow(0 2px 8px rgba(0,0,0,0.2));"></button>
            </div>

            <!-- Body with Tabs -->
            <div class="modal-body" style="padding: 0; background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 50%, #ffffff 100%);">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs" id="authTabs" role="tablist" style="border: none; padding: 0 25px; margin-top: 20px;">
                    <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login-tab-pane" type="button" role="tab" aria-controls="login-tab-pane" aria-selected="true" style="background: none; border: none; border-bottom: 3px solid transparent; color: #6c757d; font-weight: 600; padding: 12px 0; width: 100%; transition: all 0.3s ease;">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup-tab-pane" type="button" role="tab" aria-controls="signup-tab-pane" aria-selected="false" style="background: none; border: none; border-bottom: 3px solid transparent; color: #6c757d; font-weight: 600; padding: 12px 0; width: 100%; transition: all 0.3s ease;">
                            <i class="fas fa-user-plus me-2"></i>Sign Up
                        </button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="authTabContent" style="padding: 25px;">
                    <!-- Login Tab -->
                    <div class="tab-pane fade show active" id="login-tab-pane" role="tabpanel" aria-labelledby="login-tab" tabindex="0">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="loginEmail" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                                    <i class="fas fa-envelope me-2 text-muted"></i>Email Address
                                </label>
                                <input type="email" class="form-control" id="loginEmail" name="email" value="{{ old('email') }}" required style="border-radius: 12px; padding: 12px 16px; border: 2px solid #e5e7eb; transition: all 0.3s ease; font-size: 0.9rem;">
                                @error('email')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                                    <i class="fas fa-lock me-2 text-muted"></i>Password
                                </label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="loginPassword" name="password" required style="border-radius: 12px; padding: 12px 16px; padding-right: 45px; border: 2px solid #e5e7eb; transition: all 0.3s ease; font-size: 0.9rem;">
                                    <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('loginPassword')" style="border: none; background: none; color: #6c757d; padding: 0;">
                                        <i class="fas fa-eye" id="loginPasswordIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember" style="border-radius: 4px; border: 2px solid #e5e7eb;">
                                    <label class="form-check-label small fw-medium" for="remember" style="color: #6c757d; margin-left: 6px;">
                                        Remember me
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-decoration-none small fw-medium" style="color: var(--primary-color); transition: color 0.3s ease;">
                                    Forgot password?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, var(--primary-color, #0f5057) 0%, #1a6b6d 100%); color: white; border: none; border-radius: 12px; padding: 14px; font-weight: 600; font-size: 1rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(15, 80, 87, 0.3);">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </form>
                    </div>

                    <!-- Signup Tab -->
                    <div class="tab-pane fade" id="signup-tab-pane" role="tabpanel" aria-labelledby="signup-tab" tabindex="0">
                        <form method="POST" action="{{ route('register') }}" id="signupForm" data-otp-enabled="true">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="signupName" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                                    <i class="fas fa-user me-2 text-muted"></i>Full Name
                                </label>
                                <input type="text" class="form-control" id="signupName" name="name" value="{{ old('name') }}" required style="border-radius: 12px; padding: 12px 16px; border: 2px solid #e5e7eb; transition: all 0.3s ease; font-size: 0.9rem;">
                                @error('name')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="signupEmail" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                                    <i class="fas fa-envelope me-2 text-muted"></i>Email Address
                                </label>
                                <input type="email" class="form-control" id="signupEmail" name="email" value="{{ old('email') }}" required style="border-radius: 12px; padding: 12px 16px; border: 2px solid #e5e7eb; transition: all 0.3s ease; font-size: 0.9rem;">
                                @error('email')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="signupPassword" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                                    <i class="fas fa-lock me-2 text-muted"></i>Password
                                </label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="signupPassword" name="password" required style="border-radius: 12px; padding: 12px 16px; padding-right: 45px; border: 2px solid #e5e7eb; transition: all 0.3s ease; font-size: 0.9rem;">
                                    <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('signupPassword')" style="border: none; background: none; color: #6c757d; padding: 0;">
                                        <i class="fas fa-eye" id="signupPasswordIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="signupPasswordConfirm" class="form-label fw-semibold" style="color: #374151; font-size: 0.9rem; margin-bottom: 8px;">
                                    <i class="fas fa-lock me-2 text-muted"></i>Confirm Password
                                </label>
                                <div class="position-relative">
                                    <input type="password" class="form-control" id="signupPasswordConfirm" name="password_confirmation" required style="border-radius: 12px; padding: 12px 16px; padding-right: 45px; border: 2px solid #e5e7eb; transition: all 0.3s ease; font-size: 0.9rem;">
                                    <button type="button" class="btn position-absolute top-50 end-0 translate-middle-y me-2" onclick="togglePassword('signupPasswordConfirm')" style="border: none; background: none; color: #6c757d; padding: 0;">
                                        <i class="fas fa-eye" id="signupPasswordConfirmIcon"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" name="terms" required style="border-radius: 4px; border: 2px solid #e5e7eb;">
                                    <label class="form-check-label small fw-medium" for="terms" style="color: #6c757d; margin-left: 6px; line-height: 1.4;">
                                        I agree to the <a href="#" class="text-decoration-none fw-semibold" style="color: var(--primary-color);">Terms of Service</a> and <a href="{{ route('privacy-policy') }}" class="text-decoration-none fw-semibold" style="color: var(--primary-color);">Privacy Policy</a>
                                    </label>
                                </div>
                                @error('terms')
                                    <div class="text-danger small mt-1"><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, var(--primary-color, #0f5057) 0%, #1a6b6d 100%); color: white; border: none; border-radius: 12px; padding: 14px; font-weight: 600; font-size: 1rem; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(15, 80, 87, 0.3);">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password toggle function
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(inputId + 'Icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'fas fa-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'fas fa-eye';
    }
}

// Initialize password icons
document.addEventListener('DOMContentLoaded', function() {
    // Set initial eye icons
    const passwordFields = ['loginPassword', 'signupPassword', 'signupPasswordConfirm'];
    passwordFields.forEach(field => {
        const icon = document.getElementById(field + 'Icon');
        if (icon) {
            icon.className = 'fas fa-eye';
        }
    });
});
</script>