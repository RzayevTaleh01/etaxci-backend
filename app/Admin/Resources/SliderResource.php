<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\Slider;

class SliderResource extends Resource
{
    public static string $model = Slider::class;

    public static string $slug = 'sliders';

    public static string $label = 'Slayder (ana səhifə)';

    public static string $singular = 'Slayd';

    public static string $icon = 'bi-images';

    public static string $group = 'Ana səhifə';

    public static bool $sortable = true;

    public static array $search = ['title'];

    public static function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Başlıq', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'text', 'label' => 'Mətn', 'type' => 'textarea', 'translatable' => true],
            ['name' => 'button_text', 'label' => 'Düymə yazısı', 'type' => 'text', 'translatable' => true],
            ['name' => 'button_url', 'label' => 'Düymə linki', 'type' => 'url', 'help' => 'Daxili: /about  — xarici: https://...', 'col' => 6],
            ['name' => 'image', 'label' => 'Fon şəkli (1920x800 tövsiyə olunur)', 'type' => 'image', 'folder' => 'sliders', 'max_width' => 2200, 'col' => 6],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'image', 'label' => '', 'type' => 'image'],
            ['name' => 'title', 'label' => 'Başlıq', 'type' => 'text', 'translatable' => true],
            ['name' => 'button_url', 'label' => 'Link', 'type' => 'text'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
