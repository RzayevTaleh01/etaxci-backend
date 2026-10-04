@extends('admin.layouts.app')

@section('title', $r::$label)
@section('heading', $r::$label)

@section('content')
@php
    $columns = $r::columns();
    $sortable = $r::$sortable;
    $hasActive = $r::hasActiveFlag();
@endphp

<div class="d-flex flex-wrap gap-2 align-items-center mb-3">
  <form class="d-flex flex-wrap gap-2 flex-grow-1" method="get">
    @if ($r::$search)
      <div class="input-group" style="max-width:320px">
        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
        <input class="form-control" type="search" name="q" value="{{ request('q') }}" placeholder="Axtar...">
      </div>
    @endif
    @foreach ($r::filters() as $filter)
      <select class="form-select" name="{{ $filter['name'] }}" style="max-width:220px" onchange="this.form.submit()">
        <option value="">{{ $filter['label'] }}</option>
        @foreach ($filter['options'] as $value => $label)
          <option value="{{ $value }}" @selected((string) request($filter['name']) === (string) $value)>{{ $label }}</option>
        @endforeach
      </select>
    @endforeach
    @if ($r::$search)<button class="btn btn-outline-secondary" type="submit">Axtar</button>@endif
    @if (request()->hasAny(['q', ...collect($r::filters())->pluck('name')->all()]))
      <a class="btn btn-link" href="{{ $r::route('index') }}">Təmizlə</a>
    @endif
  </form>
  @if ($r::$canCreate)
    <a class="btn btn-brand" href="{{ $r::route('create') }}"><i class="bi bi-plus-lg me-1"></i>Yeni əlavə et</a>
  @endif
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover table-admin table-responsive-cards align-middle">
      <thead>
        <tr>
          @if ($sortable)<th style="width:36px"></th>@endif
          @foreach ($columns as $col)<th>{{ $col['label'] }}</th>@endforeach
          <th class="text-end">Əməliyyat</th>
        </tr>
      </thead>
      <tbody @if($sortable) data-sortable data-url="{{ $r::route('reorder') }}" @endif>
        @forelse ($items as [$item, $depth])
          <tr data-id="{{ $item->id }}">
            @if ($sortable)<td data-label=""><i class="bi bi-grip-vertical drag-handle"></i></td>@endif
            @foreach ($columns as $col)
              <td data-label="{{ $col['label'] }}">
                @php($name = $col['name'])
                @switch($col['type'])
                  @case('image')
                    @if ($item->{$name})<img class="thumb" src="{{ media_url($item->{$name}) }}" alt="">@endif
                    @break
                  @case('bool')
                    @if ($hasActive && $name === 'is_active')
                      <form method="post" action="{{ $r::route('toggle', $item->id) }}">@csrf
                        <button class="btn btn-sm {{ $item->is_active ? 'btn-success' : 'btn-outline-secondary' }} py-0" type="submit">{{ $item->is_active ? 'Aktiv' : 'Passiv' }}</button>
                      </form>
                    @else
                      <i class="bi {{ $item->{$name} ? 'bi-check-circle-fill text-success' : 'bi-dash-circle text-muted' }}"></i>
                    @endif
                    @break
                  @case('badge')
                    @php($val = data_get($item, $name))
                    @if ($val)<span class="badge bg-secondary-subtle text-secondary-emphasis">{{ ($col['map'] ?? [])[$val] ?? $val }}</span>@endif
                    @break
                  @case('date')
                    {{ $item->{$name}?->format('d.m.Y H:i') ?? '—' }}
                    @break
                  @case('computed')
                    {{ $r::computed($name, $item) }}
                    @break
                  @default
                    @if (! empty($col['tree']))<span class="tree-indent">{!! str_repeat('&emsp;', $depth) !!}{{ $depth ? '└ ' : '' }}</span>@endif
                    @if (! empty($col['translatable']))
                      {{ \Illuminate\Support\Str::limit(strip_tags((string) $item->{$name}), $col['limit'] ?? 70) }}
                    @else
                      {{ \Illuminate\Support\Str::limit((string) data_get($item, $name), 70) }}
                    @endif
                @endswitch
              </td>
            @endforeach
            <td class="text-end row-actions cell-actions" data-label="">
              <a class="btn btn-sm btn-outline-brand" href="{{ $r::route('edit', $item->id) }}" title="Redaktə"><i class="bi bi-pencil"></i></a>
              @if ($r::canDelete($item))
                <form class="d-inline" method="post" action="{{ $r::route('destroy', $item->id) }}" data-confirm="Bu qeydi silmək istədiyinizə əminsiniz?">@csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger" type="submit" title="Sil"><i class="bi bi-trash"></i></button>
                </form>
              @endif
            </td>
          </tr>
        @empty
          <tr><td colspan="{{ count($columns) + 2 }}" class="text-center text-muted py-5">Qeyd tapılmadı.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  @if ($paginator && $paginator->hasPages())
    <div class="card-footer bg-white">{{ $paginator->links() }}</div>
  @endif
</div>
@if ($sortable)<p class="text-muted small mt-2"><i class="bi bi-info-circle"></i> Sıranı dəyişmək üçün sətirləri tutub sürüşdürün.</p>@endif
@endsection
