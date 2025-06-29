@extends('layouts.admin')


@section('content')

<main class="content">
    <!-- ========== section start ========== -->
    <section class="section">
     <div class="container-fluid">
      <div class="row mt-50">

        <div class="col-lg-3">

            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.auth.google') ? 'active' : '' }}" href="{{ route('admin.auth.google') }}">
                            Google </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.auth.facebook') ? 'active' : '' }}" href="{{ route('admin.auth.facebook') }}">
                            Facebook </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.auth.email') ? 'active' : '' }}" href="{{ route('admin.auth.email') }}">
                            {{ trans('email_verification') }} </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.auth.recaptcha') ? 'active' : '' }}" href="{{ route('admin.auth.recaptcha') }}">
                            Google Recaptcha</a>
                        </li>
                    </ul>
                </div>
            </div>


        </div>

        <div class="col-lg-9">

            @if(Route::is('admin.auth.google') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.auth.google') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                             <div class="select-style-1">
                                <label>{{ trans('enable_google_login') }}</label>
                                <div class="select-position">
                                    <select name="google_active" class="light-bg">
                                        <option @if (get_setting('google_active') == 'Yes') selected="selected" @endif value="Yes">{{ trans('yes') }}</option>
                                        <option @if (get_setting('google_active') == 'No') selected="selected" @endif value="No">{{ trans('no') }}</option>
                                    </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Client ID</label>
                                    <input type="text" name="google_client_id" value="{{ get_setting('google_client_id') }}" placeholder="Client ID" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Secret ID</label>
                                    <input type="text" name="google_secret" value="{{ get_setting('google_secret') }}" placeholder="Secret ID" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Redirect URI</label>
                                    <input type="text" name="google_redirect_uri" value="{{ get_setting('google_redirect_uri') }}" placeholder="Redirect URI" />
                                    <p class="mt-2">redirect to <strong>your website/google/callback</strong></p>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            @elseif(Route::is('admin.auth.facebook') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.auth.facebook') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                            <div class="select-style-1">
                                <label>{{ trans('enable_facebook_login') }}</label>
                                <div class="select-position">
                                    <select name="facebook_active" class="light-bg">
                                        <option @if (get_setting('facebook_active') == 'Yes') selected="selected" @endif value="Yes">{{ trans('yes') }}</option>
                                        <option @if (get_setting('facebook_active') == 'No') selected="selected" @endif value="No">{{ trans('no') }}</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Client ID</label>
                                    <input type="text" name="facebook_client_id" value="{{ get_setting('facebook_client_id') }}" placeholder="Client ID" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Secret ID</label>
                                    <input type="text" name="facebook_secret" value="{{ get_setting('facebook_secret') }}" placeholder="Secret ID" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Redirect URI</label>
                                    <input type="text" name="facebook_redirect_uri" value="{{ get_setting('facebook_redirect_uri') }}" placeholder="Redirect URI">
                                    <p class="mt-2">redirect to <strong>your website/facebook/callback</strong></p>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            @elseif(Route::is('admin.auth.email') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.auth.email') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="select-style-1">
                                    <label>{{ trans('enable_email_verification') }}</label>
                                    <div class="select-position">
                                        <select name="email_verification" class="light-bg">
                                            <option @if (get_setting('email_verification') == 'Yes') selected="selected" @endif value="Yes">{{ trans('yes') }}</option>
                                            <option @if (get_setting('email_verification') == 'No') selected="selected" @endif value="No">{{ trans('no') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            @elseif(Route::is('admin.auth.recaptcha') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.auth.recaptcha') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                            <div class="select-style-1">
                                <label>{{ trans('enable_google_recaptcha') }}</label>
                                <div class="select-position">
                                    <select name="recaptcha_active" class="light-bg">
                                        <option @if (get_setting('recaptcha_active') == 'Yes') selected="selected" @endif value="Yes">Yes</option>
                                        <option @if (get_setting('recaptcha_active') == 'No') selected="selected" @endif value="No">No</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Google Recaptcha Site Key</label>
                                    <input type="text" name="recaptcha_site" value="{{ get_setting('recaptcha_site') }}" placeholder="Site Key" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Google Recaptcha Secret Key</label>
                                    <input type="text" name="recaptcha_secret" value="{{ get_setting('recaptcha_secret') }}" placeholder="Secret Key" />
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            @endif

        </div>

      </div>
     </div>
    </section>
</main>

@endsection
