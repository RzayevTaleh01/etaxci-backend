<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\AboutBlock;
use App\Models\Page;
use App\Models\Partner;

class PageController extends Controller
{
    public function show(?string $slug = null)
    {
        $slug ??= request()->route()->defaults['slug'];
        $page = Page::active()->where('slug', $slug)->firstOrFail();

        $crumbs = [[$page->title, null]];
        if ($page->slug === 'about') {
            $crumbs = [[t('about_us'), localized_url('/about')], [$page->title, null]];
        }

        if ($page->slug === 'about') {
            return view('site.about', [
                'page' => $page,
                'blocks' => AboutBlock::active()->ordered()->get(),
                'crumbs' => $crumbs,
            ]);
        }

        if ($page->template === 'international') {
            return view('site.international', [
                'page' => $page,
                'partners' => Partner::active()->ordered()->get(),
                'crumbs' => $crumbs,
            ]);
        }

        return view('site.page', ['page' => $page, 'crumbs' => $crumbs]);
    }
}
