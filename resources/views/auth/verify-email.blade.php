@extends('layouts.login')

@section('content')


	<div class="vine-wrapper">

		<!-- ==============================================
		 Main
		=============================================== -->
        <div class="login p-3 p-xxl-5" style="background-image: linear-gradient( rgba(35, 37, 38, 0.50), rgba(35, 37, 38, 0.50) ), url({{ my_asset('uploads/settings/'.get_setting('login_bg')) }});">
            <div class="shape">
                <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" width="100%" height="140px" viewBox="20 -20 300 100" xml:space="preserve">
                  <path d="M30.913 43.944s42.911-34.464 87.51-14.191c77.31 35.14 113.304-1.952 146.638-4.729 48.654-4.056 69.94 16.218 69.94 16.218v54.396H30.913V43.944z" class="vine-svg fill" opacity=".4"></path>
                  <path d="M-35.667 44.628s42.91-34.463 87.51-14.191c77.31 35.141 113.304-1.952 146.639-4.729 48.653-4.055 69.939 16.218 69.939 16.218v54.396H-35.667V44.628z" class="vine-svg fill" opacity=".4"></path>
                  <path d="M-34.667 62.998s56-45.667 120.316-27.839C167.484 57.842 197 41.332 232.286 30.428c53.07-16.399 104.047 36.903 104.047 36.903l1.333 36.667-372-2.954-.333-38.046z" class="vine-svg fill"></path>
                </svg>
            </div>
        </div>

		<div class="vine-login">
			<div class="container">

                <div class="row gy-5 justify-content-center">
                    <div class="col-md-6 col-lg-6 col-xxl-6">
                        <div class="card" data-aos="fade-up" data-aos-easing="linear">
                            <div class="card-body p-4 p-xl-5">
                                <div class="login-header">
                                    <a href="{{ route('home') }}"><img src="{{ my_asset('uploads/settings/'.get_setting('logo')) }}" alt="Logo"></a>
                                    <p class="small mb-4">{{ trans('verify_your_email_to_continue') }}.</p>

                                    <form id="login_form" method="POST" action="{{ route('verification.resend') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-lg btn-mint mt-2">{{ trans('send_verification_link') }}</button>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

			</div>
		</div>

    </div><!--/vine-wrapper-->

@endsection
