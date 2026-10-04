<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\StructureNode;
use Illuminate\Database\Eloquent\Model;

class StructureNodeResource extends Resource
{
    public static string $model = StructureNode::class;

    public static string $slug = 'structure';

    public static string $label = 'Təşkilati struktur';

    public static string $singular = 'Struktur bölməsi';

    public static string $icon = 'bi-diagram-3';

    public static string $group = 'Komanda';

    public static ?string $tree = 'parent_id';

    public static array $search = ['title'];

    public static function typeLabels(): array
    {
        return [
            'council' => 'Şura',
            'director' => 'Rəhbərlik',
            'deputy' => 'Müavin',
            'department' => 'Departament',
            'unit' => 'Şöbə',
            'committee' => 'Komitə',
            'advisor' => 'Müşavir / xidmət',
        ];
    }

    public static function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Ad', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'parent_id', 'label' => 'Üst bölmə', 'type' => 'select', 'options' => static::parentOptions(), 'col' => 6, 'help' => 'Boş buraxılan bölmə sxemin kökü (yuxarıdakı qutu) olur.'],
            ['name' => 'type', 'label' => 'Növ (rəng)', 'type' => 'select', 'options' => self::typeLabels(), 'required' => true, 'col' => 6],
            ['name' => 'side', 'label' => 'Yerləşmə', 'type' => 'select', 'options' => ['left' => 'Yan qutu — sol', 'right' => 'Yan qutu — sağ'], 'col' => 6, 'help' => 'Boş = üst bölmənin altında. Sol/sağ = yan qutu.'],
            ['name' => 'sort', 'label' => 'Sıra', 'type' => 'number', 'default' => 0, 'col' => 6],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'title', 'label' => 'Ad', 'type' => 'text', 'translatable' => true, 'tree' => true],
            ['name' => 'type', 'label' => 'Növ', 'type' => 'badge', 'map' => self::typeLabels()],
            ['name' => 'side', 'label' => 'Yan', 'type' => 'badge', 'map' => ['left' => 'sol', 'right' => 'sağ']],
            ['name' => 'sort', 'label' => 'Sıra', 'type' => 'text'],
        ];
    }

    private static function parentOptions(): array
    {
        $all = StructureNode::orderBy('sort')->orderBy('id')->get()->groupBy('parent_id');
        $out = [];
        $walk = function ($parentId, $depth) use (&$walk, $all, &$out) {
            foreach ($all->get($parentId, collect()) as $n) {
                $out[$n->id] = str_repeat('— ', $depth).$n->title;
                $walk($n->id, $depth + 1);
            }
        };
        $walk(null, 0);

        return $out;
    }

    public static function canDelete(Model $model): bool
    {
        return true; // children are removed by the cascading foreign key
    }
}
