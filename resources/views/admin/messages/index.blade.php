@extends('admin.layouts.app')

@section('title', 'Müraciətlər')
@section('heading', 'Müraciətlər')

@section('content')
<form class="d-flex flex-wrap gap-2 mb-3" method="get">
  <div class="input-group" style="max-width:320px">
    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
    <input class="form-control" type="search" name="q" value="{{ request('q') }}" placeholder="Axtar...">
  </div>
  <select class="form-select" name="status" style="max-width:200px" onchange="this.form.submit()">
    <option value="">Bütün statuslar</option>
    @foreach (['new' => 'Yeni', 'read' => 'Oxunub', 'answered' => 'Cavablandırılıb'] as $v => $l)
      <option value="{{ $v }}" @selected(request('status') === $v)>{{ $l }}</option>
    @endforeach
  </select>
  <button class="btn btn-outline-secondary" type="submit">Axtar</button>
</form>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover table-admin table-responsive-cards align-middle">
      <thead><tr><th></th><th>Ad, soyad</th><th>Əlaqə</th><th>Mesaj</th><th>Tarix</th><th class="text-end">Əməliyyat</th></tr></thead>
      <tbody>
        @forelse ($messages as $m)
          <tr class="{{ $m->status === 'new' ? 'fw-semibold' : '' }}">
            <td data-label=""><span class="status-dot {{ $m->status }}" title="{{ $m->status }}"></span></td>
            <td data-label="Ad, soyad">{{ $m->fullName() }}</td>
            <td data-label="Əlaqə"><span class="d-block">{{ $m->email }}</span><small class="text-muted">{{ $m->phone }}</small></td>
            <td data-label="Mesaj">{{ \Illuminate\Support\Str::limit($m->message, 80) }}</td>
            <td data-label="Tarix" class="text-nowrap">{{ $m->created_at->format('d.m.Y H:i') }}</td>
            <td class="text-end cell-actions" data-label="">
              <a class="btn btn-sm btn-outline-brand" href="{{ route('admin.messages.show', $m) }}"><i class="bi bi-eye"></i></a>
              <form class="d-inline" method="post" action="{{ route('admin.messages.destroy', $m) }}" data-confirm="Müraciəti silmək istəyirsiniz?">@csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted py-5">Müraciət yoxdur.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if ($messages->hasPages())<div class="card-footer bg-white">{{ $messages->links() }}</div>@endif
</div>
@endsection
