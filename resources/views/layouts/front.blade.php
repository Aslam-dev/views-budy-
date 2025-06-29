<html lang="en" data-theme="dark"
 @if (get_setting('site_direction') == 'ltr')
     dir="ltr"
 @elseif (get_setting('site_direction') == 'rtl')
     dir="rtl"
 @endif
 >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @if (Route::is('video'))
        <title>{{ $video->title }}</title>
    @elseif (Route::is('users'))
        <title>{{ trans('users') }} - {{ get_setting('site_name') }}</title>
    @elseif (Route::is('user'))
        <title>{{ $user->name }} - {{ get_setting('site_name') }}</title>
    @elseif (Route::is('categories'))
        <title>{{ trans('categories') }} - {{ get_setting('site_name') }}</title>
    @elseif (Route::is('category'))
        <title>{{ $category->name }} - {{ get_setting('site_name') }}</title>
    @elseif (Route::is('about') || Route::is('privacy') || Route::is('terms') || Route::is('cookie'))
        <title>{{ $page->meta_title }} - {{ get_setting('site_name') }}</title>
        <meta name="description" content="{{ $page->meta_description }}">
        <meta name="keywords" content="{{ $page->meta_keywords }}">
    @elseif (Route::is('faqs'))
        <title>{{ trans('faqs') }} - {{ get_setting('site_name') }}</title>
    @elseif (Route::is('leaderboard'))
        <title>{{ trans('leaderboard') }} - {{ get_setting('site_name') }}</title>
    @else
        <title>{{ get_setting('site_name') }} - {{ get_setting('site_title') }}</title>
    @endif

    <meta name="description" content="{{ get_setting('site_description') }}">
    <meta name="keywords" content="{{ get_setting('site_keywords') }}">
    <meta name="robots" content="all,follow">


@if (Route::is('video'))
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $video->title }}">
    <meta property="og:description" content="{{ $video->title }}">
    <meta property="og:image" content="{{ ytThumbnail($video->video_id) }}">
    <meta property="og:site_name" content="{{ get_setting('site_name') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@{{ get_setting('site_name') }}">
    <meta name="twitter:title" content="{{ $video->title }}">
    <meta name="twitter:description" content="{{ $video->title }}">
    <meta property="twitter:image" content="">
    <meta name="twitter:creator" content="@{{ get_setting('site_name') }}">
    <meta name="st:robots" content="all, follow">
    <link rel="canonical" href="{{ route('video', ['video_id' => $video->video_id, 'slug' => $video->slug]) }}">
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "NewsArticle",
            "headline": "{{ $video->title }}",
            "url": "{{ route('video', ['video_id' => $video->video_id, 'slug' => $video->slug]) }}",
            "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ route('video', ['video_id' => $video->video_id, 'slug' => $video->slug]) }}"
            },
            "articleSection": "{{ $video->category->name }}",
            "author": {
                "@type": "Person",
                "name": "{{ $video->user->name }}",
                "url": "{{ route('user', ['id' => $video->user->id, 'slug' => $video->user->slug]) }}"
            },
            "creator": "{{ $video->user->name }}",
            "publisher": {
                "@type": "Organization",
                "name": "{{ get_setting('site_name') }}",
                "logo": "{{ my_asset('uploads/settings/'.get_setting('favicon')) }}"
            },
            "keywords": "{{ get_setting('site_keywords') }}",
            "dateCreated": "{{ $video->created_at }}-05:00",
            "datePublished": "{{ $video->created_at }}-05:00",
            "dateModified": "{{ $video->updated_at }}-05:00"
        }
    </script>
@endif


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="app-url" content="{{ env('APP_URL')}}">

    <script>
        //Check local storage
        let localS = localStorage.getItem('theme')
            themeToSet = localS

        // If local storage is not set, we check the OS preference
        if(!localS){
            themeToSet = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
        }

        //Set the correct theme
        document.documentElement.setAttribute('data-theme', themeToSet)
    </script>


    @if (get_setting('analytics') != '')
        {!! get_setting('analytics') !!}
    @endif

    @if (get_setting('adsense') != '')
        {!! get_setting('adsense') !!}
    @endif

    <!-- ==============================================
    Favicons
    =============================================== -->
    <link href="{{ my_asset('uploads/settings/'.get_setting('favicon')) }}" rel="icon">

    <!-- ==============================================
    CSS Styles
    =============================================== -->
    @if (get_setting('site_direction') == 'ltr')
        <link rel="stylesheet" href="{{ my_asset('assets/vendors/bootstrap/bootstrap.min.css') }}">
    @elseif (get_setting('site_direction') == 'rtl')
        <link rel="stylesheet" href="{{ my_asset('assets/vendors/bootstrap/bootstrap.rtl.min.css') }}">
    @endif
    <link rel="stylesheet" href="{{ my_asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ my_asset('assets/vendors/simplebar/simplebar.min.css') }}">
    <link rel="stylesheet" href="{{ my_asset('assets/vendors/magnific-popup/magnific-popup.css') }}">
    @if (get_setting('site_direction') == 'ltr')
        <link rel="stylesheet" href="{{ my_asset('assets/frontend/css/style.css') }}">
    @elseif (get_setting('site_direction') == 'rtl')
        <link rel="stylesheet" href="{{ my_asset('assets/frontend/css/style-rtl.css') }}">
    @endif

    <!-- ==============================================
    Scripts
    =============================================== -->
    <script src="{{ my_asset('assets/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ my_asset('assets/vendors/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ my_asset('assets/vendors/popper/popper.min.js') }}"></script>


    <script>
    "use strict";
    var APP_URL = {!! json_encode(url('/')) !!}
    </script>

    @yield('styles')

    <!-- ==============================================
    Fonts
    =============================================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Switcher Icon -->
    <div class="switcher switcher-show" id="theme-switcher">
        <i id="switcher-icon" class="bi bi-sun"></i>
    </div>

    <!-- Back to Top -->
	<a href="#" id="back-to-top"></a>

    <div class="vine-wrapper">

        @include('layouts.partials.front.navbar')

    	<!-- ==============================================
		 Main
		=============================================== -->
		<section class="vine-main">
			<div class="container">
                @yield('content')
            </div>
        </section>

        @include('layouts.partials.front.footer')

    </div>


    <!-- ==============================================
	Scripts
	=============================================== -->
	<script src="{{ my_asset('assets/vendors/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ my_asset('assets/vendors/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ my_asset('assets/vendors/tata/tata.js') }}"></script>
    <script src="{{ my_asset('assets/vendors/magnific-popup/magnific-popup.js') }}"></script>
	<script src="{{ my_asset('assets/frontend/js/main.js') }}"></script>
    <script src="{{ my_asset('assets/functions.js') }}"></script>

    @if (Session::has('success'))
      <script>
        tata.success("Success", "{{ Session::get('success') }}", {
          position: 'tr',
          duration: 3000,
          animate: 'slide'
        });
      </script>
    @endif

    @if (Session::has('error'))
      <script>
        tata.error("Error", "{{ Session::get('error') }}", {
          position: 'tr',
          duration: 6000,
          animate: 'slide'
        });
      </script>
    @endif

    @yield('scripts')

</body>
</html>
