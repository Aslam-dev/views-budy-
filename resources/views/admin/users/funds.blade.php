@extends('layouts.admin')

@section('content')

<main class="content">
    <!-- ========== section start ========== -->
    <section class="section">
      <div class="container-fluid">
      <div class="row mt-50">

        <div class="col-lg-12">

            <div class="card-style settings-card-2 mb-30">
                <h5 class="h4 mb-3">{{ trans('add_money_to_user_account') }}</h5>
                <form action="{{ route('admin.users.update_funds') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $user->id }}">
                    <div class="row">
                        <div class="col-lg-12 mb-4">

                            <div class="media align-items-center">
                                <div class="media-head me-2">
                                    <img src="{{ my_asset('uploads/users/'.$user->image) }}" alt="user" class="rounded-circle" width="80" height="80">
                                </div>
                                <div class="media-body">
                                    <h5>{{ $user->name }}</h5>
                                    <p class="fs-7">{{ trans('wallet') }} : {{ get_setting('currency_symbol') . $user->wallet }}</p>
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="title">{{ trans('amount') }}</label>
                                <input type="number" name="amount" id="amount" min="1" class="form-control my-2">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                </form>
            </div>
        </div><!-- col-lg-12 -->

    </div><!-- row -->
    </div><!-- container -->
 </section>

</main>
@endsection
