@extends('front.layouts.master')
@section('title',$category->name.' kategorisi')
@section('content')
<div class="col-lg-8 col-md-10 mx-auto">

        @include('front.widgets.postsWidget')
        
        <!-- Pager -->
        <div class="clearfix">
            <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a>
        </div>
    </div>
    
    
    @include('front.widgets.categoryWidget')

    @endsection