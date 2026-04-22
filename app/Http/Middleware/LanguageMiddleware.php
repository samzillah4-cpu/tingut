<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\TranslationService;

class LanguageMiddleware
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Get locale from session or default
        $locale = Session::get('locale', config('app.locale', 'en'));

        // Validate locale
        if (!$this->translationService->isLanguageSupported($locale)) {
            $locale = config('app.locale', 'en');
        }

        // Set application locale
        app()->setLocale($locale);

        // Set locale for translator (if available)
        if (class_exists('\Mcamara\LaravelLocalization\Facades\LaravelLocalization')) {
            \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale($locale);
        }

        return $next($request);
    }
}
