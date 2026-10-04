<?php

use App\Models\Setting;
use App\Models\Translation;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Storage;

if (! function_exists('locales')) {
    /** @return array<string,string> code => native name */
    function locales(): array
    {
        return config('site.locales');
    }
}

if (! function_exists('media_url')) {
    /** Public URL of an uploaded file, a bundled asset, or an absolute URL. */
    function media_url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }
        if (preg_match('~^(https?:)?//~', $path)) {
            return $path;
        }
        if (str_starts_with($path, 'assets/')) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }
}

if (! function_exists('localized_url')) {
    /** "/news" -> "/az/news"; absolute URLs, "#" and empty values are returned untouched. */
    function localized_url(?string $path, ?string $locale = null): string
    {
        $path = trim((string) $path);
        if ($path === '' || $path === '#') {
            return '#';
        }
        if (preg_match('~^([a-z][a-z0-9+.-]*:|//|#)~i', $path)) {
            return $path;
        }

        $locale ??= app()->getLocale();
        $path = '/'.ltrim($path, '/');

        return url($path === '/' ? "/{$locale}" : "/{$locale}{$path}");
    }
}

if (! function_exists('switch_locale_url')) {
    function switch_locale_url(string $locale): string
    {
        $segments = request()->segments();
        if ($segments && array_key_exists($segments[0], locales())) {
            array_shift($segments);
        }

        $url = url('/'.$locale.($segments ? '/'.implode('/', $segments) : ''));
        $query = request()->getQueryString();

        return $query ? "{$url}?{$query}" : $url;
    }
}

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null, ?string $locale = null): mixed
    {
        return Setting::get($key, $default, $locale);
    }
}

if (! function_exists('t')) {
    /** Interface string: admin-edited translation, then lang/{locale}/site.php, then the key itself. */
    function t(string $key, array $replace = []): string
    {
        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale');
        $row = Translation::map()[$key] ?? [];

        $text = ($row[$locale] ?? '') !== '' ? $row[$locale] : null;
        $text ??= trans("site.{$key}", [], $locale);
        if ($text === "site.{$key}") {
            $text = ($row[$fallback] ?? '') !== '' ? $row[$fallback] : trans("site.{$key}", [], $fallback);
        }
        if ($text === "site.{$key}") {
            $text = $key;
        }

        foreach ($replace as $name => $value) {
            $text = str_replace(':'.$name, (string) $value, $text);
        }

        return $text;
    }
}

if (! function_exists('format_date')) {
    function format_date(?CarbonInterface $date): string
    {
        if (! $date) {
            return '';
        }

        return $date->day.' '.mb_strtolower(t('month.'.$date->month)).', '.$date->year;
    }
}
