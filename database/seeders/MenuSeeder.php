<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    private function t(string $az, string $en, string $ru): array
    {
        return compact('az', 'en', 'ru');
    }

    public function run(): void
    {
        MenuItem::query()->delete();

        $about = [
            [$this->t('Yaranma tarixi', 'History', 'История создания'), '/about'],
            [$this->t('Rəhbərlik', 'Leadership', 'Руководство'), '/leadership'],
            [$this->t('İdarəetmə aparatı', 'Administrative staff', 'Административный аппарат'), '/management'],
            [$this->t('Struktur', 'Structure', 'Структура'), '/structure'],
            [$this->t('Elmi hissə', 'Scientific division', 'Научная часть'), '/section/scientific'],
            [$this->t('Tibbi hissə', 'Medical division', 'Лечебная часть'), '/section/medical'],
            [$this->t('İnzibati hissə', 'Administrative division', 'Административная часть'), '/section/administrative'],
        ];
        $science = [
            [$this->t('Təhsil', 'Education', 'Образование'), '/p/education'],
            [$this->t('Elmi-Tədqiqat İşləri', 'Research work', 'Научно-исследовательская работа'), '/p/research'],
            [$this->t('Elmi Şura', 'Scientific Council', 'Научный совет'), '/p/scientific-council'],
        ];
        $doctors = [
            [$this->t('Elmi dərəcəli həkimlər', 'Doctors with academic degrees', 'Врачи с учёной степенью'), '/doctors/degree'],
            [$this->t('Ümumi siyahı', 'All doctors', 'Общий список'), '/doctors'],
        ];
        $citizens = [
            [$this->t('Tez-tez verilən suallar', 'Frequently asked questions', 'Часто задаваемые вопросы'), '/faq'],
            [$this->t('Səhiyyə Nazirliyi', 'Ministry of Health', 'Министерство здравоохранения'), '/ministry'],
            [$this->t('İcbari Tibbi Sığorta', 'Compulsory medical insurance', 'Обязательное медицинское страхование'), '/citizens'],
            [$this->t('Qəbul günləri', 'Reception days', 'Дни приёма'), '/reception'],
        ];
        $news = [
            [$this->t('Beynəlxalq görüşlər', 'International meetings', 'Международные встречи'), '/news/category/international-meetings'],
            [$this->t('Konfranslar', 'Conferences', 'Конференции'), '/news/category/conferences'],
            [$this->t('Tədbirlər', 'Events', 'Мероприятия'), '/news/category/events'],
            [$this->t('Müsahibələr', 'Interviews', 'Интервью'), '/news/category/interviews'],
            [$this->t('Press Relizlər', 'Press releases', 'Пресс-релизы'), '/news/category/press-releases'],
        ];
        $gallery = [
            [$this->t('Fotolar', 'Photos', 'Фото'), '/gallery'],
            [$this->t('Videolar', 'Videos', 'Видео'), '/videos'],
        ];

        $sort = 0;
        $header = function (array $title, string $url, array $children = []) use (&$sort) {
            $parent = MenuItem::create(['location' => 'header', 'title' => $title, 'url' => $url, 'sort' => ++$sort]);
            foreach ($children as $i => [$t, $u]) {
                MenuItem::create(['location' => 'header', 'parent_id' => $parent->id, 'title' => $t, 'url' => $u, 'sort' => $i + 1]);
            }
        };

        $header($this->t('Ana Səhifə', 'Home', 'Главная'), '/');
        $header($this->t('Haqqımızda', 'About us', 'О нас'), '/about', $about);
        $header($this->t('Elmi Fəaliyyət', 'Scientific activity', 'Научная деятельность'), '#', $science);
        $header($this->t('Tibbi Fəaliyyət', 'Medical activity', 'Медицинская деятельность'), '#', $doctors);
        $header($this->t('Vətəndaşlar Üçün', 'For citizens', 'Для граждан'), '/citizens', $citizens);
        $header($this->t('Xəbərlər', 'News', 'Новости'), '/news', $news);
        $header($this->t('Qalereya', 'Gallery', 'Галерея'), '/gallery', $gallery);
        $header($this->t('Əlaqə', 'Contact', 'Контакты'), '/contact');

        $footer = [
            [$this->t('Haqqımızda', 'About us', 'О нас'), $about],
            [$this->t('Fəaliyyət', 'Activity', 'Деятельность'), array_merge($science, $doctors)],
            [$this->t('Xəbərlər', 'News', 'Новости'), array_merge([[$this->t('Bütün xəbərlər', 'All news', 'Все новости'), '/news']], $news, [[$this->t('Qalereya', 'Gallery', 'Галерея'), '/gallery']])],
            [$this->t('Vətəndaşlar üçün', 'For citizens', 'Для граждан'), $citizens],
        ];
        foreach ($footer as $i => [$title, $items]) {
            $parent = MenuItem::create(['location' => 'footer', 'title' => $title, 'url' => '#', 'sort' => $i + 1]);
            foreach ($items as $j => [$t, $u]) {
                MenuItem::create(['location' => 'footer', 'parent_id' => $parent->id, 'title' => $t, 'url' => $u, 'sort' => $j + 1]);
            }
        }
    }
}
