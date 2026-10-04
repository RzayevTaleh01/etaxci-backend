<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\StructureNode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamSeeder extends Seeder
{
    /** Position => [en, ru] */
    private array $pos = [
        'Direktor' => ['Director', 'Директор'],
        'Direktor Müavini' => ['Deputy Director', 'Заместитель директора'],
        'Katiblik şöbəsinin müdiri' => ['Head of the Secretariat', 'Заведующий секретариатом'],
        'İctimaiyyətlə əlaqələr və kommunikasiya departamentinin rəhbəri' => ['Head of the Public Relations and Communications Department', 'Руководитель департамента по связям с общественностью и коммуникациям'],
        'Daxili nəzarət və monitorinq departamentinin rəhbəri' => ['Head of the Internal Control and Monitoring Department', 'Руководитель департамента внутреннего контроля и мониторинга'],
        'Hüquq departamentinin rəhbəri' => ['Head of the Legal Department', 'Руководитель юридического департамента'],
        'Elmi işlər üzrə direktor müavini' => ['Deputy Director for Scientific Affairs', 'Заместитель директора по научной работе'],
        'Elmi-tədqiqat departamentinin rəhbəri' => ['Head of the Research Department', 'Руководитель научно-исследовательского департамента'],
        'Təlim və tədqiqatlar departamentinin rəhbəri' => ['Head of the Training and Research Department', 'Руководитель департамента обучения и исследований'],
        'Beynəlxalq əlaqələr departamentinin rəhbəri' => ['Head of the International Relations Department', 'Руководитель департамента международных связей'],
        'Ftiziatriya şöbəsinin müdiri' => ['Head of the Phthisiology Unit', 'Заведующий отделением фтизиатрии'],
        'Pulmonologiya şöbəsinin müdiri' => ['Head of the Pulmonology Unit', 'Заведующий отделением пульмонологии'],
        'Müalicə işi üzrə direktor müavini' => ['Deputy Director for Treatment', 'Заместитель директора по лечебной работе'],
        'Klinik departamentin rəhbəri' => ['Head of the Clinical Department', 'Руководитель клинического департамента'],
        'Diaqnostika departamentinin rəhbəri' => ['Head of the Diagnostics Department', 'Руководитель департамента диагностики'],
        'Stasionar şöbənin müdiri' => ['Head of the Inpatient Unit', 'Заведующий стационарным отделением'],
        'Ambulator şöbənin müdiri' => ['Head of the Outpatient Unit', 'Заведующий амбулаторным отделением'],
        'Laborator şöbəsinin müdiri' => ['Head of the Laboratory Unit', 'Заведующий лабораторным отделением'],
        'İnzibati-təsərrüfat işləri üzrə direktor müavini' => ['Deputy Director for Administrative Affairs', 'Заместитель директора по административно-хозяйственной работе'],
        'İnsan resursları departamentinin rəhbəri' => ['Head of the Human Resources Department', 'Руководитель департамента кадровых ресурсов'],
        'Maliyyə departamentinin rəhbəri' => ['Head of the Finance Department', 'Руководитель финансового департамента'],
        'Müraciətlərlə iş departamentinin rəhbəri' => ['Head of the Citizen Appeals Department', 'Руководитель департамента по работе с обращениями'],
        'Mühasibatlıq şöbəsinin müdiri' => ['Head of the Accounting Unit', 'Заведующий бухгалтерией'],
        'Həkim-pulmonoloq' => ['Pulmonologist', 'Врач-пульмонолог'],
        'Həkim-ftiziatr' => ['Phthisiatrician', 'Врач-фтизиатр'],
        'Həkim-radioloq' => ['Radiologist', 'Врач-радиолог'],
        'Həkim-laborant' => ['Laboratory doctor', 'Врач-лаборант'],
        'Həkim-reanimatoloq' => ['Resuscitation specialist', 'Врач-реаниматолог'],
        'Həkim-terapevt' => ['Therapist', 'Врач-терапевт'],
        'Tibb elmləri doktoru, professor' => ['Doctor of Medical Sciences, Professor', 'Доктор медицинских наук, профессор'],
        'Tibb elmləri namizədi, dosent' => ['Candidate of Medical Sciences, Associate Professor', 'Кандидат медицинских наук, доцент'],
        'Tibb elmləri namizədi' => ['Candidate of Medical Sciences', 'Кандидат медицинских наук'],
        'Tibb elmləri doktoru' => ['Doctor of Medical Sciences', 'Доктор медицинских наук'],
    ];

    private function tp(string $az): array
    {
        return ['az' => $az, 'en' => $this->pos[$az][0] ?? $az, 'ru' => $this->pos[$az][1] ?? $az];
    }

    public function run(): void
    {
        Person::query()->delete();

        $placeholderName = ['az' => 'Soyadı Adı Ata adı', 'en' => 'Surname Name Patronymic', 'ru' => 'Фамилия Имя Отчество'];
        $placeholderBio = [
            'az' => 'Qısa tərcümeyi-hal və fəaliyyət haqqında məlumat burada yerləşdirilir.',
            'en' => 'A short biography and information about activities will be placed here.',
            'ru' => 'Здесь будет размещена краткая биография и информация о деятельности.',
        ];
        $specialty = [
            'az' => 'İxtisası: ftiziatriya və pulmonologiya. Elmi-tədqiqat və klinik fəaliyyətlə məşğuldur.',
            'en' => 'Specialty: phthisiology and pulmonology. Engaged in research and clinical work.',
            'ru' => 'Специальность: фтизиатрия и пульмонология. Занимается научно-исследовательской и клинической деятельностью.',
        ];

        $sort = 0;
        $make = function (string $slug, string $group, array $name, string $position, array $bio, array $extra = []) use (&$sort) {
            Person::create(array_merge([
                'slug' => $slug, 'group' => $group, 'name' => $name, 'position' => $this->tp($position), 'bio' => $bio,
                'sort' => ++$sort,
            ], $extra));
        };

        // Leadership
        $director = [
            'az' => '<p>3 Sentyabr 1959-cu ildə Bakı şəhərində anadan olmuşdur.</p><p>1976-cı ildən 1982-ci ilə qədər Dövlət Tibb Universitetində “Ftiziatr-Pulmonoloq” ixtisası üzrə təhsil almışdır. Peşəkar fəaliyyətinə 1978-ci ildə F.Əfəndiyev adına 4 nömrəli Mərkəzi klinik xəstəxanada Tibb Bacısı olaraq başlamışdır. 1988-ci ildə Elmi-Tədqiqat Ağciyər Xəstəlikləri İnstitutunda həkim olaraq işə başlamış, daha sonrakı dövrlərdə Müalicə-Reabilitasiya şöbəsinin müdiri və Direktor Müavini vəzifələrini icra etmişdir. 2022-ci ildən Elmi-Tədqiqat Ağciyər Xəstəlikləri İnstitutunda Direktor vəzifəsində çalışır.</p>',
            'en' => '<p>Born on 3 September 1959 in Baku.</p><p>From 1976 to 1982 she studied at the State Medical University, specializing in “Phthisiatrician-Pulmonologist”. She began her professional career in 1978 as a nurse at Central Clinical Hospital No. 4 named after F. Afandiyev. In 1988 she started working as a doctor at the Research Institute of Lung Diseases, and later served as Head of the Treatment and Rehabilitation Unit and Deputy Director. Since 2022 she has been the Director of the Research Institute of Lung Diseases.</p>',
            'ru' => '<p>Родилась 3 сентября 1959 года в городе Баку.</p><p>В 1976–1982 годах училась в Государственном медицинском университете по специальности «Фтизиатр-пульмонолог». Профессиональную деятельность начала в 1978 году медицинской сестрой в Центральной клинической больнице № 4 имени Ф. Эфендиева. В 1988 году начала работать врачом в Научно-исследовательском институте лёгочных заболеваний, затем занимала должности заведующей отделением лечения и реабилитации и заместителя директора. С 2022 года работает директором Научно-исследовательского института лёгочных заболеваний.</p>',
        ];
        $deputy = [
            'az' => '<p>28 Noyabr 1973-cü ildə anadan olmuşdur. 1992-ci ildən 1998-ci ilə qədər Azərbaycan Tibb Universitetində təhsil almışdır.</p>',
            'en' => '<p>Born on 28 November 1973. From 1992 to 1998 she studied at the Azerbaijan Medical University.</p>',
            'ru' => '<p>Родилась 28 ноября 1973 года. В 1992–1998 годах училась в Азербайджанском медицинском университете.</p>',
        ];
        $make('axundova-irade-mirsaab-qizi', 'leadership', ['az' => 'Axundova İradə Mirsaab qızı', 'en' => 'Akhundova Irada Mirsaab gizi', 'ru' => 'Ахундова Ирада Мирсааб гызы'], 'Direktor', $director,
            ['photo' => 'assets/img/leader.png', 'show_on_home' => true]);
        $make('eliyeva-gulzar-rafiq-qiz', 'leadership', ['az' => 'Əliyeva Gülzar Rafiq qız', 'en' => 'Aliyeva Gulzar Rafig gizi', 'ru' => 'Алиева Гюльзар Рафиг гызы'], 'Direktor Müavini', $deputy,
            ['photo' => 'assets/img/team-2.png']);

        // Management apparatus
        foreach (['Katiblik şöbəsinin müdiri', 'İctimaiyyətlə əlaqələr və kommunikasiya departamentinin rəhbəri', 'Daxili nəzarət və monitorinq departamentinin rəhbəri', 'Hüquq departamentinin rəhbəri'] as $i => $position) {
            $make(Str::slug($position), 'management', $placeholderName, $position, $placeholderBio, ['photo' => $i % 2 ? 'assets/img/team-2.png' : 'assets/img/team-1.png']);
        }

        $sections = [
            'scientific' => ['Elmi işlər üzrə direktor müavini', 'Elmi-tədqiqat departamentinin rəhbəri', 'Təlim və tədqiqatlar departamentinin rəhbəri', 'Beynəlxalq əlaqələr departamentinin rəhbəri', 'Ftiziatriya şöbəsinin müdiri', 'Pulmonologiya şöbəsinin müdiri'],
            'medical' => ['Müalicə işi üzrə direktor müavini', 'Klinik departamentin rəhbəri', 'Diaqnostika departamentinin rəhbəri', 'Stasionar şöbənin müdiri', 'Ambulator şöbənin müdiri', 'Laborator şöbəsinin müdiri'],
            'administrative' => ['İnzibati-təsərrüfat işləri üzrə direktor müavini', 'İnsan resursları departamentinin rəhbəri', 'Maliyyə departamentinin rəhbəri', 'Müraciətlərlə iş departamentinin rəhbəri', 'Mühasibatlıq şöbəsinin müdiri'],
        ];
        foreach ($sections as $group => $positions) {
            foreach ($positions as $i => $position) {
                $make(Str::slug($position), $group, $placeholderName, $position, $placeholderBio, ['photo' => $i % 2 ? 'assets/img/team-2.png' : 'assets/img/team-1.png']);
            }
        }

        // Doctors
        foreach (['Tibb elmləri doktoru, professor', 'Tibb elmləri namizədi, dosent', 'Tibb elmləri namizədi', 'Tibb elmləri doktoru'] as $i => $position) {
            $make(Str::slug($position), 'doctor', $placeholderName, $position, $specialty, ['has_degree' => true, 'photo' => $i % 2 ? 'assets/img/team-2.png' : 'assets/img/team-1.png']);
        }
        foreach (['Həkim-pulmonoloq', 'Həkim-ftiziatr', 'Həkim-radioloq', 'Həkim-laborant', 'Həkim-reanimatoloq', 'Həkim-terapevt'] as $i => $position) {
            $make(Str::slug($position), 'doctor', $placeholderName, $position, $specialty, ['photo' => $i % 2 ? 'assets/img/team-1.png' : 'assets/img/team-2.png']);
        }

        // Organizational structure (generated from the original static structure.js)
        StructureNode::query()->delete();
        $tree = json_decode(file_get_contents(database_path('seeders/data/structure.json')), true);
        $this->node($tree, null, null, 1);
    }

    private function node(array $data, ?int $parentId, ?string $side, int $sort): void
    {
        $node = StructureNode::create([
            'parent_id' => $parentId, 'side' => $side, 'type' => $data['type'], 'title' => $data['title'], 'sort' => $sort,
        ]);

        foreach (($data['children'] ?? []) as $i => $child) {
            $this->node($child, $node->id, null, $i + 1);
        }
        foreach (['left', 'right'] as $s) {
            foreach (($data['side'][$s] ?? []) as $i => $child) {
                $this->node($child, $node->id, $s, $i + 1);
            }
        }
    }
}
