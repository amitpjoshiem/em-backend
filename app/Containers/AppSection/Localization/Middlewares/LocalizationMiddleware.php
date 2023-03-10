<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Localization\Middlewares;

use App\Containers\AppSection\Localization\Exceptions\UnsupportedLanguageException;
use App\Ship\Parents\Middlewares\Middleware;
use ArrayIterator;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class LocalizationMiddleware extends Middleware
{
    /**
     * @psalm-return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Find and validate the lang on that request
        $lang = $this->validateLanguage($this->findLanguage($request));

        // Set the local language
        App::setLocale($lang);

        // Get the response after the request is done
        $response = $next($request);

        // Set Content Languages header in the response
        $response->headers->set('Content-Language', $lang);
        // Return the response
        return $response;
    }

    /**
     * Be sure to check $lang of the format 'de-DE,de;q=0.8,en-US;q=0.6,en;q=0.4'
     * this means:
     *  1) give me de-DE if it is available
     *  2) otherwise, give me de
     *  3) otherwise, give me en-US
     *  4) if all fails, give me en.
     *
     * @throws UnsupportedLanguageException
     */
    private function validateLanguage(string $requestLanguages): string
    {
        // Split it up by ","
        $languages = explode(',', $requestLanguages);

        // We need an ArrayIterator because we will be extending the FOREACH below dynamically!
        $languageIterator = new ArrayIterator($languages);

        $supportedLanguages = $this->getSupportedLanguages();

        foreach ($languageIterator as $language) {
            // Split it up by ";"
            $locale = explode(';', $language);

            $currentLocale = $locale[0];

            // Now check, if this locale is "supported"
            if (\in_array($currentLocale, $supportedLanguages, true)) {
                return $currentLocale;
            }

            // now check, if the language to be checked is in the form of de-DE
            if (Str::contains($currentLocale, '-')) {
                // extract the "main" part ("de") and append it to the end of the languages to be checked
                $base = explode('-', $currentLocale);
                $languageIterator->append($base[0]);
            }
        }

        if (config('appSection-localization.force-valid-locale', true)) {
            // We have not found any language that is supported
            throw new UnsupportedLanguageException();
        }

        return config('app.fallback_locale');
    }

    private function getSupportedLanguages(): array
    {
        $supportedLocales = [];

        $locales = (array)config('appSection-localization.supported_languages');

        foreach ($locales as $key => $value) {
            // It is a "simple" language code (e.g., "en")!
            if (!\is_array($value)) {
                $supportedLocales[] = $value;
            }

            // It is a combined language-code (e.g., "en-US")
            if (\is_array($value)) {
                foreach ($value as $k => $v) {
                    $supportedLocales[] = $v;
                }

                $supportedLocales[] = $key;
            }
        }

        return $supportedLocales;
    }

    private function findLanguage(Request $request): string
    {
        /**
         * Read the accept-language from the request if the header is missing, use the default local language.
         */
        $language = config('app.locale');

        if ($request->hasHeader('Accept-Language')) {
            $language = $request->header('Accept-Language');
        }

        return \is_string($language) ? (string)$language : config('app.locale');
    }
}
