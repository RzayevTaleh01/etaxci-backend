<a data-reveal class="team-card{{ $compact ? ' team-card--compact' : '' }}" href="{{ $person->url() }}">
  <img class="team-card__photo" src="{{ $person->photoUrl() }}" width="208" height="208" loading="lazy" alt="{{ $person->name }}">
  <div class="team-card__content">
    <h2 class="team-card__name">{{ $person->name }}</h2>
    <p class="team-card__role">{{ $person->position }}</p>
    @if ($summary = $person->summary())<p class="team-card__bio">{{ $summary }}</p>@endif
    @if ($person->facebook || $person->linkedin)
    <ul class="social-list social-list--sm" aria-label="{{ t('social_networks') }}">
      @if ($person->facebook)<li><span class="social-list__item" title="Facebook">@include('site.partials.svg-facebook')</span></li>@endif
      @if ($person->linkedin)<li><span class="social-list__item" title="LinkedIn">@include('site.partials.svg-linkedin', ['maskId' => 'p'.$person->id])</span></li>@endif
    </ul>
    @endif
  </div>
</a>
