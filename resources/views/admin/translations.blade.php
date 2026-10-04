@extends('admin.layouts.app')

@section('title', 'Tərcümə meneceri')
@section('heading', 'Tərcümə meneceri')

@section('content')
<p class="text-muted">Saytın interfeys yazıları (düymələr, başlıqlar, etiketlər) burada 3 dildə redaktə olunur. Məzmun (xəbərlər, səhifələr və s.) isə uyğun bölmələrdən dəyişdirilir.</p>

<form class="d-flex gap-2 mb-3" method="get">
  <div class="input-group" style="max-width:320px">
    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
    <input class="form-control" type="search" name="q" value="{{ $q }}" placeholder="Açar və ya mətn...">
  </div>
  <button class="btn btn-outline-secondary" type="submit">Axtar</button>
</form>

<form method="post" action="{{ route('admin.translations.update') }}">
  @csrf
  <div class="card">
    <div class="table-responsive">
      <table class="table table-admin align-middle table-responsive-cards">
        <thead><tr><th style="width:18%">Açar</th>@foreach (locales() as $code => $name)<th>{{ $name }}</th>@endforeach</tr></thead>
        <tbody>
          @foreach ($rows as $row)
            <tr>
              <td data-label="Açar"><code class="small">{{ $row->key }}</code></td>
              @foreach (locales() as $code => $name)
                <td data-label="{{ strtoupper($code) }}"><input class="form-control form-control-sm" type="text" name="t[{{ $row->id }}][{{ $code }}]" value="{{ $row->text[$code] ?? '' }}"></td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  <div class="form-sticky-bar justify-content-end mt-2"><button class="btn btn-brand px-4" type="submit"><i class="bi bi-check2 me-1"></i>Hamısını saxla</button></div>
</form>
@endsection
