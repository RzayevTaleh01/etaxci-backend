<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\Faq;

class FaqResource extends Resource
{
    public static string $model = Faq::class;

    public static string $slug = 'faqs';

    public static string $label = 'Tez-tez verilən suallar';

    public static string $singular = 'Sual';

    public static string $icon = 'bi-question-circle';

    public static string $group = 'Vətəndaşlar üçün';

    public static bool $sortable = true;

    public static array $search = ['question', 'answer'];

    public static function fields(): array
    {
        return [
            ['name' => 'question', 'label' => 'Sual', 'type' => 'text', 'translatable' => true, 'required' => true],
            ['name' => 'answer', 'label' => 'Cavab', 'type' => 'textarea', 'translatable' => true, 'required' => true, 'help' => 'Boş sətirlə ayrılan hissələr ayrı abzas olur.'],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'question', 'label' => 'Sual', 'type' => 'text', 'translatable' => true],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }
}
