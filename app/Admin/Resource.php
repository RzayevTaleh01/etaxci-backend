<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
 * Describes one admin module. The generic ResourceController and the generic
 * index / form views are driven entirely by these definitions.
 *
 * Field array keys: name, label, type, translatable, required, rules, options,
 * help, default, col (grid width 1-12), folder, max_width, source (for slug).
 * Field types: text, textarea, richtext, image, gallery, select, datetime, number,
 *              toggle, url, email, slug, password.
 */
abstract class Resource
{
    /** @var class-string<Model> */
    public static string $model;

    public static string $slug;

    public static string $label;

    public static string $singular;

    public static string $icon = 'bi-circle';

    public static string $group = 'Məzmun';

    /** Drag & drop ordering via the `sort` column. */
    public static bool $sortable = false;

    /** Parent column – renders the list as an indented tree. */
    public static ?string $tree = null;

    public static bool $canCreate = true;

    /** Roles allowed to open this module. */
    public static array $roles = ['super-admin', 'admin', 'editor'];

    /** Column => direction used when the list is not sortable. */
    public static array $order = ['id' => 'desc'];

    /** Columns searched by the search box (translatable columns are searched in every language). */
    public static array $search = [];

    abstract public static function fields(): array;

    abstract public static function columns(): array;

    /** Optional select filters: [['name' => 'group', 'label' => '...', 'options' => [...]]]. */
    public static function filters(): array
    {
        return [];
    }

    public static function with(): array
    {
        return [];
    }

    public static function query(): Builder
    {
        return (static::$model)::query()->with(static::with());
    }

    /** Mutate validated data before it is saved. */
    public static function beforeSave(array $data, ?Model $model, Request $request): array
    {
        return $data;
    }

    public static function afterSave(Model $model, Request $request): void {}

    public static function canDelete(Model $model): bool
    {
        return true;
    }

    /** Extra values passed to the form view (e.g. option lists). */
    public static function formData(?Model $model): array
    {
        return [];
    }

    /** Cell text for a computed column (type = "computed"). */
    public static function computed(string $name, Model $model): string
    {
        return '';
    }

    public static function hasActiveFlag(): bool
    {
        return collect(static::fields())->contains('name', 'is_active');
    }

    public static function route(string $action, mixed $param = null): string
    {
        return route('admin.'.static::$slug.'.'.$action, $param);
    }
}
