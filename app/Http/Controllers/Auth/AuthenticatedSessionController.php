<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Check if user exists and password is correct
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Auth::validate(['email' => $request->email, 'password' => $request->password])) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        // Generate and send OTP for login verification
        $otp = Otp::createOtp($request->email, 'login');

        // Log OTP for localhost testing
        if (app()->environment('local')) {
            Log::info("🔐 LOGIN OTP for {$request->email}: {$otp->code}");
        }

        // Send OTP notification
        Notification::route('mail', $request->email)->notify(new OtpNotification($otp, 'login'));

        // Store email and type in session for OTP verification
        session(['otp_email' => $request->email, 'otp_type' => 'login']);

        return redirect()->route('otp.verify')->with('success', 'A verification code has been sent to your email.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
