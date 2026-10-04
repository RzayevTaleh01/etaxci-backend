<?php

namespace Database\Seeders;

use App\Models\FeatureCard;
use App\Models\Slider;
use Illuminate\Database\Seeder;

class HomeSeeder extends Seeder
{
    public function run(): void
    {
        Slider::query()->delete();
        FeatureCard::query()->delete();

        $sliders = [
            [
                'title' => ['az' => 'Elmi-Tədqiqat Ağciyər Xəstəlikləri İnstitutu', 'en' => 'Research Institute of Lung Diseases', 'ru' => 'Научно-исследовательский институт лёгочных заболеваний'],
                'text' => [
                    'az' => 'Azərbaycanda tibb elminin, o cümlədən ağciyər xəstəlikləri və vərəm əleyhinə mübarizənin elmi əsaslarının qurulması 1919-cu ildə Baki Dövlət Universitetinin yaradılması və onun nəzdində tibb fakültəsinin açılması ilə sıx bağlıdır. Vərəmin respublikada yayılmasını nəzərə alaraq, onun...',
                    'en' => 'The foundation of medical science in Azerbaijan, including the scientific basis of the fight against lung diseases and tuberculosis, is closely linked to the establishment of Baku State University and its Faculty of Medicine in 1919. Taking into account the spread of tuberculosis in the republic...',
                    'ru' => 'Становление медицинской науки в Азербайджане, в том числе научных основ борьбы с заболеваниями лёгких и туберкулёзом, тесно связано с основанием Бакинского государственного университета и медицинского факультета при нём в 1919 году. Учитывая распространение туберкулёза в республике...',
                ],
                'button_text' => ['az' => 'Daha çox', 'en' => 'Read more', 'ru' => 'Подробнее'],
                'button_url' => '/about', 'image' => 'assets/img/hero-bg.png',
            ],
            [
                'title' => ['az' => 'Beynəlxalq əlaqələr', 'en' => 'International relations', 'ru' => 'Международные связи'],
                'text' => [
                    'az' => 'Azərbaycanda İİV/QİÇS, Vərəm və Malariya üzrə Qlobal Fondun maliyyələşdirdiyi fəaliyyəti haqqında məlumat.',
                    'en' => 'Information on the activities in Azerbaijan financed by the Global Fund to Fight AIDS, Tuberculosis and Malaria.',
                    'ru' => 'Информация о деятельности в Азербайджане, финансируемой Глобальным фондом для борьбы со СПИДом, туберкулёзом и малярией.',
                ],
                'button_text' => ['az' => 'Daha çox', 'en' => 'Read more', 'ru' => 'Подробнее'],
                'button_url' => '/international', 'image' => 'assets/img/international-hero.png',
            ],
            [
                'title' => ['az' => 'İcbari tibbi sığorta', 'en' => 'Compulsory medical insurance', 'ru' => 'Обязательное медицинское страхование'],
                'text' => [
                    'az' => 'Xidmətlər Zərfinə daxil olan tibbi xidmətlər və tariflər Azərbaycan Respublikası Nazirlər Kabinetinin 2020-ci il 10 yanvar tarixli 5 nömrəli Qərarı ilə təsdiq edilmişdir.',
                    'en' => 'The medical services and tariffs included in the Service Package were approved by Decision No. 5 of the Cabinet of Ministers of the Republic of Azerbaijan dated 10 January 2020.',
                    'ru' => 'Медицинские услуги и тарифы, входящие в Пакет услуг, утверждены Постановлением № 5 Кабинета министров Азербайджанской Республики от 10 января 2020 года.',
                ],
                'button_text' => ['az' => 'Daha çox', 'en' => 'Read more', 'ru' => 'Подробнее'],
                'button_url' => '/citizens', 'image' => 'assets/img/citizens.png',
            ],
        ];
        foreach ($sliders as $i => $s) {
            Slider::create($s + ['sort' => $i + 1]);
        }

        $cards = [
            ['general', '/about',
                ['az' => 'Ümumi məlumat', 'en' => 'General information', 'ru' => 'Общая информация'],
                ['az' => 'Azərbaycanda tibb elminin, o cümlədən ağciyər xəstəlikləri...', 'en' => 'Medical science in Azerbaijan, including lung diseases...', 'ru' => 'Медицинская наука в Азербайджане, в том числе заболевания лёгких...']],
            ['leadership', '/leadership',
                ['az' => 'Rəhbərlik', 'en' => 'Leadership', 'ru' => 'Руководство'],
                ['az' => 'Direktor və direktor müavini haqqında məlumat.', 'en' => 'Information about the Director and Deputy Director.', 'ru' => 'Информация о директоре и заместителе директора.']],
            ['structure', '/structure',
                ['az' => 'Struktur', 'en' => 'Structure', 'ru' => 'Структура'],
                ['az' => 'İnstitutun təşkilati strukturu və bölmələri.', 'en' => 'Organizational structure and divisions of the Institute.', 'ru' => 'Организационная структура и подразделения института.']],
            ['international', '/international',
                ['az' => 'Beynəlxalq əlaqələr', 'en' => 'International relations', 'ru' => 'Международные связи'],
                ['az' => '2005-ci ildən başlayaraq İİV/QİÇS, Vərəm və Malariya üzrə Qlobal...', 'en' => 'Since 2005, the Global Fund to Fight AIDS, Tuberculosis and Malaria...', 'ru' => 'С 2005 года Глобальный фонд по борьбе со СПИДом, туберкулёзом и малярией...']],
        ];
        foreach ($cards as $i => [$icon, $url, $title, $text]) {
            FeatureCard::create(['icon' => $icon, 'url' => $url, 'title' => $title, 'text' => $text, 'sort' => $i + 1]);
        }
    }
}
