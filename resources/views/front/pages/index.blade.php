@extends('layouts.front')

@section('content')


    <div class="vine-header mb-1">
        <ul class="breadcrumbs">
            <li><a href="{{ route('home') }}"><span class="bi bi-house me-1"></span>{{ trans('home') }}</a></li>
            <li>{{ $page->title }}</li>
        </ul>
        <h2 class="tt">{{ $page->title }}</h2>
    </div><!--/vine-header-->

    <div class="vine-page">
        <div class="content">
            {!!  $page->description  !!}
        </div>
    </div>

@endsection
