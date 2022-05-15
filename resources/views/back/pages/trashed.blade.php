@extends('back.layouts.master')
@section('title','Silinen Makaleler')
@section('content')

  

  <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold float-right text-primary">{{$articles->count()}} makale bulundu.</h6>
                            <a href="{{route('admin.makaleler.index')}}" class="btn btn-sm btn-info">Makaleler</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                               
                                    
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Resim</th>
                                            <th>Kategori Adı</th>
                                            <th>Başlık</th>
                                            <th>İçerik</th>
                                            <th>Silinme tarih</th>
                                            <th>Aksiyon</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($articles as $article)
                                        <tr>
                                            <td><img src='{{asset($article->image)}}' height="50" width="50"/></td>
                                            <td>{{$article->getCategory->name}}</td>
                                            <td>{{$article->title}}</td>
                                            <td>{{substr( strip_tags($article->content),0,100) . '...'}}</td>
                                            <td>{{ $article->deleted_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{route('admin.article.recover',$article->id)}}" class="btn btn-sm btn-primary text-light">Kurtar</a>
                                                    <a href="{{route('admin.article.delete.force',$article->id)}}" class="btn btn-sm btn-danger text-light"><i class="fa fa-times"></i></a>
                                                   
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                              
                            </div>
                        </div>
    </div>
@endsection


@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection



@section('javascript')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script>

$(function() {

    let adres = "{{route('admin.switch')}}";

    $('.toggle-event').change(function() {
       $.get(adres,{id:$(this).data('articleid'),status:$(this).prop('checked')}).then(function(data,text,xhr){
        if(xhr.status === 200){
            toastr.success('Güncellendi', 'Kayıt güncellendi.')
        }
       });
    })
  })

</script>
@endsection