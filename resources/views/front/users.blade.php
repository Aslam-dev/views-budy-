@extends('layouts.front')

@section('content')

    <div class="vine-header mb-4">
        <ul class="breadcrumbs">
            <li><a href="{{ route('home') }}"><span class="bi bi-house me-1"></span>{{ trans('home') }}</a></li>
            <li>{{ trans('users') }}</li>
        </ul>
        <h2 class="mb-2">{{ trans('users') }}</h2>
    </div><!--/vine-header-->

    <div class="filter mx-0">
        <form class="form" id="search_form">
            @csrf
            <div class="filter-toolbar">
                <div class="filter-item" id="sorting">
                    <label>{{ trans('sorting') }}</label>
                    <a class="filter-item-content dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <input type="hidden" name="sort" id="sort" value="">
                        <span class="filter-value"></span>
                        <span class="dropdown-btn"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li value="all" class="selected">{{ trans('all') }}</li>
                        <li value="recent">{{ trans('recent') }} </li>
                        <li value="creators">{{ trans('creators') }}</li>
                        <li value="users">{{ trans('users') }}</li>
                    </ul>
                </div>
                <div class="filter-item" id="numberSort">
                    <label>{{ trans('number') }}</label>
                    <a class="filter-item-content dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <input type="hidden" name="number" id="number" value="">
                        <span class="filter-value"></span>
                        <span class="dropdown-btn"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li value="12" class="selected">{{ trans('show') }} 12 </li>
                        <li value="24">{{ trans('show') }} 24 </li>
                        <li value="36">{{ trans('show') }} 36 </li>
                        <li value="48">{{ trans('show') }} 48 </li>
                        <li value="60">{{ trans('show') }} 60 </li>
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

    <div class="users mt-5">
        <div class="row" id="users_data">
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

    //Sorting Default
    var sort_text = $('#sorting .dropdown-menu li.selected').text();
    var sort_value = $('#sorting .dropdown-menu li.selected').attr('value');
    $('#sorting input').val(sort_value);
    $('#sorting .filter-value').html(sort_text);

    filterUsers();

    $('#sorting .dropdown-menu li').on('click', function() {
        var value = $(this).attr('value');
        var text = $(this).text();
        var item = $(this);
        item.closest('#sorting').find('li.selected').removeClass('selected');
        $(this).addClass('selected');
        $('#sorting').find('input').val(value);
        $('#sorting').find('.filter-value').html(text);
        filterUsers();
    });

    $('#numberSort .dropdown-menu li').on('click', function() {
        var value = $(this).attr('value');
        var text = $(this).text();
        var item = $(this);
        item.closest('#numberSort').find('li.selected').removeClass('selected');
        $(this).addClass('selected');
        $('#numberSort').find('input').val(value);
        $('#numberSort').find('.filter-value').html(text);
        filterUsers();
    });

    $(document).on('submit', '#search_form', function(e) {
        e.preventDefault();
        $("#search_posts_btn").text('{{ trans('searching') }}...');
        filterUsers();
    });

    function filterUsers() {

        let sort = $('#sort').val();
        let number = $('#number').val();
        let search_term = $('#search_term').val();

        let url = "{{ route('users.sort') }}";
        $.ajax({
            type: "get",
            url: url,
            data: {
                'number': number,
                'sort': sort,
                'search_term': search_term
            },
            success: function(response) {

                $('#users_data').html(response);

                $("#search_posts_btn").text('Search');
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
        let sort = $('#sort').val();
        let number = $('#number').val();
        let search_term = $('#search_term').val();

        fetchData(page, sort, number, search_term);
    });

    function fetchData(page, sort, number, search_term) {

        var sort = sort;
        var number = number;
        var search_term = search_term;

        $.ajax({
            url: "{{ url('users/pagination/?page=') }}" + page,
            data: {
                'sort': sort,
                'number': number,
                'search_term': search_term
            },
            success: function(response) {

                $('#users_data').html(response);

                window.scroll({
                    top: 0, left: 0,
                    behavior: 'smooth'
                });
            }
        });
    }

</script>

@endsection
