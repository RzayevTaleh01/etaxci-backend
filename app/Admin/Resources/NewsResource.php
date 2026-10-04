<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\News;
use App\Models\NewsCategory;

class NewsResource extends Resource
{
    public static string $model = News::class;

    public static string $slug = 'news';

    public static string $label = 'Xəbərlər';

    public static string $singular = 'Xəbər';

    public static string $icon = 'bi-newspaper';

    public static string $group = 'Xəbərlər';

    public static array $search = ['title', 'slug'];

    public static function with(): array
    {
        return ['category'];
    }

    public static function fields(): array
    {
        return [
            ['name' => 'news_category_id', 'label' => 'Kateqoriya', 'type' => 'select', 'options' => NewsCategory::ordered()->get()->mapWithKeys(fn ($c) => [$c->id => $c->name])->all(), 'col' => 6],
            ['name' => 'published_at', 'label' => 'Dərc tarixi', 'type' => 'datetime', 'col' => 6, 'help' => 'Gələcək tarix seçilərsə, xəbər həmin vaxtdan görünəcək.'],
            ['name' => 'title', 'label' => 'Başlıq', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'slug', 'label' => 'Link (slug)', 'type' => 'slug', 'source' => 'title', 'help' => 'Boş buraxsanız, başlıqdan avtomatik yaranır.', 'col' => 6],
            ['name' => 'excerpt', 'label' => 'Qısa məzmun', 'type' => 'textarea', 'translatable' => true],
            ['name' => 'content', 'label' => 'Mətn', 'type' => 'richtext', 'translatable' => true],
            ['name' => 'image', 'label' => 'Əsas şəkil', 'type' => 'image', 'folder' => 'news', 'col' => 6],
            ['name' => 'gallery', 'label' => 'Foto qalereya', 'type' => 'gallery', 'folder' => 'news'],
            ['name' => 'is_featured', 'label' => 'Ana səhifədə əsas xəbər', 'type' => 'toggle', 'col' => 6],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true, 'col' => 6],
            ['name' => 'meta_title', 'label' => 'SEO başlıq', 'type' => 'text', 'translatable' => true],
            ['name' => 'meta_description', 'label' => 'SEO təsvir', 'type' => 'textarea', 'translatable' => true],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'image', 'label' => '', 'type' => 'image'],
            ['name' => 'title', 'label' => 'Başlıq', 'type' => 'text', 'translatable' => true],
            ['name' => 'category.name', 'label' => 'Kateqoriya', 'type' => 'badge'],
            ['name' => 'published_at', 'label' => 'Tarix', 'type' => 'date'],
            ['name' => 'views', 'label' => 'Baxış', 'type' => 'text'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    public static function filters(): array
    {
        return [['name' => 'news_category_id', 'label' => 'Bütün kateqoriyalar', 'options' => NewsCategory::ordered()->get()->mapWithKeys(fn ($c) => [$c->id => $c->name])->all()]];
    }

    public static function query(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::query()->orderByDesc('published_at');
    }
}
