@extends('layouts.user')

@section('content')


<div class="d-flex justify-content-between mb-5">
    <h4><i class="bi bi-youtube me-2"></i> {{ trans('add_more_money') }}</h4>
    <a href="{{ route('user.videos.list') }}" class="btn btn-sm btn-mint rounded-pill"><i class="bi bi-arrow-left me-2"></i>{{ trans('back') }}</a>
</div>

<div class="dashboard-card">
    <div class="dashboard-body">

        <div>
            <h4 class="text-green">{{ trans('title') }}</h4>
            <p>{{ $video->title }}</p>
            <h4 class="text-green mt-2">{{ trans('current_amount') }}</h4>
            <p>{{ get_setting('currency_symbol'). round($video->amount) }}</p>
        </div>
    </div>
</div>

<div class="dashboard-card">
    <div class="dashboard-body">


        <form id="editpost_form" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-sm-12">
                    <label class="form-label">{{ trans('amount') }}</label>
                    <input type="number" name="amount" id="amount" min="1">
                    <div class="invalid-feedback"></div>
                </div>

            </div>
            <div class="d-flex pt-5">
                <button type="submit" id="editpost_btn" class="btn btn-mint me-3">{{ trans('submit') }}</button>
            </div>
        </form>

    </div>
</div><!--/dashboard-card-->

@endsection


@section('scripts')

<script>
    $(function() {

        // update user ajax request
        $(document).on('submit', '#editpost_form', function(e) {
            e.preventDefault();
            start_load();
            const fd = new FormData(this);
            $("#editpost_btn").text('{{ trans('submitting') }}...');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url: '{{ route('user.videos.topup', ['id' => $video->id]) }}',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    end_load();

                    if (response.status == 400) {

                        showError('amount', response.messages.amount);
                        $("#editpost_btn").text('{{ trans('submit') }}');

                    }else if (response.status == 200) {

                        tata.success("Success", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        removeValidationClasses("#editpost_form");
                        $("#editpost_form")[0].reset();
                        window.location.reload();

                    }else if(response.status == 401){

                        tata.error("Error", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        $("#editpost_form")[0].reset();
                        window.location.reload();

                    }

                }
            });

        });


    });
</script>

@endsection
