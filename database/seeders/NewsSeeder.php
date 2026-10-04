<?php

namespace Database\Seeders;

use App\Models\GalleryPhoto;
use App\Models\GalleryVideo;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        News::query()->delete();
        NewsCategory::query()->delete();
        GalleryPhoto::query()->delete();
        GalleryVideo::query()->delete();

        $cats = [
            ['international-meetings', 'Beynəlxalq görüşlər', 'International meetings', 'Международные встречи', 'default'],
            ['conferences', 'Konfranslar', 'Conferences', 'Конференции', 'default'],
            ['events', 'Tədbirlər', 'Events', 'Мероприятия', 'default'],
            ['interviews', 'Müsahibələr', 'Interviews', 'Интервью', 'default'],
            ['press-releases', 'Press Relizlər', 'Press releases', 'Пресс-релизы', 'default'],
        ];
        $category = [];
        foreach ($cats as $i => [$slug, $az, $en, $ru, $style]) {
            $category[$slug] = NewsCategory::create([
                'slug' => $slug, 'name' => compact('az', 'en', 'ru'), 'badge_style' => $style, 'sort' => $i + 1,
            ]);
        }

        $conferenceTitle = [
            'az' => '“Ümumdünya Vərəmlə Mübarizə Gününə Həsr Olunmuş” Konfrans',
            'en' => 'Conference “Dedicated to World Tuberculosis Day”',
            'ru' => 'Конференция, посвящённая Всемирному дню борьбы с туберкулёзом',
        ];
        $conferenceText = [
            'az' => '<p>30.03.2023-ci ildə Azərbaycan Respublikası Səhiyyə Nazirliyi "Elmi-Tədqiqat Ağciyər Xəstəlikləri İnstitutu" publik hüquqi şəxs, Azərbaycan Respublikası Səhiyyə Nazirliyinin tabeliyində fəaliyyət göstərən elmi-tədqiqat müəssisəsi kimi yaradılıb.</p><p>Konfransda institutun əməkdaşları, nazirlik və beynəlxalq təşkilat nümayəndələri iştirak edərək vərəmə qarşı mübarizənin aktual məsələlərini müzakirə etdilər.</p>',
            'en' => '<p>On 30 March 2023, the Research Institute of Lung Diseases was established as a public legal entity and a research institution operating under the Ministry of Health of the Republic of Azerbaijan.</p><p>Institute staff and representatives of the Ministry and international organizations took part in the conference and discussed topical issues in the fight against tuberculosis.</p>',
            'ru' => '<p>30 марта 2023 года Научно-исследовательский институт лёгочных заболеваний был создан как публичное юридическое лицо и научно-исследовательское учреждение при Министерстве здравоохранения Азербайджанской Республики.</p><p>В конференции приняли участие сотрудники института, представители министерства и международных организаций, обсудившие актуальные вопросы борьбы с туберкулёзом.</p>',
        ];
        $missionTitle = [
            'az' => 'Azərbaycanda İİV/QİÇS və Hepatit üzrə milli proqramlarının qiymətləndirmə missiyası öz işinə başlayıb',
            'en' => 'Evaluation mission of Azerbaijan\'s national HIV/AIDS and Hepatitis programmes has begun its work',
            'ru' => 'Миссия по оценке национальных программ по ВИЧ/СПИДу и гепатиту в Азербайджане приступила к работе',
        ];
        $missionText = [
            'az' => '<p>Azərbaycan Respublikası Səhiyyə Nazirliyinin təşəbbüsü ilə ÜST-nin ekspert qrupu tərəfindən, nəzərdə tutulan Azərbaycanda İİV/QİÇS və Hepatit üzrə milli proqramlarının qiymətləndirmə missiyası öz işinə başlayıb.</p><p>Qiymətləndirmə prosesinin birinci mərhələsində, ekspert qrupu distant formatda hər iki sahə üzrə təqdim olunan sənədləri, hesabatları və protokolları nəzərdən keçirib və onları təhlil edib. İkinci mərhələ isə bir həftə davam edəcək ölkədaxili missiyanı əhatə edib.</p>',
            'en' => '<p>At the initiative of the Ministry of Health of the Republic of Azerbaijan, the evaluation mission of the national HIV/AIDS and Hepatitis programmes, carried out by a WHO expert group, has begun its work.</p><p>In the first stage of the evaluation, the expert group reviewed and analysed the documents, reports and protocols submitted for both areas remotely. The second stage covered an in-country mission lasting one week.</p>',
            'ru' => '<p>По инициативе Министерства здравоохранения Азербайджанской Республики группа экспертов ВОЗ приступила к работе в рамках миссии по оценке национальных программ по ВИЧ/СПИДу и гепатиту в Азербайджане.</p><p>На первом этапе оценки группа экспертов в дистанционном формате изучила и проанализировала документы, отчёты и протоколы по обеим областям. Второй этап включал недельную миссию в стране.</p>',
        ];

        $items = [
            ['conferences', $conferenceTitle, $conferenceText, 'assets/img/news-featured.png', '2026-02-13 10:00', true],
            ['international-meetings', $missionTitle, $missionText, 'assets/img/news-detail.png', '2026-02-10 10:00', false],
            ['press-releases', $conferenceTitle, $conferenceText, 'assets/img/news-1.png', '2026-02-05 10:00', false],
            ['events', $conferenceTitle, $conferenceText, 'assets/img/news-3.png', '2026-01-28 10:00', false],
            ['interviews', $conferenceTitle, $conferenceText, 'assets/img/news-2.png', '2026-01-20 10:00', false],
            ['conferences', $missionTitle, $missionText, 'assets/img/news-2.png', '2026-01-12 10:00', false],
            ['events', $conferenceTitle, $conferenceText, 'assets/img/news-1.png', '2025-12-22 10:00', false],
            ['international-meetings', $conferenceTitle, $conferenceText, 'assets/img/news-3.png', '2025-12-15 10:00', false],
        ];

        foreach ($items as $i => [$cat, $title, $text, $image, $date, $featured]) {
            $slug = 'news-'.($i + 1);
            News::create([
                'news_category_id' => $category[$cat]->id,
                'slug' => $slug,
                'title' => $title,
                'content' => $text,
                'excerpt' => array_map(fn ($t) => mb_substr(trim(html_entity_decode(strip_tags($t))), 0, 220), $text),
                'image' => $image,
                'gallery' => ['assets/img/slide-1.png', 'assets/img/slide-2.png', 'assets/img/news-detail.png'],
                'published_at' => $date,
                'is_featured' => $featured,
                'views' => 356 - $i * 23,
            ]);
        }

        $photos = [
            ['news-1.png', ['Konfrans çıxışı', 'Conference speech', 'Выступление на конференции']],
            ['news-2.png', ['Ümumdünya Səhiyyə Təşkilatı nümayəndələri ilə görüş', 'Meeting with World Health Organization representatives', 'Встреча с представителями Всемирной организации здравоохранения']],
            ['news-3.png', ['Tibbi müayinə', 'Medical examination', 'Медицинский осмотр']],
            ['gallery-large.png', ['Elmi şuranın iclası', 'Scientific Council meeting', 'Заседание научного совета']],
            ['gallery-thumb-1.png', ['Süni intellekt və tibb', 'Artificial intelligence and medicine', 'Искусственный интеллект и медицина']],
            ['gallery-thumb-2.png', ['Seminar', 'Seminar', 'Семинар']],
            ['gallery-thumb-3.png', ['Təlim', 'Training', 'Обучение']],
            ['slide-1.png', ['Tədbir', 'Event', 'Мероприятие']],
        ];
        foreach ($photos as $i => [$file, $t]) {
            GalleryPhoto::create(['image' => 'assets/img/'.$file, 'title' => ['az' => $t[0], 'en' => $t[1], 'ru' => $t[2]], 'sort' => $i + 1]);
        }

        $videos = [
            ['news-1.png', ['Konfrans çıxışı', 'Conference speech', 'Выступление на конференции']],
            ['news-2.png', ['Beynəlxalq görüş', 'International meeting', 'Международная встреча']],
            ['news-3.png', ['Tibbi müayinə', 'Medical examination', 'Медицинский осмотр']],
            ['gallery-large.png', ['Elmi şura', 'Scientific Council', 'Научный совет']],
        ];
        foreach ($videos as $i => [$file, $t]) {
            GalleryVideo::create([
                'youtube_url' => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ',
                'thumbnail' => 'assets/img/'.$file,
                'title' => ['az' => $t[0], 'en' => $t[1], 'ru' => $t[2]],
                'sort' => $i + 1,
            ]);
        }
    }
}
