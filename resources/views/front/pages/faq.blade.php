@extends('layouts.front')

@section('content')


    <div class="vine-header mb-4">
        <ul class="breadcrumbs">
            <li><a href="{{ route('home') }}"><span class="bi bi-house me-1"></span>{{ trans('home') }}</a></li>
            <li>{{ trans('faqs') }}</li>
        </ul>
        <h2 class="mb-2">{{ trans('faqs') }}</h2>
    </div><!--/vine-header-->

    <div class="faq">
        @foreach ($faqs as $faq)

         <div class="accordion-item border-0 rounded-3 shadow-sm mb-3">
            <h2 class="accordion-header" id="q{{ $faq->id }}-heading">
              <button class="accordion-button shadow-none rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#q{{ $faq->id }}" aria-expanded="true" aria-controls="q{{ $faq->id }}">
                {{ $faq->question }}
              </button>
            </h2>
            <div id="q{{ $faq->id }}" class="accordion-collapse collapse" aria-labelledby="q{{ $faq->id }}-heading" data-bs-parent="#faq">
              <div class="accordion-body fs-sm pt-0">
                <p>{{ $faq->answer }}</p>
              </div>
            </div>
          </div>
        @endforeach
    </div>

@endsection
