@extends('site.layouts.app')

@section('main')
<main id="main" class="{{ trim($__env->yieldContent('main_class')) ?: 'container page' }}">
  @hasSection('raw')
    @yield('raw')
  @else
    @include('site.partials.page-head')
    @yield('content')
  @endif
</main>
@endsection
