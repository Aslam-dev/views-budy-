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
                                    <h4 class="mb-4">{{ trans('reset_password') }}</h4>
                                </div>

                                <form id="reset_form" method="POST">
                                    @csrf

                                    <input type="hidden" name="token" id="token" value="{{ $token }}">
                                    <input type="hidden" name="email" id="email" value="{{ $email }}">

                                    <div class="pb-3">
                                        <label class="form-label rd-input-label focus not-empty">{{ trans('new_password') }}</label>
                                        <div class="password-toggle">
                                            <input type="password" name="new_password" id="new_password" placeholder="***********">
                                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                                <input class="password-toggle-check" id="newPassword" type="checkbox">
                                                <span class="password-toggle-indicator"></span>
                                            </label>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="pb-3">
                                        <label class="form-label rd-input-label focus not-empty">{{ trans('confirm_new_password') }}</label>
                                        <div class="password-toggle">
                                            <input type="password" name="c_new_password" id="c_new_password" placeholder="***********">
                                            <label class="password-toggle-btn" aria-label="Show/hide password">
                                                <input class="password-toggle-check" id="cnewPassword" type="checkbox">
                                                <span class="password-toggle-indicator"></span>
                                            </label>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>

                                    <div class="pb-3"><button type="submit" id="reset_btn" class="w-100 btn btn-mint">{{ trans('submit') }}</button></div>
                                    <div class="text-center"><a href="{{ route('home') }}" class="small font-weight-bold">{{ trans('return_to_home') }}</a></div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>

			</div>
		</div>

    </div><!--/vine-wrapper-->

@endsection

@section('scripts')


<script>

    // Toggle Passwords

    $('#newPassword').on('click', function(){
    var passInput=$("#new_password");
    if(passInput.attr('type')==='password')
        {
        passInput.attr('type','text');
    }else{
        passInput.attr('type','password');
    }
    });

    $('#cnewPassword').on('click', function(){
    var passInput=$("#c_new_password");
    if(passInput.attr('type')==='password')
        {
        passInput.attr('type','text');
    }else{
        passInput.attr('type','password');
    }
    });

    $(function (){
        $(document).on('submit', '#reset_form', function (e){
            e.preventDefault();

            start_load();
            const fd = new FormData(this);
            $('#reset_btn').text('{{ trans('submitting') }}...');

            $.ajax({
                url: '{{ route('update.password') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function (response){

                    end_load();

                    if(response.status == 400){

                        showError('new_password', response.messages.new_password);
                        showError('c_new_password', response.messages.c_new_password);
                        $('#reset_btn').text('{{ trans('submit') }}');

                    } else if(response.status == 401){

                        tata.error("Error", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        removeValidationClasses('#reset_form');
                        $('#reset_btn').text('{{ trans('submit') }}');

                    } else if (response.status == 200){

                        tata.success("Success", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        removeValidationClasses("#reset_form");
                        $("#reset_form")[0].reset();
                        $('#reset_btn').text('{{ trans('submit') }}');
                        window.location = '{{ route('auth.login') }}'
                    }

                } // End success
            }); // End Ajax
        })
    });
</script>

@endsection
