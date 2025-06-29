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
                        <h5 class="h4 mb-0">{{ trans('categories') }}</h5>
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
                                <th>{{ trans('image') }}</th>
                                <th>{{ trans('status') }}</th>
                                <th class="text-right">{{ trans('options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $category)
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td><img src="{{ my_asset('uploads/categories/'.$category->image) }}" class="img-fluid" width="70px" height="60px" alt="Image"></td>
                                    @if ($category->status == 1)
                                     <td> <span class="badge bg-success">{{ trans('active') }}</span> </td>
                                    @else
                                    <td> <span class="badge bg-danger">{{ trans('not_active') }}</span> </td>
                                    @endif
                                    <td class="text-right">

                                        @if ($category->status == '2')
                                            <span class="badge bg-danger">{{ trans('deleted') }}</span>
                                        @else

                                        <a  href="#" id="{{ $category->id }}" class="btn btn-soft-success btn-icon btn-circle btn-sm btn icon editIcon" title="Edit">
                                            <i class="align-middle" data-feather="edit-2"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="Delete"
                                        onclick="delete_item('{{ route('admin.categories.destroy') }}','{{ $category->id }}','{{ trans('delete_this_category') }}');">
                                            <i class="align-middle" data-feather="trash"></i>
                                        </a>

                                        @endif

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
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('add_category') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="model-body">

                    <form id="add_category_form" action="" method="POST">
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
                                    <label for="symbol">{{ trans('image') }}</label>
                                    <input type="file" name="image" id="image">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="status">{{ trans('status') }}</label>
                                    <select name="status" id="status" class="form-select form-control">
                                        <option value="1">{{ trans('active') }}</option>
                                        <option value="0">{{ trans('not_active') }}</option>
                                    </select>
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
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('edit_category') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="model-body">

                    <form id="edit_category_form" action="" method="POST">
                        @csrf

                        <input type="hidden" name="category_id" id="category_id">
                        <input type="hidden" name="old_image" id="old_image">
                        <div class="row px-3 py-3">
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="name">{{ trans('name') }}</label>
                                    <input type="text" name="name" id="name" class="form-control my-2">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12" id="current_image">
                                <div class="input-style-1">
                                    <label for="symbol">{{ trans('image') }}</label>
                                    <input type="file" name="image" id="image">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="status">{{ trans('status') }}</label>
                                    <select name="status" id="status" class="form-select form-control">
                                        <option value="1">{{ trans('active') }}</option>
                                        <option value="0">{{ trans('not_active') }}</option>
                                    </select>
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
            url: '{{ route('admin.categories.add') }}',
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
                    showError('image', response.messages.image);
                    showError('status', response.messages.status);
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
                url: '{{ route('admin.categories.edit') }}',
                method: 'get',
                data: {
                id: id,
                },
                success: function(response) {
                    end_load();

                    $('#editCategoryModal').modal('show');

                    $('#edit_category_form #name').val(response.name);

                    $('#edit_category_form #current_image').prepend($('<img>',{id:'theImg',src:'../../public/uploads/categories/'+response.image,class:'img-fluid mb-3',width:'100px',height:'100px'}));
                    $('#edit_category_form #old_image').val(response.image);
                    $('#edit_category_form #category_id').val(response.id);
                    if (response.status == 1) {
                        $("#edit_category_form #status option[value=1]").attr('selected', 'selected');
                    } else {
                        $("#edit_category_form #status option[value=0]").attr('selected', 'selected');
                    }

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
                url: '{{ route('admin.categories.update') }}',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    end_load();

                    if (response.status == 400) {

                        showError('name', response.messages.name);
                        showError('image', response.messages.image);
                        showError('status', response.messages.status);
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
