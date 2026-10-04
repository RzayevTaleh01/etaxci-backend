<nav class="gallery-tabs" aria-label="{{ t('gallery_sections') }}">
  <a class="gallery-tabs__link{{ $active === 'photos' ? ' is-active' : '' }}" href="{{ localized_url('/gallery') }}" @if($active === 'photos') aria-current="page" @endif>{{ t('photos') }}</a>
  <a class="gallery-tabs__link{{ $active === 'videos' ? ' is-active' : '' }}" href="{{ localized_url('/videos') }}" @if($active === 'videos') aria-current="page" @endif>{{ t('videos') }}</a>
</nav>
