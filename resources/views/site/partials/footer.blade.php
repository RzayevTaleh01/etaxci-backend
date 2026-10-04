@php
    $logo = media_url(setting('logo')) ?: asset('assets/img/logo.png');
    $shortName = setting('site_short_name', 'ETACXİ');
    $phones = array_values(array_filter(array_map('trim', preg_split('/\R/', (string) setting('phones', '')))));
@endphp
<footer class="site-footer">
  <div class="container">
    <div class="row gy-4 site-footer__main">
      @foreach ($footerMenu as $group)
        <div class="col-6 col-md-3 col-xl-2">
          <h2 class="site-footer__title">{{ $group->title }}</h2>
          <ul class="site-footer__list">
            @foreach ($group->children as $item)
              <li><a href="{{ $item->link() }}">{{ $item->title }}</a></li>
            @endforeach
          </ul>
        </div>
      @endforeach
      <div class="col-12 col-xl-4">
        <div class="site-footer__contact">
          <h2 class="site-footer__contact-title">{{ t('contact_us') }}</h2>
          <ul class="site-footer__contact-list">
            @foreach ($phones as $phone)
              @if ($loop->first)
                <li>@include('site.partials.svg-phone')<a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}">{{ $phone }}</a></li>
              @endif
            @endforeach
            @if ($email = setting('email'))
              <li>@include('site.partials.svg-mail')<a href="mailto:{{ $email }}">{{ $email }}</a></li>
            @endif
            @if ($address = setting('address'))
              <li>@include('site.partials.svg-pin')<span>{{ $address }}</span></li>
            @endif
          </ul>
        </div>
      </div>
    </div>
    <div class="site-footer__bar">
      <a href="{{ url('/'.app()->getLocale()) }}"><img class="site-footer__logo" src="{{ $logo }}" width="60" height="60" alt="{{ $shortName }}"></a>
      <ul class="social-list">
        @include('site.partials.social', ['maskId' => 'f'])
      </ul>
    </div>
    <p class="site-footer__copy">© {{ date('Y') }} {{ setting('footer_copy', setting('site_name')) }}</p>
  </div>
</footer>
