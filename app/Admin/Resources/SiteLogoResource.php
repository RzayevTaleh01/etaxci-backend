<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\SiteLogo;

class SiteLogoResource extends Resource
{
    public static string $model = SiteLogo::class;

    public static string $slug = 'logos';

    public static string $label = 'Loqolar';

    public static string $singular = 'Loqo';

    public static string $icon = 'bi-patch-check';

    public static string $group = 'Səhifələr';

    public static bool $sortable = true;

    public static array $search = ['title'];

    public static function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Ad (şəklin alt mətni)', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'image', 'label' => 'Loqo', 'type' => 'image', 'folder' => 'logos', 'max_width' => 800, 'required' => true, 'col' => 6],
            ['name' => 'url', 'label' => 'Link', 'type' => 'url', 'col' => 6, 'help' => 'Boş buraxsanız, ana səhifəyə aparır. Başqa sayta aparan link yeni tabda açılır.'],
            ['name' => 'placement', 'label' => 'Harada göstərilsin', 'type' => 'select', 'options' => SiteLogo::PLACEMENTS, 'required' => true, 'default' => 'both', 'col' => 4, 'rules' => ['in:both,header,footer']],
            ['name' => 'header_height', 'label' => 'Header-də hündürlük (px)', 'type' => 'number', 'default' => 84, 'col' => 4, 'rules' => ['min:24', 'max:200'], 'help' => 'Mobildə avtomatik kiçilir. Standart: 84.'],
            ['name' => 'footer_height', 'label' => 'Footer-də hündürlük (px)', 'type' => 'number', 'default' => 72, 'col' => 4, 'rules' => ['min:24', 'max:200'], 'help' => 'Standart: 72.'],
            ['name' => 'badge', 'label' => 'Ana səhifədə ağ dairə içində göstər', 'type' => 'toggle', 'col' => 6, 'help' => 'Ana səhifədə şəklin üstündə oxunsun deyə (məs. Səhiyyə Nazirliyinin loqosu). Ağ fonlu header və footer-də dairəsiz göstərilir.'],
            ['name' => 'is_active', 'label' => 'Göstər', 'type' => 'toggle', 'default' => true, 'col' => 6],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'image', 'label' => '', 'type' => 'image'],
            ['name' => 'title', 'label' => 'Ad', 'type' => 'text', 'translatable' => true],
            ['name' => 'placement', 'label' => 'Yer', 'type' => 'badge', 'map' => SiteLogo::PLACEMENTS],
            ['name' => 'url', 'label' => 'Link', 'type' => 'text'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
