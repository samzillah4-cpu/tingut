<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="color: var(--primary-color);">
            {{ __('Edit Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" style="border-left: 4px solid var(--primary-color);">
                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" style="border-left: 4px solid var(--primary-color);">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" style="border-left: 4px solid var(--primary-color);">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-color: {{ config('settings.primary_color', '#1a6969') }};
        }

        .profile-card {
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            box-shadow: 0 8px 25px rgba(26, 105, 105, 0.15) !important;
            transform: translateY(-2px);
        }

        .form-section h2 {
            color: var(--primary-color) !important;
            font-weight: 600;
        }

        .form-section .text-gray-600 {
            color: #6c757d !important;
        }

        .btn-primary {
            background-color: var(--primary-color) !important;
            border-color: var(--primary-color) !important;
        }

        .btn-primary:hover {
            background-color: #0e4a4d !important;
            border-color: #0e4a4d !important;
        }

        .form-control:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(26, 105, 105, 0.25) !important;
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .border-primary {
            border-color: var(--primary-color) !important;
        }
    </style>
</x-app-layout>
