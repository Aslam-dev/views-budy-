<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="app-url" content="{{ env('APP_URL')}}">

    <title>Admin - {{ get_setting('site_name') }}</title>

    <!-- ==============================================
    Favicons
    =============================================== -->
    <link href="{{ my_asset('uploads/settings/'.get_setting('favicon')) }}" rel="icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ my_asset('assets/vendors/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ my_asset('assets/backend/css/app.css') }}" rel="stylesheet">
    <link href="{{ my_asset('assets/backend/css/main.css') }}" rel="stylesheet">

    <link href="{{ my_asset('assets/vendors/datatables/dataTables.bootstrap5.css') }}" rel="stylesheet">
    <link href="{{ my_asset('assets/vendors/datatables/jquery.dataTables_them.css') }}" rel="stylesheet">
    <link href="{{ my_asset('assets/vendors/summernote/summernote.min.css') }}" rel="stylesheet">
    <link href="{{ my_asset('assets/vendors/summernote/summernote-lite.min.css') }}" rel="stylesheet">

    <link href="{{ my_asset('assets/vendors/lineicons/lineicons.css') }}" rel="stylesheet">
    <link href="{{ my_asset('assets/vendors/line-awesome/line-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ my_asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">

    <link href="{{ my_asset('assets/vendors/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ my_asset('assets/backend/css/custom.css') }}" rel="stylesheet">

    @yield('styles')

    <script>
        "use strict";
        var APP_URL = {!! json_encode(url('/')) !!}
    </script>

    <!-- ==============================================
    Scripts
    =============================================== -->
    <script src="{{ my_asset('assets/vendors/jquery/jquery.min.js') }}"></script>
</head>
<body>
    <div class="wrapper">
        @include('layouts.partials.admin.sidebar')
      <div class="main">
        @include('layouts.partials.admin.navbar')
        @yield('content')
        @include('layouts.partials.admin.footer')
      </div>
    </div>

    <!-- ==============================================
    Scripts
    =============================================== -->
    <script src="{{ my_asset('assets/vendors/sweetalert/sweetalert2.all.min.js') }}"></script>
    <script src="{{ my_asset('assets/vendors/tata/tata.js') }}"></script>

    <script src="{{ my_asset('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ my_asset('assets/vendors/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ my_asset('assets/vendors/summernote/summernote-lite.min.js') }}"></script>

    <script src="{{ my_asset('assets/backend/js/app.js') }}"></script>
    <script src="{{ my_asset('assets/functions.js') }}"></script>
    <script src="{{ my_asset('assets/backend/js/main.js') }}"></script>

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


    @if (!Route::is('admin.pages.add') && !Route::is('admin.pages.edit') && !Route::is('admin.email.add') && !Route::is('admin.email.edit'))
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>
    @endif

    @yield('scripts')
</body>
</html>
