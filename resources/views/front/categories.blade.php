@extends('layouts.front')

@section('content')

<div class="vine-header mb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('home') }}"><span class="bi bi-house me-1"></span>{{ trans('home') }}</a></li>
                    <li>{{ trans('categories') }}</li>
                </ul>
                <h2 class="mb-2">{{ trans('categories') }}</h2>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">

        @foreach ($categories as $category)

            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{ route('category', ['slug' => $category->slug]) }}" class="tn-box">
                    <div class="tn-box-inner">
                        <div class="tn-box-thumbnail">
                            <img src="{{ my_asset('uploads/categories/'.$category->image) }}" alt="Icons Images">
                        </div>
                        <div class="tn-box-content">
                            <h3 class="tn-box-title">{{ $category->name }}</h3>
                            <div class="read-more-btn">
                                <span class="tn-box-link">{{ short($category->videos()->count()) }} {{ trans('videos') }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        @endforeach

    </div>
</div>

@endsection
