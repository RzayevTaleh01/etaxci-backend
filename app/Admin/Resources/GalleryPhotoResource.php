<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\GalleryPhoto;

class GalleryPhotoResource extends Resource
{
    public static string $model = GalleryPhoto::class;

    public static string $slug = 'gallery-photos';

    public static string $label = 'Foto qalereya';

    public static string $singular = 'Foto';

    public static string $icon = 'bi-camera';

    public static string $group = 'Qalereya';

    public static bool $sortable = true;

    public static array $search = ['title'];

    public static function fields(): array
    {
        return [
            ['name' => 'image', 'label' => 'Şəkil', 'type' => 'image', 'folder' => 'gallery', 'required' => true, 'col' => 6],
            ['name' => 'title', 'label' => 'Başlıq / izah', 'type' => 'text', 'translatable' => true],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'image', 'label' => 'Şəkil', 'type' => 'image'],
            ['name' => 'title', 'label' => 'Başlıq', 'type' => 'text', 'translatable' => true],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
