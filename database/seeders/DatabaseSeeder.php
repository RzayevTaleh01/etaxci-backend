<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SettingSeeder::class,
            TranslationSeeder::class,
            MenuSeeder::class,
            HomeSeeder::class,
            PageSeeder::class,
            TeamSeeder::class,
            CitizenSeeder::class,
            NewsSeeder::class,
        ]);
    }
}
