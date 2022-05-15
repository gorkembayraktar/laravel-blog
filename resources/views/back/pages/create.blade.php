@extends('back.layouts.master')
@section('title','Makle Oluştur')
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

                            <form method="POST" action="{{route('admin.makaleler.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="">Makale Başlığı</label>
                                    <input type="text" name="title" class="form-control" id="" />
                                </div>
                                <div class="form-group">
                                    <label for="">Makale Kategori</label>
                                    <select name="category" class="form-control" id="">
                                        
                                        <option value="">Seçim yapınız</option>
                                        @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Makale Fotoğrafı</label>
                                    <input type="file" name="image" class="form-control" required />
                                </div>

                                <div class="form-group">
                                    <label for="">Makale İçeriği</label>
                                    <textarea name="content" class="form-control" id="summernote" cols="30" rows="50"></textarea>
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


