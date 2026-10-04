@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
  @foreach ($stats as [$label, $value, $icon, $color, $url])
    <div class="col-6 col-md-4 col-xl-2">
      <a class="card stat-card h-100" href="{{ $url }}">
        <span class="icon bg-{{ $color }}-subtle text-{{ $color }}"><i class="bi {{ $icon }}"></i></span>
        <span><span class="value d-block">{{ $value }}</span><span class="label">{{ $label }}</span></span>
      </a>
    </div>
  @endforeach
</div>

<div class="row g-3">
  <div class="col-xl-8">
    <div class="card mb-3">
      <div class="card-header">Son 6 ayda əlavə olunan xəbərlər</div>
      <div class="card-body" style="height:260px">
        <canvas id="newsChart" data-label="Xəbərlər" data-chart='@json($chart)'></canvas>
      </div>
    </div>

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">Son müraciətlər <a class="small" href="{{ route('admin.messages.index') }}">Hamısı</a></div>
      <div class="list-group list-group-flush">
        @forelse ($latestMessages as $m)
          <a class="list-group-item list-group-item-action d-flex gap-3 align-items-start" href="{{ route('admin.messages.show', $m) }}">
            <span class="status-dot {{ $m->status }} mt-2"></span>
            <span class="flex-grow-1 min-w-0">
              <strong>{{ $m->fullName() }}</strong> <span class="text-muted small">· {{ $m->email }}</span>
              <span class="d-block text-muted small text-truncate">{{ \Illuminate\Support\Str::limit($m->message, 110) }}</span>
            </span>
            <small class="text-muted text-nowrap">{{ $m->created_at->diffForHumans() }}</small>
          </a>
        @empty
          <div class="list-group-item text-muted">Hələ müraciət yoxdur.</div>
        @endforelse
      </div>
    </div>
  </div>

  <div class="col-xl-4">
    <div class="card mb-3">
      <div class="card-header">Son xəbərlər</div>
      <div class="list-group list-group-flush">
        @forelse ($latestNews as $n)
          <a class="list-group-item list-group-item-action" href="{{ route('admin.news.edit', $n->id) }}">
            <span class="d-block text-truncate">{{ $n->title }}</span>
            <small class="text-muted">{{ $n->published_at?->format('d.m.Y') ?? '—' }} · {{ $n->views }} baxış</small>
          </a>
        @empty
          <div class="list-group-item text-muted">Xəbər yoxdur.</div>
        @endforelse
      </div>
    </div>

    <div class="card">
      <div class="card-header">Son əməliyyatlar</div>
      <ul class="list-group list-group-flush small">
        @forelse ($logs as $log)
          <li class="list-group-item">
            <strong>{{ $log->user?->name ?? 'Sistem' }}</strong> — {{ $log->description ?: $log->action }}
            <span class="d-block text-muted">{{ $log->created_at->diffForHumans() }}</span>
          </li>
        @empty
          <li class="list-group-item text-muted">Qeyd yoxdur.</li>
        @endforelse
      </ul>
    </div>
  </div>
</div>
@endsection
