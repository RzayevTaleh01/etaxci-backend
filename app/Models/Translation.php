<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Translation extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['text' => 'array'];
    }

    /** Admin-editable interface strings: key => [locale => text], cached. */
    public static function map(): array
    {
        return Cache::rememberForever('ui_translations', function () {
            try {
                return static::query()->pluck('text', 'key')->all();
            } catch (\Throwable) {
                return [];
            }
        });
    }

    public static function flush(): void
    {
        Cache::forget('ui_translations');
    }
}
