<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Services\TranslationService;

class LanguageController extends Controller
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Switch language
     */
    public function switch(Request $request, $locale)
    {
        // Validate locale
        if (!$this->translationService->isLanguageSupported($locale)) {
            $locale = config('app.locale', 'en');
        }

        // Store in session
        Session::put('locale', $locale);

        // Set app locale
        app()->setLocale($locale);

        // Redirect back with success message
        return Redirect::back()->with('success', __('Language switched successfully'));
    }

    /**
     * Get current language
     */
    public function current()
    {
        return response()->json([
            'locale' => app()->getLocale(),
            'supported_languages' => $this->translationService->getSupportedLanguages()
        ]);
    }

    /**
     * Translate text via AJAX
     */
    public function translate(Request $request)
    {
        $request->validate([
            'text' => 'required|string',
            'target_language' => 'required|string|in:en,nb',
            'source_language' => 'nullable|string'
        ]);

        $translated = $this->translationService->translate(
            $request->text,
            $request->target_language,
            $request->source_language ?? 'auto'
        );

        return response()->json([
            'original' => $request->text,
            'translated' => $translated,
            'target_language' => $request->target_language
        ]);
    }
}
