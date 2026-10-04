@php
    $user = auth()->user();
    $groups = [];
    foreach (\App\Admin\Registry::all() as $res) {
        if ($user->hasAnyRole($res::$roles)) {
            $groups[$res::$group][] = ['label' => $res::$label, 'icon' => $res::$icon, 'url' => $res::route('index'), 'match' => parse_url($res::route('index'), PHP_URL_PATH)];
        }
    }
    $isAdmin = $user->hasAnyRole(['super-admin', 'admin']);
    if ($isAdmin) {
        $groups['Sayt'][] = ['label' => 'Ümumi parametrlər', 'icon' => 'bi-gear', 'url' => route('admin.settings'), 'match' => parse_url(route('admin.settings'), PHP_URL_PATH)];
        $groups['Sayt'][] = ['label' => 'Tərcümə meneceri', 'icon' => 'bi-translate', 'url' => route('admin.translations'), 'match' => parse_url(route('admin.translations'), PHP_URL_PATH)];
        $groups['Sistem'][] = ['label' => 'Fəaliyyət jurnalı', 'icon' => 'bi-clock-history', 'url' => route('admin.logs'), 'match' => parse_url(route('admin.logs'), PHP_URL_PATH)];
    }
    $order = ['Ana səhifə', 'Xəbərlər', 'Səhifələr', 'Komanda', 'Vətəndaşlar üçün', 'Qalereya', 'Sayt', 'Sistem'];
    uksort($groups, fn ($a, $b) => (array_search($a, $order) === false ? 99 : array_search($a, $order)) <=> (array_search($b, $order) === false ? 99 : array_search($b, $order)));
    $newMessages = \App\Models\ContactMessage::where('status', 'new')->count();
    $path = '/'.trim(request()->path(), '/');
    $logo = media_url(setting('logo')) ?: asset('assets/img/logo.png');
@endphp
<!DOCTYPE html>
<html lang="az">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="robots" content="noindex, nofollow">
  <title>@yield('title', 'Panel') — ETACXİ Admin</title>
  <link rel="icon" href="{{ $logo }}">
  <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('panel/vendor/bootstrap-icons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('panel/vendor/quill.snow.css') }}">
  <link rel="stylesheet" href="{{ asset('panel/admin.css').'?v='.filemtime(public_path('panel/admin.css')) }}">
</head>
<body class="admin">
<div class="admin-shell">
  <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
  <aside class="admin-sidebar" id="adminSidebar">
    <a class="brand" href="{{ route('admin.dashboard') }}"><img src="{{ $logo }}" alt=""><span>ETACXİ Admin</span></a>
    <div class="nav-scroll">
      <ul class="nav flex-column">
        <li><a class="nav-link {{ $path === '/admin' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i>Dashboard</a></li>
        <li><a class="nav-link {{ ($path === '/admin/messages' || str_starts_with($path, '/admin/messages/')) ? 'active' : '' }}" href="{{ route('admin.messages.index') }}"><i class="bi bi-envelope"></i>Müraciətlər @if($newMessages)<span class="badge bg-danger badge-count">{{ $newMessages }}</span>@endif</a></li>
      </ul>
      @foreach ($groups as $title => $items)
        <div class="nav-heading">{{ $title }}</div>
        <ul class="nav flex-column">
          @foreach ($items as $item)
            <li><a class="nav-link {{ ($path === $item['match'] || str_starts_with($path, $item['match'].'/')) ? 'active' : '' }}" href="{{ $item['url'] }}"><i class="bi {{ $item['icon'] }}"></i>{{ $item['label'] }}</a></li>
          @endforeach
        </ul>
      @endforeach
    </div>
  </aside>

  <div class="admin-main">
    <header class="admin-topbar">
      <button class="btn btn-light d-lg-none" type="button" data-sidebar-toggle aria-label="Menyu"><i class="bi bi-list fs-5"></i></button>
      <h1 class="page-title">@yield('heading', 'Panel')</h1>
      <div class="ms-auto d-flex align-items-center gap-2">
        <a class="btn btn-light btn-sm d-none d-sm-inline-flex align-items-center gap-1" href="{{ url('/') }}" target="_blank" rel="noopener"><i class="bi bi-box-arrow-up-right"></i> Sayta bax</a>
        <div class="dropdown">
          <button class="btn btn-light btn-sm dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown" type="button">
            <i class="bi bi-person-circle"></i><span class="d-none d-sm-inline">{{ $user->name }}</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><span class="dropdown-item-text small text-muted">{{ $user->roleLabel() }}</span></li>
            <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="bi bi-person me-2"></i>Profil</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="post" action="{{ route('admin.logout') }}">@csrf
                <button class="dropdown-item" type="submit"><i class="bi bi-box-arrow-right me-2"></i>Çıxış</button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </header>

    <main class="admin-content">
      @if (session('success'))<div class="alert alert-success alert-flash"><i class="bi bi-check-circle me-2"></i>{{ session('success') }}</div>@endif
      @if (session('error'))<div class="alert alert-danger alert-flash"><i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}</div>@endif
      @if ($errors->any() && ! View::hasSection('own-errors'))
        <div class="alert alert-danger">
          <strong>Xəta:</strong> formu yoxlayın.
          <ul class="mb-0 small">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
      @endif
      @yield('content')
    </main>
  </div>
</div>

<script src="{{ asset('assets/vendor/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('panel/vendor/quill.js') }}"></script>
<script src="{{ asset('panel/vendor/Sortable.min.js') }}"></script>
<script src="{{ asset('panel/vendor/chart.umd.js') }}"></script>
<script src="{{ asset('panel/admin.js').'?v='.filemtime(public_path('panel/admin.js')) }}"></script>
@stack('scripts')
</body>
</html>
