@extends('layouts.app')

@section('content')
  <section class="py-20 bg-white" id="about">
    <div class="max-w-6xl mx-auto px-4 xl:px-0 2xl:px-1">
      <span class="bg-green-100 text-green-500 text-xs px-3 py-1 rounded-full font-medium">
        {{ __('website.home.tag') }}
      </span>
      <div class="my-5">
        <p class="font-bold text-2xl md:text-4xl text-gray-800">
          {{ __('website.home.title') }}
        </p>
        <p class="text-gray-700 text-base md:text-xl mt-5">
          {{ __('website.home.subtitle') }}
        </p>
      </div>
      <div class="mt-8">
        <a href="#about" class="lg:text-lg px-7 py-3 bg-orange-400 hover:bg-orange-500 text-white shadow-lg rounded-lg inline-block font-medium">
          {{ __('website.home.button') }}
        </a>
      </div>
    </div>
  </section>
@endsection
