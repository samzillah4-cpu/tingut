<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialLoginController extends Controller
{
    public function redirectToFacebook()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
        if (!isset($settings['facebook_login_enabled']) || $settings['facebook_login_enabled'] != '1') {
            abort(404);
        }

        config([
            'services.facebook.client_id' => $settings['facebook_app_id'] ?? '',
            'services.facebook.client_secret' => $settings['facebook_app_secret'] ?? '',
            'services.facebook.redirect' => url('login/facebook/callback'),
        ]);

        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
        config([
            'services.facebook.client_id' => $settings['facebook_app_id'] ?? '',
            'services.facebook.client_secret' => $settings['facebook_app_secret'] ?? '',
            'services.facebook.redirect' => url('login/facebook/callback'),
        ]);

        try {
            $user = Socialite::driver('facebook')->user();

            $existingUser = User::where('email', $user->getEmail())->first();

            if ($existingUser) {
                Auth::login($existingUser);
            } else {
                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make(Str::random(16)),
                    'email_verified_at' => now(),
                ]);

                $newUser->assignRole('Customer');
                Auth::login($newUser);
            }

            return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['social' => 'Unable to login with Facebook.']);
        }
    }

    public function redirectToGoogle()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
        if (!isset($settings['google_login_enabled']) || $settings['google_login_enabled'] != '1') {
            abort(404);
        }

        config([
            'services.google.client_id' => $settings['google_client_id'] ?? '',
            'services.google.client_secret' => $settings['google_client_secret'] ?? '',
            'services.google.redirect' => url('login/google/callback'),
        ]);

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
        config([
            'services.google.client_id' => $settings['google_client_id'] ?? '',
            'services.google.client_secret' => $settings['google_client_secret'] ?? '',
            'services.google.redirect' => url('login/google/callback'),
        ]);

        try {
            $user = Socialite::driver('google')->user();

            $existingUser = User::where('email', $user->getEmail())->first();

            if ($existingUser) {
                Auth::login($existingUser);
            } else {
                $newUser = User::create([
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'password' => Hash::make(Str::random(16)),
                    'email_verified_at' => now(),
                ]);

                $newUser->assignRole('Customer');
                Auth::login($newUser);
            }

            return redirect()->intended('/dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['social' => 'Unable to login with Google.']);
        }
    }
}
