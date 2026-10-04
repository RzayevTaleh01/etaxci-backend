<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\FeatureCard;
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

        $featured = News::published()->with('category')
            ->orderByDesc('is_featured')->orderByDesc('published_at')->first();
        $latest = $featured
            ? News::published()->with('category')->where('id', '!=', $featured->id)->orderByDesc('published_at')->limit(3)->get()
            : collect();

        return view('site.home', compact('sliders', 'cards', 'leader', 'featured', 'latest'));
    }
}
