@extends('site.layouts.inner')

@section('title', $person->name)
@section('description', $person->position.' — '.$person->summary(150))
@section('image', $person->photo ? media_url($person->photo) : '')

@section('content')
<article data-reveal class="leader-profile">
  <img class="leader-profile__photo" src="{{ $person->photoUrl() }}" width="300" height="300" alt="{{ $person->name }}">
  <div class="leader-profile__content">
    <div class="leader-profile__header">
      <div>
        <h2 class="leader-profile__name">{{ $person->name }}</h2>
        <p class="leader-profile__role">{{ $person->position }}</p>
        @if ($person->specialty)<p class="leader-profile__role">{{ $person->specialty }}</p>@endif
      </div>
      @if ($person->facebook || $person->linkedin)
      <ul class="social-list social-list--sm" aria-label="{{ t('social_networks') }}">
        @if ($person->facebook)<li><a class="social-list__item" href="{{ $person->facebook }}" target="_blank" rel="noopener" title="Facebook">@include('site.partials.svg-facebook')</a></li>@endif
        @if ($person->linkedin)<li><a class="social-list__item" href="{{ $person->linkedin }}" target="_blank" rel="noopener" title="LinkedIn">@include('site.partials.svg-linkedin', ['maskId' => 'pp'])</a></li>@endif
      </ul>
      @endif
    </div>
    @if ($person->bio)
      <h3 class="leader-profile__label">{{ t('about_person') }}</h3>
      <div class="leader-profile__text">{!! $person->bio !!}</div>
    @endif
    @if ($person->email || $person->phone)
      <p class="leader-profile__text mt-3">
        @if ($person->email)<a href="mailto:{{ $person->email }}">{{ $person->email }}</a><br>@endif
        @if ($person->phone)<a href="tel:{{ preg_replace('/[^\d+]/', '', $person->phone) }}">{{ $person->phone }}</a>@endif
      </p>
    @endif
  </div>
</article>
@endsection
