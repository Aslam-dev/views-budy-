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
                <a class="nav-link {{ Route::is('admin.pages.list') ? 'active' : '' }}
                {{ Route::is('admin.pages.edit') ? 'active' : '' }}" href="{{ route('admin.pages.list') }}">
                    <i class="align-middle me-1" data-feather="layers"></i> {{ trans('pages') }} </a>
                </li>
                <li class="nav-item">
                <a class="nav-link
                {{ Route::is('admin.pages.add') ? 'active' : '' }}" href="{{ route('admin.pages.add') }}">
                    <i class="align-middle me-1" data-feather="plus-square"></i> {{ trans('add_page') }}</a>
                </li>
            </ul>
            </div>
         </div>

        </div>

      <div class="col-lg-9">
        @if(Route::is('admin.pages.list') )

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="h4 mb-0">{{ trans('pages') }}</h5>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable_cms" class="table table-bordered table-reload">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('title') }}</th>
                                    <th>{{ trans('description') }}</th>
                                    <th>{{ trans('status') }}</th>
                                    <th class="text-right">{{ trans('options') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pages as $key => $page)
                                    <tr>
                                        <td>{{ ($key+1) }}</td>
                                        <td>{{ $page->title }}</td>
                                        <td>
                                            <a  href="#" id="{{ $page->id }}'" class="btn btn-soft-success btn-icon btn-circle btn-sm btn icon viewIcon" title="{{ trans('view') }}">
                                            <i class="align-middle" data-feather="eye"></i>
                                            </a>
                                        </td>
                                        @if ($page->status == 1)
                                        <td> <span class="badge bg-success">{{ trans('active') }}</span> </td>
                                        @else
                                        <td> <span class="badge bg-danger">{{ trans('not_active') }}</span> </td>
                                        @endif
                                        <td class="text-right">

                                            <a  href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-soft-success btn-icon btn-circle btn-sm btn icon editIcon" title="{{ trans('edit') }}">
                                                <i class="align-middle" data-feather="edit-2"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="Delete"
                                            onclick="delete_item('{{ route('admin.pages.destroy') }}','{{ $page->id }}','{{ trans('delete_this_page') }}');">
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

        @elseif(Route::is('admin.pages.add') )

            <div class="card-style settings-card-2 mb-30">
                <h5 class="h4 mb-3">{{ trans('add_page') }}</h5>
                <form action="{{ route('admin.pages.add') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                        <div class="input-style-1">
                            <label for="title">{{ trans('title') }}</label>
                            <input type="text" name="title" id="title" placeholder="{{ trans('title') }}" class="form-control my-2 @error('title') is-invalid @enderror">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="input-style-1">
                            <label for="symbol">{{ trans('description') }}</label>
                            <textarea name="description" id="body" rows="4" class="@error('description') is-invalid @enderror"></textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="input-style-1">
                            <label for="exchange_rate">{{ trans('status') }}</label>
                            <select name="status" id="status" class="form-select form-control @error('status') is-invalid @enderror">
                                <option value="1">{{ trans('active') }}</option>
                                <option value="0">{{ trans('not_active') }}</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="input-style-1">
                            <label for="title">Meta {{ trans('title') }}</label>
                            <input type="text" name="meta_title" id="meta_title" placeholder="Meta {{ trans('title') }}" class="form-control my-2 @error('meta_title') is-invalid @enderror">
                            @error('meta_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="input-style-1">
                            <label for="keywords">Meta {{ trans('keywords') }}</label>
                            <input type="text" name="meta_keywords" id="meta_keywords" placeholder="Meta {{ trans('keywords') }}" class="form-control my-2 @error('meta_keywords') is-invalid @enderror">
                            @error('meta_keywords')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="input-style-1">
                            <label for="description">Meta {{ trans('description') }}</label>
                            <textarea name="meta_description" rows="3" placeholder="Meta {{ trans('description') }}" class="form-control my-2 @error('meta_description') is-invalid @enderror"></textarea>
                            @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                    </div>
                    <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                </form>
            </div>

        @elseif(Route::is('admin.pages.edit') )

            <div class="card-style settings-card-2 mb-30">
                <h5 class="h4 mb-3">{{ trans('edit_page') }}</h5>
                <form action="{{ route('admin.pages.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $page->id }}">
                    <div class="row">
                        <div class="col-12">
                        <div class="input-style-1">
                            <label for="title">{{ trans('title') }}</label>
                            <input type="text" name="title" id="title" value="{{ $page->title }}" class="form-control my-2 @error('title') is-invalid @enderror">
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="input-style-1">
                            <label for="symbol">{{ trans('description') }}</label>
                            <textarea name="description" id="body" rows="4" class="@error('description') is-invalid @enderror">{{ $page->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="input-style-1">
                            <label for="exchange_rate">{{ trans('status') }}</label>
                            <select name="status" id="status" class="form-select form-control @error('status') is-invalid @enderror">
                                <option value="1" {{ $page->status == 1 ? 'selected' : '' }}>{{ trans('active') }}</option>
                                <option value="0" {{ $page->status == 0 ? 'selected' : '' }}>{{ trans('not_active') }}</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="input-style-1">
                            <label for="title">Meta {{ trans('title') }}</label>
                            <input type="text" name="meta_title" value="{{ $page->meta_title }}" placeholder="Meta Title" class="form-control my-2 @error('meta_title') is-invalid @enderror">
                            @error('meta_title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="input-style-1">
                            <label for="keywords">Meta {{ trans('keywords') }}</label>
                            <input type="text" name="meta_keywords" value="{{ $page->meta_keywords }}" placeholder="Meta Keywords" class="form-control my-2 @error('meta_keywords') is-invalid @enderror">
                            @error('meta_keywords')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                        <div class="col-12">
                        <div class="input-style-1">
                            <label for="description">Meta {{ trans('description') }}</label>
                            <textarea name="meta_description" rows="3" placeholder="Meta Description" class="form-control my-2 @error('meta_description') is-invalid @enderror">{{ $page->meta_description }}</textarea>
                            @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        </div>
                    </div>
                    <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                </form>
            </div>

        @endif

    </div><!-- col-lg-9 -->

    {{-- View Page modal start --}}
    <div class="modal fade" id="viewPageModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    data-bs-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="title"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="model-body p-4">

            <p id="description"></p>

        </div>
        </div>
    </div>
    </div>
    {{-- View Page modal end --}}




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

    $(function() {

        // edit category ajax request
        $(document).on('click', '.viewIcon', function(e) {
            e.preventDefault();
            start_load();
            let id = $(this).attr('id');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{ route('admin.pages.view') }}',
                method: 'get',
                data: {
                id: id,
                },
                success: function(response) {
                    end_load();

                    $('#viewPageModal').modal('show');

                    $('#viewPageModal #title').html(response.title);
                    $('#viewPageModal #description').html(response.description);

                }
            });
        });

    });
</script>

@endsection
