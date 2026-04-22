<x-guest-layout>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password toggle functionality
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');

            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            const confirmPasswordIcon = document.getElementById('confirmPasswordIcon');

            // Toggle password visibility
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle icon
                if (type === 'password') {
                    passwordIcon.classList.remove('fa-eye-slash');
                    passwordIcon.classList.add('fa-eye');
                } else {
                    passwordIcon.classList.remove('fa-eye');
                    passwordIcon.classList.add('fa-eye-slash');
                }
            });

            // Toggle confirm password visibility
            toggleConfirmPassword.addEventListener('click', function() {
                const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                confirmPasswordInput.setAttribute('type', type);

                // Toggle icon
                if (type === 'password') {
                    confirmPasswordIcon.classList.remove('fa-eye-slash');
                    confirmPasswordIcon.classList.add('fa-eye');
                } else {
                    confirmPasswordIcon.classList.remove('fa-eye');
                    confirmPasswordIcon.classList.add('fa-eye-slash');
                }
            });
        });
    </script>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" autocomplete="tel" placeholder="+47" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Location -->
        <div class="mt-4">
            <x-input-label for="location" :value="__('Location')" />
            <select id="location" class="block mt-1 w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm" name="location" required>
                <option value="">Select your location</option>
                <option value="Agder" {{ old('location') == 'Agder' ? 'selected' : '' }}>Agder</option>
                <option value="Innlandet" {{ old('location') == 'Innlandet' ? 'selected' : '' }}>Innlandet</option>
                <option value="Møre og Romsdal" {{ old('location') == 'Møre og Romsdal' ? 'selected' : '' }}>Møre og Romsdal</option>
                <option value="Nordland" {{ old('location') == 'Nordland' ? 'selected' : '' }}>Nordland</option>
                <option value="Oslo" {{ old('location') == 'Oslo' ? 'selected' : '' }}>Oslo</option>
                <option value="Rogaland" {{ old('location') == 'Rogaland' ? 'selected' : '' }}>Rogaland</option>
                <option value="Troms og Finnmark" {{ old('location') == 'Troms og Finnmark' ? 'selected' : '' }}>Troms og Finnmark</option>
                <option value="Trøndelag" {{ old('location') == 'Trøndelag' ? 'selected' : '' }}>Trøndelag</option>
                <option value="Vestfold og Telemark" {{ old('location') == 'Vestfold og Telemark' ? 'selected' : '' }}>Vestfold og Telemark</option>
                <option value="Vestland" {{ old('location') == 'Vestland' ? 'selected' : '' }}>Vestland</option>
                <option value="Viken" {{ old('location') == 'Viken' ? 'selected' : '' }}>Viken</option>
            </select>
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-eye" id="passwordIcon"></i>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <div class="relative">
                <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10"
                             type="password"
                             name="password_confirmation" required autocomplete="new-password" />
                <button type="button" id="toggleConfirmPassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />

            <select id="role" class="block mt-1 w-full border-gray-300 focus:border-primary focus:ring-primary rounded-md shadow-sm" name="role" required>
                <option value="Customer" {{ old('role', 'Customer') == 'Customer' ? 'selected' : '' }}>Customer</option>
                <option value="Seller" {{ old('role') == 'Seller' ? 'selected' : '' }}>Seller</option>
            </select>

            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-primary hover:text-secondary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition ease-in-out duration-150" href="{{ route('login') }}" style="color: var(--primary-color) !important;">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <!-- BankID Registration Option -->
    @if(\App\Models\Setting::get('bankid_enabled', false) && \App\Models\Setting::get('bankid_required_for_registration', false))
    <div class="mt-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Or verify with</span>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('bankid.verify', ['redirect' => 'dashboard']) }}" class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                <i class="fas fa-id-card mr-2"></i>
                {{ __('Register with BankID') }}
            </a>
            <p class="mt-2 text-xs text-center text-gray-500">
                Verify your identity with BankID for instant verification
            </p>
        </div>
    </div>
    @endif

</x-guest-layout>
