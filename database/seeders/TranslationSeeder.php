<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Seeder;

/** Copies the interface strings from lang/{az,en,ru}/site.php into the editable `translations` table. */
class TranslationSeeder extends Seeder
{
    public function run(): void
    {
        $merged = [];
        foreach (array_keys(config('site.locales')) as $locale) {
            $lines = require lang_path("{$locale}/site.php");
            foreach ($lines as $key => $text) {
                $merged[$key][$locale] = $text;
            }
        }

        foreach ($merged as $key => $texts) {
            Translation::updateOrCreate(['key' => $key], ['text' => $texts]);
        }

        Translation::flush();
    }
}
