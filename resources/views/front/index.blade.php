@extends('layouts.front')

@section('content')

<div class="vine-top" style="background-image: linear-gradient( rgba(35, 37, 38, 0.40), rgba(35, 37, 38, 0.40) ), url({{ my_asset('uploads/settings/'.get_setting('home_bg')) }});">
    <div class="vine-top-content">
        <h1 class="vine-top-title mb-2">{{ get_setting('home_title') }}</h1>
        <p class="mb-3 text-white">{{ get_setting('home_sub_title') }}</p>

        @if (Auth::check())
            <!-- Buttons Group -->
            <div class="buttons-group">
                <a href="{{ route('user.videos.add') }}" class="btn btn-lg btn-mint">{{ trans('post_a_video') }}</a>
                <a href="{{ route('user.wallet') }}" class="btn btn-lg btn-border">{{ trans('add_funds') }}</a>
            </div>
        @else
            <!-- Buttons Group -->
            <div class="buttons-group">
                <a href="{{ route('auth.register') }}" class="btn btn-lg btn-mint">{{ trans('join_the_community') }}</a>
                <a href="{{ route('auth.login') }}" class="btn btn-lg btn-border">{{ trans('sign_in') }}</a>
            </div>
        @endif

        <!-- Stats -->
        <div class="stats-box">
            <div>
                <div class="stats-item">5M+</div>
                <p>{{ trans('videos') }}</p>
            </div>
            <svg class="ui" width="14" height="10" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.039 0c.099.006 1.237.621 1.649.787.391.17.735.41 1.067.667.682.515 1.387.995 2.089 1.48.102.071.196.153.284.245l.497-.172 1.76-.342.13-.097a.402.402 0 0 1 .206-.09l.107-.012c.218-.035.677-.132 1.143-.122l1.11-.062c.16-.001 1.67.295 1.691.339a.639.639 0 0 1 .026.129c.018.125-.035.29.09.352.045.022.167.292.084.41l-.137.203a.726.726 0 0 1-.147.164 5.18 5.18 0 0 1-.658.404l-.182.089a.534.534 0 0 0-.257.327c-.046.133-.134.134-.204.189-.376.26-.736.581-1.102.868L11 5.965l.219.284.55.784c.093.129.187.255.286.375.052.073.137.1.147.242.022.324.182.399.314.529.184.179.363.368.528.581.081.107.123.285.179.437.049.138-.138.362-.186.37-.137.023-.128.197-.178.312a.618.618 0 0 1-.058.116c-.03.034-1.375-.105-1.67-.162l-.09-.028-1.004-.368c-.552-.157-1.05-.462-1.167-.498-.117-.043-.19-.173-.275-.278l-1.604-.847c-.138-.113-.294-.199-.433-.311l-.162.083-.174.068c-.8.26-1.602.514-2.39.808-.385.15-.778.278-1.198.327-.439.038-1.692.294-1.788.271a3.114 3.114 0 0 1-.505-.227c-.09-.049-.306-.58-.324-.78-.056-.628.013-1.007.285-.96.11.02.29-.51.395-.536.06-.016.165-.088.287-.182l.334-.266c.157-.126.297-.234.363-.252.697-.205 1.325-.62 2.004-.878l.063-.035.07-.057-.01-.013a.425.425 0 0 0-.094-.115c-.586-.448-1.082-1.031-1.7-1.434-.058-.036-.165-.181-.284-.349L1.55 2.72c-.12-.168-.233-.316-.3-.356-.095-.056-.131-.619-.24-.632C.734 1.696.765 1.31.982.725 1.05.537 1.396.09 1.495.07c.192-.037.38-.07.544-.07Z" fill-rule="evenodd"></path>
            </svg>
            <div>
                <div class="stats-item">100k</div>
                <p>{{ trans('users') }}</p>
            </div>
            <svg class="ui" width="14" height="10" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.039 0c.099.006 1.237.621 1.649.787.391.17.735.41 1.067.667.682.515 1.387.995 2.089 1.48.102.071.196.153.284.245l.497-.172 1.76-.342.13-.097a.402.402 0 0 1 .206-.09l.107-.012c.218-.035.677-.132 1.143-.122l1.11-.062c.16-.001 1.67.295 1.691.339a.639.639 0 0 1 .026.129c.018.125-.035.29.09.352.045.022.167.292.084.41l-.137.203a.726.726 0 0 1-.147.164 5.18 5.18 0 0 1-.658.404l-.182.089a.534.534 0 0 0-.257.327c-.046.133-.134.134-.204.189-.376.26-.736.581-1.102.868L11 5.965l.219.284.55.784c.093.129.187.255.286.375.052.073.137.1.147.242.022.324.182.399.314.529.184.179.363.368.528.581.081.107.123.285.179.437.049.138-.138.362-.186.37-.137.023-.128.197-.178.312a.618.618 0 0 1-.058.116c-.03.034-1.375-.105-1.67-.162l-.09-.028-1.004-.368c-.552-.157-1.05-.462-1.167-.498-.117-.043-.19-.173-.275-.278l-1.604-.847c-.138-.113-.294-.199-.433-.311l-.162.083-.174.068c-.8.26-1.602.514-2.39.808-.385.15-.778.278-1.198.327-.439.038-1.692.294-1.788.271a3.114 3.114 0 0 1-.505-.227c-.09-.049-.306-.58-.324-.78-.056-.628.013-1.007.285-.96.11.02.29-.51.395-.536.06-.016.165-.088.287-.182l.334-.266c.157-.126.297-.234.363-.252.697-.205 1.325-.62 2.004-.878l.063-.035.07-.057-.01-.013a.425.425 0 0 0-.094-.115c-.586-.448-1.082-1.031-1.7-1.434-.058-.036-.165-.181-.284-.349L1.55 2.72c-.12-.168-.233-.316-.3-.356-.095-.056-.131-.619-.24-.632C.734 1.696.765 1.31.982.725 1.05.537 1.396.09 1.495.07c.192-.037.38-.07.544-.07Z" fill-rule="evenodd"></path>
            </svg>
            <div>
                <div class="stats-item">10M</div>
                <p>{{ trans('views') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="tags mb-4">
    <a href="{{ route('categories') }}" class="tag-link green">{{ trans('all_categories') }} <i class="bi bi-arrow-right"></i></a>
    @foreach (App\Models\Admin\Category::where('status', 1)->orderBy('created_at','asc')->limit(10)->get() as $category)
        <a href="{{ route('category', ['slug' => $category->slug]) }}" class="tag-link">{{ $category->name }} ({{ short($category->videos()->count()) }})</a>
    @endforeach
</div>

<div class="videos" id="videos">
    @include('front.videos')
</div><!--/posts-->

@endsection

@section('scripts')
<script>

    $(document).on('click', '#videos .pagination-list a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];

        $.ajax({
            url: "{{ url('/paginate/?page=') }}" + page,
            data: {},
            success: function(response) {
                $('#videos').html(response);

                window.scroll({
                    top: 0, left: 0,
                    behavior: 'smooth'
                });
            }
        });

    });
</script>

@endsection
