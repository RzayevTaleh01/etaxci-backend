<?php

use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\MiscController;
use App\Http\Controllers\Site\NewsController;
use App\Http\Controllers\Site\PageController;
use App\Http\Controllers\Site\TeamController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

// "/" always opens the default language (Azerbaijani).
Route::get('/', fn () => redirect('/'.config('site.default_locale')));

Route::get('/sitemap.xml', [MiscController::class, 'sitemap']);
Route::get('/robots.txt', [MiscController::class, 'robots']);

require __DIR__.'/admin.php';

Route::prefix('{locale}')
    ->where(['locale' => implode('|', array_keys(config('site.locales')))])
    ->middleware(SetLocale::class)
    ->name('site.')
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');

        // Informational pages (content is managed in admin -> Səhifələr)
        Route::get('/about', [PageController::class, 'show'])->defaults('slug', 'about')->name('about');
        Route::get('/citizens', [PageController::class, 'show'])->defaults('slug', 'citizens')->name('citizens');
        Route::get('/ministry', [PageController::class, 'show'])->defaults('slug', 'ministry')->name('ministry');
        Route::get('/international', [PageController::class, 'show'])->defaults('slug', 'international')->name('international');
        Route::get('/p/{slug}', [PageController::class, 'show'])->name('page');

        // Team
        Route::get('/leadership', [TeamController::class, 'leadership'])->name('leadership');
        Route::get('/management', [TeamController::class, 'management'])->name('management');
        Route::get('/section/{section}', [TeamController::class, 'section'])->name('section');
        Route::get('/doctors', [TeamController::class, 'doctors'])->name('doctors');
        Route::get('/doctors/degree', [TeamController::class, 'doctors'])->defaults('degree', true)->name('doctors.degree');
        Route::get('/doctors/{person:slug}', [TeamController::class, 'person'])->name('doctor');
        Route::get('/team/{person:slug}', [TeamController::class, 'person'])->name('person');
        Route::get('/structure', [MiscController::class, 'structure'])->name('structure');
        Route::get('/structure/{lang}.json', [MiscController::class, 'structureJson'])->name('structure.json');

        // Citizens
        Route::get('/faq', [MiscController::class, 'faq'])->name('faq');
        Route::get('/reception', [MiscController::class, 'reception'])->name('reception');

        // News
        Route::get('/news', [NewsController::class, 'index'])->name('news');
        Route::get('/news/category/{category:slug}', [NewsController::class, 'index'])->name('news.category');
        Route::get('/news/{news:slug}', [NewsController::class, 'show'])->name('news.show');

        // Gallery
        Route::get('/gallery', [MiscController::class, 'photos'])->name('gallery');
        Route::get('/videos', [MiscController::class, 'videos'])->name('videos');

        // Contact & search
        Route::get('/contact', [MiscController::class, 'contact'])->name('contact');
        Route::post('/contact', [MiscController::class, 'contactSend'])->middleware('throttle:6,1')->name('contact.send');
        Route::get('/search', [MiscController::class, 'search'])->name('search');
    });
