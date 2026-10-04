<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsView extends Model
{
    public const UPDATED_AT = null;

    protected $guarded = [];

    /** Registers a view for this IP once; returns true only the first time. */
    public static function track(News $news, ?string $ip, ?string $userAgent): bool
    {
        if (! $ip || preg_match('/bot|crawl|spider|slurp|preview|curl|wget/i', (string) $userAgent)) {
            return false;
        }

        $view = static::firstOrCreate(['news_id' => $news->id, 'ip' => $ip]);

        if ($view->wasRecentlyCreated) {
            $news->increment('views');

            return true;
        }

        return false;
    }
}
