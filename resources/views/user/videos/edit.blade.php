@extends('layouts.user')

@section('content')


<div class="d-flex justify-content-between mb-5">
    <h4><i class="bi bi-youtube me-2"></i> {{ trans('edit_video') }}</h4>
    <a href="{{ route('user.videos.list') }}" class="btn btn-sm btn-mint rounded-pill"><i class="bi bi-arrow-left me-2"></i>{{ trans('back') }}</a>
</div>

<div class="dashboard-card">
    <div class="dashboard-body">


        <form id="editpost_form" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-sm-12">
                    <label class="form-label">{{ trans('title') }}</label>
                    <input type="text" name="title" id="title" value="{{ $video->title }}">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label">{{ trans('categories') }}</label>
                    <select name="category_id" id="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $video->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label">Youtube Video URL</label>
                    <input type="text" name="url" id="url" value="{{ $video->url }}">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label">{{ trans('cost_per_view') }} e.g 0.001</label>
                    <input type="number" name="view_cost" id="view_cost" step=".001" value="{{ $video->view_cost }}">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label">User View Count</label>
                    <select name="view_count" id="view_count">
                        <option value="1" {{ $video->view_count == '1' ? 'selected' : '' }}>1 {{ trans('hrs') }}</option>
                        <option value="3" {{ $video->view_count == '3' ? 'selected' : '' }}>3 {{ trans('hrs') }}</option>
                        <option value="6" {{ $video->view_count == '6' ? 'selected' : '' }}>6 {{ trans('hrs') }}</option>
                        <option value="9" {{ $video->view_count == '9' ? 'selected' : '' }}>9 {{ trans('hrs') }}</option>
                        <option value="12" {{ $video->view_count == '12' ? 'selected' : '' }}>12 {{ trans('hrs') }}</option>
                        <option value="15" {{ $video->view_count == '15' ? 'selected' : '' }}>15 {{ trans('hrs') }}</option>
                        <option value="24" {{ $video->view_count == '24' ? 'selected' : '' }}>24 {{ trans('hrs') }}</option>
                    </select>
                    <p class="small text-danger mt-2">{{ trans('user_view_count_instruction') }}</p>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label">{{ trans('show_video_to_public') }}</label>
                    <select name="hidden" id="hidden">
                        <option value="1" {{ $video->hidden == '1' ? 'selected' : '' }}>{{ trans('show') }}</option>
                        <option value="2"{{ $video->hidden == '2' ? 'selected' : '' }}>{{ trans('hide') }}</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="col-sm-12">
                    <label class="form-label">{{ trans('amount_paid') }}</label>
                    <input type="number" name="amount" id="amount" value="{{ round($video->amount_original) }}" readonly>
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
                url: '{{ route('user.videos.edit', ['id' => $video->id]) }}',
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
