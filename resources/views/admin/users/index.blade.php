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
                        <h5 class="h4 mb-0">{{ trans('users') }}</h5>
                        <div>
                            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">+ {{ trans('add_user') }}</button>
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
                                <th>{{ trans('email') }}</th>
                                <th>{{ trans('role') }}</th>
                                <th>{{ trans('joined') }}</th>
                                <th class="text-right">{{ trans('options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td><img src="{{ my_asset('uploads/users/'.$user->image) }}" class="img-fluid" width="70px" height="60px" alt="Image"></td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td> <span class="badge bg-danger">{{ \Carbon\Carbon::parse($user->created_at)->isoFormat('D MMMM YYYY') }}</span> </td>
                                    <td class="text-right">

                                        @if ($user->deleted == '1')
                                            <span class="badge bg-danger">{{ trans('deleted') }}</span>
                                        @else

                                        <a  href="{{ route('admin.users.view', ['id' => $user->id]) }}" class="btn btn-soft-success btn-icon btn-circle btn-sm btn icon" title="View">
                                            <i class="align-middle" data-feather="eye"></i>
                                        </a>

                                        <a  href="{{ route('admin.users.funds', ['id' => $user->id]) }}" class="btn btn-soft-danger btn-icon btn-circle btn-sm btn icon" title="Funds">
                                            <i class="align-middle" data-feather="dollar-sign"></i>
                                        </a>

                                        <a  href="#" id="{{ $user->id }}'" class="btn btn-soft-success btn-icon btn-circle btn-sm btn icon editIcon" title="Edit">
                                            <i class="align-middle" data-feather="edit-2"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="Delete"
                                        onclick="delete_item('{{ route('admin.users.destroy') }}','{{ $user->id }}','{{ trans('delete_this_user') }}');">
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


        {{-- add User modal start --}}
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
          data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ add('add_user') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="model-body">

                    <form id="add_user_form" action="" method="POST">
                        @csrf

                        <div class="row px-3 py-3">
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="name">{{ trans('name') }}</label>
                                    <input type="text" name="name" id="name" placeholder="Eg. John Doe" class="form-control my-2">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="email">{{ trans('email') }}</label>
                                    <input type="text" name="email" id="email" placeholder="Eg. john@example.com" class="form-control my-2">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="password">{{ trans('password') }}</label>
                                    <input type="text" name="password" id="password" value="password" class="form-control my-2" readonly>
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
                                    <label for="role">{{ trans('role') }}</label>
                                    <select name="role" id="role" class="form-select form-control">
                                        <option value="User">User</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('close') }}</button>
                        <button type="submit" id="add_user_btn" class="btn btn-success">{{ trans('submit') }}</button>
                        </div>
                    </form>

                </div>
                </div>
            </div>
        </div>
        {{-- add User modal end --}}

        {{-- Edit User modal start --}}
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('edit_user') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="model-body">

                    <form id="edit_user_form" action="" method="POST">
                        @csrf

                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="old_image" id="old_image">
                        <div class="row px-3 py-3">
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="name">{{ trans('name') }}</label>
                                    <input type="text" name="edit_name" id="edit_name" placeholder="Eg. John Doe" class="form-control my-2">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="email">{{ trans('email') }}</label>
                                    <input type="text" name="edit_email" id="edit_email" placeholder="Eg. john@example.com" class="form-control my-2">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="password">{{ trans('new_password') }}</label>
                                    <input type="password" name="edit_password" id="edit_password" placeholder="{{ trans('new_password') }}" class="form-control my-2">
                                    <p class="small">{{ trans('leave_this_empty_if_you_do_not_want_to_change') }}</p>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12" id="current_image">
                                <div class="input-style-1">
                                    <label for="symbol">{{ trans('image') }}</label>
                                    <input type="file" name="edit_image" id="edit_image">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label for="role">{{ trans('role') }}</label>
                                    <select name="edit_role" id="edit_role" class="form-select form-control">
                                        <option value="User">User</option>
                                        <option value="Admin">Admin</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>


                        </div>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('close') }}</button>
                        <button type="submit" id="edit_user_btn" class="btn btn-success">{{ trans('submit') }}</button>
                        </div>
                    </form>

                </div>
                </div>
            </div>
        </div>
        {{-- Edit User modal end --}}


    </div><!-- row -->
   </div><!-- container -->
  </section>

</main>
@endsection



@section('scripts')

<script>
    $(function() {

        // add user ajax request
        $(document).on('submit', '#add_user_form', function(e) {
        e.preventDefault();
        start_load();
        const fd = new FormData(this);
        $("#add_user_btn").text('{{ trans('submitting') }}...');
        $.ajax({
            url: '{{ route('admin.users.add') }}',
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
                showError('email', response.messages.email);
                showError('password', response.messages.password);
                showError('image', response.messages.image);
                $("#add_user_btn").text('{{ trans('submit') }}');

            }else if (response.status == 200) {

                tata.success("Success", response.messages, {
                position: 'tr',
                duration: 3000,
                animate: 'slide'
                });

                removeValidationClasses("#add_user_form");
                $("#add_user_form")[0].reset();
                $("#addUserModal").modal('hide');
                window.location.reload();

            }else if(response.status == 401){

                tata.error("Error", response.messages, {
                position: 'tr',
                duration: 3000,
                animate: 'slide'
                });

                $("#add_user_form")[0].reset();
                $("#addUserModal").modal('hide');
                window.location.reload();

            }

            }
        });
        });

        // edit user ajax request
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            start_load();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ route('admin.users.edit') }}',
                method: 'get',
                data: {
                id: id,
                },
                success: function(response) {
                    end_load();

                    $('#editUserModal').modal('show');

                    $('#edit_user_form #edit_name').val(response.name);
                    $('#edit_user_form #edit_email').val(response.email);

                    $('#edit_user_form #current_image').prepend($('<img>',{id:'theImg',src:'../../public/uploads/users/'+response.image,class:'img-fluid mb-3',width:'100px',height:'100px'}));
                    $('#edit_user_form #old_image').val(response.image);
                    $('#edit_user_form #user_id').val(response.id);

                }
            });
        });

        // update user ajax request
        $(document).on('submit', '#edit_user_form', function(e) {
            e.preventDefault();
            start_load();
            const fd = new FormData(this);
            $("#edit_user_btn").text('{{ trans('submitting') }}...');
            $.ajax({
                method: 'POST',
                url: '{{ route('admin.users.update') }}',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    end_load();

                    if (response.status == 400) {


                        showError('edit_name', response.messages.edit_name);
                        showError('edit_email', response.messages.edit_email);
                        showError('edit_password', response.messages.edit_password);
                        showError('edit_image', response.messages.edit_image);
                        $("#edit_user_btn").text('{{ trans('submit') }}');

                    }else if (response.status == 200) {

                        tata.success("Success", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        removeValidationClasses("#edit_user_form");
                        $("#edit_user_form")[0].reset();
                        $("#editUserModal").modal('hide');
                        window.location.reload();

                    }else if(response.status == 401){

                        tata.error("Error", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        $("#edit_user_form")[0].reset();
                        $("#editUserModal").modal('hide');
                        window.location.reload();

                    }

                }
            });
        });

    });
</script>

@endsection
