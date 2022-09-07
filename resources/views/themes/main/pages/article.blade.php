@extends('themes.main.layouts.app')

@section('content')
<section class="py-10 md:py-20 bg-gray-50" style="background-image: url('/pattern.png');">
  <div class="max-w-6xl mx-auto px-4 xl:px-0 2xl:px-1">
    <div class="my-5">
      <p class="font-bold text-2xl md:text-5xl text-gray-800 mb-5">{{ $page->title ?? '-' }}</p>
      <p class="text-gray-500 text-lg">{{ $page->excerpt ?? '-' }}</p>
    </div>
  </div>
</section>

<section class="my-8 md:my-10 bg-white" id="about">
  <div class="max-w-6xl mx-auto px-4 xl:px-0 2xl:px-1">
    <div class="flex flex-wrap -mx-4">
      
      @foreach ($articles as $article)
        <div class="w-full md:w-6/12 px-4 my-2">
          <a href="{{ route('article_detail_' . app()->getLocale(), [ $article->slug ]) }}">
            <img src="/storage/{{ $article->banner }}" class="rounded-md" alt="{{ $article->title }}" />
          </a>
          <div class="my-5">
            <p class="text-gray-500 text-base mb-3 mt-5">{{ $article->author->name }} • {{ $article->published_at->translatedFormat('l, d M Y') }}</p>
            <p class="text-lg md:text-xl text-gray-800 font-semibold mb-4">{{ $article->title }}</p>
            <p class="text-gray-400 mb-4">{{ $article->excerpt }}</p>
            <a href="{{ route('article_detail_' . app()->getLocale(), [ $article->slug ]) }}" class="text-main-color font-medium hover:underline">
              {{ app()->getLocale() == 'en' ? 'Read More' : 'Lebih Lanjut' }} <i class="owl owl-arrow-right"></i>
            </a>
          </div>
        </div>
      @endforeach

    </div>
  </div>
</section>
@endsection