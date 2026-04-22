<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Notifications\OtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['required', 'string'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:Customer,Seller'],
        ]);

        // Store registration data in session
        session([
            'registration_data' => [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'location' => $request->location,
                'password' => $request->password,
                'role' => $request->role,
            ],
        ]);

        // Generate and send OTP
        $otp = Otp::createOtp($request->email, 'register');

        // Log OTP for localhost testing
        if (app()->environment('local')) {
            \Log::info("🔐 REGISTRATION OTP for {$request->email}: {$otp->code}");
        }

        // Send OTP notification
        Notification::route('mail', $request->email)->notify(new OtpNotification($otp, 'register'));

        // Store email in session for OTP verification
        session(['otp_email' => $request->email, 'otp_type' => 'register']);

        return redirect()->route('otp.verify')->with('success', 'A verification code has been sent to your email.');
    }
}
