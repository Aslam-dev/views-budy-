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
        <h4><i class="bi bi-currency-dollar me-2"></i> {{ trans('earnings') }}</h4>
    </div>

    <div class="dashboard-card mb-5 mb-xl-10">
        <div class="dashboard-body p-0">
            <h4>{{ trans('your_earnings') }}</h4>
            <div class="price-price mb-2">
                <span><b>{{ get_setting('currency_symbol') }}{{ Auth::user()->earnings }}</b></span>
            </div>
            <a href="#withdraw-dialog" class="btn btn-red btn-sm ms-2 has-popup"><i class="bi bi-send me-2"></i>{{ trans('withdraw') }}</a>
        </div>
    </div><!--/dashboard-card-->

    <div class="dashboard-card">
        <div class="dashboard-header">
            <h4 class="m-0">{{ trans('earnings_history') }}</h4>
        </div>
        <div class="dashboard-body">
            <div class="table-responsive">
                <!--begin::Table-->
                <table id="datatable_cms" class="table align-middle table-row-dashed gy-4 mb-0">
                    <thead>
                        <tr class="border-bottom border-gray-200 gs-0">
                            <th class="min-w-150px">{{ trans('user_sender') }}</th>
                            <th class="min-w-125px">{{ trans('amount') }}</th>
                            <th class="min-w-125px">{{ trans('date') }}</th>
                            <th class="min-w-125px">{{ trans('status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($earnings as $earning)
                            <tr>
                                <td><img src="{{ my_asset('uploads/users/'.App\Models\User::find($earning->sender_id)->image) }}"
                                    class="img-fluid avatar avatar-rounded me-2" width="40px" height="40px" alt="Image">
                                 {{ App\Models\User::find($earning->sender_id)->name }}
                                </td>
                                <td>{{ get_setting('currency_symbol') . $earning->amount }}</td>
                                <td>{{ \Carbon\Carbon::parse($earning->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                @if ($earning->status === 1)
                                    <td><span class="badge bg-green p-2">{{ trans('active') }}</span></td>
                                @else
                                    <td><span class="badge bg-danger p-2">{{ trans('pending') }}</span></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div id="withdraw-dialog" class="white-popup zoom-anim-dialog mfp-hide">
        <div class="mfp-modal-header">
            <span class="mb-2">
                <img src="{{ my_asset('uploads/users/'.Auth::user()->image) }}" class="rounded-circle" alt="User">
            </span>
            <h4>{{ trans('your_earnings') }} - {{ get_setting('currency_symbol') }}{{ Auth::user()->earnings }}</h4>
        </div>
        <div class="mfp-modal-body py-4">

            <div class="w-100 pt-3 pb-3 px-4">

                <form id="withdraw_form" method="POST">
                    @csrf
                    <div class="input-style-1">
                        <label for="amount">{{ trans('amount') }}</label>
                        <input type="number" name="amount" id="amount" class="my-2" min="{{ trans('minimum_withdraw') }}" placeholder="{{ trans('minimum_withdraw') }} {{ get_setting('currency_symbol') . get_setting('min_withdraw') }}">
                    </div>

                    <button type="submit" class="btn btn-mint w-100 mt-4" id="withdraw_btn"><i class="bi bi-send fs-xl me-2"></i>{{ trans('withdraw') }}</button>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="{{ my_asset('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ my_asset('assets/vendors/datatables/dataTables.bootstrap5.min.js') }}"></script>

<script>

    $('#datatable_cms, #datatable_cms_2').DataTable();


    // Withdraw
    $(document).on('submit', '#withdraw_form', function(e) {
        e.preventDefault();
        start_load();
        const fd = new FormData(this);
        $("#withdraw_btn").text('{{ trans('submitting') }}...');
        $.ajax({
            url: '{{ route('user.withdraw') }}',
            method: 'post',
            data: fd,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {

            end_load();

            if (response.status == 200) {

                tata.success("Success", response.messages, {
                position: 'tr',
                duration: 3000,
                animate: 'slide'
                });

                window.location.reload();

            }else if(response.status == 401){

                tata.error("Error", response.messages, {
                position: 'tr',
                duration: 3000,
                animate: 'slide'
                });

                window.location.reload();

            }

            }
        });
    });

</script>

@endsection
