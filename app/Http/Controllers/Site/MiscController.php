<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Faq;
use App\Models\GalleryPhoto;
use App\Models\GalleryVideo;
use App\Models\News;
use App\Models\Page;
use App\Models\Person;
use App\Models\Reception;
use App\Models\Setting;
use App\Models\StructureNode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MiscController extends Controller
{
    public function faq()
    {
        return view('site.faq', [
            'faqs' => Faq::active()->ordered()->get(),
            'crumbs' => [[t('citizens'), localized_url('/citizens')], [t('faq'), null]],
        ]);
    }

    public function reception()
    {
        return view('site.reception', [
            'rows' => Reception::active()->ordered()->get(),
            'crumbs' => [[t('citizens'), localized_url('/citizens')], [t('reception_days'), null]],
        ]);
    }

    public function structure()
    {
        return view('site.structure', [
            'crumbs' => [[t('about_us'), localized_url('/about')], [t('structure'), null]],
        ]);
    }

    public function structureJson(string $lang)
    {
        $lang = array_key_exists($lang, locales()) ? $lang : app()->getLocale();

        return response()->json(StructureNode::tree($lang));
    }

    public function photos()
    {
        return view('site.gallery.photos', [
            'photos' => GalleryPhoto::active()->ordered()->paginate(24),
            'crumbs' => [[t('gallery'), localized_url('/gallery')], [t('photos'), null]],
        ]);
    }

    public function videos()
    {
        return view('site.gallery.videos', [
            'videos' => GalleryVideo::active()->ordered()->paginate(24),
            'crumbs' => [[t('gallery'), localized_url('/gallery')], [t('videos'), null]],
        ]);
    }

    public function contact()
    {
        return view('site.contact', ['crumbs' => [[t('contact'), null]]]);
    }

    public function contactSend(Request $request)
    {
        // Honeypot: real visitors never fill the hidden "website" field.
        if ($request->filled('website')) {
            return back();
        }

        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:150'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $message = ContactMessage::create($data + ['locale' => app()->getLocale(), 'ip' => $request->ip()]);

        if ($to = Setting::get('contact_notify_email') ?: Setting::get('email')) {
            try {
                Mail::raw(
                    "Ad: {$message->fullName()}\nTelefon: {$message->phone}\nE-poçt: {$message->email}\n\n{$message->message}",
                    fn ($m) => $m->to($to)->replyTo($message->email)->subject('Saytdan yeni müraciət — '.$message->fullName())
                );
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return redirect(localized_url('/contact').'#contact-form')->with('contact_success', true);
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->query('q'));
        $locale = app()->getLocale();
        $news = $people = $pages = collect();

        if (mb_strlen($q) >= 2) {
            $like = "%{$q}%";
            $news = News::published()->where(fn ($w) => $w
                ->where("title->{$locale}", 'like', $like)->orWhere("excerpt->{$locale}", 'like', $like)->orWhere("content->{$locale}", 'like', $like))
                ->orderByDesc('published_at')->limit(20)->get();
            $people = Person::active()->where(fn ($w) => $w
                ->where("name->{$locale}", 'like', $like)->orWhere("position->{$locale}", 'like', $like)->orWhere("specialty->{$locale}", 'like', $like))
                ->limit(20)->get();
            $pages = Page::active()->where('is_system', false)->where(fn ($w) => $w
                ->where("title->{$locale}", 'like', $like)->orWhere("content->{$locale}", 'like', $like))
                ->limit(10)->get();
        }

        return view('site.search', [
            'q' => $q, 'news' => $news, 'people' => $people, 'pages' => $pages,
            'crumbs' => [[t('search'), null]],
        ]);
    }

    public function sitemap()
    {
        $urls = collect();
        $static = ['', '/about', '/leadership', '/management', '/structure', '/section/scientific', '/section/medical', '/section/administrative',
            '/doctors', '/doctors/degree', '/citizens', '/ministry', '/international', '/faq', '/reception', '/news', '/gallery', '/videos', '/contact'];

        foreach (array_keys(locales()) as $loc) {
            foreach ($static as $p) {
                $urls->push(['loc' => url("/{$loc}{$p}"), 'date' => null]);
            }
            foreach (News::published()->get() as $n) {
                $urls->push(['loc' => url("/{$loc}/news/{$n->slug}"), 'date' => $n->updated_at]);
            }
            foreach (Person::active()->get() as $p) {
                $urls->push(['loc' => url("/{$loc}/".($p->group === 'doctor' ? 'doctors' : 'team').'/'.$p->slug), 'date' => $p->updated_at]);
            }
            foreach (Page::active()->where('is_system', false)->get() as $p) {
                $urls->push(['loc' => url("/{$loc}/p/{$p->slug}"), 'date' => $p->updated_at]);
            }
        }

        return response()->view('site.sitemap', compact('urls'))->header('Content-Type', 'application/xml');
    }

    public function robots()
    {
        return response("User-agent: *\nAllow: /\nDisallow: /admin\n\nSitemap: ".url('/sitemap.xml')."\n")
            ->header('Content-Type', 'text/plain');
    }
}
