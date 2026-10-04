<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (['super-admin', 'admin', 'editor'] as $role) {
            Role::findOrCreate($role, 'web');
        }

        // Default administrator. Override with ADMIN_EMAIL / ADMIN_PASSWORD in .env and change the password after the first login.
        $user = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@etacxi.az')],
            ['name' => 'Administrator', 'password' => env('ADMIN_PASSWORD', 'Admin@12345'), 'is_active' => true]
        );
        $user->syncRoles(['super-admin']);

        $editor = User::firstOrCreate(
            ['email' => 'editor@etacxi.az'],
            ['name' => 'Redaktor', 'password' => env('ADMIN_PASSWORD', 'Admin@12345'), 'is_active' => true]
        );
        $editor->syncRoles(['editor']);
    }
}
