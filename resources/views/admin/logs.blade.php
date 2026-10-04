@extends('admin.layouts.app')

@section('title', 'Fəaliyyət jurnalı')
@section('heading', 'Fəaliyyət jurnalı')

@section('content')
<div class="card">
  <div class="table-responsive">
    <table class="table table-admin table-hover align-middle table-responsive-cards">
      <thead><tr><th>Tarix</th><th>İstifadəçi</th><th>Əməliyyat</th><th>Təsvir</th><th>IP</th></tr></thead>
      <tbody>
        @forelse ($logs as $log)
          <tr>
            <td data-label="Tarix" class="text-nowrap">{{ $log->created_at->format('d.m.Y H:i:s') }}</td>
            <td data-label="İstifadəçi">{{ $log->user?->name ?? '—' }}</td>
            <td data-label="Əməliyyat"><span class="badge bg-secondary-subtle text-secondary-emphasis">{{ $log->action }}</span></td>
            <td data-label="Təsvir">{{ $log->subject_type }} {{ $log->subject_id ? '#'.$log->subject_id : '' }} {{ $log->description }}</td>
            <td data-label="IP" class="text-muted small">{{ $log->ip }}</td>
          </tr>
        @empty
          <tr><td colspan="5" class="text-center text-muted py-5">Qeyd yoxdur.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if ($logs->hasPages())<div class="card-footer bg-white">{{ $logs->links() }}</div>@endif
</div>
@endsection
