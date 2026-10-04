<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\Reception;

class ReceptionResource extends Resource
{
    public static string $model = Reception::class;

    public static string $slug = 'receptions';

    public static string $label = 'Qəbul günləri';

    public static string $singular = 'Qəbul';

    public static string $icon = 'bi-calendar-check';

    public static string $group = 'Vətəndaşlar üçün';

    public static bool $sortable = true;

    public static array $search = ['position', 'name'];

    public static function fields(): array
    {
        return [
            ['name' => 'position', 'label' => 'Vəzifə', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'name', 'label' => 'Soyadı, adı, ata adı', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'schedule', 'label' => 'Qəbul günü və vaxtı', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'email', 'label' => 'E-poçt', 'type' => 'email', 'col' => 6],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true, 'col' => 6],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'position', 'label' => 'Vəzifə', 'type' => 'text', 'translatable' => true],
            ['name' => 'name', 'label' => 'Ad', 'type' => 'text', 'translatable' => true],
            ['name' => 'schedule', 'label' => 'Qəbul vaxtı', 'type' => 'text', 'translatable' => true],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
