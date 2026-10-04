<?php

namespace App\Admin\Resources;

use App\Admin\Resource;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserResource extends Resource
{
    public static string $model = User::class;

    public static string $slug = 'users';

    public static string $label = 'İstifadəçilər';

    public static string $singular = 'İstifadəçi';

    public static string $icon = 'bi-people';

    public static string $group = 'Sistem';

    public static array $roles = ['super-admin'];

    public static array $search = ['name', 'email'];

    public static function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Ad', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'email', 'label' => 'E-poçt', 'type' => 'email', 'required' => true, 'col' => 6, 'rules' => ['unique:users,email,'.request()->route('id')]],
            ['name' => 'password', 'label' => 'Şifrə', 'type' => 'password', 'required' => true, 'col' => 6, 'help' => 'Redaktə zamanı boş qalsa, dəyişməz (min. 8 simvol).'],
            ['name' => 'role', 'label' => 'Rol', 'type' => 'select', 'options' => ['super-admin' => 'Super Admin', 'admin' => 'Admin', 'editor' => 'Redaktor'], 'required' => true, 'virtual' => true, 'col' => 6],
            ['name' => 'is_active', 'label' => 'Aktiv', 'type' => 'toggle', 'default' => true],
        ];
    }

    public static function columns(): array
    {
        return [
            ['name' => 'name', 'label' => 'Ad', 'type' => 'text'],
            ['name' => 'email', 'label' => 'E-poçt', 'type' => 'text'],
            ['name' => 'role', 'label' => 'Rol', 'type' => 'computed'],
            ['name' => 'last_login_at', 'label' => 'Son giriş', 'type' => 'date'],
            ['name' => 'is_active', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    public static function computed(string $name, Model $model): string
    {
        return $model->roleLabel();
    }

    public static function formData(?Model $model): array
    {
        return ['values' => ['role' => $model?->getRoleNames()->first()]];
    }

    public static function afterSave(Model $model, Request $request): void
    {
        if ($request->filled('role')) {
            $model->syncRoles([$request->input('role')]);
        }
    }

    public static function canDelete(Model $model): bool
    {
        return $model->id !== auth()->id();
    }
}
