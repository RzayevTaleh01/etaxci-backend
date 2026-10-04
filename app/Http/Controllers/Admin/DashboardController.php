<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\GalleryPhoto;
use App\Models\GalleryVideo;
use App\Models\News;
use App\Models\Person;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            ['Xəbərlər', News::count(), 'bi-newspaper', 'primary', route('admin.news.index')],
            ['Həkimlər', Person::where('group', 'doctor')->count(), 'bi-heart-pulse', 'success', route('admin.people.index', ['group' => 'doctor'])],
            ['Əməkdaşlar', Person::where('group', '!=', 'doctor')->count(), 'bi-person-badge', 'info', route('admin.people.index')],
            ['Foto / Video', GalleryPhoto::count().' / '.GalleryVideo::count(), 'bi-images', 'warning', route('admin.gallery-photos.index')],
            ['Suallar', Faq::count(), 'bi-question-circle', 'secondary', route('admin.faqs.index')],
            ['Yeni müraciətlər', ContactMessage::where('status', 'new')->count(), 'bi-envelope', 'danger', route('admin.messages.index')],
        ];

        $latestMessages = ContactMessage::latest()->limit(5)->get();
        $latestNews = News::latest()->limit(5)->get();
        $logs = ActivityLog::with('user')->latest()->limit(8)->get();

        // News created per month (last 6 months) for the chart.
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->startOfMonth());
        $chart = [
            'labels' => $months->map(fn ($m) => $m->format('m.Y'))->all(),
            'data' => $months->map(fn ($m) => News::whereBetween('created_at', [$m, $m->copy()->endOfMonth()])->count())->all(),
        ];

        return view('admin.dashboard', compact('stats', 'latestMessages', 'latestNews', 'logs', 'chart'));
    }
}
