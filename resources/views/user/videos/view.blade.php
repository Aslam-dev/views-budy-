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
@endsection

@section('content')

<div class="vine-header mb-4">
    <div class="row">
        <ul class="breadcrumbs breadcrumbs-2">
            <li><a href="{{ route('user.videos.list') }}"><span class="bi bi-youtube me-1"></span>{{ trans('videos') }}</a></li>
            <li>{{ $video->title }}</li>
        </ul>
        <h4 class="mb-2">{{ $video->title }}</h4>
        <p class="small">{{ $video->created_at->diffForHumans() }} / {{ $video->category->name }}</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-5">
        <img class="img-fluid" src="{{ ytThumbnail($video->video_id) }}" alt="Thumbnail">
    </div>
    <div class="col-lg-7">
        <div class="row">
            <div class="col-lg-4">
                <div class="mo-box mb-3">
                    <h4>{{ get_setting('currency_symbol'). round($video->amount_original) }}</h4>
                    <p class="small">{{ trans('original_amount') }}</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mo-box mb-3">
                    <h4>{{ get_setting('currency_symbol'). $video->amount }}</h4>
                    <p class="small">{{ trans('current_amount') }}</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mo-box mb-3">
                    <h4>{{ get_setting('currency_symbol'). round($video->view_cost, 3) }}</h4>
                    <p class="small">{{ trans('cost_per_view') }}</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mo-box mb-3">
                    <h4>{{ $video->view_count }}{{ trans('hrs') }}</h4>
                    <p class="small">{{ trans('view_count') }}</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="mo-box mb-3">
                    <h4>{{ short($video->views()->count()) }}</h4>
                    <p class="small">{{ trans('views') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="dashboard-card">
    <div class="dashboard-header">
        <h4>{{ trans('viewers') }}</h4>
    </div>
    <div class="dashboard-body">
        <div class="table-responsive">
            <!--begin::Table-->
            <table id="datatable_cms" class="table align-middle table-row-dashed gy-4 mb-0">
                <thead>
                    <tr class="border-bottom border-gray-200 gs-0">
                        <th class="min-w-150px">ID</th>
                        <th class="min-w-125px">{{ trans('user') }}</th>
                        <th class="min-w-125px">{{ trans('paid') }}</th>
                        <th class="min-w-125px">{{ trans('date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (App\Models\Earning::where('video_id', $video->id)->get() as $key => $views)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>
                                <img src="{{ my_asset('uploads/users/'.App\Models\User::find($views->user_id)->image) }}" class="img-fluid rounded-circle"
                                width="60px" height="60px" alt="Image">
                                <p class="small mt-1">{{ App\Models\User::find($views->user_id)->name }}</p>
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
