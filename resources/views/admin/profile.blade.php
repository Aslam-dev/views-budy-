@extends('layouts.admin')

@section('content')

<main class="content">
    <!-- ========== section start ========== -->
    <section class="section">
      <div class="container-fluid">
      <div class="row mt-50">

        <div class="col-lg-8">

            <div class="card-style settings-card-2 mb-30">
                <h3 class="mb-4">{{ add('admin_profile') }}</h3>
                <form id="admin_form" action="" method="POST">
                    @csrf

                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="old_image" id="old_image" value="{{ Auth::user()->image }}">

                    <div class="row">
                        <div class="col-12">
                          <div class="input-style-1">
                            <label>{{ add('name') }}</label>
                            <input type="text" name="name" id="name" value="{{ Auth::user()->name }}">
                            <div class="invalid-feedback"></div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="input-style-1">
                            <label>{{ add('email') }}</label>
                            <input type="text" name="email" id="email" value="{{ Auth::user()->email }}">
                            <div class="invalid-feedback"></div>
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="input-style-1">
                            <label>{{ add('new_password') }}</label>
                            <input type="password" name="password" id="password">
                            <p class="small">{{ add('leave_this_empty_if_you_do_not_want_to_change') }}</p>
                            <div class="invalid-feedback"></div>
                          </div>
                        </div>

                        <div class="col-12">
                          <div class="input-style-1">
                            <label>{{ add('confirm_new_password') }}</label>
                            <input type="password" name="confirm_password" id="confirm_password">
                            <div class="invalid-feedback"></div>
                          </div>
                        </div>

                        <div class="col-lg-12 mb-5 d-flex justify-content-left" io-image-input="true">

                           <div class="photo me-5">
                            <label for="Image" class="form-label">{{ add('image') }}</label>
                            <div class="d-block">
                                <div class="image-picker">
                                    <img id='image_preview' class="image previewImage" src="{{ my_asset('uploads/users/'. Auth::user()->image) }}">
                                    <span class="picker-edit rounded-circle text-gray-500 fs-small" data-bs-toggle="tooltip" data-placement="top" data-bs-original-title="Change Image">
                                        <label>
                                            <svg class="svg-inline--fa fa-pen" id="profileImageIcon" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="pen" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                                <path fill="currentColor" d="M362.7 19.32C387.7-5.678 428.3-5.678 453.3 19.32L492.7 58.75C517.7 83.74 517.7 124.3 492.7 149.3L444.3 197.7L314.3 67.72L362.7 19.32zM421.7 220.3L188.5 453.4C178.1 463.8 165.2 471.5 151.1 475.6L30.77 511C22.35 513.5 13.24 511.2 7.03 504.1C.8198 498.8-1.502 489.7 .976 481.2L36.37 360.9C40.53 346.8 48.16 333.9 58.57 323.5L291.7 90.34L421.7 220.3z">
                                                    </path></svg><!-- <i class="fa-solid fa-pen" id="profileImageIcon"></i> Font Awesome fontawesome.com -->

                                            <input id="image" class="image-upload d-none" accept=".png, .jpg, .jpeg" name="image" type="file">
                                        </label>
                                        <div class="invalid-feedback"></div>
                                    </span>
                                </div>
                            </div>
                         </div>

                        </div>

                        <div class="col-12">
                          <button type="submit" id="admin_btn" class="main-btn primary-btn btn-hover">{{ add('submit') }}</button>
                        </div>
                      </div>

                </form>
            </div>

        </div>


      </div><!-- row -->
    </div><!-- container -->
   </section>

 </main>
 @endsection

 @section('scripts')

 <script>

    $(document).on('change', '#image', function () {
      if (isValidFile($(this), '#validationErrorsBox')) {
        displayPhoto(this, '#image_preview');
      }
    });

     $(function() {

        // update user ajax request
        $(document).on('submit', '#admin_form', function(e) {
            e.preventDefault();
            start_load();
            const fd = new FormData(this);
            $("#admin_btn").text('{{ add('submitting') }}...');
            $.ajax({
                method: 'POST',
                url: '{{ route('admin.profile') }}',
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
                        showError('password', response.messages.password);
                        showError('image', response.messages.image);
                        $("#admin_btn").text('{{ add('submit') }}');

                    }else if (response.status == 200) {

                        tata.success("Success", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        removeValidationClasses("#admin_form");
                        $("#admin_form")[0].reset();
                        window.location.reload();

                    }else if(response.status == 401){

                        tata.error("Error", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        $("#admin_form")[0].reset();
                        window.location.reload();

                    }

                }
            });
        });

    });
</script>

@endsection
