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
    <title>{{ trans('user') }} {{ trans('dashboard') }} - {{ get_setting('site_name') }}</title>

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
        <i id="switcher-icon" class="bi bi-moon"></i>
    </div>

    <!-- Back to Top -->
	<a href="#" id="back-to-top"></a>

    <div class="vine-wrapper">

        @include('layouts.partials.front.navbar')

    	<!-- ==============================================
		 Main
		=============================================== -->
		<section class="dashboard">
			<div class="container">
				<div class="row">
                    <div class="col-sm-12 col-lg-3 mb-5">
                        @include('layouts.partials.user.sidebar')
                    </div>
                    <div class="col-12 col-lg-9">
                        @yield('content')
                    </div>
                </div>
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
