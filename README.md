# ETACXİ — Laravel backend + admin panel

Elmi-Tədqiqat Ağciyər Xəstəlikləri İnstitutunun saytının dinamik versiyası.
**Laravel 13 · PHP 8.4 · MySQL 8 · Docker**. Saytın dilləri: **AZ** (əsas), **EN**, **RU**.

## Docker ilə işə salmaq

Tələb olunan yeganə proqram: Docker Desktop.

```bash
cd backend
docker compose up -d --build
```

İlk işə salınma 2–3 dəqiqə çəkir (paketlərin yüklənməsi, miqrasiya və ilkin məzmunun seed olunması avtomatik gedir).
Hazır olduğunu izləmək üçün: `docker compose logs -f app` (`ready to handle connections` yazısı çıxanda hazırdır).

| Ünvan | Təsvir |
|---|---|
| http://localhost:8000 | Sayt (avtomatik `/az`, `/en` və ya `/ru` səhifəsinə yönləndirir) |
| http://localhost:8000/admin | Admin panel |
| http://localhost:8080 | phpMyAdmin (server: `db`, istifadəçi: `etacxi`, şifrə: `secret`) |

### Admin giriş məlumatları (ilk girişdən sonra dəyişin)

| Rol | E-poçt | Şifrə |
|---|---|---|
| Super Admin | `admin@etacxi.az` | `Admin@12345` |
| Redaktor | `editor@etacxi.az` | `Admin@12345` |

Başqa e-poçt/şifrə ilə başlamaq üçün ilk işə salınmadan əvvəl `.env` faylına `ADMIN_EMAIL` və `ADMIN_PASSWORD` yazın.

### Faydalı əmrlər

```bash
docker compose down                 # dayandır
docker compose down -v              # dayandır + bazanı və yüklənmiş faylları sil
docker compose exec app php artisan migrate:fresh --seed --force   # bazanı sıfırla və ilkin məzmunu yenidən yüklə
docker compose exec app php artisan optimize:clear                  # keşi təmizlə
docker compose exec app tail -f storage/logs/laravel.log            # xətalara bax
```

> Yüklənən şəkillər `storage` Docker volume-unda saxlanılır (`docker compose down -v` onları silir).

## Rollar

| Rol | İcazələr |
|---|---|
| **Super Admin** | Hər şey, o cümlədən istifadəçilər |
| **Admin** | Bütün məzmun, menyu, parametrlər, tərcümələr, jurnal |
| **Redaktor** | Yalnız məzmun (xəbər, səhifə, həkim, qalereya və s.) və müraciətlər |

## Admin panelin bölmələri

* **Dashboard** — statistika, qrafik, son müraciətlər və əməliyyatlar
* **Müraciətlər** — əlaqə formasından gələn mesajlar (yeni / oxunub / cavablandırılıb)
* **Ana səhifə** — slayder, 4 kart
* **Xəbərlər** — xəbərlər (foto qalereya ilə) və kateqoriyalar
* **Səhifələr** — Ümumi məlumat, İcbari tibbi sığorta, Səhiyyə Nazirliyi, Beynəlxalq əlaqələr, rəhbərlik/hissə başlıqları və yeni statik səhifələr; Haqqımızda blokları; beynəlxalq tərəfdaşlar
* **Komanda** — rəhbərlik, idarəetmə aparatı, elmi/tibbi/inzibati hissələr və həkimlər (`Əməkdaşlar və həkimlər`), təşkilati struktur ağacı
* **Vətəndaşlar üçün** — tez-tez verilən suallar, qəbul günləri
* **Qalereya** — foto və video (YouTube)
* **Sayt** — menyu meneceri (üst menyu və footer), ümumi parametrlər (loqo, telefon, ünvan, sosial şəbəkələr, SEO), tərcümə meneceri
* **Sistem** — istifadəçilər, fəaliyyət jurnalı

Bütün məzmun sahələri AZ / EN / RU üçün ayrıca doldurulur (formun yuxarısındakı dil düymələri). Boş qalan dildə AZ mətni göstərilir.
Düymələr, etiketlər kimi interfeys yazıları **Tərcümə meneceri**ndən redaktə olunur.

## Layihənin quruluşu

```
app/Admin/Resources/      Admin modullarının təsviri (sahələr, sütunlar) — yeni modul əlavə etmək üçün bura baxın
app/Http/Controllers/     Admin/ (panel), Site/ (ictimai sayt)
app/Models/               Eloquent modellər (çoxdilli sahələr: spatie/laravel-translatable)
config/site.php           Dillər və "Ümumi parametrlər" sahələri
database/migrations/      Cədvəllər
database/seeders/         İlkin məzmun (3 dildə)
lang/{az,en,ru}/site.php  İnterfeys yazılarının ilkin dəyərləri
resources/views/site/     Saytın Blade şablonları (mövcud HTML/CSS dizaynı saxlanılıb)
resources/views/admin/    Admin panel şablonları
public/assets/            Saytın CSS/JS/şəkilləri
public/panel/             Admin panelin CSS/JS (Bootstrap Icons, Quill, Sortable, Chart.js — hamısı lokaldır)
docker/                   PHP, Nginx və entrypoint konfiqurasiyası
```

### Yeni admin modulu əlavə etmək

1. Migrasiya + model yaradın.
2. `app/Admin/Resources/` altında `Resource`-dan miras alan sinif yazın (sahələr və sütunlar).
3. Sinfi `app/Admin/Registry.php`-ə əlavə edin — CRUD, axtarış, sıralama və menyu avtomatik yaranır.

## SEO və texniki qeydlər

* Hər səhifədə `hreflang`, canonical, Open Graph, JSON-LD (təşkilat, breadcrumb, FAQ) var.
* `/sitemap.xml` (3 dil, xəbərlər və əməkdaşlar daxil) və `/robots.txt` avtomatik yaranır.
* Yüklənən şəkillər avtomatik WebP-yə çevrilir və kiçildilir.
* Əlaqə formu: CSRF, honeypot və sorğu limiti (dəqiqədə 6) ilə qorunur. E-poçt bildirişi üçün `.env`-də `MAIL_*` parametrlərini doldurun (default `MAIL_MAILER=log` — mesajlar yalnız bazada saxlanılır və jurnala yazılır).
* İstehsalda `.env`-də `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://etacxi.az` təyin edin və admin şifrələrini dəyişin.
* Faylların yüklənməsi: `Dockerfile`-da `upload_max_filesize=32M`.
