<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsView;

class NewsController extends Controller
{
    public function index(?NewsCategory $category = null)
    {
        if ($category && ! $category->is_active) {
            abort(404);
        }

        $items = News::published()->with('category')
            ->when($category, fn ($q) => $q->where('news_category_id', $category->id))
            ->orderByDesc('published_at')->orderByDesc('id')
            ->paginate(12)->withQueryString();

        $crumbs = $category
            ? [[t('news'), localized_url('/news')], [$category->name, null]]
            : [[t('news'), null]];

        return view('site.news.index', [
            'items' => $items,
            'category' => $category,
            'categories' => NewsCategory::active()->ordered()->get(),
            'crumbs' => $crumbs,
        ]);
    }

    public function show(News $news)
    {
        abort_unless($news->is_active && (! $news->published_at || $news->published_at->isPast()), 404);

        // Count one view per visitor IP (IPs are stored only for this purpose).
        if (NewsView::track($news, request()->ip(), request()->userAgent())) {
            $news->views++;
        }

        $related = News::published()->with('category')->where('id', '!=', $news->id)
            ->when($news->news_category_id, fn ($q) => $q->orderByRaw('news_category_id = ? desc', [$news->news_category_id]))
            ->orderByDesc('published_at')->limit(4)->get();

        return view('site.news.show', [
            'news' => $news,
            'related' => $related,
            'crumbs' => [[t('news'), localized_url('/news')], [$news->title, null]],
        ]);
    }
}
