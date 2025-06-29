@extends('layouts.login')

@section('content')


	<div class="vine-wrapper">

		<!-- ==============================================
		 Main
		=============================================== -->
        <div class="login p-3 p-xxl-5" style="background-image: linear-gradient( rgba(35, 37, 38, 0.50), rgba(35, 37, 38, 0.50) ),
        url({{ my_asset('uploads/settings/'.get_setting('login_bg')) }});">
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
                                    <p class="small mb-4 text-secondary">{{ trans('sign_in_to_your_account_to_continue') }}.</p>
                                </div>

                                <form id="login_form" method="POST">
                                    @csrf

                                    <div class="pb-3">
                                        <label class="form-label rd-input-label focus not-empty">{{ trans('email') }}</label>
                                        <input type="text" name="email" id="email" placeholder="name@example.com">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="pb-3">
                                        <label class="form-label rd-input-label focus not-empty">{{ trans('password') }}</label>
                                        <div class="password-toggle">
                                            <input type="password" name="password" id="password" placeholder="***********">
                                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                                <input class="password-toggle-check" id="togglePassword" type="checkbox">
                                                <span class="password-toggle-indicator"></span>
                                            </label>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-4 d-flex justify-content-between">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                                            <label class="form-check-label" for="remember_me">{{ trans('remember_me') }}</label>
                                        </div>
                                        <div class="text-primary-hover">
                                            <a href="{{ route('auth.forgot') }}" class="text-secondary">
                                                <u>{{ trans('forgot_password') }}?</u>
                                            </a>
                                        </div>
                                    </div>

                                    @if(get_setting('recaptcha_active') == 'Yes')
                                        <div class="pb-3">
                                            <div  class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.siteKey') }}"></div>
                                        </div>
                                    @endif

                                    <div class="pb-3">
                                        <button type="submit" id="login_btn" class="w-100 btn btn-mint">{{ trans('login') }}</button>
                                    </div>

                                    <div class="text-center"><small class="text-secondary">{{ trans('not_registered') }}?</small> <a href="{{ route('auth.register') }}" class="small font-weight-bold">{{ trans('create_an_account') }}</a></div>
                                </form>



                                <div class="row">

                                    @if(get_setting('google_active') == 'Yes' || get_setting('facebook_active') == 'Yes')
                                        <!-- Divider with text -->
                                        <div class="position-relative my-4">
                                            <hr class="text-secondary">
                                            <p class="text-secondary small position-absolute top-50 start-50 translate-middle bg-body px-5">Or</p>
                                        </div>
                                    @endif

                                    @if(get_setting('google_active') == 'Yes')
                                        <div class="col-xxl-6 d-grid">
                                            <a href="{{ route('auth.google') }}" class="btn bg-google mb-2 mb-xxl-0"><i class="bi bi-google text-white me-2"></i>Login with Google</a>
                                        </div>
                                    @endif
                                    @if(get_setting('facebook_active') == 'Yes')
                                        <div class="col-xxl-6 d-grid">
                                            <a href="{{ route('auth.facebook') }}" class="btn bg-facebook mb-0"><i class="bi bi-facebook me-2"></i>Login with Facebook</a>
                                        </div>
                                    @endif
                                </div>

                                @if (get_setting('app_demo') == 'true')
                                    @include('auth.logins')
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

			</div>
		</div>

    </div><!--/vine-wrapper-->

@endsection

@section('scripts')
<script src="https://www.google.com/recaptcha/api.js"></script>

<script>

    // Toggle Passwords
    $('#togglePassword').on('click', function(){
        var passInput=$("#password");
        if(passInput.attr('type')==='password')
        {
            passInput.attr('type','text');
        }else{
        passInput.attr('type','password');
        }
    });


    /* <=========== To fill password in username and password field ===========> */
    const fillCredentials = () => {
        const td = event.target.parentNode;
        const tr = td.parentNode;
        const username = tr.children[1].innerHTML;
        const password = tr.children[2].innerHTML;

        document.getElementById('email').value = username;
        document.getElementById('password').value = password;

    }

    $(function (){
        $(document).on('submit', '#login_form', function (e){
            e.preventDefault();

            start_load();
            $('#login_btn').text('{{ trans('loading') }}...');
            const fd = new FormData(this);

            $.ajax({
                url: '{{ route('auth.login') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response){

                    console.log(response);


                    end_load();

                    if(response.status == 400){

                        if (response.messages.g-recaptcha-response != '') {
                            tata.error("Error", 'Captcha is Required', {
                            position: 'tr',
                            duration: 3000,
                            animate: 'slide'
                            });
                        }

                        showError('email', response.messages.email);
                        showError('password', response.messages.password);
                        $('#login_btn').text('{{ trans('login') }}');

                    } else if(response.status == 401){


                        tata.error("Error", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        removeValidationClasses('#login_form');
                        $('#login_btn').text('{{ trans('login') }}');
                        window.location.reload();

                    } else if(response.status == 402){


                        tata.error("Error", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        removeValidationClasses('#login_form');
                        $('#login_btn').text('{{ trans('login') }}');
                        window.location.reload();

                    } else if (response.status == 200){

                        tata.success("Success", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        removeValidationClasses("#login_form");
                        $("#login_form")[0].reset();
                        window.location = response.intended
                    }

                } // End success
            }); // End Ajax
        })
    });
</script>

@endsection
