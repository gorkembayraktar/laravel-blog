@extends('back.layouts.master')
@section('title',$page->title.' sayfasını güncelle')
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

                            <form method="POST" action="{{route('admin.page.edit.post',$page->id)}}" enctype="multipart/form-data">
                                @method('POST')
                                @csrf
                                <div class="form-group">
                                    <label for="">Sayfa Başlığı</label>
                                    <input type="text" name="title" value="{{$page->title}}" class="form-control" id="" />
                                </div>
                               
                                <div class="form-group">
                                    <label for="">Sayfa Fotoğrafı</label>
                                    @if(!empty($page->image))
                                    <img src="{{asset($page->image)}}" height="100" width="100" />
                                    @endif
                                    <input type="file" name="image" class="form-control" />
                                </div>

                                <div class="form-group">
                                    <label for="">Sayfa İçeriği</label>
                                    <textarea name="content" class="form-control" id="summernote" cols="30" rows="50">{{$page->content}}</textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Sayfa oluştur</button>
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


