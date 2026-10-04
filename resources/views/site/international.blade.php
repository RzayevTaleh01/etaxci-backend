@extends('site.layouts.app')

@section('title', $page->meta_title ?: $page->title)
@section('description', $page->meta_description ?: strip_tags((string) $page->content))

@section('main')
<main id="main" class="page">
  <div class="container">
    @include('site.partials.page-head', ['wide' => true])
  </div>
  <div data-reveal class="banner" role="img" aria-label="{{ $page->title }}" @if($page->banner) style="background-image: url('{{ media_url($page->banner) }}')" @endif></div>
  <div class="container">
    <article data-reveal class="info-card">
      <h2 class="info-card__title">{{ $page->title }}</h2>
      <div class="info-card__text">
        <div class="info-card__group">{!! $page->content !!}</div>
      </div>
    </article>

    @if ($partners->isNotEmpty())
      <section data-reveal class="mt-5">
        <h2 class="article-related__title">{{ t('partners') }}</h2>
        <div class="row g-4 align-items-center">
          @foreach ($partners as $partner)
            <div class="col-6 col-md-3 text-center">
              @if ($partner->url)<a href="{{ $partner->url }}" target="_blank" rel="noopener" title="{{ $partner->name }}">@endif
              @if ($partner->logo)
                <img src="{{ media_url($partner->logo) }}" alt="{{ $partner->name }}" class="img-fluid" style="max-height:90px" loading="lazy">
              @else
                <span class="fw-medium">{{ $partner->name }}</span>
              @endif
              @if ($partner->url)</a>@endif
            </div>
          @endforeach
        </div>
      </section>
    @endif
  </div>
</main>
@endsection
