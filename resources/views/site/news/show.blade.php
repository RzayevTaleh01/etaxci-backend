@extends('site.layouts.inner')

@if (! empty($news->gallery))
  @section('fancybox', '1')
@endif

@section('title', $news->meta_title ?: $news->title)
@section('description', $news->meta_description ?: $news->summary(180))
@section('og_type', 'article')
@if ($news->image)
  @section('image', media_url($news->image))
@endif

@section('content')
<article data-reveal class="row gx-lg-4 gy-4 align-items-center justify-content-between article-row">
  <div class="{{ $news->image ? 'col-lg-6' : 'col-12' }}">
    <h2 class="article__title">{{ $news->title }}</h2>
    <div class="article__meta">
      <span class="article__date"><img src="{{ asset('assets/icons/calendar-sm.svg') }}" width="17" height="16" alt="">{{ format_date($news->published_at) }}</span>
      <span class="article__views"><img src="{{ asset('assets/icons/eye-sm.svg') }}" width="24" height="24" alt="">{{ $news->views }}</span>
    </div>
    <div class="article__text">{!! $news->content !!}</div>
  </div>
  @if ($news->image)
    <div class="col-lg-6 d-flex justify-content-lg-end">
      <img class="article__image" src="{{ media_url($news->image) }}" width="559" height="505" alt="{{ $news->title }}">
    </div>
  @endif
</article>

@if (! empty($news->gallery))
<section data-reveal class="mt-5 pt-4 thumb-strip" data-strip aria-label="{{ t('photo_gallery') }}">
  <div class="thumb-strip__track" data-strip-track>
    @foreach ($news->gallery as $photo)
      <a class="thumb-strip__item" href="{{ media_url($photo) }}" data-fancybox="news-gallery" data-caption="{{ $news->title }}"><img class="thumb-strip__image" src="{{ media_url($photo) }}" loading="lazy" alt=""></a>
    @endforeach
  </div>
  <div class="d-flex justify-content-between mt-4">
    <button class="round-arrow" type="button" data-strip-prev aria-label="{{ t('prev') }}"><img src="{{ asset('assets/icons/arrow-left.svg') }}" alt=""></button>
    <button class="round-arrow round-arrow--next" type="button" data-strip-next aria-label="{{ t('next') }}"><img src="{{ asset('assets/icons/arrow-left.svg') }}" alt=""></button>
  </div>
</section>
@endif

@if ($related->isNotEmpty())
<hr class="article-divider">
<section data-reveal class="article-related">
  <h2 class="article-related__title">{{ t('other_news') }}</h2>
  <div class="row g-4">
    @foreach ($related as $item)
      @include('site.news.card', ['item' => $item])
    @endforeach
  </div>
</section>
@endif
@endsection

