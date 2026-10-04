@extends('admin.layouts.app')

@section('title', 'Müraciət')
@section('heading', 'Müraciət')

@section('content')
<div class="mb-3"><a class="btn btn-light" href="{{ route('admin.messages.index') }}"><i class="bi bi-arrow-left me-1"></i>Geri</a></div>
<div class="row g-3">
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">{{ $message->fullName() }}</div>
      <div class="card-body">
        <div class="message-body">{{ $message->message }}</div>
      </div>
    </div>
  </div>
  <div class="col-lg-4">
    <div class="card mb-3">
      <div class="card-body">
        <dl class="mb-0">
          <dt>E-poçt</dt><dd><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd>
          <dt>Telefon</dt><dd><a href="tel:{{ $message->phone }}">{{ $message->phone }}</a></dd>
          <dt>Tarix</dt><dd>{{ $message->created_at->format('d.m.Y H:i') }}</dd>
          <dt>Dil</dt><dd>{{ strtoupper((string) $message->locale) }}</dd>
          <dt>IP</dt><dd class="mb-0">{{ $message->ip }}</dd>
        </dl>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <form method="post" action="{{ route('admin.messages.status', $message) }}" class="d-flex gap-2">
          @csrf
          <select class="form-select" name="status">
            @foreach (['new' => 'Yeni', 'read' => 'Oxunub', 'answered' => 'Cavablandırılıb'] as $v => $l)
              <option value="{{ $v }}" @selected($message->status === $v)>{{ $l }}</option>
            @endforeach
          </select>
          <button class="btn btn-brand" type="submit">Saxla</button>
        </form>
        <a class="btn btn-outline-brand w-100 mt-2" href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: müraciət') }}"><i class="bi bi-reply me-1"></i>E-poçtla cavabla</a>
      </div>
    </div>
  </div>
</div>
@endsection
