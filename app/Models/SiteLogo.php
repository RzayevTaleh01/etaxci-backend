<?php

namespace App\Models;

use App\Models\Concerns\Common;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SiteLogo extends Model
{
    use Common, HasTranslations;

    public const PLACEMENTS = ['both' => 'Header və footer', 'header' => 'Yalnız header', 'footer' => 'Yalnız footer'];

    protected $guarded = [];

    public array $translatable = ['title'];

    protected function casts(): array
    {
        return ['badge' => 'boolean', 'is_active' => 'boolean', 'header_height' => 'integer', 'footer_height' => 'integer'];
    }

    /** Logos shown in the given area ("header" or "footer"). */
    public function scopeFor(Builder $q, string $area): Builder
    {
        return $q->whereIn('placement', ['both', $area]);
    }

    /** Empty link means the site's home page. */
    public function link(): string
    {
        return $this->url ?: url('/'.app()->getLocale());
    }

    public function isExternal(): bool
    {
        $href = $this->link();

        return ! str_starts_with($href, url('/')) && ! str_starts_with($href, '/');
    }
}
