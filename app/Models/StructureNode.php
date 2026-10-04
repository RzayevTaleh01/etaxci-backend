<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class StructureNode extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public const TYPES = ['council', 'director', 'deputy', 'department', 'unit', 'committee', 'advisor'];

    public array $translatable = ['title'];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /** Builds the nested array consumed by assets/js/org-chart.js. */
    public static function tree(string $locale): ?array
    {
        $all = static::query()->orderBy('sort')->orderBy('id')->get()->groupBy('parent_id');

        $build = function ($node) use (&$build, $all, $locale) {
            $kids = $all->get($node->id, collect());
            $out = ['title' => $node->getTranslation('title', $locale), 'type' => $node->type];

            $main = $kids->whereNull('side')->values();
            if ($main->isNotEmpty()) {
                $out['children'] = $main->map($build)->all();
            }

            foreach (['left', 'right'] as $side) {
                $items = $kids->where('side', $side)->values();
                if ($items->isNotEmpty()) {
                    $out['side'][$side] = $items->map($build)->all();
                }
            }

            return $out;
        };

        $root = $all->get(null, collect())->first();

        return $root ? $build($root) : null;
    }
}
