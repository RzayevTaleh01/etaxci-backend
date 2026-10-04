<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\GalleryVideo;

class GalleryVideoResource extends Resource
{
    public static string $model = GalleryVideo::class;

    public static string $slug = 'gallery-videos';

    public static string $label = 'Video qalereya';

    public static string $singular = 'Video';

    public static string $icon = 'bi-play-btn';

    public static string $group = 'Qalereya';

    public static bool $sortable = true;

    public static array $search = ['title', 'youtube_url'];

    public static function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Başlıq', 'type' => 'text', 'translatable' => true],
            ['name' => 'youtube_url', 'label' => 'YouTube linki', 'type' => 'url', 'required' => true, 'col' => 6, 'help' => 'Məs. https://www.youtube.com/watch?v=...'],
            ['name' => 'thumbnail', 'label' => 'Üz şəkli (boş qalsa YouTube-dan götürülür)', 'type' => 'image', 'folder' => 'gallery', 'col' => 6],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'title', 'label' => 'Başlıq', 'type' => 'text', 'translatable' => true],
            ['name' => 'youtube_url', 'label' => 'Link', 'type' => 'text'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
