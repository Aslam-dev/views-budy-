@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" href="{{ my_asset('assets/vendors/trumbowyg/ui/trumbowyg.css') }}">
<link rel="stylesheet" href="{{ my_asset('assets/vendors/trumbowyg/plugins/colors/ui/trumbowyg.colors.min.css') }}">
<link rel="stylesheet" href="{{ my_asset('assets/vendors/trumbowyg/plugins/emoji/ui/trumbowyg.emoji.min.css') }}">
<link rel="stylesheet" href="{{ my_asset('assets/vendors/trumbowyg/plugins/giphy/ui/trumbowyg.giphy.min.css') }}">
<link rel="stylesheet" href="{{ my_asset('assets/vendors/prism/prism.css') }}">
<link rel="stylesheet" href="{{ my_asset('assets/vendors/trumbowyg/plugins/highlight/ui/trumbowyg.highlight.min.css') }}">

@endsection

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
                <a class="nav-link {{ Route::is('admin.email.list') ? 'active' : '' }}
                {{ Route::is('admin.email.edit') ? 'active' : '' }}" href="{{ route('admin.email.list') }}">
                    <i class="align-middle me-1" data-feather="layers"></i> {{ trans('email_templates') }} </a>
                </li>
                <li class="nav-item">
                <a class="nav-link
                {{ Route::is('admin.email.add') ? 'active' : '' }}" href="{{ route('admin.email.add') }}">
                    <i class="align-middle me-1" data-feather="plus-square"></i> {{ trans('add_email_template') }}</a>
                </li>
            </ul>
            </div>
         </div>

        </div>

      <div class="col-lg-9">
        @if(Route::is('admin.email.list') )

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="h4 mb-0">{{ trans('email_templates') }}</h5>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable_cms" class="table table-bordered table-reload">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('name') }}</th>
                                    <th>{{ trans('subject') }}</th>
                                    <th class="text-right">{{ trans('options') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($templates as $key => $template)
                                    <tr>
                                        <td>{{ ($key+1) }}</td>
                                        <td>{{ $template->name }}</td>
                                        <td>{{ $template->subject }}</td>
                                        <td class="text-right">

                                            <a  href="{{ route('admin.email.edit', $template->id) }}" class="btn btn-soft-success btn-icon btn-circle btn-sm btn icon editIcon" title="{{ trans('edit') }}">
                                                <i class="align-middle" data-feather="edit-2"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="Delete"
                                            onclick="delete_item('{{ route('admin.email.destroy') }}','{{ $template->id }}','{{ trans('delete_this_email_template') }}');">
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

        @elseif(Route::is('admin.email.add') )

            <div class="card-style settings-card-2 mb-30">
                <h5 class="h4 mb-3">{{ trans('add_email_template') }}</h5>
                <form id="add_template_form" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="name">{{ trans('name') }}</label>
                                <input type="text" name="name" id="name" placeholder="{{ trans('name') }}" class="form-control my-2">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="subject">{{ trans('subject') }}</label>
                                <input type="text" name="subject" id="subject" placeholder="{{ trans('subject') }}" class="form-control my-2">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-style-1">
                                <label class="form-label">{{ trans('body') }}</label>
                                <span class="text-danger mb-3">{{ trans('data_in_brackets_plus_images_would_be_automatically_replaced') }}.</span>
                                <textarea name="body" id="body" rows="5"></textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="add_template_btn" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                </form>
            </div>

        @elseif(Route::is('admin.email.edit') )

            <div class="card-style settings-card-2 mb-30">
                <h5 class="h4 mb-3">{{ trans('edit_email_template') }}</h5>
                <form id="edit_template_form" method="POST">
                    @csrf
                    <input type="hidden" name="template_id" value="{{ $template->id }}">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="name">{{ trans('name') }}</label>
                                <input type="text" name="name" id="name" value="{{ $template->name }}" class="form-control my-2">
                                <div class="invalid-feedback"></div>
                                <span class="small text-danger">{{ trans('please_do_not_change_this_name') }}, {{ trans('unless_you_will_have_to_change_in_the_code') }}.</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="subject">{{ trans('subject') }}</label>
                                <input type="text" name="subject" id="subject" value="{{ $template->subject }}" class="form-control my-2">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-style-1">
                                <label class="form-label">{{ trans('body') }}</label>
                                <span class="text-danger mb-3">{{ trans('data_in_brackets_plus_images_would_be_automatically_replaced') }}.</span>
                                <textarea name="body" id="body" rows="5">{{ $template->body }}</textarea>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="edit_template_btn" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                </form>
            </div>

        @endif

    </div><!-- col-lg-9 -->




    </div><!-- row -->
   </div><!-- container -->
  </section>

</main>
@endsection



@section('scripts')

<script src="{{ my_asset('assets/vendors/trumbowyg/trumbowyg.min.js') }}"></script>
<!-- Import Trumbowyg plugins... -->
<script src="{{ my_asset('assets/vendors/trumbowyg/plugins/colors/trumbowyg.colors.min.js') }}"></script>
<script src="{{ my_asset('assets/vendors/trumbowyg/plugins/emoji/trumbowyg.emoji.min.js') }}"></script>
<script src="{{ my_asset('assets/vendors/trumbowyg/plugins/giphy/trumbowyg.giphy.min.js') }}"></script>
<script src="{{ my_asset('assets/vendors/prism/prism.js') }}"></script>
<script src="{{ my_asset('assets/vendors/trumbowyg/plugins/highlight/trumbowyg.highlight.min.js') }}"></script>
<script src="{{ my_asset('assets/vendors/trumbowyg/plugins/noembed/trumbowyg.noembed.min.js') }}"></script>
<script src="{{ my_asset('assets/vendors/trumbowyg/plugins/indent/trumbowyg.indent.min.js') }}"></script>
<script src="{{ my_asset('assets/vendors/trumbowyg/plugins/cleanpaste/trumbowyg.cleanpaste.min.js') }}"></script>
<script src="{{ my_asset('assets/vendors/trumbowyg/plugins/pasteimage/trumbowyg.pasteimage.min.js') }}"></script>
<script src="{{ my_asset('assets/vendors/trumbowyg/plugins/upload/trumbowyg.upload.min.js') }}"></script>

<script>
    $(document).ready(function () {

        $('#body').trumbowyg({
            removeformatPasted: true,
            btnsDef: {
                // Create a new dropdown
                image: {
                    dropdown: ['insertImage', 'upload'],
                    ico: 'insertImage'
                }
            },
            btns: [
                ['viewHTML'],
                ['undo', 'redo'], // Only supported in Blink browsers
                ['formatting'],
                ['strong', 'em', 'del'],
                ['superscript', 'subscript'],
                ['indent', 'outdent'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['unorderedList', 'orderedList'],
                ['foreColor', 'backColor'],
                ['horizontalRule'],
                ['removeformat'],
                ['link'],
                ['emoji'],
                ['giphy'],
                ['noembed'],
                ['highlight'],
                ['image']
            ],
            plugins: {
                giphy: {
                    apiKey: 'dNhCbN6hrhpBMxXhIswM34wIR2UBpCns'
                },

                upload: {
                    serverPath: '{{ route('trumb.upload') }}',
                    fileFieldName: 'image',
                    data: [],
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    urlPropertyName: 'file',
                    statusPropertyName: 'success',
                    imageWidthModalEdit: false,
                    success: function (data, trumbowyg, $modal, values) {

                        if (data.status == 200) {

                            var url = data.url;
                            trumbowyg.execCmd('insertImage', url, false, true);
                            var $img = $('img[src="' + url + '"]:not([alt])', trumbowyg.$box);
                            $img.attr('alt', values.alt);
                            setTimeout(function () {
                                trumbowyg.closeModal();
                            }, 250);
                            trumbowyg.$c.trigger('tbwuploadsuccess', [trumbowyg, data, url]);

                        } else if(data.status == 400){

                            trumbowyg.closeModal();

                            tata.error("Error", data.messages, {
                            position: 'tr',
                            duration: 3000,
                            animate: 'slide'
                            });
                        }
                    },
                    error: null
                }
            }
        });

    });
</script>

    @if(Route::is('admin.email.add'))
        <script>
        $(function() {
            // add comment ajax request
            $(document).on('submit', '#add_template_form', function(e) {
                e.preventDefault();

                const fd = new FormData(this);
                $("#add_template_btn").text('{{ trans('submitting') }}...');
                $.ajax({
                    url: '{{ route('admin.email.add') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {

                    if (response.status == 400) {

                        showError('name', response.messages.name);
                        showError('subject', response.messages.subject);
                        showError('body', response.messages.body);
                        $("#add_template_btn").text('{{ trans('submit') }}');

                    }else if (response.status == 200) {

                        tata.success("Success", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        removeValidationClasses("#add_template_form");
                        $("#add_template_form")[0].reset();
                        window.location.reload();

                    }else if(response.status == 401){

                        tata.error("Error", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        $("#add_template_form")[0].reset();
                        window.location.reload();

                    }

                    }
                });
            });

        });
        </script>
    @endif

    @if(Route::is('admin.email.edit'))
      <script>
        $(function() {
            // add comment ajax request
            $(document).on('submit', '#edit_template_form', function(e) {
                e.preventDefault();

                const fd = new FormData(this);
                $("#edit_template_btn").text('{{ trans('submitting') }}...');
                $.ajax({
                    url: '{{ route('admin.email.update') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {

                    if (response.status == 400) {

                        showError('name', response.messages.name);
                        showError('subject', response.messages.subject);
                        showError('body', response.messages.body);
                        $("#edit_template_btn").text('{{ trans('submit') }}');

                    }else if (response.status == 200) {

                        tata.success("Success", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        removeValidationClasses("#edit_template_form");
                        $("#edit_template_form")[0].reset();
                        window.location.reload();

                    }else if(response.status == 401){

                        tata.error("Error", response.messages, {
                        position: 'tr',
                        duration: 3000,
                        animate: 'slide'
                        });

                        $("#edit_template_form")[0].reset();
                        window.location.reload();

                    }

                    }
                });
            });

        });
      </script>

    @endif
@endsection
