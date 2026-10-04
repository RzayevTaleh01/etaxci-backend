@php
    $locale = app()->getLocale();
    $logo = media_url(setting('logo')) ?: asset('assets/img/logo.png');
    $searchIcon = asset($overlay ? 'assets/icons/search-light.svg' : 'assets/icons/search.svg');
    $shortName = setting('site_short_name', 'ETACXİ');
@endphp
<header class="site-header{{ $overlay ? ' site-header--overlay' : '' }}">
  <div class="container">
    <nav class="navbar navbar-expand-xl">
      <a class="navbar-brand m-0" href="{{ url('/'.$locale) }}"><img class="site-logo" src="{{ $logo }}" width="60" height="60" alt="{{ $shortName }}"></a>
      <div class="site-nav__actions d-xl-none">
        <button class="site-nav__search d-xl-none" type="button" data-bs-toggle="collapse" data-bs-target="#searchPanel" aria-expanded="false" aria-controls="searchPanel" aria-label="{{ t('search') }}"><img src="{{ $searchIcon }}" width="24" height="24" alt=""></button>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mainNav" aria-controls="mainNav" aria-label="{{ t('open_menu') }}">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
      <div class="offcanvas offcanvas-start" tabindex="-1" id="mainNav" aria-label="{{ t('main_menu') }}">
        <div class="offcanvas-header d-xl-none">
          <img class="site-logo" src="{{ $logo }}" width="60" height="60" alt="{{ $shortName }}">
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#mainNav" aria-label="{{ t('close') }}"></button>
        </div>
        <div class="offcanvas-body">
          <div class="site-nav__end">
            <ul class="navbar-nav site-nav__menu">
              @foreach ($headerMenu as $item)
                @if ($item->children->isNotEmpty())
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle{{ $item->isCurrent() ? ' active' : '' }}" href="{{ $item->link() }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ $item->title }}@include('site.partials.svg-chevron')</a>
                    <ul class="dropdown-menu">
                      @foreach ($item->children as $child)
                        <li><a class="dropdown-item{{ $child->isCurrent() ? ' active' : '' }}" href="{{ $child->link() }}">{{ $child->title }}</a></li>
                      @endforeach
                    </ul>
                  </li>
                @else
                  <li class="nav-item"><a class="nav-link{{ $item->isCurrent() ? ' active' : '' }}" href="{{ $item->link() }}">{{ $item->title }}</a></li>
                @endif
              @endforeach
            </ul>
            <div class="site-nav__tools">
              <div class="dropdown site-nav__lang">
                <button class="site-nav__lang-current dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="{{ t('language') }}">
                  {{ strtoupper($locale) }}@include('site.partials.svg-chevron')
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                  @foreach (locales() as $code => $name)
                    <li><a class="dropdown-item{{ $code === $locale ? ' active' : '' }}" href="{{ switch_locale_url($code) }}" hreflang="{{ $code }}" @if($code === $locale) aria-current="true" @endif><span class="site-nav__lang-code">{{ strtoupper($code) }}</span>{{ $name }}@if($code === $locale)@include('site.partials.svg-check')@endif</a></li>
                  @endforeach
                </ul>
              </div>
              <button class="site-nav__search d-none d-xl-inline-flex" type="button" data-bs-toggle="collapse" data-bs-target="#searchPanel" aria-expanded="false" aria-controls="searchPanel" aria-label="{{ t('search') }}"><img src="{{ $searchIcon }}" width="24" height="24" alt=""></button>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </div>
  <div class="collapse site-searchbar" id="searchPanel">
    <div class="container site-searchbar__inner">
      <form class="site-searchbar__form" role="search" action="{{ route('site.search') }}" method="get">
        <label class="site-searchbar__label" for="siteSearchInput">{{ t('site_search') }}</label>
        <div class="site-searchbar__row">
          <div class="site-searchbar__field">
            <input id="siteSearchInput" name="q" type="search" placeholder="{{ t('search_placeholder') }}" autocomplete="off">
            <button class="site-searchbar__submit" type="submit" aria-label="{{ t('search') }}">@include('site.partials.svg-search')</button>
          </div>
        </div>
      </form>
      <div class="site-searchbar__links">
        <span>{{ t('quick_links') }}</span>
        <ul>
          <li><a href="{{ localized_url('/leadership') }}">{{ t('leadership') }}</a></li>
          <li><a href="{{ localized_url('/structure') }}">{{ t('structure') }}</a></li>
          <li><a href="{{ localized_url('/news') }}">{{ t('news') }}</a></li>
          <li><a href="{{ localized_url('/gallery') }}">{{ t('gallery') }}</a></li>
          <li><a href="{{ localized_url('/faq') }}">{{ t('faq') }}</a></li>
          <li><a href="{{ localized_url('/contact') }}">{{ t('contact') }}</a></li>
        </ul>
      </div>
      <button class="site-searchbar__close" type="button" data-bs-toggle="collapse" data-bs-target="#searchPanel" aria-label="{{ t('close_search') }}">@include('site.partials.svg-close')</button>
    </div>
  </div>
</header>
