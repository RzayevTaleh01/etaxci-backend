@php
    $locale = app()->getLocale();
    $siteName = setting('site_name', 'Elmi-Tədqiqat Ağciyər Xəstəlikləri İnstitutu');
    $shortName = setting('site_short_name', 'ETACXİ');
    $pageTitle = trim($__env->yieldContent('title'));
    $fullTitle = $pageTitle !== '' ? $pageTitle.' | '.$shortName : $siteName.' | '.$shortName;
    $description = trim($__env->yieldContent('description')) ?: setting('meta_description', $siteName);
    $ogImageSection = trim($__env->yieldContent('image'));
    $ogImage = $ogImageSection ?: media_url(setting('og_image')) ?: asset('assets/img/og-image.png');
    $logo = media_url(setting('logo')) ?: asset('assets/img/logo.png');
    $canonical = url()->current();
    $ogLocales = ['az' => 'az_AZ', 'en' => 'en_US', 'ru' => 'ru_RU'];
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
  <meta charset="utf-8">
  <script>document.documentElement.classList.add("js");</script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $fullTitle }}</title>
  <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($description), 190) }}">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <meta name="theme-color" content="#0392ce">
  <link rel="canonical" href="{{ $canonical }}">
  @foreach (locales() as $code => $name)
  <link rel="alternate" hreflang="{{ $code }}" href="{{ switch_locale_url($code) }}">
  @endforeach
  <link rel="alternate" hreflang="x-default" href="{{ switch_locale_url(config('site.default_locale')) }}">
  <meta property="og:locale" content="{{ $ogLocales[$locale] ?? $locale }}">
  <meta property="og:type" content="{{ trim($__env->yieldContent('og_type')) ?: 'website' }}">
  <meta property="og:site_name" content="{{ $siteName }}">
  <meta property="og:title" content="{{ $fullTitle }}">
  <meta property="og:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($description), 190) }}">
  <meta property="og:url" content="{{ $canonical }}">
  <meta property="og:image" content="{{ $ogImage }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $fullTitle }}">
  <meta name="twitter:description" content="{{ \Illuminate\Support\Str::limit(strip_tags($description), 190) }}">
  <meta name="twitter:image" content="{{ $ogImage }}">
  <script type="application/ld+json">{!! json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'MedicalOrganization',
      'name' => $siteName,
      'alternateName' => $shortName,
      'url' => url('/'.$locale),
      'logo' => $logo,
      'telephone' => trim(strtok((string) setting('phones', ''), "\n")),
      'email' => setting('email'),
      'address' => ['@type' => 'PostalAddress', 'streetAddress' => setting('address'), 'addressCountry' => 'AZ'],
  ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
  @isset($crumbs)
  <script type="application/ld+json">{!! json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'BreadcrumbList',
      'itemListElement' => collect([[t('home'), url('/'.$locale)]])->merge($crumbs)->values()->map(fn ($c, $i) => array_filter([
          '@type' => 'ListItem', 'position' => $i + 1, 'name' => strip_tags((string) $c[0]), 'item' => $c[1] ?: ($i ? $canonical : null),
      ]))->all(),
  ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
  @endisset
  @yield('head')
  <link rel="icon" href="{{ $logo }}">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;500;600&family=Poppins:wght@400;500&subset=cyrillic,latin-ext&display=swap">
  <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/base.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css').'?v='.filemtime(public_path('assets/css/components.css')) }}">
  <link rel="stylesheet" href="{{ asset('assets/css/pages.css') }}">
  @hasSection('fancybox')
  <link rel="stylesheet" href="{{ asset('assets/vendor/fancybox.css') }}">
  @endif
</head>
<body>
  <a class="visually-hidden-focusable skip-link" href="#main">{{ t('skip_to_content') }}</a>

  @hasSection('hero')
  <div class="hero-wrap">
    @include('site.partials.header', ['overlay' => true])
    @yield('hero')
  </div>
  @else
  @include('site.partials.header', ['overlay' => false])
  @endif

  @yield('main')

  @include('site.partials.footer')

  <script src="{{ asset('assets/vendor/bootstrap.bundle.min.js') }}"></script>
  @hasSection('fancybox')
  <script src="{{ asset('assets/vendor/fancybox.umd.js') }}"></script>
  @endif
  <script>window.ETACXI_I18N = {!! json_encode(['locale' => $locale], JSON_UNESCAPED_UNICODE) !!};</script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
  @stack('scripts')
</body>
</html>
