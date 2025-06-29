@extends('layouts.front')

@section('content')


    <div class="vine-header mb-4">
        <ul class="breadcrumbs">
            <li><a href="{{ route('home') }}"><span class="bi bi-house me-1"></span>{{ trans('home') }}</a></li>
            <li>{{ trans('leaderboard') }}</li>
        </ul>
        <h2 class="mb-2">{{ trans('leaderboard') }}</h2>
    </div><!--/vine-header-->



    <div class="filter mx-0 mb-5">

        <form class="form" id="search_form">
            @csrf
            <div class="filter-toolbar">
                <div class="filter-item" id="numberSort">
                    <label>{{ trans('number') }}</label>
                    <a class="filter-item-content dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <input type="hidden" name="number" id="number" value="">
                        <span class="filter-value"></span>
                        <span class="dropdown-btn"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li value="10" class="selected">{{ trans('show') }} 10 </li>
                        <li value="20">{{ trans('show') }} 20 </li>
                        <li value="30">{{ trans('show') }} 30 </li>
                        <li value="40">{{ trans('show') }} 40 </li>
                        <li value="50">{{ trans('show') }} 50 </li>
                        <li value="100">{{ trans('show') }} 100 </li>
                    </ul>
                </div>

                <!-- Nav Search START -->
                <div class="w-100 mt-3 mb-3">
                    <div class="nav px-4 flex-nowrap align-items-center">
                        <div class="search-form nav-item w-100">
                            <input class="border-0" name="search_term" id="search_term" type="search" placeholder="{{ trans('search') }}" aria-label="Search">
                        </div>
                    </div>
                </div>
                <!-- Nav Search END -->
                <button type="submit" id="search_posts_btn" class="btn btn-md btn-mint">{{ trans('search') }}</button>
            </div>
        </form>
    </div><!--/filter-->

    <div class="leaderboard">
        <div class="row" id="leaderboard">
        </div>
    </div>

@endsection

@section('scripts')
<script>

    //Number Default
    var num_text = $('#numberSort .dropdown-menu li.selected').text();
    var num_value = $('#numberSort .dropdown-menu li.selected').attr('value');
    $('#numberSort input').val(num_value);
    $('#numberSort .filter-value').html(num_text);

    filterPosts();

    $('#numberSort .dropdown-menu li').on('click', function() {
        var value = $(this).attr('value');
        var text = $(this).text();
        var item = $(this);
        item.closest('#numberSort').find('li.selected').removeClass('selected');
        $(this).addClass('selected');
        $('#numberSort').find('input').val(value);
        $('#numberSort').find('.filter-value').html(text);
        filterPosts();
    });

    $(document).on('submit', '#search_form', function(e) {
        e.preventDefault();
        $("#search_posts_btn").text('{{ trans('searching') }}...');
        filterPosts();
    });

    function filterPosts() {

        let number = $('#number').val();
        let search_term = $('#search_term').val();

        let url = "{{ route('leaderboard.sort') }}";
        $.ajax({
            type: "get",
            url: url,
            data: {
                'number': number,
                'search_term': search_term
            },
            success: function(response) {

                $("#search_posts_btn").text('{{ trans('search') }}');

                $('#leaderboard').html(response);
            }
        }).done(function() {
            setTimeout(() => {
                $("#overlay, #overlay2").fadeOut(300);
            }, 500);
        });
    }

    $(document).on('click', '.pagination-list a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        let number = $('#number').val();
        let search_term = $('#search_term').val();

        fetchData(page, number, search_term);
    });

    function fetchData(page, number, search_term) {

        var number = number;
        var search_term = search_term;

        $.ajax({
            url: "{{ url('leaderboard/pagination/?page=') }}" + page,
            data: {
                'number': number,
                'search_term': search_term
            },
            success: function(response) {
                $('#leaderboard').html(response);

                window.scroll({
                    top: 0, left: 0,
                    behavior: 'smooth'
                });
            }
        });
    }

</script>

@endsection
