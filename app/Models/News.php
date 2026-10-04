<?php

namespace App\Models;

use App\Models\Concerns\Common;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class News extends Model
{
    use Common, HasTranslations;

    protected $table = 'news';

    protected $guarded = [];

    public array $translatable = ['title', 'excerpt', 'content', 'meta_title', 'meta_description'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'datetime',
            'gallery' => 'array',
        ];
    }

    public function category()
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function scopePublished($q)
    {
        return $q->where('news.is_active', true)
            ->where(fn ($w) => $w->whereNull('news.published_at')->orWhere('news.published_at', '<=', now()));
    }

    public function url(): string
    {
        return route('site.news.show', $this->slug);
    }

    public function summary(int $limit = 140): string
    {
        $text = $this->excerpt ?: strip_tags((string) $this->content);

        return Str::limit(trim(html_entity_decode($text)), $limit);
    }
}
