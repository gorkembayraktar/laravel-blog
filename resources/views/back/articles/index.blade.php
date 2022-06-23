@extends('back.layouts.master')
@section('title','Tüm Makaleler')
@section('content')

  

  <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold float-right text-primary">{{$articles->count()}} makale bulundu.</h6>
                            <a href="{{route('admin.trashed.article')}}" class="btn btn-sm btn-warning"><i class="fa fa-trash"></i> Geri dönüşüm kutusu</a>
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
                                            <th>Hit</th>
                                            <th>Durum</th>
                                            <th>Oluşturma tarih</th>
                                            <th>Son düzenleme</th>
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
                                            <td>{{$article->hit}}</td>
                                            <td><input type="checkbox" class="toggle-event" data-articleid="{{$article->id}}" data-on="Aktif" data-off="Pasif" data-offstyle="danger" data-onstyle="success" data-toggle="toggle" @if($article->status) checked @endif /></td>
                                            <td>{{ $article->created_at->diffForHumans()}}</td>
                                            <td>{{$article->updated_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{route('single',[$article->getCategory->slug,$article->slug])}}" target="_blank" class="btn btn-sm btn-success text-light"><i class="fa fa-eye"></i></a>
                                                    @if(App\Models\UserRole::hasRole("Makaleleri Düzenle",Auth::user()->roleCount))
                                                    <a href="{{route('admin.makaleler.edit',$article->id)}}" class="btn btn-sm btn-info text-light"><i class="fa fa-pen"></i></a>
                                                   @endif
                                                   @if(App\Models\UserRole::hasRole("Makaleleri Sil",Auth::user()->roleCount))
                                                    <!-- route http de tanımlı name ile gelir -->
                                                    <a href="{{route('admin.article.delete',$article->id)}}" class="btn btn-sm btn-danger text-light"><i class="fa fa-times"></i></a>
                                                   @endif 
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