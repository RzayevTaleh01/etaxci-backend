@php
    // Pick the language from the first URL segment; the locale middleware does not run for unmatched routes.
    $seg = request()->segment(1);
    app()->setLocale(array_key_exists((string) $seg, locales()) ? $seg : config('site.default_locale'));
    \Illuminate\Support\Facades\URL::defaults(['locale' => app()->getLocale()]);
    $headerMenu = $headerMenu ?? \App\Models\MenuItem::active()->where('location', 'header')->whereNull('parent_id')->with('children')->orderBy('sort')->get();
    $footerMenu = $footerMenu ?? \App\Models\MenuItem::active()->where('location', 'footer')->whereNull('parent_id')->with('children')->orderBy('sort')->get();
@endphp
@extends('site.layouts.app')

@section('title', '404')

@section('main')
<main id="main" class="container page text-center">
  <h1 class="display-1 fw-medium text-primary-brand mt-5">404</h1>
  <p class="fs-5 mb-4">{{ t('page_not_found') }}</p>
  <a class="btn btn-brand" href="{{ url('/'.app()->getLocale()) }}">{{ t('back_home') }}</a>
</main>
@endsection
