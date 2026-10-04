<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Reception;
use Illuminate\Database\Seeder;

class CitizenSeeder extends Seeder
{
    public function run(): void
    {
        Faq::query()->delete();
        Reception::query()->delete();

        $faqs = [
            [
                ['İnstitut harada yerləşir?', 'Where is the Institute located?', 'Где находится институт?'],
                ['Elmi-Tədqiqat Ağciyər Xəstəlikləri İnstitutu Bakı şəhəri, Nizami rayonu, Məmmədəli Şərifli küçəsi, 163 ünvanında yerləşir.', 'The Research Institute of Lung Diseases is located at 163 Mammadali Sharifli Street, Nizami district, Baku.', 'Научно-исследовательский институт лёгочных заболеваний расположен по адресу: г. Баку, Низаминский район, ул. Мамедали Шарифли, 163.'],
            ],
            [
                ['İş saatları necədir?', 'What are the working hours?', 'Каков режим работы?'],
                ['İnstitutun əlaqə xidməti 09:00-18:00 saatları arasında fəaliyyət göstərir.', 'The Institute\'s contact service operates from 09:00 to 18:00.', 'Служба связи института работает с 09:00 до 18:00.'],
            ],
            [
                ['İnstitutla necə əlaqə saxlamaq olar?', 'How can I contact the Institute?', 'Как связаться с институтом?'],
                ['Əlaqə səhifəsindəki formanı doldura, etacxi@esehiyye.az ünvanına yaza və ya (+99412) 4214498 nömrəsinə zəng edə bilərsiniz.', 'You can fill in the form on the Contact page, write to etacxi@esehiyye.az or call (+99412) 4214498.', 'Вы можете заполнить форму на странице «Контакты», написать на etacxi@esehiyye.az или позвонить по номеру (+99412) 4214498.'],
            ],
            [
                ['Müraciəti necə göndərə bilərəm?', 'How can I submit an appeal?', 'Как отправить обращение?'],
                ["Müraciətinizi Əlaqə səhifəsindəki elektron formadan göndərə bilərsiniz.\n\nForma ad, soyad, əlaqə məlumatları və müraciətin məzmununu tələb edir.", "You can send your appeal using the electronic form on the Contact page.\n\nThe form requires your first name, last name, contact details and the content of your appeal.", "Вы можете отправить обращение через электронную форму на странице «Контакты».\n\nФорма требует указать имя, фамилию, контактные данные и содержание обращения."],
            ],
            [
                ['Qəbul günləri haqqında məlumatı harada tapa bilərəm?', 'Where can I find information about reception days?', 'Где можно узнать о днях приёма?'],
                ['Qəbul günləri barədə məlumat saytın “Vətəndaşlar Üçün” bölməsində yerləşdirilir. Dəqiq məlumat üçün əlaqə nömrələrimizə də müraciət edə bilərsiniz.', 'Information about reception days is published in the “For citizens” section of the website. You can also call our contact numbers for exact details.', 'Информация о днях приёма размещена в разделе сайта «Для граждан». За точной информацией можно также обратиться по нашим контактным номерам.'],
            ],
            [
                ['İcbari tibbi sığorta hansı xidmətləri əhatə edir?', 'Which services does compulsory medical insurance cover?', 'Какие услуги покрывает обязательное медицинское страхование?'],
                ['Xidmətlər Zərfinə daxil olan tibbi xidmətlərin sayı 2550-dir. Bura təcili və təxirəsalınmaz tibbi yardım, ilkin səhiyyə xidməti, ambulator şəraitdə müayinə və müalicə daxildir.', 'The Service Package includes 2,550 medical services, covering emergency and urgent medical care, primary healthcare, and outpatient examination and treatment.', 'В Пакет услуг входит 2550 медицинских услуг: неотложная и экстренная помощь, первичная медико-санитарная помощь, обследование и лечение в амбулаторных условиях.'],
            ],
            [
                ['İnstitutun xəbərlərini harada izləyə bilərəm?', 'Where can I follow the Institute\'s news?', 'Где можно следить за новостями института?'],
                ['Son xəbərlər saytın “Xəbərlər” bölməsində, foto və video materiallar isə “Qalereya” bölməsində yerləşdirilir.', 'The latest news is published in the “News” section of the website, and photo and video materials in the “Gallery” section.', 'Последние новости размещаются в разделе «Новости», а фото- и видеоматериалы — в разделе «Галерея».'],
            ],
        ];
        foreach ($faqs as $i => [$q, $a]) {
            Faq::create([
                'question' => ['az' => $q[0], 'en' => $q[1], 'ru' => $q[2]],
                'answer' => ['az' => $a[0], 'en' => $a[1], 'ru' => $a[2]],
                'sort' => $i + 1,
            ]);
        }

        $rows = [
            [['Direktor', 'Director', 'Директор'], ['Axundova İradə Mirsaab qızı', 'Akhundova Irada Mirsaab gizi', 'Ахундова Ирада Мирсааб гызы'],
                ['Hər həftənin çərşənbə günü saat 15:00', 'Every Wednesday at 15:00', 'Каждую среду в 15:00']],
            [['Direktor müavini', 'Deputy Director', 'Заместитель директора'], ['Əliyeva Gülzar Rafiq qız', 'Aliyeva Gulzar Rafig gizi', 'Алиева Гюльзар Рафиг гызы'],
                ['Hər həftənin cümə axşamı saat 15:00', 'Every Thursday at 15:00', 'Каждый четверг в 15:00']],
            [['Elmi-tədqiqat departamentinin rəhbəri', 'Head of the Research Department', 'Руководитель научно-исследовательского департамента'], ['Soyadı Adı Ata adı', 'Surname Name Patronymic', 'Фамилия Имя Отчество'],
                ['Hər həftənin cümə günü saat 15:00-17:00', 'Every Friday 15:00-17:00', 'Каждую пятницу с 15:00 до 17:00']],
            [['Klinik departamentin rəhbəri', 'Head of the Clinical Department', 'Руководитель клинического департамента'], ['Soyadı Adı Ata adı', 'Surname Name Patronymic', 'Фамилия Имя Отчество'],
                ['Hər həftənin bazar ertəsi günü saat 15:00-17:00', 'Every Monday 15:00-17:00', 'Каждый понедельник с 15:00 до 17:00']],
            [['Müraciətlərlə iş departamentinin rəhbəri', 'Head of the Citizen Appeals Department', 'Руководитель департамента по работе с обращениями'], ['Soyadı Adı Ata adı', 'Surname Name Patronymic', 'Фамилия Имя Отчество'],
                ['Hər həftənin çərşənbə axşamı saat 14:00-16:00', 'Every Tuesday 14:00-16:00', 'Каждый вторник с 14:00 до 16:00']],
        ];
        foreach ($rows as $i => [$pos, $name, $schedule]) {
            Reception::create([
                'position' => ['az' => $pos[0], 'en' => $pos[1], 'ru' => $pos[2]],
                'name' => ['az' => $name[0], 'en' => $name[1], 'ru' => $name[2]],
                'schedule' => ['az' => $schedule[0], 'en' => $schedule[1], 'ru' => $schedule[2]],
                'email' => 'etacxi@esehiyye.az',
                'sort' => $i + 1,
            ]);
        }
    }
}
