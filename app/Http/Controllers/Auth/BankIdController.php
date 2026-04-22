<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\BankIdService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BankIdController extends Controller
{
    protected $bankIdService;

    public function __construct(BankIdService $bankIdService)
    {
        $this->bankIdService = $bankIdService;
    }

    /**
     * Show BankID verification page.
     */
    public function showVerification(Request $request): View
    {
        $redirect = $request->get('redirect', 'home');

        return view('auth.bankid-verify', [
            'redirect' => $redirect,
        ]);
    }

    /**
     * Show BankID login page.
     */
    public function showLogin(Request $request): View
    {
        return view('auth.bankid-verify', [
            'redirect' => 'login',
        ]);
    }

    /**
     * Initiate BankID authentication.
     */
    public function initiate(Request $request): JsonResponse
    {
        $request->validate([
            'national_id' => 'required|string|min:11|max:11',
        ]);

        $result = $this->bankIdService->initiateAuthentication(
            $request,
            $request->national_id
        );

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return redirect()->route('auth.bankid.status');
        }

        return back()->with('error', $result['error'] ?? 'Failed to initiate BankID');
    }

    /**
     * Check BankID authentication status.
     */
    public function status(Request $request): JsonResponse|View
    {
        $result = $this->bankIdService->collectAuthentication($request);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($result);
        }

        return view('auth.bankid-status', $result);
    }

    /**
     * Complete BankID authentication.
     */
    public function complete(Request $request): JsonResponse|RedirectResponse
    {
        $result = $this->bankIdService->collectAuthentication($request);

        if (!$result['success'] || $result['status'] !== 'complete') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Authentication not complete',
                ], 400);
            }

            return back()->with('error', 'BankID authentication not complete');
        }

        // Verify the user with BankID
        $user = $this->bankIdService->verifyAuthentication($request);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'BankID verification successful',
                'redirect' => $request->get('redirect', route('dashboard')),
            ]);
        }

        // Clear session
        $request->session()->forget(['bankid_order_ref', 'bankid_national_id']);

        if ($user) {
            Auth::login($user);
            return redirect()->intended(route('dashboard'))->with('success', 'Identity verified with BankID');
        }

        return back()->with('error', 'Failed to verify BankID credentials');
    }

    /**
     * Cancel BankID authentication.
     */
    public function cancel(Request $request): JsonResponse|RedirectResponse
    {
        $this->bankIdService->cancelAuthentication($request);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'BankID authentication cancelled',
            ]);
        }

        return redirect()->route('login')->with('info', 'BankID authentication cancelled');
    }

    /**
     * Verify BankID for existing user (after login).
     */
    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'national_id' => 'required|string|min:11|max:11',
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'error' => 'User must be logged in',
            ], 401);
        }

        $result = $this->bankIdService->initiateAuthentication(
            $request,
            $request->national_id
        );

        return response()->json($result);
    }

    /**
     * Check if BankID is enabled.
     */
    public function isEnabled(): bool
    {
        return $this->bankIdService->isEnabled();
    }

    /**
     * Check if BankID is required for login.
     */
    public function isRequiredForLogin(): bool
    {
        return $this->bankIdService->isRequiredForLogin();
    }

    /**
     * Check if BankID is required for registration.
     */
    public function isRequiredForRegistration(): bool
    {
        return $this->bankIdService->isRequiredForRegistration();
    }
}
