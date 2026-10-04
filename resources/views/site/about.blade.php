@extends('site.layouts.inner')

@section('title', $page->meta_title ?: $page->title)
@section('description', $page->meta_description ?: ($blocks->first()?->text ?? ''))

@section('content')
<div class="about-stack">
  @foreach ($blocks as $block)
    @php($imageLeft = $loop->index % 2 === 1 && $block->image)
    <section data-reveal class="row align-items-center gy-4 about-block-row">
      <div class="col-lg-6{{ $imageLeft ? ' order-1 order-lg-2' : '' }}">
        @if ($block->title)<h2 class="about-block__title">{{ $block->title }}</h2>@endif
        <p class="about-block__text">{!! nl2br(e($block->text)) !!}</p>
      </div>
      @if ($block->image)
        <div class="col-lg-6 d-flex {{ $imageLeft ? 'order-2 order-lg-1 justify-content-lg-start' : 'justify-content-lg-end' }}">
          <img class="about-block__image" src="{{ media_url($block->image) }}" width="555" height="336" @if(! $loop->first) loading="lazy" @endif alt="{{ $block->title }}">
        </div>
      @endif
    </section>
  @endforeach

  @if ($page->content)
    <section data-reveal class="info-text">{!! $page->content !!}</section>
  @endif
</div>
@endsection
