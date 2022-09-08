<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="robots" content="index, follow">

  <link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="/images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/images/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/images/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/images/favicon-16x16.png">
  <link rel="manifest" href="/images/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/images/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  
  <link rel="canonical" href="{{url()->current()}}" />

  {!! SEOMeta::generate() !!}
  {!! OpenGraph::generate() !!}
  {!! Twitter::generate() !!}
  {!! JsonLd::generate() !!}

  @stack('styles')

  <link rel="stylesheet" href="{{ asset('/css/app.css') . '?v=' . time()  }}">

  <script src="{{ asset('/vendor/alpine.min.js') }}" defer></script>

  @if (Config::get('app.env') == 'production')
    <!-- Global site tag (sharethis.js) - Share This -->
    <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=YOUR_SHARE_THIS_PROPERTY&product=sop' async='async'></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-YOUR_GTM_PROPERTY"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-YOUR_GTM_PROPERTY');
    </script>
  @endif
</head>

<body x-data="boilerplate()">

  <nav class="shadow w-full fixed bg-white top-0 z-50">
    <div class="px-4 max-w-7xl mx-auto sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row justify-between items-center">
      <div class="w-full md:w-auto flex justify-between items-center">
        <a href="{{ route('home') }}">
          <img src="/images/logo.svg" width="158" height="40" alt="Logo The Owl Engine">
        </a>
        <div x-on:click="mobile = !mobile" class="flex md:hidden">
          <button class="text-gray-500 hover:text-gray-700 text-3xl">
            <i class="owl owl-bars"></i>
          </button>
        </div>
      </div>
      <div class="w-full md:w-auto h-0 md:h-auto flex flex-col md:flex-row md:mt-0 overflow-hidden" x-bind:style="mobile ? { height: 'auto', padding: '10px 0' } : {}">
        @if ($menu)
          @foreach ($menu->items as $index => $item)
            @php
              $currentUrl = $item['data']['url'];
              $currentPath = request()->path();
              $currentActive = false;

              if ($currentPath === '' || $currentPath === '/') {
                if ($currentUrl === $currentPath) {
                  $currentActive = true;
                }
              } else if (strpos($currentPath, 'articles') > -1) {
                if ($currentUrl === '/articles') {
                  $currentActive = true;
                }
              }  else if (strpos($currentPath, 'artikel') > -1) {
                if ($currentUrl === '/artikel') {
                  $currentActive = true;
                }
              } else {
                if (strpos($currentUrl, $currentPath) > -1) {
                  $currentActive = true;
                }
              }
            @endphp

            <a href="{{ $item['data']['url'] }}" class="py-3 px-6 md:p-0 md:px-4 flex md:inline-flex items-center bg-white hover:bg-gray-50 rounded-xl md:hover:bg-transparent cursor-pointer relative {{ $currentActive ? 'text-orange-400 hover:text-orange-400' : 'text-gray-500 hover:text-gray-700' }}">
              {{ $item['label'] }}
            </a>
          @endforeach
        @else
          <div class="text-gray-500">Menu item not available right now</div>
        @endif
        <div x-on:click="dropdown = (dropdown == 'language-mobile' ? -1 : 'language-mobile')" class="py-3 px-6 md:p-0 md:px-4 flex md:hidden justify-between items-center bg-white hover:bg-gray-50 rounded-xl md:hover:bg-transparent cursor-pointer">
          <span>{{ __('website.app.language') }}</span>
          <i class="owl owl-angle-down"></i>
        </div>
        <div class="hidden relative md:absolute md:top-12 w-full px-6 md:p-4 bg-white md:w-auto md:rounded-xl md:shadow-lg md:mt-4 md:border" x-bind:style="{ display: dropdown == 'language-mobile' ? 'block' : 'none' }">
          @foreach ([ 'id' => 'Bahasa Indonesia', 'en' => 'English (US)' ] as $code => $name)
            <a href="{{ route('switch', [ $code ]) }}" class="p-4 text-gray-600 hover:bg-gray-50 rounded-xl flex">
              <img class="w-7 h-auto border rounded" src="/images/flag/{{ $code  == 'en' ? 'us' : $code }}.svg" alt="{{ $code }}">
              <span class="ml-4">{{ $name }}</span>
            </a>
          @endforeach
        </div>
      </div>
      <div class="hidden md:flex items-center relative">
        <div x-on:click="dropdown = (dropdown == 'language-desktop' ? -1 : 'language-desktop')" class="py-3 px-6 md:p-0 md:px-4 flex justify-between items-center md:block bg-white hover:bg-gray-50 rounded-xl md:hover:bg-transparent cursor-pointer">
          <img class="w-7 h-auto border rounded inline-flex" src="/images/flag/{{ app()->getLocale() == 'en' ? 'us' : app()->getLocale() }}.svg" alt="{{ app()->getLocale() }}">
          <i class="owl owl-angle-down"></i>
        </div>
        <div class="hidden relative md:absolute md:top-12 md:right-0 w-full px-6 md:p-4 bg-white md:w-64 md:rounded-xl md:shadow-lg md:mt-4 md:border" x-bind:style="{ display: dropdown == 'language-desktop' ? 'block' : 'none' }">
          @foreach ([ 'id' => 'Bahasa Indonesia', 'en' => 'English (US)' ] as $code => $name)
            <a href="{{ route('switch', [ $code ]) }}" class="p-4 text-gray-600 hover:bg-gray-50 rounded-xl flex">
              <img class="w-7 h-auto border rounded" src="/images/flag/{{ $code  == 'en' ? 'us' : $code }}.svg" alt="{{ $code }}">
              <span class="ml-4">{{ $name }}</span>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </nav>

  <article x-on:click="dropdown = -1" style="padding-top: 72px;">
    @yield('content')
  </article>

  <footer class="mt-20">
    <div class="max-w-6xl mx-auto px-4 xl:px-0 2xl:px-1 mb-10">
      <div class="flex flex-wrap">
        <div class="w-full md:w-4/12 mb-4 md:mb-0">
          <img src="/images/logo.svg" class="mx-auto md:mx-0" width="158" height="40" alt="Logo OwlEngine.com">
          <p class="text-gray-500 mt-4 text-center md:text-left">
            {{ __('website.app.footer.copywriting') }}
          </p>
        </div>
        <div class="w-1/2 md:w-2/12 text-center md:text-left py-4 md:p-0">
          <p class="md:text-lg font-semibold text-gray-700">
            {{ __('website.app.footer.information.title') }}
          </p>
          <ul>
            <li class="text-gray-500 hover:text-orange-400 mt-2 md:mt-6">
              <a href="{{ route('article_' . app()->getLocale()) }}">
                {{ __('website.app.footer.information.articles') }}
              </a>
            </li>
          </ul>
        </div>
        <div class="w-full md:w-4/12 mt-4 md:mt-0">
          <p class="hidden md:block md:text-lg font-semibold text-gray-700">
            {{ __('website.app.footer.updates.title') }}
          </p>
          <div class="flex flex-wrap gap-2 items-center justify-center md:justify-start mt-2 md:mt-6">
            <form action="{{ route('subscribe') }}" method="POST">
              @csrf
              <input type="email" name="email" class="w-auto border border-gray-200 shadow rounded-md px-4 py-2 outline-0" placeholder="your@email.com">
              <button class="bg-orange-400 hover:bg-orange-500 text-white px-4 shadow py-2 rounded-md">
                {{ __('website.app.footer.updates.button') }}
              </button>
            </form>
            <p class="text-sm mt-2 text-gray-500">
              {{ __('website.app.footer.updates.message') }}
            </p>
          </div>
        </div>
        <div class="w-full mt-4 block md:hidden">
          <div x-on:click="dropdown = (dropdown == 'language-mobile-footer' ? -1 : 'language-mobile-footer')" class="py-3 px-6 md:p-0 md:px-4 flex md:hidden justify-center items-center bg-white hover:bg-gray-50 rounded-xl md:hover:bg-transparent cursor-pointer">
            <span>{{ __('website.app.language') }}</span>
            <i class="owl owl-angle-down"></i>
          </div>
          <div class="hidden relative w-full px-6 md:p-4 bg-white md:w-auto md:rounded-xl md:shadow-lg md:border" x-bind:style="{ display: dropdown == 'language-mobile-footer' ? 'block' : 'none' }">
            @foreach ([ 'id' => 'Bahasa Indonesia', 'en' => 'English (US)' ] as $code => $name)
              <a href="{{ route('switch', [ $code ]) }}" class="p-4 text-gray-600 hover:bg-gray-50 rounded-xl flex">
                <img class="w-7 h-auto border rounded" src="/images/flag/{{ $code  == 'en' ? 'us' : $code }}.svg" alt="{{ $code }}">
                <span class="ml-4">{{ $name }}</span>
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="border-t">
      <div class="py-12 text-center">
        <p class="text-sm text-gray-500">
          {!! __('website.app.footer.copyright') !!}
        </p>
      </div>
    </div>
  </footer>

  <span class="bg-green-500"></span>
  <span class="bg-blue-500"></span>
  <span class="bg-purple-500"></span>

  <script>
    function boilerplate() {
      return {
        dropdown: -1,
        mobile: false,
      }
    }
  </script>

  @stack('scripts')

</body>

</html>