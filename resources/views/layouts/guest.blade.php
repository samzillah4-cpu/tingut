<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        @php
            $favicon = \App\Models\Setting::where('key', 'favicon')->first()->value ?? null;
        @endphp
        <link rel="icon" href="{{ $favicon ? asset('storage/' . $favicon) : '/favicon.ico' }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="background-color: #fbf3d7;">
            <div>
                <a href="/">
                    @php
                        $logo = \App\Models\Setting::where('key', 'site_logo')->first()->value ?? null;
                    @endphp
                    @if($logo)
                        <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="w-20 h-20 object-contain" />
                    @else
                        <x-application-logo class="w-20 h-20 fill-current text-primary" />
                    @endif
                </a>
            </div>

            <div class="w-full sm:max-w-sm mt-6 px-6 py-4 bg-white overflow-hidden sm:rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
