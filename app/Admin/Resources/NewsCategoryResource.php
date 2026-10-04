<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\NewsCategory;

class NewsCategoryResource extends Resource
{
    public static string $model = NewsCategory::class;

    public static string $slug = 'news-categories';

    public static string $label = 'Xəbər kateqoriyaları';

    public static string $singular = 'Kateqoriya';

    public static string $icon = 'bi-tags';

    public static string $group = 'Xəbərlər';

    public static bool $sortable = true;

    public static array $search = ['name', 'slug'];

    public static function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Ad', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'slug', 'label' => 'Link (slug)', 'type' => 'slug', 'source' => 'name', 'col' => 6],
            ['name' => 'badge_style', 'label' => 'Etiket rəngi', 'type' => 'select', 'options' => ['blue' => 'Mavi', 'default' => 'Standart'], 'col' => 6],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'name', 'label' => 'Ad', 'type' => 'text', 'translatable' => true],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    public static function canDelete($model): bool
    {
        return $model->news()->count() === 0;
    }
}
