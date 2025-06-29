@extends('layouts.user')

@section('styles')
<link href="{{ my_asset('assets/vendors/datatables/dataTables.bootstrap5.css') }}" rel="stylesheet">
<link href="{{ my_asset('assets/vendors/datatables/jquery.dataTables_them.css') }}" rel="stylesheet">
<style>
    /* Datatable */
    table.dataTable{
        background-color: var(--theme-white) !important;
        color: var(--text-color) !important;
    }
    table.dataTable tbody tr {
        background-color: var(--theme-white) !important;
    }
    .form-select{
        background-color: var(--theme-white) !important;
        color: var(--text-color) !important;
    }
    .form-control{
        background-color: var(--theme-white) !important;
        color: var(--text-color) !important;
    }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_processing,
    .dataTables_wrapper .dataTables_paginate {
        color: var(--text-color) !important;
    }
</style>
    @if (get_setting('site_direction') == 'rtl')
        <style>
            .dataTables_wrapper .dataTables_length {
                float: right !important;
            }
            .dataTables_wrapper .dataTables_filter {
                float: left !important;
                text-align: left !important;
            }
            .dataTables_wrapper .dataTables_paginate {
                float: left !important;
                text-align: left !important;
            }
            .dataTables_wrapper .dataTables_info {
                float: right !important;
            }
        </style>
    @endif
@endsection

@section('content')

    <div class="mb-4">
        <h4><i class="bi bi-eye me-2"></i> {{ trans('viewers') }}</h4>
    </div>

    <div class="dashboard-card">
        <div class="dashboard-body">
            <div class="table-responsive">
                <!--begin::Table-->
                <table id="datatable_cms" class="table align-middle table-row-dashed gy-4 mb-0">
                    <thead>
                        <tr class="border-bottom border-gray-200 gs-0">
                            <th class="min-w-150px">ID</th>
                            <th class="min-w-125px">{{ trans('user') }}</th>
                            <th class="min-w-125px">{{ trans('video') }}</th>
                            <th class="min-w-125px">{{ trans('paid') }}</th>
                            <th class="min-w-125px">{{ trans('date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($viewers as $key => $views)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td>
                                    <img src="{{ my_asset('uploads/users/'.App\Models\User::find($views->user_id)->image) }}" class="img-fluid"
                                    width="70px" height="60px" alt="Image">
                                    <p class="small">{{ App\Models\User::find($views->user_id)->name }}</p>
                                </td>
                                <td>
                                    <a href="{{ route('user.videos.view', ['id' => $views->video_id]) }}">
                                        <img src="{{ ytThumbnail(App\Models\Video::find($views->video_id)->video_id) }}" class="img-fluid" width="130px" height="100px" alt="Image">
                                    </a>
                                    <p class="small">{{ App\Models\Video::find($views->video_id)->title }}</p>
                                </td>
                                <td>{{ get_setting('currency_symbol') . $views->amount }}</td>
                                <td>{{ \Carbon\Carbon::parse($views->created_at)->isoFormat('D MMMM YYYY H:m:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
<script src="{{ my_asset('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ my_asset('assets/vendors/datatables/dataTables.bootstrap5.min.js') }}"></script>

<script>
    $('#datatable_cms').DataTable();
</script>

@endsection
