<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\Partner;

class PartnerResource extends Resource
{
    public static string $model = Partner::class;

    public static string $slug = 'partners';

    public static string $label = 'Beynəlxalq tərəfdaşlar';

    public static string $singular = 'Tərəfdaş';

    public static string $icon = 'bi-globe2';

    public static string $group = 'Səhifələr';

    public static bool $sortable = true;

    public static array $search = ['name'];

    public static function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Ad', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'url', 'label' => 'Sayt linki', 'type' => 'url', 'col' => 6],
            ['name' => 'logo', 'label' => 'Loqo', 'type' => 'image', 'folder' => 'partners', 'max_width' => 600, 'col' => 6],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'logo', 'label' => '', 'type' => 'image'],
            ['name' => 'name', 'label' => 'Ad', 'type' => 'text', 'translatable' => true],
            ['name' => 'url', 'label' => 'Link', 'type' => 'text'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
