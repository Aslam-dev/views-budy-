@extends('layouts.admin')

@section('content')

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3"><strong>{{ add('admin_dashboard') }}</strong></h1>

        <div class="row">

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">{{ trans('users') }}</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="users"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ App\Models\User::count() }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">{{ trans('videos') }}</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="columns"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ App\Models\Video::count() }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">{{ trans('views') }}</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="menu"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ App\Models\Earning::count() }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">{{ trans('deposits') }}</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ get_setting('currency_symbol'). App\Models\Fund::sum('amount') }}</h1>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col mt-0">
                                <h5 class="card-title">{{ trans('user') }} {{ trans('earnings') }}</h5>
                            </div>

                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="align-middle" data-feather="dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                        <h1 class="mt-1 mb-3">{{ get_setting('currency_symbol'). App\Models\Earning::sum('amount') }}</h1>
                    </div>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-lg-9">
                <div class="card flex-fill w-100">
                    <div class="card-header">

                        <h5 class="card-title mb-0">{{ trans('views') }}</h5>
                    </div>
                    <div class="card-body py-3">
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>


@endsection

@section('scripts')
<script src="{{ my_asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
<script>
    $(document).ready(function () {

        "use strict";

        /* ==========================================================================
        ApexChart Line Graph
        ========================================================================== */

        var options = {
            series: [{
                name: "{{ trans("views") }}",
                data: {{ $views }}
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            grid: {
                row: {
                    colors: ['transparent', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            colors: ['#1BC5BD']
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();


    });
</script>
@endsection

