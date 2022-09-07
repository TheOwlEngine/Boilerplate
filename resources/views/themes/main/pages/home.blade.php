@extends('themes.main.layouts.app')

@section('content')
  <section class="py-20 bg-white" id="about">
    <div class="max-w-6xl mx-auto px-4 xl:px-0 2xl:px-1">
      <div class="flex flex-wrap items-center justify-between">
        <div class="w-full md:w-5/12 text-center md:text-left">
          <span class="bg-green-100 text-green-500 text-xs px-3 py-1 rounded-full font-medium">
            {{ __('website.home.about.tag') }}
          </span>
          <div class="my-5">
            <p class="font-bold text-2xl md:text-4xl text-gray-800">
              {{ __('website.home.about.title') }}
            </p>
            <p class="text-gray-700 text-base md:text-xl mt-5">
              {{ __('website.home.about.subtitle') }}
            </p>
          </div>
        </div>
        <div class="w-full md:w-6/12 text-center md:text-left">
          <p class="text-gray-600 text-base mb-4">
            {{ __('website.home.about.description') }}
          </p>
        </div>
      </div>
    </div>
  </section>
@endsection
