<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['value' => 'array'];
    }

    /** All settings as key => raw value (string, or locale => string array), cached. */
    public static function allValues(): array
    {
        return Cache::rememberForever('settings', function () {
            try {
                return static::query()->pluck('value', 'key')->all();
            } catch (\Throwable) {
                return [];
            }
        });
    }

    public static function get(string $key, mixed $default = null, ?string $locale = null): mixed
    {
        $value = static::allValues()[$key] ?? null;

        if (is_array($value)) {
            $locale ??= app()->getLocale();
            $value = ($value[$locale] ?? '') !== '' ? $value[$locale] : ($value[config('app.fallback_locale')] ?? null);
        }

        return ($value === null || $value === '') ? $default : $value;
    }

    public static function put(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings');
    }
}
