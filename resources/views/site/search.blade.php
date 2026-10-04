@extends('site.layouts.inner')

@section('title', t('search'))
@section('description', t('site_search'))

@section('content')
<div class="profiles-head">
  <h2 class="profiles-head__title">{{ t('search') }}</h2>
  @if ($q !== '')<p class="profiles-head__meta">“{{ $q }}”</p>@endif
</div>

<form class="mb-5" role="search" action="{{ route('site.search') }}" method="get">
  <div class="input-group">
    <input class="form-control" type="search" name="q" value="{{ $q }}" placeholder="{{ t('search_placeholder') }}" aria-label="{{ t('search') }}" minlength="2" required>
    <button class="btn btn-brand" type="submit">{{ t('search') }}</button>
  </div>
</form>

@if ($q !== '' && $news->isEmpty() && $people->isEmpty() && $pages->isEmpty())
  <p class="text-muted">{{ t('no_results') }}</p>
@endif

@if ($news->isNotEmpty())
  <h3 class="article-related__title">{{ t('news') }}</h3>
  <div class="row g-4 mb-5">
    @foreach ($news as $item)
      @include('site.news.card', ['item' => $item])
    @endforeach
  </div>
@endif

@if ($people->isNotEmpty())
  <h3 class="article-related__title">{{ t('people') }}</h3>
  <div class="row g-4 mb-5">
    @foreach ($people as $person)
      <div class="col-md-6 col-xl-4">@include('site.team.card', ['person' => $person, 'compact' => true])</div>
    @endforeach
  </div>
@endif

@if ($pages->isNotEmpty())
  <h3 class="article-related__title">{{ t('pages') }}</h3>
  <ul class="mb-5">
    @foreach ($pages as $p)
      <li><a href="{{ $p->url() }}">{{ $p->title }}</a></li>
    @endforeach
  </ul>
@endif
@endsection
