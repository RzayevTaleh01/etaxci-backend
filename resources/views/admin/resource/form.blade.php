@extends('admin.layouts.app')

@php
    $isEdit = $model->exists;
    $fields = $r::fields();
    $hasTranslatable = collect($fields)->contains(fn ($f) => ! empty($f['translatable']));
    $action = $isEdit ? $r::route('update', $model->id) : $r::route('store');
@endphp

@section('title', ($isEdit ? 'Redaktə: ' : 'Yeni: ').$r::$singular)
@section('heading', ($isEdit ? 'Redaktə — ' : 'Yeni — ').$r::$singular)

@section('content')
<form method="post" action="{{ $action }}" enctype="multipart/form-data" novalidate>
  @csrf
  @if ($isEdit) @method('PUT') @endif

  <div class="form-sticky-bar">
    <div class="d-flex align-items-center gap-3 flex-wrap">
      <a class="btn btn-light" href="{{ $r::route('index') }}"><i class="bi bi-arrow-left me-1"></i>Geri</a>
      @if ($hasTranslatable)
        <div class="lang-switch" data-lang-switch role="tablist" aria-label="Dil">
          @foreach (locales() as $code => $name)
            <button type="button" data-lang="{{ $code }}" title="{{ $name }}">{{ strtoupper($code) }}<span class="dot"></span></button>
          @endforeach
        </div>
      @endif
    </div>
    <button class="btn btn-brand px-4" type="submit"><i class="bi bi-check2 me-1"></i>Yadda saxla</button>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="row g-3">
        @foreach ($fields as $field)
          <div class="col-12 col-md-{{ $field['col'] ?? 12 }}">
            @include('admin.resource.field', ['field' => $field, 'model' => $model, 'extra' => $extra])
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="mt-3 d-flex gap-2 justify-content-end">
    <a class="btn btn-light" href="{{ $r::route('index') }}">Ləğv et</a>
    <button class="btn btn-brand px-4" type="submit">Yadda saxla</button>
  </div>
</form>
@endsection
