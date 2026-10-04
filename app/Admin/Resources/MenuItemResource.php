<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\MenuItem;

class MenuItemResource extends Resource
{
    public static string $model = MenuItem::class;

    public static string $slug = 'menu';

    public static string $label = 'Menyu meneceri';

    public static string $singular = 'Menyu maddəsi';

    public static string $icon = 'bi-list-nested';

    public static string $group = 'Sayt';

    public static ?string $tree = 'parent_id';

    public static array $roles = ['super-admin', 'admin'];

    public static array $search = ['title', 'url'];

    public static function locations(): array
    {
        return ['header' => 'Üst menyu', 'footer' => 'Footer'];
    }

    public static function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Ad', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'location', 'label' => 'Yer', 'type' => 'select', 'options' => self::locations(), 'required' => true, 'col' => 6],
            ['name' => 'parent_id', 'label' => 'Üst maddə', 'type' => 'select', 'options' => MenuItem::whereNull('parent_id')->orderBy('location')->orderBy('sort')->get()->mapWithKeys(fn ($m) => [$m->id => '['.(self::locations()[$m->location] ?? '').'] '.$m->title])->all(), 'col' => 6, 'help' => 'Boş = əsas səviyyə.'],
            ['name' => 'url', 'label' => 'Link', 'type' => 'url', 'col' => 6, 'help' => 'Daxili səhifə üçün /about, /news, /doctors; xarici üçün https://...; açılan menyu başlığı üçün # yazın.'],
            ['name' => 'sort', 'label' => 'Sıra', 'type' => 'number', 'default' => 0, 'col' => 3],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true, 'col' => 3],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'title', 'label' => 'Ad', 'type' => 'text', 'translatable' => true, 'tree' => true],
            ['name' => 'url', 'label' => 'Link', 'type' => 'text'],
            ['name' => 'location', 'label' => 'Yer', 'type' => 'badge', 'map' => self::locations()],
            ['name' => 'sort', 'label' => 'Sıra', 'type' => 'text'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    public static function filters(): array
    {
        return [['name' => 'location', 'label' => 'Bütün yerlər', 'options' => self::locations()]];
    }

    public static function afterSave($model, $request): void
    {
        cache()->forget('menus');
    }
}
