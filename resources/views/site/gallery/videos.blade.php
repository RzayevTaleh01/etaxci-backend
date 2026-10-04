@extends('site.layouts.inner')

@section('fancybox', '1')
@section('title', t('videos'))
@section('description', t('videos'))

@section('content')
@include('site.gallery.tabs', ['active' => 'videos'])
<div class="row g-4">
  @foreach ($videos as $video)
    <div data-reveal class="col-sm-6 col-lg-3 media-col">
      <a class="gallery-item gallery-item--video" href="{{ $video->youtube_url }}" data-fancybox="videos" data-caption="{{ $video->title }}">
        <img src="{{ $video->thumbnailUrl() }}" width="298" height="230" loading="lazy" alt="{{ $video->title }}">
        <span class="gallery-item__play"></span>
      </a>
    </div>
  @endforeach
</div>
<div class="mt-5 d-flex justify-content-center">{{ $videos->links() }}</div>
@endsection
