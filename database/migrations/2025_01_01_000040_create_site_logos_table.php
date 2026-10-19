<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_logos', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->string('image');
            $table->string('url')->nullable();
            $table->string('placement', 10)->default('both'); // both | header | footer
            $table->unsignedSmallInteger('header_height')->default(84);
            $table->unsignedSmallInteger('footer_height')->default(72);
            $table->boolean('badge')->default(false);
            $table->unsignedInteger('sort')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Start with the two logos the header and footer showed before, carrying over any values set in site settings.
        $setting = function (string $key) {
            $value = DB::table('settings')->where('key', $key)->value('value');

            return $value === null ? null : json_decode($value, true);
        };

        DB::table('site_logos')->insert([
            [
                'title' => json_encode(['az' => 'Azərbaycan Respublikası Səhiyyə Nazirliyi', 'en' => 'Ministry of Health of the Republic of Azerbaijan', 'ru' => 'Министерство здравоохранения Азербайджанской Республики'], JSON_UNESCAPED_UNICODE),
                'image' => $setting('ministry_logo') ?: 'assets/img/logo-ministry.svg',
                'url' => $setting('ministry_logo_url') ?: 'https://sehiyye.gov.az',
                'placement' => 'both',
                'header_height' => 84,
                'footer_height' => 64,
                'badge' => true,
                'sort' => 1,
                'is_active' => $setting('show_ministry_logo') !== '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => json_encode(['az' => 'ETACXİ', 'en' => 'ETACXİ', 'ru' => 'ETACXİ'], JSON_UNESCAPED_UNICODE),
                'image' => $setting('logo') ?: 'assets/img/logo.png',
                'url' => $setting('logo_url') ?: null,
                'placement' => 'both',
                'header_height' => 84,
                'footer_height' => 72,
                'badge' => false,
                'sort' => 2,
                'is_active' => $setting('show_logo') !== '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('settings')->whereIn('key', ['ministry_logo', 'ministry_logo_url', 'show_ministry_logo', 'logo_url', 'show_logo'])->delete();
    }

    public function down(): void
    {
        Schema::dropIfExists('site_logos');
    }
};
