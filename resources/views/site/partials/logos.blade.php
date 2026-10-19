{{-- Header / footer logos, managed in admin under "Loqolar" (order, placement, size, link, visibility). --}}
@php($items = $siteLogos[$area] ?? collect())
@if ($items->isNotEmpty())
  <span class="site-logos">
    @foreach ($items as $logo)
      @php($height = $area === 'header' ? $logo->header_height : $logo->footer_height)
      <a href="{{ $logo->link() }}" style="--logo-h: {{ $height }}px" @if ($logo->isExternal()) target="_blank" rel="noopener" @endif>
        @if ($logo->badge)
          <span class="{{ $class }} site-logo--badge"><img src="{{ media_url($logo->image) }}" alt="{{ $logo->title }}"></span>
        @else
          <img class="{{ $class }}" src="{{ media_url($logo->image) }}" height="{{ $height }}" alt="{{ $logo->title }}">
        @endif
      </a>
    @endforeach
  </span>
@endif
