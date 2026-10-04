@php($heading = $heading ?? ($crumbs ? strip_tags((string) end($crumbs)[0]) : ''))
<div class="page-head{{ !empty($wide) ? ' page-head--wide' : '' }}">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/'.app()->getLocale()) }}">{{ t('home') }}</a></li>
      @foreach ($crumbs as $crumb)
        @if ($loop->last || empty($crumb[1]))
          <li class="breadcrumb-item active" aria-current="page">{{ $crumb[0] }}</li>
        @else
          <li class="breadcrumb-item"><a href="{{ $crumb[1] }}">{{ $crumb[0] }}</a></li>
        @endif
      @endforeach
    </ol>
  </nav>
  <h1 class="visually-hidden">{{ $heading }}</h1>
</div>
