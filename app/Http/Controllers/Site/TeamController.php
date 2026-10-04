<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Person;

class TeamController extends Controller
{
    private const SECTIONS = ['scientific', 'medical', 'administrative'];

    private function heading(string $slug, string $fallback): Page
    {
        return Page::where('slug', $slug)->first() ?? new Page(['title' => [app()->getLocale() => $fallback]]);
    }

    private function about(): array
    {
        return [t('about_us'), localized_url('/about')];
    }

    public function leadership()
    {
        $page = $this->heading('leadership', t('leadership'));

        return view('site.team.list', [
            'page' => $page,
            'people' => Person::active()->where('group', 'leadership')->ordered()->get(),
            'layout' => 'wide',
            'crumbs' => [$this->about(), [$page->title, null]],
        ]);
    }

    public function management()
    {
        $page = $this->heading('management', t('management'));

        return view('site.team.list', [
            'page' => $page,
            'people' => Person::active()->whereIn('group', ['leadership', 'management'])
                ->orderByRaw("`group` = 'leadership' desc")->ordered()->get(),
            'layout' => 'grid',
            'crumbs' => [$this->about(), [$page->title, null]],
        ]);
    }

    public function section(string $section)
    {
        abort_unless(in_array($section, self::SECTIONS, true), 404);
        $page = $this->heading('section-'.$section, t('section_'.$section));

        return view('site.team.list', [
            'page' => $page,
            'people' => Person::active()->where('group', $section)->ordered()->get(),
            'layout' => 'grid',
            'crumbs' => [$this->about(), [$page->title, null]],
        ]);
    }

    public function doctors(bool $degree = false)
    {
        $degree = request()->route()->defaults['degree'] ?? $degree;
        $page = $this->heading($degree ? 'doctors-degree' : 'doctors', $degree ? t('doctors_degree') : t('doctors_all'));
        $people = Person::active()->where('group', 'doctor')->when($degree, fn ($q) => $q->where('has_degree', true))->ordered()->get();

        $page->subtitle = t('doctors_count', ['n' => $people->count()]);

        return view('site.team.list', [
            'page' => $page,
            'people' => $people,
            'layout' => 'grid',
            'crumbs' => [[t('medical_activity'), localized_url('/doctors')], [$page->title, null]],
        ]);
    }

    public function person(Person $person)
    {
        abort_unless($person->is_active, 404);

        $parent = match ($person->group) {
            'leadership' => [t('leadership'), localized_url('/leadership')],
            'management' => [t('management'), localized_url('/management')],
            'scientific', 'medical', 'administrative' => [t('section_'.$person->group), localized_url('/section/'.$person->group)],
            default => [t('doctors_all'), localized_url('/doctors')],
        };

        $crumbs = $person->group === 'doctor'
            ? [[t('medical_activity'), localized_url('/doctors')], $parent, [$person->name, null]]
            : [$this->about(), $parent, [$person->name, null]];

        return view('site.team.show', compact('person', 'crumbs'));
    }
}
