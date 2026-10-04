<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\FeatureCard;

class FeatureCardResource extends Resource
{
    public static string $model = FeatureCard::class;

    public static string $slug = 'feature-cards';

    public static string $label = 'Ana səhifə kartları';

    public static string $singular = 'Kart';

    public static string $icon = 'bi-grid-1x2';

    public static string $group = 'Ana səhifə';

    public static bool $sortable = true;

    public static array $search = ['title'];

    public static function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Başlıq', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'text', 'label' => 'Qısa mətn', 'type' => 'textarea', 'translatable' => true],
            ['name' => 'url', 'label' => 'Link', 'type' => 'url', 'help' => 'Məs. /about', 'col' => 6],
            ['name' => 'icon', 'label' => 'İkon', 'type' => 'select', 'options' => ['general' => 'Ümumi məlumat', 'leadership' => 'Rəhbərlik', 'structure' => 'Struktur', 'international' => 'Beynəlxalq'], 'col' => 6],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'title', 'label' => 'Başlıq', 'type' => 'text', 'translatable' => true],
            ['name' => 'url', 'label' => 'Link', 'type' => 'text'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
