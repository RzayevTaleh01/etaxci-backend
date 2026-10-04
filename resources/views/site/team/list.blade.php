@extends('site.layouts.inner')

@section('title', $page->title)
@section('description', $page->subtitle ?: $page->title)

@section('content')
<div class="profiles-head">
  <h2 class="profiles-head__title">{{ $page->title }}</h2>
  @if ($page->subtitle)<p class="profiles-head__meta">{{ $page->subtitle }}</p>@endif
</div>

@if ($people->isEmpty())
  <p class="text-muted">{{ t('no_results') }}</p>
@elseif ($layout === 'wide')
  <div class="team-list">
    @foreach ($people as $person)
      @include('site.team.card', ['person' => $person, 'compact' => false])
    @endforeach
  </div>
@else
  <div class="row g-4">
    @foreach ($people as $person)
      <div class="col-md-6 col-xl-4">
        @include('site.team.card', ['person' => $person, 'compact' => true])
      </div>
    @endforeach
  </div>
@endif
@endsection
