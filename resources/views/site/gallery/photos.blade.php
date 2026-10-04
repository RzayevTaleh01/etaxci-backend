@extends('site.layouts.inner')

@section('fancybox', '1')
@section('title', t('photos'))
@section('description', t('photos'))

@section('content')
@include('site.gallery.tabs', ['active' => 'photos'])
<div class="row g-4">
  @foreach ($photos as $photo)
    <div data-reveal class="col-sm-6 col-lg-3 media-col">
      <a class="gallery-item" href="{{ media_url($photo->image) }}" data-fancybox="photos" data-caption="{{ $photo->title }}">
        <img src="{{ media_url($photo->image) }}" width="298" height="230" loading="lazy" alt="{{ $photo->title }}">
      </a>
    </div>
  @endforeach
</div>
<div class="mt-5 d-flex justify-content-center">{{ $photos->links() }}</div>
@endsection
