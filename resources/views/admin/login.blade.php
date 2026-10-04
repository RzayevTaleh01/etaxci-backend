<!DOCTYPE html>
<html lang="az">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="noindex, nofollow">
  <title>Giriş — ETACXİ Admin</title>
  <link rel="icon" href="{{ asset('assets/img/logo.png') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('panel/vendor/bootstrap-icons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('panel/admin.css').'?v='.filemtime(public_path('panel/admin.css')) }}">
</head>
<body class="admin">
<div class="login-wrap">
  <form class="login-card" method="post" action="{{ route('admin.login.post') }}">
    @csrf
    <img class="logo" src="{{ media_url(setting('logo')) ?: asset('assets/img/logo.png') }}" alt="ETACXİ">
    <h1 class="h4 text-center mb-1">İdarəetmə paneli</h1>
    <p class="text-center text-muted mb-4">Davam etmək üçün daxil olun</p>

    @if ($errors->any())
      <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
    @endif

    <div class="mb-3">
      <label class="form-label" for="email">E-poçt</label>
      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
        <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>
      </div>
    </div>
    <div class="mb-3">
      <label class="form-label" for="password">Şifrə</label>
      <div class="input-group">
        <span class="input-group-text"><i class="bi bi-lock"></i></span>
        <input class="form-control" id="password" type="password" name="password" autocomplete="current-password" required>
      </div>
    </div>
    <div class="form-check mb-4">
      <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
      <label class="form-check-label" for="remember">Məni xatırla</label>
    </div>
    <button class="btn btn-brand w-100 py-2" type="submit">Daxil ol</button>
  </form>
</div>
</body>
</html>
