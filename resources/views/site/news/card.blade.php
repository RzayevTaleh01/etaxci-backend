<div data-reveal class="col-sm-6 col-lg-3 media-col">
  <a class="media-card" href="{{ $item->url() }}">
    <img class="media-card__image" src="{{ media_url($item->image) ?: asset('assets/img/news-1.png') }}" width="298" height="230" loading="lazy" alt="">
    <div class="media-card__meta">
      <span class="media-card__meta-item"><img src="{{ asset('assets/icons/calendar.svg') }}" width="24" height="24" alt="">{{ format_date($item->published_at) }}</span>
      <span class="media-card__meta-item media-card__views"><img src="{{ asset('assets/icons/eye.svg') }}" width="24" height="24" alt="">{{ $item->views }}</span>
    </div>
    <h3 class="media-card__title">{{ $item->title }}</h3>
  </a>
</div>
