<?php

use App\Admin\Registry;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ResourceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TranslationController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.post');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
        Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

        Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('/messages/{message}/status', [MessageController::class, 'status'])->name('messages.status');
        Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

        Route::middleware('role:super-admin|admin')->group(function () {
            Route::get('/settings', [SettingController::class, 'edit'])->name('settings');
            Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
            Route::get('/translations', [TranslationController::class, 'index'])->name('translations');
            Route::post('/translations', [TranslationController::class, 'update'])->name('translations.update');
            Route::get('/logs', [ActivityLogController::class, 'index'])->name('logs');
        });

        // Generic CRUD for every resource registered in App\Admin\Registry
        foreach (Registry::all() as $resource) {
            $slug = $resource::$slug;
            $c = ResourceController::class;

            Route::get("/{$slug}", [$c, 'index'])->defaults('resource', $resource)->name("{$slug}.index");
            Route::get("/{$slug}/create", [$c, 'create'])->defaults('resource', $resource)->name("{$slug}.create");
            Route::post("/{$slug}", [$c, 'store'])->defaults('resource', $resource)->name("{$slug}.store");
            Route::post("/{$slug}/reorder", [$c, 'reorder'])->defaults('resource', $resource)->name("{$slug}.reorder");
            Route::get("/{$slug}/{id}/edit", [$c, 'edit'])->defaults('resource', $resource)->name("{$slug}.edit")->whereNumber('id');
            Route::put("/{$slug}/{id}", [$c, 'update'])->defaults('resource', $resource)->name("{$slug}.update")->whereNumber('id');
            Route::post("/{$slug}/{id}/toggle", [$c, 'toggle'])->defaults('resource', $resource)->name("{$slug}.toggle")->whereNumber('id');
            Route::delete("/{$slug}/{id}", [$c, 'destroy'])->defaults('resource', $resource)->name("{$slug}.destroy")->whereNumber('id');
        }
    });
});
