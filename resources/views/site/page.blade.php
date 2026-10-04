@extends('site.layouts.inner')

@section('title', $page->meta_title ?: $page->title)
@section('description', $page->meta_description ?: strip_tags((string) $page->content))
@if ($page->image)
  @section('image', media_url($page->image))
@endif

@section('content')
<div class="profiles-head">
  <h2 class="profiles-head__title">{{ $page->title }}</h2>
  @if ($page->subtitle)<p class="profiles-head__meta">{{ $page->subtitle }}</p>@endif
</div>

@if ($page->template === 'plain' || ! $page->image)
  <section data-reveal class="info-row">
    <div class="info-text">{!! $page->content !!}</div>
  </section>
@else
  <section data-reveal class="row align-items-center gx-lg-4 gy-4 info-row">
    <div class="col-lg-8 info-text">{!! $page->content !!}</div>
    <div class="col-lg-4 text-center">
      <img class="info-logo" src="{{ media_url($page->image) }}" width="330" alt="{{ $page->title }}">
    </div>
  </section>
@endif
@endsection
