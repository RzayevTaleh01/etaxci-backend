@extends('admin.layouts.app')

@section('title', 'Profil')
@section('heading', 'Profil')

@section('content')
<div class="row">
  <div class="col-lg-6">
    <form class="card" method="post" action="{{ route('admin.profile.update') }}">
      @csrf
      <div class="card-body">
        <div class="mb-3">
          <label class="form-label">E-poçt</label>
          <input class="form-control" value="{{ auth()->user()->email }}" disabled>
        </div>
        <div class="mb-3">
          <label class="form-label" for="name">Ad</label>
          <input class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
        </div>
        <hr>
        <p class="text-muted small">Şifrəni dəyişmək istəmirsinizsə, aşağıdakı sahələri boş buraxın.</p>
        <div class="mb-3">
          <label class="form-label" for="current_password">Cari şifrə</label>
          <input class="form-control" type="password" id="current_password" name="current_password" autocomplete="current-password">
        </div>
        <div class="mb-3">
          <label class="form-label" for="password">Yeni şifrə</label>
          <input class="form-control" type="password" id="password" name="password" autocomplete="new-password">
        </div>
        <div class="mb-3">
          <label class="form-label" for="password_confirmation">Yeni şifrə (təkrar)</label>
          <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
        </div>
        <button class="btn btn-brand" type="submit">Yadda saxla</button>
      </div>
    </form>
  </div>
</div>
@endsection
