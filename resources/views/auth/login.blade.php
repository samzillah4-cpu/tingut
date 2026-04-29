<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />

                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                    <i class="fas fa-eye" id="passwordIcon"></i>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>



        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-primary hover:text-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition ease-in-out duration-150" href="{{ route('password.request') }}" style="color: {{ config('settings.primary_color', '#1a6969') }} !important;">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- BankID Login Option -->
    @if(\App\Models\Setting::get('bankid_enabled', false))
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Or</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('bankid.verify', ['redirect' => 'dashboard']) }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-id-card mr-2"></i>
                {{ __('Log in with BankID') }}
            </a>
            <p class="mt-2 text-xs text-center text-gray-500">
                Secure identity verification with BankID
            </p>
        </div>
    </div>
    @endif

    <!-- Social Login Links -->
    @if(\App\Models\Setting::get('facebook_login_enabled', false) || \App\Models\Setting::get('google_login_enabled', false))
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Or continue with</span>
            </div>
        </div>

        <div class="mt-6 grid grid-cols-2 gap-3">
            @if(\App\Models\Setting::get('facebook_login_enabled', false))
            <a href="{{ route('login.facebook') }}" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i class="fab fa-facebook text-blue-600 mr-2"></i>
                Facebook
            </a>
            @endif

            @if(\App\Models\Setting::get('google_login_enabled', false))
            <a href="{{ route('login.google') }}" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i class="fab fa-google text-red-500 mr-2"></i>
                Google
            </a>
            @endif
        </div>
    </div>
    @endif

    @section('js')
    <script>
        // Add any custom JavaScript here
        $(document).ready(function() {
            // Password toggle functionality
            $('#togglePassword').on('click', function() {
                const passwordInput = $('#password');
                const passwordIcon = $('#passwordIcon');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    passwordIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordInput.attr('type', 'password');
                    passwordIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Form validation
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
    @stop
</x-guest-layout>
