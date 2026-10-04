@php
    $name = $field['name'];
    $type = $field['type'];
    $label = $field['label'];
    $required = ! empty($field['required']);
    $help = $field['help'] ?? null;
    $translatable = ! empty($field['translatable']);
    $extraValues = $extra['values'] ?? [];

    // Current value for non-translatable fields
    $value = old($name, array_key_exists($name, $extraValues) ? $extraValues[$name] : ($model->exists ? ($model->{$name} ?? null) : ($field['default'] ?? null)));
    if ($type === 'datetime' && $value instanceof \Carbon\CarbonInterface) {
        $value = $value->format('Y-m-d\TH:i');
    } elseif ($type === 'datetime' && ! $model->exists && ! $value && $name === 'published_at') {
        $value = now()->format('Y-m-d\TH:i');
    }
@endphp

@if ($translatable)
  <label class="form-label fw-semibold {{ $required ? 'required' : '' }}">{{ $label }}</label>
  @foreach (locales() as $code => $langName)
    @php
        $tv = old("{$name}.{$code}", $model->exists ? $model->getTranslation($name, $code, false) : '');
    @endphp
    <div class="lang-pane" data-lang="{{ $code }}">
      @if ($type === 'richtext')
        <div data-richtext>
          <div class="editor">{!! '' !!}</div>
        </div>
        <input type="hidden" name="{{ $name }}[{{ $code }}]" value="{{ $tv }}" data-lang-input>
      @elseif ($type === 'textarea')
        <textarea class="form-control @error($name.'.'.$code) is-invalid @enderror" name="{{ $name }}[{{ $code }}]" rows="4" data-lang-input placeholder="{{ $langName }}">{{ $tv }}</textarea>
      @else
        <input class="form-control @error($name.'.'.$code) is-invalid @enderror" type="text" name="{{ $name }}[{{ $code }}]" value="{{ $tv }}" data-lang-input placeholder="{{ $langName }}">
      @endif
      @error($name.'.'.$code)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
    </div>
  @endforeach
  @if ($help)<div class="form-text">{{ $help }}</div>@endif

@elseif ($type === 'toggle')
  <div class="form-check form-switch mt-2">
    <input type="hidden" name="{{ $name }}" value="0">
    <input class="form-check-input" type="checkbox" role="switch" id="f-{{ $name }}" name="{{ $name }}" value="1" @checked((bool) $value)>
    <label class="form-check-label" for="f-{{ $name }}">{{ $label }}</label>
  </div>
  @if ($help)<div class="form-text">{{ $help }}</div>@endif

@elseif ($type === 'image')
  <label class="form-label fw-semibold {{ $required ? 'required' : '' }}" for="f-{{ $name }}">{{ $label }}</label>
  <div data-image-field>
    <img class="img-preview mb-2 {{ $model->exists && $model->{$name} ? '' : 'd-none' }}" src="{{ $model->exists && $model->{$name} ? media_url($model->{$name}) : '' }}" alt="">
    <input class="form-control @error($name) is-invalid @enderror" type="file" id="f-{{ $name }}" name="{{ $name }}" accept="image/*">
    @if ($model->exists && $model->{$name})
      <div class="form-check mt-2"><input class="form-check-input" type="checkbox" name="remove_{{ $name }}" value="1" id="rm-{{ $name }}" data-remove><label class="form-check-label" for="rm-{{ $name }}">Şəkli sil</label></div>
    @endif
  </div>
  @error($name)<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
  @if ($help)<div class="form-text">{{ $help }}</div>@endif

@elseif ($type === 'gallery')
  <label class="form-label fw-semibold">{{ $label }}</label>
  <div data-gallery-field>
    <div class="gallery-grid mb-2">
      @foreach ((array) ($model->exists ? $model->{$name} : []) as $path)
        <div class="gallery-item">
          <img src="{{ media_url($path) }}" alt="">
          <input type="hidden" name="{{ $name }}_keep[]" value="{{ $path }}">
          <button class="remove" type="button" title="Sil">&times;</button>
        </div>
      @endforeach
    </div>
    <div class="gallery-grid gallery-new mb-2"></div>
    <input class="form-control" type="file" name="{{ $name }}_new[]" accept="image/*" multiple>
    <div class="form-text">Bir neçə şəkil seçə bilərsiniz. Silmək üçün şəklin üzərindəki × düyməsini basın.</div>
  </div>

@elseif ($type === 'select')
  <label class="form-label fw-semibold {{ $required ? 'required' : '' }}" for="f-{{ $name }}">{{ $label }}</label>
  <select class="form-select @error($name) is-invalid @enderror" id="f-{{ $name }}" name="{{ $name }}">
    @unless ($required)<option value="">— seçilməyib —</option>@endunless
    @foreach (($field['options'] ?? []) as $optValue => $optLabel)
      <option value="{{ $optValue }}" @selected((string) $value === (string) $optValue)>{{ $optLabel }}</option>
    @endforeach
  </select>
  @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
  @if ($help)<div class="form-text">{{ $help }}</div>@endif

@elseif ($type === 'textarea' || $type === 'richtext')
  <label class="form-label fw-semibold {{ $required ? 'required' : '' }}" for="f-{{ $name }}">{{ $label }}</label>
  <textarea class="form-control @error($name) is-invalid @enderror" id="f-{{ $name }}" name="{{ $name }}" rows="5">{{ $value }}</textarea>
  @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
  @if ($help)<div class="form-text">{{ $help }}</div>@endif

@else
  @php($inputType = ['email' => 'email', 'number' => 'number', 'datetime' => 'datetime-local', 'password' => 'password', 'url' => 'text'][$type] ?? 'text')
  <label class="form-label fw-semibold {{ $required && ! ($type === 'password' && $model->exists) ? 'required' : '' }}" for="f-{{ $name }}">{{ $label }}</label>
  <input class="form-control @error($name) is-invalid @enderror" type="{{ $inputType }}" id="f-{{ $name }}" name="{{ $name }}"
         value="{{ $type === 'password' ? '' : $value }}" @if($type === 'password') autocomplete="new-password" @endif>
  @error($name)<div class="invalid-feedback">{{ $message }}</div>@enderror
  @if ($help)<div class="form-text">{{ $help }}</div>@endif
@endif
