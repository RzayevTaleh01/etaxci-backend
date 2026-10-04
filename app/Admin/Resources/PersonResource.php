<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\Person;

class PersonResource extends Resource
{
    public static string $model = Person::class;

    public static string $slug = 'people';

    public static string $label = 'Əməkdaşlar və həkimlər';

    public static string $singular = 'Əməkdaş';

    public static string $icon = 'bi-person-badge';

    public static string $group = 'Komanda';

    public static bool $sortable = true;

    public static array $search = ['name', 'position', 'slug'];

    public static function groups(): array
    {
        return [
            'leadership' => 'Rəhbərlik',
            'management' => 'İdarəetmə aparatı',
            'scientific' => 'Elmi hissə',
            'medical' => 'Tibbi hissə',
            'administrative' => 'İnzibati hissə',
            'doctor' => 'Həkimlər',
        ];
    }

    public static function fields(): array
    {
        return [
            ['name' => 'group', 'label' => 'Bölmə', 'type' => 'select', 'options' => self::groups(), 'required' => true, 'col' => 6, 'help' => 'Əməkdaşın hansı səhifədə görünəcəyini müəyyən edir.'],
            ['name' => 'slug', 'label' => 'Link (slug)', 'type' => 'slug', 'source' => 'name', 'col' => 6],
            ['name' => 'name', 'label' => 'Soyadı, adı, ata adı', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'position', 'label' => 'Vəzifə / dərəcə', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'specialty', 'label' => 'İxtisas', 'type' => 'text', 'translatable' => true],
            ['name' => 'bio', 'label' => 'Haqqında (tərcümeyi-hal)', 'type' => 'richtext', 'translatable' => true],
            ['name' => 'photo', 'label' => 'Şəkil', 'type' => 'image', 'folder' => 'people', 'max_width' => 900, 'col' => 6],
            ['name' => 'email', 'label' => 'E-poçt', 'type' => 'email', 'col' => 6],
            ['name' => 'phone', 'label' => 'Telefon', 'type' => 'text', 'col' => 6],
            ['name' => 'facebook', 'label' => 'Facebook linki', 'type' => 'url', 'col' => 6],
            ['name' => 'linkedin', 'label' => 'LinkedIn linki', 'type' => 'url', 'col' => 6],
            ['name' => 'has_degree', 'label' => 'Elmi dərəcəsi var (yalnız həkimlər üçün)', 'type' => 'toggle', 'col' => 4],
            ['name' => 'show_on_home', 'label' => 'Ana səhifədə göstər (direktor)', 'type' => 'toggle', 'col' => 4],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true, 'col' => 4],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'photo', 'label' => '', 'type' => 'image'],
            ['name' => 'name', 'label' => 'Ad', 'type' => 'text', 'translatable' => true],
            ['name' => 'position', 'label' => 'Vəzifə', 'type' => 'text', 'translatable' => true],
            ['name' => 'group', 'label' => 'Bölmə', 'type' => 'badge', 'map' => self::groups()],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    public static function filters(): array
    {
        return [['name' => 'group', 'label' => 'Bütün bölmələr', 'options' => self::groups()]];
    }
}
