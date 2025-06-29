@extends('layouts.user')

@section('content')



<h4 class="mb-4" data-aos="fade-down" data-aos-easing="linear"><i class="bi bi-gear me-2"></i>{{ trans('settings') }}</h4>
<div class="row g-4" data-aos="fade-up" data-aos-easing="linear">
    <div class="col-12">
        <div class="vine-tabs pb-0 px-2 px-lg-0 rounded-top">
            <ul class="nav nav-tabs nav-bottom-line nav-responsive border-0 nav-justified" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link mb-0 {{ Route::is('user.profile') ? 'active' : '' }}" href="{{ route('user.profile') }}">
                        <i class="bi bi-gear fa-fw me-2"></i>{{ trans('edit_profile') }}
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link mb-0 {{ Route::is('user.password') ? 'active' : '' }}" href="{{ route('user.password') }}">
                        <i class="bi bi-lock me-2"></i> {{ trans('security_settings') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12">
        <div class="mt-5">

          @if(Route::is('user.profile') )
            <div data-aos="fade-up" data-aos-easing="linear">
                <div class="dashboard-card">
                    <div class="dashboard-header">
                        <h4>{{ trans('profile_details') }}</h4>
                    </div>
                    <div class="dashboard-body">


                        <form id="user_profile_form" method="POST">
                            @csrf

                            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="old_image" id="old_image" value="{{ Auth::user()->image }}">

                            <div class="col-lg-12 mb-5 d-flex justify-content-left" io-image-input="true">

                            <div class="photo me-5">
                                <div class="d-block">
                                    <div class="image-picker">
                                        <img id='image_preview' class="image previewImage" src="{{ my_asset('uploads/users/'. Auth::user()->image) }}">
                                        <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip" data-placement="top"
                                        data-bs-original-title="{{ trans('change_image') }}">
                                            <label>
                                                <i class="bi bi-pencil"></i>

                                                <input id="image" class="image-upload d-none" accept=".png, .jpg, .jpeg" name="image" type="file">
                                            </label>
                                            <div class="invalid-feedback"></div>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            </div>

                            <div class="row g-3">
                              <div class="col-sm-12">
                                  <label class="form-label">{{ trans('name') }}*</label>
                                  <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" placeholder="{{ trans('name') }}">
                                  <div class="invalid-feedback"></div>
                              </div>
                              <div class="col-sm-12">
                                  <label class="form-label">{{ trans('email') }}*</label>
                                  <input type="text" name="email" id="email" value="{{ Auth::user()->email }}" placeholder="{{ trans('email') }}">
                                  <div class="invalid-feedback"></div>
                              </div>
                            </div>
                            <div class="d-flex pt-5">
                              <button type="submit" id="user_profile_btn" class="btn btn-mint me-3">{{ trans('submit') }}</button>
                            </div>
                        </form>

                    </div>
                </div><!--/dashboard-card-->
            </div><!-- Tab content 1 END -->
          @elseif(Route::is('user.password') )
            <div data-aos="fade-up" data-aos-easing="linear">

                <div class="dashboard-card">
                    <div class="dashboard-header">
                        <h4>{{ trans('change_password') }}</h4>
                    </div>
                    <div class="dashboard-body">

                        <!-- Password -->
                        <form id="user_password_form" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-sm-12 mb-4">
                                    <label class="form-label fs-base">{{ trans('current_password') }}</label>
                                    <div class="password-toggle">
                                        <input type="password" name="current_password" id="current_password" placeholder="{{ trans('current_password') }}">
                                        <label class="password-toggle-btn" aria-label="Show/hide password">
                                            <input class="password-toggle-check" id="togglePassword-1" type="checkbox">
                                            <span class="password-toggle-indicator"></span>
                                        </label>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-4">
                                    <label class="form-label fs-base">{{ trans('new_password') }}</label>
                                    <div class="password-toggle">
                                        <input type="password" name="new_password" id="new_password" placeholder="{{ trans('new_password') }}">
                                        <label class="password-toggle-btn" aria-label="Show/hide password">
                                            <input class="password-toggle-check" id="togglePassword-2" type="checkbox">
                                            <span class="password-toggle-indicator"></span>
                                        </label>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-4">
                                    <label class="form-label fs-base">{{ trans('confirm_new_password') }}</label>
                                    <div class="password-toggle">
                                        <input type="password" name="confirm_password" id="confirm_password" placeholder="{{ trans('confirm_new_password') }}">
                                        <label class="password-toggle-btn" aria-label="Show/hide password">
                                            <input class="password-toggle-check" id="togglePassword-3" type="checkbox">
                                            <span class="password-toggle-indicator"></span>
                                        </label>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex mb-3 pt-2">
                            <button type="submit" id="user_password_btn" class="btn btn-mint me-3">{{ trans('submit') }}</button>
                            </div>
                        </form>

                    </div>
                </div><!--/dashboard-card-->
            </div><!-- Tab content 3 END -->

          @endif

        </div>
    </div>
</div>

@endsection


@section('scripts')

<script>

// Toggle Passwords

    $('#togglePassword-1').on('click', function(){
      var passInput=$("#current_password");
      if(passInput.attr('type')==='password')
        {
          passInput.attr('type','text');
      }else{
         passInput.attr('type','password');
      }
    });

    $('#togglePassword-2').on('click', function(){
      var passInput=$("#new_password");
      if(passInput.attr('type')==='password')
        {
          passInput.attr('type','text');
      }else{
         passInput.attr('type','password');
      }
    });

    $('#togglePassword-3').on('click', function(){
    var passInput=$("#confirm_password");
    if(passInput.attr('type')==='password')
        {
        passInput.attr('type','text');
    }else{
        passInput.attr('type','password');
    }
    });


// Image Change
   $(document).on('change', '#image', function () {
     if (isValidFile($(this), '#validationErrorsBox')) {
       displayPhoto(this, '#image_preview');
     }
   });

    $(function() {

       // update user ajax request
       $(document).on('submit', '#user_profile_form', function(e) {
           e.preventDefault();
           start_load();
           const fd = new FormData(this);
           $("#user_profile_btn").text('{{ trans('submitting') }}...');
           $.ajax({
               method: 'POST',
               url: '{{ route('user.profile') }}',
               data: fd,
               cache: false,
               contentType: false,
               processData: false,
               dataType: 'json',
               success: function(response) {
                   end_load();

                   if (response.status == 400) {

                       showError('name', response.messages.name);
                       showError('email', response.messages.email);
                       showError('image', response.messages.image);
                       $("#user_profile_btn").text('{{ trans('submit') }}');

                   }else if (response.status == 200) {

                       tata.success("Success", response.messages, {
                       position: 'tr',
                       duration: 3000,
                       animate: 'slide'
                       });

                       removeValidationClasses("#user_profile_form");
                       $("#user_profile_form")[0].reset();
                       window.location.reload();

                   }else if(response.status == 401){

                       tata.error("Error", response.messages, {
                       position: 'tr',
                       duration: 3000,
                       animate: 'slide'
                       });

                       $("#user_profile_form")[0].reset();
                       window.location.reload();

                   }

               }
           });
       });

       // password ajax request
       $(document).on('submit', '#user_password_form', function(e) {
           e.preventDefault();
           start_load();
           const fd = new FormData(this);
           $("#user_password_btn").text('{{ trans('submitting') }}...');
           $.ajax({
               method: 'POST',
               url: '{{ route('user.password') }}',
               data: fd,
               cache: false,
               contentType: false,
               processData: false,
               dataType: 'json',
               success: function(response) {
                   end_load();

                   if (response.status == 400) {

                       showError('current_password', response.messages.current_password);
                       showError('new_password', response.messages.new_password);
                       showError('confirm_password', response.messages.confirm_password);
                       $("#user_password_btn").text('{{ trans('submit') }}');

                   }else if (response.status == 200) {

                       tata.success("Success", response.messages, {
                       position: 'tr',
                       duration: 3000,
                       animate: 'slide'
                       });

                       removeValidationClasses("#user_password_form");
                       $("#user_password_form")[0].reset();
                       window.location.reload();

                   }else if(response.status == 401){

                       tata.error("Error", response.messages, {
                       position: 'tr',
                       duration: 3000,
                       animate: 'slide'
                       });

                       $("#user_password_form")[0].reset();
                       window.location.reload();

                   }

               }
           });
       });

   });
</script>

@endsection
