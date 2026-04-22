<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    /**
     * Display the OTP verification view.
     */
    public function show(): View
    {
        if (! session()->has('otp_email')) {
            return redirect()->route('login');
        }

        return view('auth.verify-otp');
    }

    /**
     * Verify the OTP code.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $email = session('otp_email');
        $type = session('otp_type');

        if (! $email || ! $type) {
            return redirect()->route('login')->withErrors(['code' => 'Session expired. Please try again.']);
        }

        // Verify the OTP code
        if (! Otp::verifyCode($email, $request->code, $type)) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        if ($type === 'login') {
            // Handle login verification
            $user = User::where('email', $email)->first();

            if (! $user) {
                return redirect()->route('login')->withErrors(['email' => 'User not found.']);
            }

            Auth::login($user);

            // Clear session data
            session()->forget(['otp_email', 'otp_type']);

            return redirect()->intended(route('dashboard', absolute: false));
        } elseif ($type === 'register') {
            // Handle registration verification
            $registrationData = session('registration_data');

            if (! $registrationData) {
                return redirect()->route('register')->withErrors(['code' => 'Registration data not found. Please try again.']);
            }

            $user = User::create([
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'phone' => $registrationData['phone'],
                'location' => $registrationData['location'],
                'password' => Hash::make($registrationData['password']),
            ]);

            // Assign role
            $user->assignRole($registrationData['role']);

            // Trigger notification for admins
            $notificationService = app(\App\Services\NotificationService::class);
            $notificationService->notifyUserRegistered($user);

            event(new Registered($user));

            Auth::login($user);

            // Clear session data
            session()->forget(['otp_email', 'otp_type', 'registration_data']);

            return redirect(route('dashboard', absolute: false));
        }

        return redirect()->route('login')->withErrors(['code' => 'Invalid verification type.']);
    }

    /**
     * Resend the OTP code.
     */
    public function resend(Request $request)
    {
        $email = session('otp_email');
        $type = session('otp_type');

        if (! $email || ! $type) {
            return response()->json(['success' => false, 'message' => 'Session expired. Please try again.']);
        }

        // Generate and send new OTP
        $otp = Otp::createOtp($email, $type);

        // Send OTP notification
        Notification::route('mail', $email)->notify(new OtpNotification($otp, $type));

        return response()->json([
            'success' => true,
            'message' => 'A new verification code has been sent to your email.',
        ]);
    }

    /**
     * Clear the OTP session.
     */
    public function clearSession(Request $request)
    {
        session()->forget(['otp_email', 'otp_type', 'registration_data']);

        return response()->json(['success' => true]);
    }
}
