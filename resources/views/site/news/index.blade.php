@extends('site.layouts.inner')

@section('title', $category ? $category->name : t('news'))
@section('description', $category ? $category->name : t('news'))

@section('content')
<nav class="gallery-tabs" aria-label="{{ t('news_categories') }}">
  <a class="gallery-tabs__link{{ ! $category ? ' is-active' : '' }}" href="{{ localized_url('/news') }}" @if(! $category) aria-current="page" @endif>{{ t('all') }}</a>
  @foreach ($categories as $cat)
    <a class="gallery-tabs__link{{ $category?->id === $cat->id ? ' is-active' : '' }}" href="{{ $cat->url() }}" @if($category?->id === $cat->id) aria-current="page" @endif>{{ $cat->name }}</a>
  @endforeach
</nav>

@if ($items->isEmpty())
  <p class="text-muted">{{ t('no_results') }}</p>
@else
  <div class="row g-4 gy-5">
    @foreach ($items as $item)
      @include('site.news.card', ['item' => $item])
    @endforeach
  </div>
  <div class="mt-5 d-flex justify-content-center">{{ $items->links() }}</div>
@endif
@endsection
