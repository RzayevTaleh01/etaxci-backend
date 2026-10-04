<?php

namespace App\Models;

use App\Models\Concerns\Common;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class NewsCategory extends Model
{
    use Common, HasTranslations;

    protected $guarded = [];

    public array $translatable = ['name'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function url(): string
    {
        return route('site.news.category', $this->slug);
    }
}
