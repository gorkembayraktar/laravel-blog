@extends('front.layouts.master')
@section('title',$article->title)
@section('image',$article->image)
@section('content')
    

        <div class="col-lg-8 col-md-10 mx-auto">
            {{$article->content}}

            <hr>
            <div class="">
                Görüntülenme : {{$article->hit}}
            </div>
        </div>
        
 

  @include('front.widgets.categoryWidget')
@endsection
