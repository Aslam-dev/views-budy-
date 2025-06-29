@extends('layouts.admin')


@section('content')

<main class="content">
    <!-- ========== section start ========== -->
    <section class="section">
      <div class="container-fluid">

      <div class="row mt-50">

        <div class="col-lg-6">

            <div class="card-style settings-card-2 mb-30">
                <h3 class="mb-4">{{ trans('mail_settings') }}</h3>
                <form action="{{ route('admin.settings.mail') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-12">
                            <div class="select-style-1">
                                <label>{{ trans('enable_sending_of_emails') }}</label>
                                <div class="select-position">
                                    <select name="enable_emails" class="light-bg">
                                        <option value="Yes" {{ get_setting('enable_emails') == "Yes" ? ' selected' : '' }}>{{ trans('yes') }}</option>
                                        <option value="No" {{ get_setting('enable_emails') == "No" ? ' selected' : '' }}>{{ trans('no') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                          <div class="input-style-1">
                            <label>MAIL MAILER</label>
                            <input type="text" name="mail_mailer" value="{{env('MAIL_MAILER')}}" placeholder="MAIL MAILER" />
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="input-style-1">
                            <label>MAIL HOST</label>
                            <input type="text" name="mail_host" value="{{env('MAIL_HOST')}}" placeholder="MAIL HOST" />
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="input-style-1">
                            <label>MAIL PORT</label>
                            <input type="text" name="mail_port" value="{{env('MAIL_PORT')}}" placeholder="MAIL PORT" />
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="input-style-1">
                            <label>MAIL USERNAME</label>
                            <input type="text" name="mail_username" value="{{env('MAIL_USERNAME')}}" placeholder="MAIL USERNAME" />
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="input-style-1">
                            <label>MAIL PASSWORD</label>
                            <input type="text" name="mail_password" value="{{env('MAIL_PASSWORD')}}" placeholder="MAIL PASSWORD" />
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="input-style-1">
                            <label>MAIL ENCRYPTION</label>
                            <input type="text" name="mail_encryption" value="{{env('MAIL_ENCRYPTION')}}" placeholder="MAIL ENCRYPTION e.g SSL/TLS" />
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="input-style-1">
                            <label>MAIL FROM ADDRESS</label>
                            <input type="text" name="mail_from_address" value="{{env('MAIL_FROM_ADDRESS')}}" placeholder="MAIL FROM ADDRESS" />
                          </div>
                        </div>
                        <div class="col-12">
                          <div class="input-style-1">
                            <label>MAIL FROM NAME</label>
                            <input type="text" name="mail_from_name" value="{{env('MAIL_FROM_NAME')}}" placeholder="MAIL FROM NAME" />
                          </div>
                        </div>

                        <div class="col-12">
                          <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                        </div>
                      </div>

                </form>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">Instructions</h5>
                </div>
                <div class="card-body">
                    <h6 class="text-danger small mb-4">Please be carefull when you are configuring SMTP. For incorrect configuration you will get error at the time of sending emails.</h6>
                    <h6 class="text-muted my-2">For Non-SSL</h6>
                    <ul class="list-group">
                        <li class="list-group-item text-dark">Select sendmail for Mail Driver if you face any issue after configuring smtp as Mail Driver </li>
                        <li class="list-group-item text-dark">Set Mail Host according to your server Mail Client Manual Settings</li>
                        <li class="list-group-item text-dark">Set Mail port as 587</li>
                        <li class="list-group-item text-dark">Set Mail Encryption as ssl if you face issue with tls</li>
                    </ul>
                    <br>
                    <h6 class="text-muted my-2">For SSL</h6>
                    <ul class="list-group mar-no">
                        <li class="list-group-item text-dark">Select sendmail for Mail Driver if you face any issue after configuring smtp as Mail Driver</li>
                        <li class="list-group-item text-dark">Set Mail Host according to your server Mail Client Manual Settings</li>
                        <li class="list-group-item text-dark">Set Mail port as 465</li>
                        <li class="list-group-item text-dark">Set Mail Encryption as ssl</li>
                    </ul>
                </div>
            </div>
        </div>


    </div><!-- row -->
    </div><!-- container -->
    </section>

  </main>

@endsection
