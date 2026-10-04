<?php

return [
    'locales' => [
        'az' => 'Azərbaycanca',
        'en' => 'English',
        'ru' => 'Русский',
    ],

    'default_locale' => 'az',

    /*
     * Editable site settings (admin: "Ümumi parametrlər").
     * type: text | textarea | image | url ; translatable values are stored per language.
     */
    'settings' => [
        'Ümumi' => [
            ['key' => 'site_name', 'label' => 'Sayt adı', 'type' => 'text', 'translatable' => true],
            ['key' => 'site_short_name', 'label' => 'Qısa ad', 'type' => 'text'],
            ['key' => 'logo', 'label' => 'Loqo', 'type' => 'image'],
            ['key' => 'og_image', 'label' => 'Sosial şəbəkə şəkli (OG, 1200x630)', 'type' => 'image'],
            ['key' => 'meta_description', 'label' => 'Əsas SEO təsviri', 'type' => 'textarea', 'translatable' => true],
            ['key' => 'footer_copy', 'label' => 'Footer yazısı', 'type' => 'text', 'translatable' => true],
        ],
        'Əlaqə' => [
            ['key' => 'address', 'label' => 'Ünvan', 'type' => 'text', 'translatable' => true],
            ['key' => 'phones', 'label' => 'Telefonlar (hər sətirdə bir nömrə, məs. +994124214498)', 'type' => 'textarea'],
            ['key' => 'email', 'label' => 'E-poçt', 'type' => 'text'],
            ['key' => 'work_hours', 'label' => 'İş saatları', 'type' => 'text', 'translatable' => true],
            ['key' => 'map_embed', 'label' => 'Google Maps embed linki', 'type' => 'text'],
            ['key' => 'contact_notify_email', 'label' => 'Müraciətlərin göndəriləcəyi e-poçt', 'type' => 'text'],
        ],
        'Sosial şəbəkələr' => [
            ['key' => 'instagram', 'label' => 'Instagram', 'type' => 'url'],
            ['key' => 'facebook', 'label' => 'Facebook', 'type' => 'url'],
            ['key' => 'youtube', 'label' => 'YouTube', 'type' => 'url'],
            ['key' => 'x', 'label' => 'X (Twitter)', 'type' => 'url'],
            ['key' => 'linkedin', 'label' => 'LinkedIn', 'type' => 'url'],
        ],
    ],
];
