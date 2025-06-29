@extends('layouts.user')

@section('content')


<div class="d-flex justify-content-between mb-5">
    <h4><i class="bi bi-youtube me-2"></i> {{ trans('add_video') }}</h4>
    <a href="{{ route('user.videos.list') }}" class="btn btn-sm btn-mint rounded-pill"><i class="bi bi-arrow-left me-2"></i>{{ trans('back') }}</a>
</div>

<div class="dashboard-card">
    <div class="dashboard-body">


        <form id="addpost_form" method="POST">
            <div class="row g-3">
                <div class="col-sm-12">
                    <label class="form-label">{{ trans('title') }}</label>
                    <input type="text" name="title" id="title" placeholder="{{ trans('title') }}">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label">{{ trans('categories') }}</label>
                    <select name="category_id" id="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label">Youtube Video URL</label>
                    <input type="text" name="url" id="url" placeholder="Youtube Video URL">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label">{{ trans('cost_per_view') }} e.g 0.001</label>
                    <input type="number" name="view_cost" id="view_cost" step=".001" placeholder="Cost per View">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label">{{ trans('user') }} {{ trans('view_count') }}</label>
                    <select name="view_count" id="view_count">
                        <option value="1">1 {{ trans('hrs') }}</option>
                        <option value="3">3 {{ trans('hrs') }}</option>
                        <option value="6">6 {{ trans('hrs') }}</option>
                        <option value="9">9 {{ trans('hrs') }}</option>
                        <option value="12">12 {{ trans('hrs') }}</option>
                        <option value="15">15 {{ trans('hrs') }}</option>
                        <option value="24">24 {{ trans('hrs') }}</option>
                    </select>
                    <p class="small text-danger mt-2">{{ trans('user_view_count_instruction') }}</p>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label">{{ trans('amount') }}</label>
                    <input type="number" name="amount" id="amount" min="1" placeholder="Payment Amount">
                    <p class="small text-danger mt-2">{{ trans('amount_instruction') }}</p>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label">{{ trans('show_video_to_public') }}</label>
                    <select name="hidden" id="hidden">
                        <option value="1">{{ trans('show') }}</option>
                        <option value="2">{{ trans('hide') }}</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

            </div>
            <div class="d-flex pt-5">
                <button type="submit" id="addpost_btn" class="btn btn-mint me-3">{{ trans('submit') }}</button>
            </div>
        </form>

    </div>
</div><!--/dashboard-card-->


@endsection


@section('scripts')

<script>

    $(function() {

        // update user ajax request
        $(document).on('submit', '#addpost_form', function(e) {
            e.preventDefault();
            start_load();
            const fd = new FormData(this);
            $("#addpost_btn").text('{{ trans('submitting') }}...');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                    method: 'POST',
                    url: '{{ route('user.videos.add') }}',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        end_load();

                        if (response.status == 400) {

                            showError('title', response.messages.title);
                            showError('url', response.messages.url);
                            showError('view_cost', response.messages.view_cost);
                            showError('view_count', response.messages.view_count);
                            showError('amount', response.messages.amount);

                            $("#addpost_btn").text('{{ trans('submit') }}');

                        }else if (response.status == 200) {

                            tata.success("Success", response.messages, {
                            position: 'tr',
                            duration: 3000,
                            animate: 'slide'
                            });

                            removeValidationClasses("#addpost_form");
                            $("#addpost_form")[0].reset();
                            window.location = '{{ route('user.videos.list') }}';

                        }else if(response.status == 401){

                            tata.error("Error", response.messages, {
                            position: 'tr',
                            duration: 3000,
                            animate: 'slide'
                            });

                            $("#addpost_form")[0].reset();
                            window.location.reload();

                        }

                    }
            });


        });

    });
</script>

@endsection
