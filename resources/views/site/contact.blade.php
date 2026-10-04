@extends('site.layouts.inner')

@section('title', t('contact'))
@section('description', t('contact_us'))

@section('content')
@php
    $phones = array_values(array_filter(array_map('trim', preg_split('/\R/', (string) setting('phones', '')))));
    $map = setting('map_embed') ?: 'https://www.google.com/maps?q='.urlencode((string) setting('address')).'&output=embed&hl='.app()->getLocale();
@endphp
<section class="row g-4 g-xl-4 align-items-start">
  <div class="col-lg-6 order-2 order-lg-1">
    <aside class="contact-info">
      <h2 class="contact-info__title">{{ t('contact_info') }}</h2>
      <ul class="contact-info__list">
        @if ($address = setting('address'))
        <li class="contact-info__item">
          <img src="{{ asset('assets/icons/pin.svg') }}" width="42" height="42" alt="">
          <div><span class="contact-info__label">{{ t('address') }}</span>{{ $address }}</div>
        </li>
        @endif
        @if ($phones)
        <li class="contact-info__item">
          <img src="{{ asset('assets/icons/phone.svg') }}" width="42" height="42" alt="">
          <div>
            <span class="contact-info__label">{{ t('phone') }}</span>
            <span class="contact-info__phones">
              @foreach ($phones as $phone)
                <a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}">{{ $phone }}</a>
              @endforeach
            </span>
          </div>
        </li>
        @endif
        <li class="contact-info__row">
          @if ($email = setting('email'))
          <div class="contact-info__item">
            <img src="{{ asset('assets/icons/message.svg') }}" width="42" height="42" alt="">
            <div><span class="contact-info__label">{{ t('email') }}</span><a href="mailto:{{ $email }}">{{ $email }}</a></div>
          </div>
          @endif
          @if ($hours = setting('work_hours'))
          <div class="contact-info__item">
            <img src="{{ asset('assets/icons/time.svg') }}" width="42" height="42" alt="">
            <div><span class="contact-info__label">{{ t('work_hours') }}</span>{{ $hours }}</div>
          </div>
          @endif
        </li>
      </ul>
      <ul class="social-list social-list--light">
        @include('site.partials.social', ['maskId' => 'c'])
      </ul>
      <iframe class="contact-map" src="{{ $map }}" title="{{ t('map_title') }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>
    </aside>
  </div>

  <div class="col-lg-6 order-1 order-lg-2">
    <form id="contact-form" data-reveal class="contact-form needs-validation{{ $errors->any() ? ' was-validated' : '' }}" method="post" action="{{ route('site.contact.send') }}" novalidate>
      @csrf
      <h2 class="contact-form__title">{{ t('form_title') }}</h2>
      @if (session('contact_success'))
        <div class="alert alert-success" role="status">{{ t('form_success') }}</div>
      @endif
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label" for="firstName">{{ t('first_name') }}</label>
          <input class="form-control @error('first_name') is-invalid @enderror" id="firstName" name="first_name" type="text" value="{{ old('first_name') }}" placeholder="{{ t('first_name_ph') }}" autocomplete="given-name" maxlength="100" required>
          @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label class="form-label" for="lastName">{{ t('last_name') }}</label>
          <input class="form-control @error('last_name') is-invalid @enderror" id="lastName" name="last_name" type="text" value="{{ old('last_name') }}" placeholder="{{ t('last_name_ph') }}" autocomplete="family-name" maxlength="100" required>
          @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label class="form-label" for="phone">{{ t('phone') }}</label>
          <input class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="{{ t('phone_ph') }}" autocomplete="tel" maxlength="50" required>
          @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
          <label class="form-label" for="email">{{ t('email') }}</label>
          <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" placeholder="{{ t('email_ph') }}" autocomplete="email" maxlength="150" required>
          @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
          <label class="form-label" for="message">{{ t('message') }}</label>
          <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="5" placeholder="{{ t('message_ph') }}" maxlength="5000" required>{{ old('message') }}</textarea>
          @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div style="position:absolute;left:-9999px" aria-hidden="true">
          <input type="text" name="website" tabindex="-1" autocomplete="off">
        </div>
        <div class="col-12">
          <button class="btn btn-brand" type="submit">{{ t('send') }}</button>
        </div>
      </div>
    </form>
  </div>
</section>
@endsection
