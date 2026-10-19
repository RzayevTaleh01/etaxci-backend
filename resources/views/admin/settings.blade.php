@extends('admin.layouts.app')

@section('title', 'Ümumi parametrlər')
@section('heading', 'Ümumi parametrlər')

@section('content')
<form method="post" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
  @csrf
  <div class="form-sticky-bar">
    <div class="lang-switch" data-lang-switch>
      @foreach (locales() as $code => $name)
        <button type="button" data-lang="{{ $code }}" title="{{ $name }}">{{ strtoupper($code) }}</button>
      @endforeach
    </div>
    <button class="btn btn-brand px-4" type="submit"><i class="bi bi-check2 me-1"></i>Yadda saxla</button>
  </div>

  @foreach ($groups as $groupTitle => $fields)
    <div class="card mb-3">
      <div class="card-header">{{ $groupTitle }}</div>
      <div class="card-body">
        <div class="row g-3">
          @foreach ($fields as $f)
            @php
                $key = $f['key'];
                $raw = $values[$key] ?? null;
            @endphp
            <div class="col-12 {{ in_array($f['type'], ['textarea']) ? '' : 'col-md-6' }}">
              @if ($f['type'] === 'toggle')
                <div class="form-check form-switch mt-md-4">
                  <input type="hidden" name="{{ $key }}" value="0">
                  <input class="form-check-input" type="checkbox" role="switch" name="{{ $key }}" value="1" id="tg-{{ $key }}" @checked(old($key, $raw ?? '1') !== '0')>
                  <label class="form-check-label fw-semibold" for="tg-{{ $key }}">{{ $f['label'] }}</label>
                </div>
              @else
              <label class="form-label fw-semibold">{{ $f['label'] }}</label>
              @endif
              @if ($f['type'] === 'toggle')
              @elseif (! empty($f['translatable']))
                @foreach (locales() as $code => $name)
                  <div class="lang-pane" data-lang="{{ $code }}">
                    @php($v = old("{$key}.{$code}", is_array($raw) ? ($raw[$code] ?? '') : ''))
                    @if ($f['type'] === 'textarea')
                      <textarea class="form-control" name="{{ $key }}[{{ $code }}]" rows="3" placeholder="{{ $name }}">{{ $v }}</textarea>
                    @else
                      <input class="form-control" type="text" name="{{ $key }}[{{ $code }}]" value="{{ $v }}" placeholder="{{ $name }}">
                    @endif
                  </div>
                @endforeach
              @elseif ($f['type'] === 'image')
                @php($preview = $raw ? media_url($raw) : (isset($f['default']) ? asset($f['default']) : ''))
                <div data-image-field>
                  <img class="img-preview mb-2 {{ $preview ? '' : 'd-none' }}" src="{{ $preview }}" alt="">
                  @if (! $raw && $preview)<div class="form-text mb-2">Standart loqo göstərilir. Yenisini yükləyərək dəyişə bilərsiniz.</div>@endif
                  <input class="form-control" type="file" name="{{ $key }}" accept="image/*">
                  @if ($raw)
                    <div class="form-check mt-2"><input class="form-check-input" type="checkbox" name="remove_{{ $key }}" value="1" id="rm-{{ $key }}" data-remove><label class="form-check-label" for="rm-{{ $key }}">Şəkli sil</label></div>
                  @endif
                </div>
              @elseif ($f['type'] === 'textarea')
                <textarea class="form-control" name="{{ $key }}" rows="4">{{ old($key, is_string($raw) ? $raw : '') }}</textarea>
              @else
                <input class="form-control" type="text" name="{{ $key }}" value="{{ old($key, is_string($raw) ? $raw : '') }}">
              @endif
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endforeach

  <div class="text-end"><button class="btn btn-brand px-4" type="submit">Yadda saxla</button></div>
</form>
@endsection
