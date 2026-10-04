@extends('site.layouts.inner')

@section('title', t('structure'))
@section('description', t('structure_desc'))

@section('content')
<div class="org-toolbar">
  <ul class="org-legend" aria-label="{{ t('org_legend') }}">
    <li><span class="org-legend__dot org-legend__dot--council"></span>{{ t('org_council') }}</li>
    <li><span class="org-legend__dot org-legend__dot--director"></span>{{ t('org_director') }}</li>
    <li><span class="org-legend__dot org-legend__dot--deputy"></span>{{ t('org_deputy') }}</li>
    <li><span class="org-legend__dot org-legend__dot--department"></span>{{ t('org_department') }}</li>
    <li><span class="org-legend__dot org-legend__dot--unit"></span>{{ t('org_unit') }}</li>
    <li><span class="org-legend__dot org-legend__dot--committee"></span>{{ t('org_committee') }}</li>
  </ul>
  <div class="org-actions">
    <button class="btn btn-secondary-brand" type="button" data-org-expand>{{ t('expand_all') }}</button>
    <button class="btn btn-secondary-brand" type="button" data-org-collapse>{{ t('collapse') }}</button>
  </div>
</div>

<div class="org-scroll" data-org-scroll>
  <div class="org" data-org-chart data-src="{{ route('site.structure.json', ['lang' => app()->getLocale()]) }}" data-error="{{ t('structure_failed') }}" aria-label="{{ t('structure_label') }}"></div>
</div>
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/org-chart.js') }}"></script>
@endpush
