@extends('site.layouts.app')

@section('title', '')

@section('head')
  @if ($sliders->first()?->image)
    <link rel="preload" as="image" href="{{ media_url($sliders->first()->image) }}" fetchpriority="high">
  @endif
@endsection

@section('hero')
<div class="hero">
  <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="7000">
    <div class="carousel-inner">
      @foreach ($sliders as $slide)
        <div class="carousel-item hero__slide{{ $loop->first ? ' active' : '' }}" style="background-image: url('{{ media_url($slide->image) ?: asset('assets/img/hero-bg.png') }}')">
          <div class="container">
            <div class="hero__body">
              @if ($loop->first)<h1 class="hero__title">{{ $slide->title }}</h1>@else<h2 class="hero__title">{{ $slide->title }}</h2>@endif
              @if ($slide->text)<p class="hero__text">{{ $slide->text }}</p>@endif
              @if ($slide->button_url)
                <a class="btn btn-brand" href="{{ localized_url($slide->button_url) }}">{{ $slide->button_text ?: t('read_more') }}</a>
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
    @if ($sliders->count() > 1)
    <div class="hero__controls">
      <div class="container hero__controls-inner">
        <div class="carousel-indicators">
          @foreach ($sliders as $slide)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $loop->index }}" @if($loop->first) class="active" aria-current="true" @endif aria-label="{{ t('slide') }} {{ $loop->iteration }}"></button>
          @endforeach
        </div>
        <div class="hero__arrows">
          <button class="hero__arrow" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" aria-label="{{ t('prev') }}"><img src="{{ asset('assets/icons/arrow-left-light.svg') }}" width="24" height="24" alt=""></button>
          <button class="hero__arrow hero__arrow--next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" aria-label="{{ t('next') }}"><img src="{{ asset('assets/icons/arrow-left-light.svg') }}" width="24" height="24" alt=""></button>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection

@section('main')
<main id="main">
  @if ($cards->isNotEmpty())
  <section class="features">
    <div class="container">
      <div class="row g-0 features__row">
        @foreach ($cards as $card)
          @php($size = ['general' => [46, 57], 'leadership' => [51, 62], 'structure' => [62, 62], 'international' => [62, 62]][$card->icon] ?? [62, 62])
          <div class="col-md-6 col-lg-3">
            <article data-reveal class="feature-card feature-card--{{ $card->icon }}">
              <div class="feature-card__body">
                <div class="feature-card__icon"><img src="{{ asset('assets/icons/feature-'.$card->icon.'.svg') }}" width="{{ $size[0] }}" height="{{ $size[1] }}" alt=""></div>
                <div>
                  <h2 class="feature-card__title">{{ $card->title }}</h2>
                  <p class="feature-card__text">{{ \Illuminate\Support\Str::limit((string) $card->text, 90) }}</p>
                </div>
              </div>
              <a class="feature-card__btn" href="{{ $card->link() }}">{{ t('details') }} @include('site.partials.svg-arrow')</a>
            </article>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  @if ($leader)
  <section class="section">
    <div class="container">
      <div data-reveal class="section-heading">
        <h2 class="section-heading__title">{{ t('leadership') }}</h2>
        <span class="section-heading__line" aria-hidden="true"></span>
        <a class="section-heading__link" href="{{ localized_url('/leadership') }}">{{ t('read_more') }} @include('site.partials.svg-arrow')</a>
      </div>
      <div data-reveal class="leader-intro">
        <img class="leader-intro__photo" src="{{ $leader->photo ? media_url($leader->photo) : asset('assets/img/director.png') }}" width="290" height="290" alt="{{ $leader->name }}">
        <div>
          <h3 class="leader-intro__name">{{ $leader->name }}</h3>
          <p class="leader-intro__role">{{ $leader->position }}</p>
          <div class="leader-intro__bio">{!! $leader->bio !!}</div>
        </div>
      </div>
    </div>
  </section>
  @endif

  @if ($featured)
  <section class="section section--surface">
    <div class="container">
      <div data-reveal class="section-heading">
        <h2 class="section-heading__title">{{ t('news') }}</h2>
        <span class="section-heading__line" aria-hidden="true"></span>
        <a class="section-heading__link" href="{{ localized_url('/news') }}">{{ t('read_more') }} @include('site.partials.svg-arrow')</a>
      </div>
      <div class="news-home">
        <article data-reveal class="news-featured">
          <img class="news-featured__image" src="{{ media_url($featured->image) ?: asset('assets/img/news-featured.png') }}" alt="">
          <div class="news-featured__body">
            <h3 class="news-featured__title">{{ $featured->title }}</h3>
            <div class="news-meta"><span><img src="{{ asset('assets/icons/calendar.svg') }}" width="16" height="16" alt="">{{ format_date($featured->published_at) }}</span><span><img src="{{ asset('assets/icons/eye.svg') }}" width="16" height="16" alt="">{{ $featured->views }}</span></div>
            <p class="news-featured__text">{{ $featured->summary(170) }}</p>
          </div>
          @if ($featured->category)<a class="news-tag" href="{{ $featured->category->url() }}">{{ $featured->category->name }}</a>@endif
          <a class="news-card-link" href="{{ $featured->url() }}" aria-label="{{ $featured->title }}"></a>
        </article>
        <div class="news-list">
          @foreach ($latest as $item)
            <article data-reveal class="news-item">
              <div class="news-item__media">
                <img class="news-item__image" src="{{ media_url($item->image) ?: asset('assets/img/news-featured.png') }}" loading="lazy" alt="">
                @if ($item->category)<a class="news-tag news-tag--blue" href="{{ $item->category->url() }}">{{ $item->category->name }}</a>@endif
              </div>
              <div>
                <h3 class="news-item__title">{{ $item->title }}</h3>
                <div class="news-meta"><span><img src="{{ asset('assets/icons/calendar.svg') }}" width="16" height="16" alt="">{{ format_date($item->published_at) }}</span><span><img src="{{ asset('assets/icons/eye.svg') }}" width="16" height="16" alt="">{{ $item->views }}</span></div>
                <p class="news-item__text">{{ $item->summary(110) }}</p>
              </div>
              <a class="news-card-link" href="{{ $item->url() }}" aria-label="{{ $item->title }}"></a>
            </article>
          @endforeach
        </div>
      </div>
    </div>
  </section>
  @endif

  @include('site.partials.cta')
</main>
@endsection
