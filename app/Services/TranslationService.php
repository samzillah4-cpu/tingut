<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    protected $translator;
    protected $supportedLanguages = ['en', 'nb'];

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    /**
     * Translate text to specified language
     */
    public function translate(string $text, string $targetLanguage, string $sourceLanguage = 'auto'): string
    {
        if (empty($text) || !in_array($targetLanguage, $this->supportedLanguages)) {
            return $text;
        }

        // Create cache key
        $cacheKey = 'translation_' . md5($text . $sourceLanguage . $targetLanguage);

        // Check cache first
        $cached = Cache::get($cacheKey);
        if ($cached) {
            return $cached;
        }

        try {
            $this->translator->setSource($sourceLanguage);
            $this->translator->setTarget($targetLanguage);

            $translated = $this->translator->translate($text);

            // Cache for 24 hours
            Cache::put($cacheKey, $translated, now()->addHours(24));

            return $translated;
        } catch (\Exception $e) {
            Log::error('Translation failed: ' . $e->getMessage());
            return $text; // Return original text on error
        }
    }

    /**
     * Translate array of texts
     */
    public function translateArray(array $texts, string $targetLanguage, string $sourceLanguage = 'auto'): array
    {
        $translated = [];
        foreach ($texts as $key => $text) {
            $translated[$key] = $this->translate($text, $targetLanguage, $sourceLanguage);
        }
        return $translated;
    }

    /**
     * Get supported languages
     */
    public function getSupportedLanguages(): array
    {
        return $this->supportedLanguages;
    }

    /**
     * Check if language is supported
     */
    public function isLanguageSupported(string $language): bool
    {
        return in_array($language, $this->supportedLanguages);
    }

    /**
     * Clear translation cache
     */
    public function clearCache(): void
    {
        Cache::forget('translation_*');
    }
}
