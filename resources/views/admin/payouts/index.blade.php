@extends('layouts.admin')

@section('content')

<main class="content">
    <!-- ========== section start ========== -->
    <section class="section">
      <div class="container-fluid">
      <div class="row mt-50">


        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-md-flex justify-content-between align-items-center mb-10">
                        <h5 class="h4 mb-0">{{ trans('payouts') }}</h5>
                        <div>
                            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">+ {{ trans('add') }}</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable_cms" class="table table-bordered table-reload">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('name') }}</th>
                                <th>{{ trans('transaction_fee') }} %</th>
                                <th class="text-right">{{ trans('options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payouts as $key => $payout)
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td>{{ $payout->name }}</td>
                                    <td>{{ $payout->transaction_fee }}</td>
                                    <td class="text-right">

                                        <a  href="#" id="{{ $payout->id }}" class="btn btn-soft-success btn-icon btn-circle btn-sm btn icon editIcon" title="Edit">
                                            <i class="align-middle" data-feather="edit-2"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="Delete"
                                        onclick="delete_item('{{ route('admin.payouts.destroy') }}','{{ $payout->id }}','{{ trans('delete_this_payout') }}');">
                                            <i class="align-middle" data-feather="trash"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                </div>
            </div>
        </div>


        {{-- add Category modal start --}}
        <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('add_payout') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="model-body">

                    <form id="add_category_form" method="POST">
                        @csrf

                        <div class="row px-3 py-3">
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="name">{{ trans('name') }}</label>
                                    <input type="text" name="name" id="name" placeholder="{{ trans('name') }}" class="form-control my-2">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>{{ trans('transaction_fee') }} %</label>
                                    <input type="number" name="transaction_fee" id="transaction_fee" step=".01" placeholder="{{ trans('transaction_fee') }} %">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('close') }}</button>
                        <button type="submit" id="add_category_btn" class="btn btn-success">{{ trans('submit') }}</button>
                        </div>
                    </form>

                </div>
                </div>
            </div>
        </div>
        {{-- add Category modal end --}}

        {{-- Edit Category modal start --}}
        <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('edit_payout') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="model-body">

                    <form id="edit_category_form" action="" method="POST">
                        @csrf

                        <input type="hidden" name="payout_id" id="payout_id">
                        <input type="hidden" name="old_image" id="old_image">
                        <div class="row px-3 py-3">
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="name">{{ trans('name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control my-2">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>{{ trans('transaction_fee') }} %</label>
                                    <input type="number" name="transaction_fee" id="transaction_fee" step=".01">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('close') }}</button>
                        <button type="submit" id="edit_category_btn" class="btn btn-success">{{ trans('submit') }}</button>
                        </div>
                    </form>

                </div>
                </div>
            </div>
        </div>
        {{-- Edit Category modal end --}}

    </div><!-- row -->
   </div><!-- container -->
  </section>

</main>
@endsection



@section('scripts')

<script>
    $(function() {

        // add category ajax request
        $(document).on('submit', '#add_category_form', function(e) {
            e.preventDefault();
            start_load();
            const fd = new FormData(this);
            $("#add_category_btn").text('{{ trans('submitting') }}...');
            $.ajax({
            url: '{{ route('admin.payouts.add') }}',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {

                end_load();

                if (response.status == 400) {

                    showError('name', response.messages.name);
                    showError('transaction_fee', response.messages.transaction_fee);
                    $("#add_category_btn").text('{{ trans('submit') }}');

                }else if (response.status == 200) {

                    tata.success("Success", response.messages, {
                    position: 'tr',
                    duration: 3000,
                    animate: 'slide'
                    });

                    removeValidationClasses("#add_category_form");
                    $("#add_category_form")[0].reset();
                    $("#addCategoryModal").modal('hide');
                    window.location.reload();

                }else if(response.status == 401){

                    tata.error("Error", response.messages, {
                    position: 'tr',
                    duration: 3000,
                    animate: 'slide'
                    });

                    $("#add_category_form")[0].reset();
                    $("#addCategoryModal").modal('hide');
                    window.location.reload();

                }

            }
            });
        });

        // edit category ajax request
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            start_load();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ route('admin.payouts.edit') }}',
                method: 'get',
                data: {
                id: id,
                },
                success: function(response) {
                    end_load();

                    $('#editCategoryModal').modal('show');

                    $('#edit_category_form #payout_id').val(response.id);
                    $('#edit_category_form #name').val(response.name);
                    $('#edit_category_form #transaction_fee').val(response.transaction_fee);

                }
            });
        });

        // update category ajax request
        $(document).on('submit', '#edit_category_form', function(e) {
            e.preventDefault();
            start_load();
            const fd = new FormData(this);
            $("#edit_category_btn").text('{{ trans('submitting') }}...');
            $.ajax({
                method: 'POST',
                url: '{{ route('admin.payouts.update') }}',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    end_load();

                    if (response.status == 400) {

                        showError('name', response.messages.name);
                        showError('transaction_fee', response.messages.transaction_fee);
                        $("#edit_category_btn").text('{{ trans('submitting') }}');

                    }else if (response.status == 200) {

                        tata.success("Success", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        removeValidationClasses("#edit_category_form");
                        $("#edit_category_form")[0].reset();
                        $("#editCategoryModal").modal('hide');
                        window.location.reload();

                    }else if(response.status == 401){

                        tata.error("Error", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        $("#edit_category_form")[0].reset();
                        $("#editCategoryModal").modal('hide');
                        window.location.reload();

                    }

                }
            });
        });

    });
</script>

@endsection
