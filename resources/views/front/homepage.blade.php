@extends('front.layouts.master')
@section('title','Anasayfa')
@section('content')

    <!-- Main Content-->
    <div class="row">
        <!-- Articles (Left) -->
        <div class="col-md-9">
            @include('front.widgets.articleList')
             
        </div>
        
        <!-- Sidebar (Widget - Right) -->
        <div class="col-md-3">
            @include('front.widgets.categoryWidget')
        </div>
    </div>

@endsection
