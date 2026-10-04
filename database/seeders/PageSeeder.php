<?php

namespace Database\Seeders;

use App\Models\AboutBlock;
use App\Models\Page;
use App\Models\Partner;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    private function t(string $az, string $en, string $ru): array
    {
        return compact('az', 'en', 'ru');
    }

    /** @param array<string,string> $paras locale => paragraphs joined with \n\n */
    private function html(array $paras): array
    {
        return array_map(fn ($text) => collect(explode("\n\n", $text))->map(fn ($p) => '<p>'.e($p).'</p>')->implode("\n"), $paras);
    }

    public function run(): void
    {
        $pages = [
            ['about', 'plain', $this->t('Ümumi məlumat', 'General information', 'Общая информация'), null, null, null],
            ['citizens', 'info', $this->t('İcbari tibbi sığorta', 'Compulsory medical insurance', 'Обязательное медицинское страхование'), null,
                $this->html([
                    'az' => "Xidmətlər Zərfinə daxil olan tibbi xidmətlər və tariflər Azərbaycan Respublikası Nazirlər Kabinetinin 2020-ci il 10 yanvar tarixli 5 nömrəli Qərarı ilə təsdiq edilmişdir.\n\nİcbari tibbi sığortanın Xidmətlər Zərfinə daxil olan tibbi xidmətlərin sayı 2550-dir. Bura təcili və təxirəsalınmaz tibbi yardım (o cümlədən ambulans xidməti), ilkin səhiyyə (ailə həkimi) xidməti, ambulator şəraitdə müayinə və müalicə daxildir.",
                    'en' => "The medical services and tariffs included in the Service Package were approved by Decision No. 5 of the Cabinet of Ministers of the Republic of Azerbaijan dated 10 January 2020.\n\nThe Service Package of compulsory medical insurance includes 2,550 medical services. These cover emergency and urgent medical care (including ambulance service), primary healthcare (family doctor) services, and outpatient examination and treatment.",
                    'ru' => "Медицинские услуги и тарифы, входящие в Пакет услуг, утверждены Постановлением № 5 Кабинета министров Азербайджанской Республики от 10 января 2020 года.\n\nВ Пакет услуг обязательного медицинского страхования входит 2550 медицинских услуг. Сюда относятся неотложная и экстренная медицинская помощь (в том числе служба скорой помощи), первичная медико-санитарная помощь (семейный врач), обследование и лечение в амбулаторных условиях.",
                ]), 'assets/img/logo-insurance.svg'],
            ['ministry', 'info', $this->t('Səhiyyə Nazirliyi', 'Ministry of Health', 'Министерство здравоохранения'), null,
                $this->html([
                    'az' => "Elmi-Tədqiqat Ağciyər Xəstəlikləri İnstitutu publik hüquqi şəxs kimi Azərbaycan Respublikası Səhiyyə Nazirliyinin tabeliyində fəaliyyət göstərir. Nazirlik haqqında ətraflı məlumat rəsmi saytında yerləşdirilir.\n\nNazirlik səhiyyə sahəsində dövlət siyasətinin həyata keçirilməsini, ictimai sağlamlığın qorunmasını, tibbi xidmətlərin keyfiyyətinin və əlçatanlığının təmin edilməsini, tibb elminin və təhsilinin inkişafını əhatə edən fəaliyyət istiqamətlərini həyata keçirir.",
                    'en' => "The Research Institute of Lung Diseases operates as a public legal entity under the Ministry of Health of the Republic of Azerbaijan. Detailed information about the Ministry is available on its official website.\n\nThe Ministry carries out the state policy in healthcare, protects public health, ensures the quality and accessibility of medical services, and promotes the development of medical science and education.",
                    'ru' => "Научно-исследовательский институт лёгочных заболеваний действует как публичное юридическое лицо при Министерстве здравоохранения Азербайджанской Республики. Подробная информация о Министерстве размещена на его официальном сайте.\n\nМинистерство осуществляет государственную политику в сфере здравоохранения, охрану общественного здоровья, обеспечение качества и доступности медицинских услуг, развитие медицинской науки и образования.",
                ]), 'assets/img/logo-ministry.svg'],
            ['international', 'international', $this->t('Azərbaycanda İİV/QİÇS, Vərəm və Malariya üzrə Qlobal Fondun maliyyələşdirdiyi fəaliyyəti haqqında məlumat', 'Information on the activities in Azerbaijan financed by the Global Fund to Fight AIDS, Tuberculosis and Malaria', 'Информация о деятельности в Азербайджане, финансируемой Глобальным фондом для борьбы со СПИДом, туберкулёзом и малярией'), null,
                $this->html([
                    'az' => "Konfrans qlobal istiləşmə, iqlim dəyişiklikləri, enerji, ətraf mühit və dayanıqlı inkişaf sahələrində fəaliyyət göstərən alimləri, tədqiqatçıları və mütəxəssisləri bir araya gətirəcək.\n\nMultidisiplinar beynəlxalq elmi platforma olan GCGW-2026 qlobal istiləşmənin təsirləri, bərpaolunan enerji, hidrogen texnologiyaları, enerji siyasəti, karbon emissiyalarının azaldılması, enerji səmərəliliyi, ekosistemlərin qorunması, süni intellektin enerji sektorunda tətbiqi və digər aktual istiqamətlər üzrə elmi müzakirələrin aparılmasına imkan yaradacaq.\n\nKonfransa qəbul edilərək təqdim olunan məqalələr konfrans materiallarında dərc olunacaq. Seçilmiş yüksəkkeyfiyyətli elmi işlərin genişləndirilmiş versiyalarının isə beynəlxalq elmi jurnalların xüsusi buraxılışlarında nəşri nəzərdə tutulur.",
                    'en' => "The conference will bring together scientists, researchers and experts working in the fields of global warming, climate change, energy, the environment and sustainable development.\n\nGCGW-2026, a multidisciplinary international scientific platform, will enable scientific discussions on the effects of global warming, renewable energy, hydrogen technologies, energy policy, carbon emission reduction, energy efficiency, ecosystem protection, the use of artificial intelligence in the energy sector and other topical areas.\n\nPapers accepted and presented at the conference will be published in the conference proceedings. Extended versions of selected high-quality papers are planned to be published in special issues of international scientific journals.",
                    'ru' => "Конференция объединит учёных, исследователей и специалистов, работающих в области глобального потепления, изменения климата, энергетики, охраны окружающей среды и устойчивого развития.\n\nGCGW-2026 — междисциплинарная международная научная платформа — позволит провести научные дискуссии о последствиях глобального потепления, возобновляемой энергетике, водородных технологиях, энергетической политике, снижении выбросов углерода, энергоэффективности, защите экосистем, применении искусственного интеллекта в энергетике и других актуальных направлениях.\n\nПринятые и представленные на конференции статьи будут опубликованы в материалах конференции. Расширенные версии отобранных высококачественных работ планируется опубликовать в специальных выпусках международных научных журналов.",
                ]), null],
            ['leadership', 'plain', $this->t('Rəhbərlik', 'Leadership', 'Руководство'), $this->t('Direktor və direktor müavini', 'Director and Deputy Director', 'Директор и заместитель директора'), null, null],
            ['management', 'plain', $this->t('İdarəetmə aparatı', 'Administrative staff', 'Административный аппарат'), $this->t('3 departament · 4 şöbə', '3 departments · 4 units', '3 департамента · 4 отдела'), null, null],
            ['section-scientific', 'plain', $this->t('Elmi işlər üzrə direktor müavini', 'Deputy Director for Scientific Affairs', 'Заместитель директора по научной работе'), $this->t('3 departament · 6 şöbə', '3 departments · 6 units', '3 департамента · 6 отделов'), null, null],
            ['section-medical', 'plain', $this->t('Müalicə işi üzrə direktor müavini', 'Deputy Director for Treatment', 'Заместитель директора по лечебной работе'), $this->t('2 departament · 4 şöbə', '2 departments · 4 units', '2 департамента · 4 отдела'), null, null],
            ['section-administrative', 'plain', $this->t('İnzibati-təsərrüfat işləri üzrə direktor müavini', 'Deputy Director for Administrative Affairs', 'Заместитель директора по административно-хозяйственной работе'), $this->t('4 departament · 8 şöbə', '4 departments · 8 units', '4 департамента · 8 отделов'), null, null],
            ['doctors', 'plain', $this->t('Ümumi siyahı', 'All doctors', 'Общий список'), null, null, null],
            ['doctors-degree', 'plain', $this->t('Elmi dərəcəli həkimlər', 'Doctors with academic degrees', 'Врачи с учёной степенью'), null, null, null],
        ];

        foreach ($pages as $i => [$slug, $template, $title, $subtitle, $content, $image]) {
            Page::updateOrCreate(['slug' => $slug], [
                'template' => $template, 'title' => $title, 'subtitle' => $subtitle, 'content' => $content,
                'image' => $image, 'is_system' => true, 'is_active' => true, 'sort' => $i,
            ]);
        }

        // Pages linked from the menu that have no content yet — to be filled in from the admin panel.
        $placeholder = $this->html([
            'az' => 'Bu bölmənin məzmunu tezliklə əlavə olunacaq.',
            'en' => 'The content of this section will be added soon.',
            'ru' => 'Содержимое этого раздела будет добавлено в ближайшее время.',
        ]);
        foreach ([
            ['education', $this->t('Təhsil', 'Education', 'Образование')],
            ['research', $this->t('Elmi-Tədqiqat İşləri', 'Research work', 'Научно-исследовательская работа')],
            ['scientific-council', $this->t('Elmi Şura', 'Scientific Council', 'Научный совет')],
        ] as $i => [$slug, $title]) {
            Page::updateOrCreate(['slug' => $slug], [
                'template' => 'plain', 'title' => $title, 'content' => $placeholder, 'is_system' => false, 'is_active' => true, 'sort' => 100 + $i,
            ]);
        }

        // "About" page blocks
        AboutBlock::query()->delete();
        $blocks = [
            [
                'title' => $this->t('Azərbaycanda ağciyər xəstəlikləri əleyhinə mübarizənin təşkili', 'Organization of the fight against lung diseases in Azerbaijan', 'Организация борьбы с заболеваниями лёгких в Азербайджане'),
                'text' => $this->t(
                    'Azərbaycanda tibb elminin, o cümlədən ağciyər xəstəlikləri və vərəm əleyhinə mübarizənin elmi əsaslarının qurulması 1919-cu ildə Baki Dövlət Universitetinin yaradılması və onun nəzdində tibb fakültəsinin açılması ilə sıx bağlıdır. Vərəmin respublikada yayılmasını nəzərə alaraq, onun əleyhinə mübarizəni gücləndirmək, profilaktika, müalicə tədbirlərini hazırlamaq, ftiziatriyanın inkişafına təkan vermək məqsədi ilə Xalq Komissarları Sovetinin 16 may 1944-cü il tarixli 761 №-li qərarı və Azərbaycan xalq səhiyyə komissarının 31 iyul 1944-cü il tarixli sərəncamı ilə Bakı şəhərində ET Vərəm İnstitutu yaradılır (müdiri t.e.n. Əhməd Cəbrayil oğlu Nurməmmədov).',
                    'The foundation of medical science in Azerbaijan, including the scientific basis of the fight against lung diseases and tuberculosis, is closely linked to the establishment of Baku State University and its Faculty of Medicine in 1919. Taking into account the spread of tuberculosis in the republic, and in order to strengthen the fight against it, develop prevention and treatment measures and promote the development of phthisiology, the Research Institute of Tuberculosis was established in Baku by Resolution No. 761 of the Council of People\'s Commissars dated 16 May 1944 and the order of the People\'s Commissar of Health of Azerbaijan dated 31 July 1944 (headed by Candidate of Medical Sciences Ahmad Jabrayil oglu Nurmammadov).',
                    'Становление медицинской науки в Азербайджане, в том числе научных основ борьбы с заболеваниями лёгких и туберкулёзом, тесно связано с основанием Бакинского государственного университета и медицинского факультета при нём в 1919 году. Учитывая распространение туберкулёза в республике, с целью усиления борьбы с ним, разработки профилактических и лечебных мер и содействия развитию фтизиатрии постановлением Совета народных комиссаров № 761 от 16 мая 1944 года и распоряжением наркома здравоохранения Азербайджана от 31 июля 1944 года в Баку был создан Научно-исследовательский институт туберкулёза (руководитель — к.м.н. Ахмед Джабраил оглы Нурмамедов).'
                ),
                'image' => 'assets/img/about.png',
            ],
            [
                'title' => null,
                'text' => $this->t(
                    'İlk dövrlərdə ET Vərəm İnstitutunda “Vərəmin müharibə dövründə klinik gedişi”, “Hərbçilər arasında vərəmin yayılması, “Yerli əhali arasında sümük-oynaq vərəminin, limfadenitin yayılması”, “Vərəmin müharibə dövründə patomorfoloji xüsusiyyətləri” kimi problemlər öyrənilir (professor P. İ. Blişenko, professor Q. Səlimxanov, V. Abdullayevin tədqiqatları). ET Vərəm İnstitutunda yeni müalicə metodları tətbiq olunmağa başlayır. Bu dövrdə respublikada doğulan uşaqlar arasında vərəm əleyhinə kütləvi peyvənd edilir. Əhali arasında sanitariya-maarif işləri genişləndirilir. 1971-ci ildə Azərbaycan Kommunist Partiyasının Mərkəzi Komitəsinin I katibi Heydər Əliyevin təşəbbüsü ilə ET Vərəm İnstitutunun yeni binası inşa olunur və istifadəyə verilir.',
                    'In the early years, the Institute studied problems such as “The clinical course of tuberculosis during the war”, “The spread of tuberculosis among military personnel”, “The spread of bone and joint tuberculosis and lymphadenitis among the local population” and “Pathomorphological features of tuberculosis during the war” (research by professors P. I. Blishenko, G. Salimkhanov and V. Abdullayev). New treatment methods began to be applied at the Institute. During this period, mass anti-tuberculosis vaccination of newborns was carried out in the republic, and sanitary and educational work among the population was expanded. In 1971, on the initiative of Heydar Aliyev, First Secretary of the Central Committee of the Communist Party of Azerbaijan, a new building of the Institute was constructed and put into operation.',
                    'В первые годы в институте изучались такие проблемы, как «Клиническое течение туберкулёза в военное время», «Распространение туберкулёза среди военнослужащих», «Распространение костно-суставного туберкулёза и лимфаденита среди местного населения», «Патоморфологические особенности туберкулёза в военное время» (исследования профессоров П. И. Блишенко, Г. Салимханова, В. Абдуллаева). В институте начали применяться новые методы лечения. В этот период в республике проводилась массовая противотуберкулёзная вакцинация новорождённых, расширялась санитарно-просветительская работа среди населения. В 1971 году по инициативе первого секретаря ЦК Компартии Азербайджана Гейдара Алиева было построено и введено в эксплуатацию новое здание института.'
                ),
                'image' => 'assets/img/about.png',
            ],
            [
                'title' => null,
                'text' => $this->t(
                    '1971-ci ildə institutda artıq onlarca səmərələşdirici təklif, bir necə elmi ixtira qeydə alınır, monoqrafiya, metodik tövsiyələr və təkcə Azərbaycan və SSRİ də deyil, eyni zamanda xarici ölkələrdə çoxlu məqalələr dərc olunur. İnstitutunun əməkdaşları xarici ölkələrə məruzələr, təcrübə mübadiləsi üçün ezam olunurlar. 90-ci illərdə artıq ET Vərəm İnstitutunun alimləri dünyanın tanınmış elmi mərkəzləri ilə geniş əməkdaşlıq edirlər və inkişafda olan elmi məktəbin nüfuzu getdikcə artır. İnstitutun nailiyyətləri göz qabağında idi. Aparılan genişmiqyaslı tədqiqatlar nəticəsində məlum olur ki, respublikamızda təkcə vərəm yox, bronx-ağciyər xəstəlikləri də geniş yayılmışdır (1:12 nisbətində). Bu tədqiqatların nəticələri əsasında təklif edilmişdir institutun ET Ftiziatriya və Pulmonologiya İnstitutu adlandırılması təklifi irəli sürülür.',
                    'By 1971, dozens of rationalization proposals and several scientific inventions had been registered at the Institute, and monographs, methodological recommendations and numerous articles were published not only in Azerbaijan and the USSR but also abroad. Staff members were sent abroad to give presentations and exchange experience. By the 1990s the Institute\'s scientists were cooperating widely with leading scientific centers of the world, and the prestige of the growing scientific school kept increasing. The large-scale research showed that not only tuberculosis but also bronchopulmonary diseases were widespread in the republic (in a ratio of 1:12). Based on the results of these studies, it was proposed to rename the Institute the Research Institute of Phthisiology and Pulmonology.',
                    'К 1971 году в институте были зарегистрированы десятки рационализаторских предложений и несколько научных изобретений, опубликованы монографии, методические рекомендации и множество статей не только в Азербайджане и СССР, но и за рубежом. Сотрудников направляли за границу для выступлений с докладами и обмена опытом. К 1990-м годам учёные института широко сотрудничали с известными научными центрами мира, а авторитет развивающейся научной школы постоянно рос. В результате масштабных исследований выяснилось, что в республике широко распространён не только туберкулёз, но и бронхолёгочные заболевания (в соотношении 1:12). На основании результатов этих исследований было предложено переименовать институт в Научно-исследовательский институт фтизиатрии и пульмонологии.'
                ),
                'image' => 'assets/img/about.png',
            ],
        ];
        foreach ($blocks as $i => $b) {
            AboutBlock::create($b + ['sort' => $i + 1]);
        }

        Partner::query()->delete();
        foreach ([
            ['The Global Fund', 'https://www.theglobalfund.org'],
            ['World Health Organization', 'https://www.who.int'],
        ] as $i => [$name, $url]) {
            Partner::create(['name' => ['az' => $name, 'en' => $name, 'ru' => $name], 'url' => $url, 'sort' => $i + 1]);
        }
    }
}
