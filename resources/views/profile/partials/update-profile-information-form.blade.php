<section class="form-section">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            <i class="fas fa-user mr-2"></i>{{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information, personal details, and social media links.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Profile Picture -->
        <div>
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <input type="file" id="profile_picture" name="profile_picture" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" accept="image/*">
            <small class="text-gray-500 mt-1 block">Upload a profile picture (JPG, PNG, GIF - max 2MB)</small>
            @if($user->profile_picture)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Current Profile Picture" class="w-20 h-20 rounded-full object-cover border">
                    <p class="text-sm text-gray-600 mt-1">Current profile picture</p>
                </div>
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $user->phone)" autocomplete="tel" placeholder="+47" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <!-- Date of Birth -->
        <div>
            <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
            <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth', $user->date_of_birth)" />
            <x-input-error class="mt-2" :messages="$errors->get('date_of_birth')" />
        </div>

        <!-- Gender -->
        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">Select Gender</option>
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <!-- Bio -->
        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
            <small class="text-gray-500 mt-1 block">Maximum 500 characters</small>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" autocomplete="address-line1" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <!-- City & Country -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-input-label for="city" :value="__('City')" />
                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" autocomplete="address-level2" />
                <x-input-error class="mt-2" :messages="$errors->get('city')" />
            </div>
            <div>
                <x-input-label for="country" :value="__('Country')" />
                <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $user->country)" autocomplete="country" />
                <x-input-error class="mt-2" :messages="$errors->get('country')" />
            </div>
        </div>

        <!-- Social Media Links -->
        <div class="space-y-4">
            <h3 class="text-lg font-medium text-gray-900">Social Media Links</h3>

            <div>
                <x-input-label for="facebook_url" :value="__('Facebook')" />
                <x-text-input id="facebook_url" name="facebook_url" type="url" class="mt-1 block w-full" :value="old('facebook_url', $user->facebook_url)" placeholder="https://facebook.com/yourprofile" />
                <x-input-error class="mt-2" :messages="$errors->get('facebook_url')" />
            </div>

            <div>
                <x-input-label for="twitter_url" :value="__('Twitter')" />
                <x-text-input id="twitter_url" name="twitter_url" type="url" class="mt-1 block w-full" :value="old('twitter_url', $user->twitter_url)" placeholder="https://twitter.com/yourhandle" />
                <x-input-error class="mt-2" :messages="$errors->get('twitter_url')" />
            </div>

            <div>
                <x-input-label for="instagram_url" :value="__('Instagram')" />
                <x-text-input id="instagram_url" name="instagram_url" type="url" class="mt-1 block w-full" :value="old('instagram_url', $user->instagram_url)" placeholder="https://instagram.com/yourusername" />
                <x-input-error class="mt-2" :messages="$errors->get('instagram_url')" />
            </div>

            <div>
                <x-input-label for="linkedin_url" :value="__('LinkedIn')" />
                <x-text-input id="linkedin_url" name="linkedin_url" type="url" class="mt-1 block w-full" :value="old('linkedin_url', $user->linkedin_url)" placeholder="https://linkedin.com/in/yourprofile" />
                <x-input-error class="mt-2" :messages="$errors->get('linkedin_url')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
