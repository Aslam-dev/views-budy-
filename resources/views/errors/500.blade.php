@extends('layouts.login')

@section('content')


<div class="vine-wrapper">

    <!-- ==============================================
     Main
    =============================================== -->
    <section class="vine-main">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 col-md-8 offset-lg-2 offset-md-2 d-flex justify-content-center">
                    <div class="error-content">
                        <h1>5<span>0</span>0</h1>
                        <h2>{{ trans('opps_internal_server_error') }}!</h2>
                        <a class="btn btn-mint w-100 mt-4" href="{{ route('home') }}">{{ trans('back_to_home') }}</a>
                    </div>
                </div>

            </div>

        </div>
    </section>


</div><!--/vine-wrapper-->

@endsection
