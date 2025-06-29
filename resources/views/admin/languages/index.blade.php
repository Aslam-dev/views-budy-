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
              <a class="nav-link {{ Route::is('admin.languages.index') ? 'active' : '' }} {{ Route::is('admin.languages.edit') ? 'active' : '' }}"
              href="{{ route('admin.languages.index') }}">
                <i class="align-middle me-1" data-feather="layers"></i> {{ trans('languages') }} </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="" data-bs-toggle="modal" data-bs-target="#addLanguageModal">
                <i class="align-middle me-1" data-feather="plus-square"></i> {{ trans('add_language') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link  {{ Route::is('admin.languages.default') ? 'active' : '' }}" href="{{ route('admin.languages.default') }}">
                <i class="align-middle me-1" data-feather="maximize"></i> {{ trans('default_language') }}</a>
            </li>
            <li class="nav-item">
              <a class="nav-link  {{ Route::is('admin.languages.dates') ? 'active' : '' }}" href="{{ route('admin.languages.dates') }}">
                <i class="align-middle me-1" data-feather="calendar"></i> {{ trans('dates_language') }}</a>
            </li>
          </ul>
        </div>
        </div>


          {{-- add Language modal start --}}
          <div class="modal fade" id="addLanguageModal" tabindex="-1" aria-labelledby="exampleModalLabel"
          data-bs-backdrop="static" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{ trans('add_language') }}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="model-body">

                  <form id="add_language_form" action="" method="POST">
                      @csrf

                      <div class="row px-3 py-3">
                          <div class="col-12">
                            <div class="input-style-1">
                                <label for="language">{{ trans('language_name') }}</label>
                                <input type="text" name="language" id="language" placeholder="Eg. English" class="form-control my-2">
                                <div class="invalid-feedback"></div>
                            </div>
                          </div>

                      </div>

                      <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ trans('close') }}</button>
                      <button type="submit" id="add_language_btn" class="btn btn-success">{{ trans('submit') }}</button>
                      </div>
                  </form>

              </div>
              </div>
          </div>
          </div>
          {{-- add Currency modal end --}}


       </div>

       <div class="col-lg-9">


            @if(Route::is('admin.languages.index') )

            <div class="card">
                <div class="card-header">
                    <h3 class="text-muted">{{ trans('languages') }}</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                      <table id="datatable_cms" class="table table-bordered table-reload">
                        <thead>
                            <tr>
                                <th style="width:40%;">{{ trans('language') }}</th>
                                <th>{{ trans('action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($languages as $language)
                            <tr>
                                <td class="ms-3">{{ ucwords($language) }}
                                    @if ($language === App::currentLocale())
                                       <span class="badge bg-danger">{{ trans('default_language') }}</span>
                                    @endif
                                </td>
                                <td class="table-action">
                                    <a href="{{ route('admin.languages.edit', ['language' => $language]) }}" class="btn btn-info">
                                        <i class="align-middle" data-feather="edit-2"></i> {{ trans('edit') }} {{ trans('phrases') }}
                                    </a>
                                    @if ($language != App::currentLocale())
                                    <a href="javascript:void(0)" class="btn btn-danger" onclick="delete_item('{{ route('admin.languages.delete') }}','{{ $language }}','{{ trans('delete_this_language') }}');">
                                        <i class="align-middle" data-feather="trash"></i> {{ trans('delete_language') }}</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>

                </div>
            </div>

            @elseif(Route::is('admin.languages.edit') )

                <div class="card mb-30">
                  <div class="card-header">
                    <h4 class="text-muted">{{ trans('edit') }} {{ ucfirst($language) }} {{ trans('phrases') }}</h4>
                  </div>
                </div>

                <div class="row" style="height: 700px; overflow-y:scroll;">

                    @foreach(openJSONFile($language) as $key => $value)

                    <div class="col-6">
                        <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                @php
                                        $string = strip_tags($key);
                                        if (strlen($string) > 40) {

                                            echo substr($string,0,40).'. . . . . . . .';
                                        }else{
                                            echo $key;
                                        }
                                @endphp
                                </h5>
                                <div class="input-style-1 d-flex justify-content-center">
                                    <input type="text" class="form-control" name="updated_phrase" value="{{ $value }}" id="phrase-{{ $key }}">
                                    <button type="button" class="btn btn-sm btn-success ms-1" id="btn-{{ $key }}"
                                      onclick="updatePhrase('{{ $key }}', '{{ $language }}','{{ route('admin.languages.update') }}','{{ trans('translation_saved') }}')">
                                        <i class="lni lni-checkmark"></i> </button>
                                </div>
                        </div>
                        </div>
                    </div>

                    @endforeach

                </div>

            @elseif(Route::is('admin.languages.default') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.languages.default') }}" method="POST">
                        @csrf
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="language">{{ trans('set_default_language') }}</label>
                                <select name="lang" class="form-select">
                                    @foreach ($languages as $lang)
                                        <option value="{{ $lang }}" {{ App::currentLocale() === $lang ? 'selected' : '' }}>{{ ucfirst($lang) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                    </form>
                </div>

            @elseif(Route::is('admin.languages.dates') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.languages.dates') }}" method="POST">
                        @csrf
                        <div class="col-12">
                            <div class="input-style-1">
                                <label for="language">{{ trans('dates_language') }}</label>
                                <select name="dates_language" class="form-select">
                                    @foreach ($countries as $key => $country)
                                    <option value="{{ $country['code'] }}" {{ get_setting('dates_language') == $country['code'] ? ' selected' : '' }}>{{ $country['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
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


<script>
    $(function() {

      // add language ajax request
      $(document).on('submit', '#add_language_form', function(e) {
        e.preventDefault();
        start_load();
        const fd = new FormData(this);
        $("#add_language_btn").text('{{ add('submitting') }}...');
        $.ajax({
          url: '{{ route('admin.languages.add') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            end_load();

            if (response.status == 400) {

                showError('language', response.messages.language);
                $("#add_language_btn").text('{{ add('submit') }}');

            }else if (response.status == 200) {

                tata.success("Success", response.messages, {
                position: 'tr',
                duration: 3000,
                animate: 'slide'
                });

                removeValidationClasses("#add_language_form");
                $("#add_language_form")[0].reset();
                $("#addLanguageModal").modal('hide');
                window.location.reload();

            }else if(response.status == 401){

                tata.error("Error", response.messages, {
                position: 'tr',
                duration: 3000,
                animate: 'slide'
                });

                $("#add_language_form")[0].reset();
                $("#addLanguageModal").modal('hide');
                window.location.reload();

            }

          }
        });
      });

    });

</script>

@endsection
