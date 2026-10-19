<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\FeatureCard;
use App\Models\GalleryPhoto;
use App\Models\News;
use App\Models\Person;
use App\Models\Slider;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $cards = FeatureCard::active()->ordered()->get();
        $leader = Person::active()->where('show_on_home', true)->ordered()->first();

        // Headline news first (newest headline leads, even if older than regular news), then the latest news fill the rest.
        $latest = News::published()->with('category')
            ->orderByDesc('is_featured')->orderByDesc('published_at')->orderByDesc('id')
            ->limit(4)->get();
        $featured = $latest->shift();
        $photos = GalleryPhoto::active()->ordered()->limit(12)->get();

        return view('site.home', compact('sliders', 'cards', 'leader', 'featured', 'latest', 'photos'));
    }
}
