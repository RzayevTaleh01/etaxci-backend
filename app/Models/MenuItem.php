<?php

namespace App\Models;

use App\Models\Concerns\Common;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MenuItem extends Model
{
    use Common, HasTranslations;

    protected $guarded = [];

    public array $translatable = ['title'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->where('is_active', true)->orderBy('sort')->orderBy('id');
    }

    public function link(): string
    {
        return localized_url($this->url);
    }

    public function isCurrent(): bool
    {
        if (! $this->url || $this->url === '#') {
            return false;
        }

        $path = '/'.trim(request()->path(), '/');
        $target = rtrim(parse_url(localized_url($this->url), PHP_URL_PATH) ?: '/', '/');

        return rtrim($path, '/') === $target;
    }
}
