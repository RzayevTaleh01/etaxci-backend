@extends('site.layouts.inner')

@section('title', t('reception_days'))
@section('description', t('reception_days'))

@section('content')
<div class="reception">
  <table class="table reception-table">
    <thead>
      <tr>
        <th scope="col">{{ t('position') }}</th>
        <th scope="col">{{ t('full_name') }}</th>
        <th scope="col">{{ t('reception_time') }}</th>
        <th scope="col">{{ t('email_address') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($rows as $row)
        <tr>
          <td data-label="{{ t('position') }}">{{ $row->position }}</td>
          <td data-label="{{ t('full_name') }}">{{ $row->name }}</td>
          <td data-label="{{ t('reception_time') }}">{{ $row->schedule }}</td>
          <td data-label="{{ t('email_address') }}">@if($row->email)<a href="mailto:{{ $row->email }}">{{ $row->email }}</a>@endif</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
