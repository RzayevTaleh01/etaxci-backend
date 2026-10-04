@extends('site.layouts.app')

@section('title', t('faq'))
@section('description', t('faq'))

@section('head')
  @if ($faqs->isNotEmpty())
  <script type="application/ld+json">{!! json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'FAQPage',
      'mainEntity' => $faqs->map(fn ($f) => [
          '@type' => 'Question', 'name' => $f->question,
          'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f->answer],
      ])->all(),
  ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
  @endif
@endsection

@section('main')
<main id="main" class="page">
  <div class="container">
    @include('site.partials.page-head')

    <div class="accordion faq__accordion" id="faqAccordion">
      @foreach ($faqs as $faq)
        <div class="accordion-item faq__item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $loop->index }}" aria-expanded="false" aria-controls="faq-{{ $loop->index }}">{{ $faq->question }}</button>
          </h2>
          <div id="faq-{{ $loop->index }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              @foreach (preg_split('/\R{2,}/', trim($faq->answer)) as $paragraph)
                <p>{{ $paragraph }}</p>
              @endforeach
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>

  @include('site.partials.cta')
</main>
@endsection
