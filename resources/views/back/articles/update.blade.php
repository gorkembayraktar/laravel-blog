@extends('back.layouts.master')
@section('title',$article->title.' makalesini güncelle')
@section('content')

  

  <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold float-right text-primary"></h6>
                        </div>
                        <div class="card-body">
                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{$error}}
                                </div>
                                @endforeach
                            @endif

                            <form method="POST" action="{{route('admin.makaleler.update',$article->id)}}" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <div class="form-group">
                                    <label for="">Makale Başlığı</label>
                                    <input type="text" name="title" value="{{$article->title}}" class="form-control" id="" />
                                </div>
                                <div class="form-group">
                                    <label for="">Makale Kategori</label>
                                    <select name="category" class="form-control" id="">
                                        
                                        <option value="">Seçim yapınız</option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}" @if($category->id == $article->id) selected @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Makale Fotoğrafı</label>
                                    @if(!empty($article->image))
                                    <img src="{{asset($article->image)}}" height="100" width="100" />
                                    @endif
                                    <input type="file" name="image" class="form-control" />
                                </div>

                                <div class="form-group">
                                    <label for="">Makale İçeriği</label>
                                    <textarea name="content" class="form-control" id="summernote" cols="30" rows="50">{{$article->content}}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Makale oluştur</button>
                                </div>

                            </form>
                        </div>
    </div>
@endsection


@section('css')
<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection


@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
$(document).ready(function() {
  $('#summernote').summernote({
        'height':300
  });
});
</script>

@endsection


