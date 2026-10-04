<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $values = [
            'site_name' => ['az' => 'Elmi-Tədqiqat Ağciyər Xəstəlikləri İnstitutu', 'en' => 'Research Institute of Lung Diseases', 'ru' => 'Научно-исследовательский институт лёгочных заболеваний'],
            'site_short_name' => 'ETACXİ',
            'meta_description' => [
                'az' => 'Elmi-Tədqiqat Ağciyər Xəstəlikləri İnstitutunun rəsmi saytı: xəbərlər, rəhbərlik, struktur, qəbul günləri və vətəndaşlar üçün məlumat.',
                'en' => 'Official website of the Research Institute of Lung Diseases: news, leadership, structure, reception days and information for citizens.',
                'ru' => 'Официальный сайт Научно-исследовательского института лёгочных заболеваний: новости, руководство, структура, дни приёма и информация для граждан.',
            ],
            'footer_copy' => [
                'az' => 'Elmi-Tədqiqat Ağciyər Xəstəlikləri İnstitutu. Bütün hüquqlar qorunur.',
                'en' => 'Research Institute of Lung Diseases. All rights reserved.',
                'ru' => 'Научно-исследовательский институт лёгочных заболеваний. Все права защищены.',
            ],
            'address' => [
                'az' => 'Bakı şəhəri, Nizami rayonu, Məmmədəli Şərifli küçəsi, 163',
                'en' => '163 Mammadali Sharifli Street, Nizami district, Baku',
                'ru' => 'г. Баку, Низаминский район, ул. Мамедали Шарифли, 163',
            ],
            'phones' => "(+99412) 4214498\n(+99412) 4212262\n(+99412) 4212361\n(+99412) 4212171",
            'email' => 'etacxi@esehiyye.az',
            'work_hours' => ['az' => '09:00-18:00', 'en' => '09:00-18:00', 'ru' => '09:00-18:00'],
            'map_embed' => 'https://www.google.com/maps?q=M%C9%99mm%C9%99d%C9%99li+%C5%9E%C9%99rifli+163,+Bak%C4%B1&output=embed&hl=az',
            'contact_notify_email' => 'etacxi@esehiyye.az',
        ];

        foreach ($values as $key => $value) {
            Setting::put($key, $value);
        }
    }
}
