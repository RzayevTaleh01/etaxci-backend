<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\AboutBlock;

class AboutBlockResource extends Resource
{
    public static string $model = AboutBlock::class;

    public static string $slug = 'about-blocks';

    public static string $label = 'Haqqımızda blokları';

    public static string $singular = 'Blok';

    public static string $icon = 'bi-layout-text-window';

    public static string $group = 'Səhifələr';

    public static bool $sortable = true;

    public static array $search = ['title', 'text'];

    public static function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Başlıq (istəyə bağlı)', 'type' => 'text', 'translatable' => true],
            ['name' => 'text', 'label' => 'Mətn', 'type' => 'textarea', 'translatable' => true, 'required' => true],
            ['name' => 'image', 'label' => 'Şəkil', 'type' => 'image', 'folder' => 'about', 'col' => 6, 'help' => 'Blokların şəkilləri növbə ilə sağa/sola düzülür.'],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true, 'col' => 6],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'image', 'label' => '', 'type' => 'image'],
            ['name' => 'title', 'label' => 'Başlıq', 'type' => 'text', 'translatable' => true],
            ['name' => 'text', 'label' => 'Mətn', 'type' => 'text', 'translatable' => true, 'limit' => 90],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
