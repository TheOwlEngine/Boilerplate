@extends('layouts.app')

@push('styles')
  <link rel="stylesheet" href="{{ asset('/vendor/prism/prism.min.css') }}">
@endpush

@push('scripts')
  <script src="{{ asset('/vendor/prism/prism.min.js') }}"></script>
  <script src="{{ asset('/vendor/prism/prism-bash.min.js') }}"></script>
  <script src="{{ asset('/vendor/prism/prism-javascript.min.js') }}"></script>
  <script src="{{ asset('/vendor/prism/prism-php.min.js') }}"></script>
  <script src="{{ asset('/vendor/prism/prism-python.min.js') }}"></script>
  <script src="{{ asset('/vendor/prism/prism-go.min.js') }}"></script>
  <script src="{{ asset('/vendor/alpine-clipboard.min.js') }}"></script>
@endpush

@section('content')
<header class="pt-20 pb-20 bg-gray-50" style="background-image: url('/pattern.png');">
  <div class="max-w-4xl mx-auto px-4 2xl:px-1 xl:px-7 text-center">
    <p class="text-gray-400">{{ $article->author->name }} • {{ $article->published_at->translatedFormat('l, d M Y') }}</p>
    <p class="font-bold text-2xl md:text-4xl text-gray-900 my-5">{{ $article->title }}</p>
    <p class="text-lg text-gray-500 mb-4">{{ $article->excerpt }}</p>
    @if (app()->getLocale() == 'en')
      <a href="/switch/id" class="inline-flex gap-x-2 bg-white hover:bg-gray-50 py-2 px-4 text-md text-gray-500 text-md rounded-xl border border-gray-200">
        <img class="w-7 h-auto border rounded" src="/images/flag/id.svg" alt="ID"> Baca dalam Bahasa Indonesia
      </a>
    @else
      <a href="/switch/en" class="inline-flex gap-x-2 bg-white hover:bg-gray-50 py-2 px-4 text-md text-gray-500 text-md rounded-xl border border-gray-200">
        <img class="w-7 h-auto border rounded" src="/images/flag/us.svg" alt="US"> Read on English (US)
      </a>
    @endif
  </div>
</header>

<section>
  <div class="max-w-4xl mx-auto px-4 2xl:px-1 xl:px-7 pb-16 pt-10 prose prose-h1:text-3xl prose-h1:font-semibold prose-h1:mt-14 prose-img:my-0 prose-h4:text-lg">
    {!! $article->content !!}
  </div>
  <div class="sharethis-inline-share-buttons mb-10"></div>
</section>
@endsection