<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\Page;

class PageResource extends Resource
{
    public static string $model = Page::class;

    public static string $slug = 'pages';

    public static string $label = 'Səhifələr';

    public static string $singular = 'Səhifə';

    public static string $icon = 'bi-file-earmark-text';

    public static string $group = 'Səhifələr';

    public static array $order = ['is_system' => 'desc', 'id' => 'asc'];

    public static array $search = ['title', 'slug'];

    public static function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Başlıq', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'subtitle', 'label' => 'Alt başlıq / qısa qeyd', 'type' => 'text', 'translatable' => true],
            ['name' => 'slug', 'label' => 'Link (slug)', 'type' => 'slug', 'source' => 'title', 'col' => 6, 'help' => 'Sistem səhifələrinin slug-ını dəyişməyin.'],
            ['name' => 'template', 'label' => 'Şablon', 'type' => 'select', 'options' => ['info' => 'Məlumat (mətn + loqo)', 'international' => 'Beynəlxalq (banner + kart)', 'plain' => 'Sadə mətn'], 'col' => 6],
            ['name' => 'content', 'label' => 'Məzmun', 'type' => 'richtext', 'translatable' => true],
            ['name' => 'image', 'label' => 'Şəkil / loqo', 'type' => 'image', 'folder' => 'pages', 'col' => 6],
            ['name' => 'banner', 'label' => 'Banner (yalnız beynəlxalq şablon)', 'type' => 'image', 'folder' => 'pages', 'max_width' => 2200, 'col' => 6],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true],
            ['name' => 'meta_title', 'label' => 'SEO başlıq', 'type' => 'text', 'translatable' => true],
            ['name' => 'meta_description', 'label' => 'SEO təsvir', 'type' => 'textarea', 'translatable' => true],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'title', 'label' => 'Başlıq', 'type' => 'text', 'translatable' => true],
            ['name' => 'slug', 'label' => 'Slug', 'type' => 'text'],
            ['name' => 'is_system', 'label' => 'Sistem', 'type' => 'bool'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    public static function canDelete($model): bool
    {
        return ! $model->is_system;
    }
}
