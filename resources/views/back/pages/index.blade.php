@extends('back.layouts.master')
@section('title','Tüm Sayfalar')
@section('content')

  

  <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold float-right text-primary">{{$pages->count()}} sayfa bulundu.</h6>
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                               
                                    
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Resim</th>
                                            <th>Sayfa Başlığı</th>    
                                           
                                            <th>Durum</th>
                                            <th>Aksiyon</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orders">
                                        @foreach($pages as $page)
                                        <tr id="page_{{$page->id}}">
                                            <td><i class="fa fa-arrows-alt handle" style="cursor:move;"></i></td>
                                            <td><img src='{{asset($page->image)}}' height="50" width="50"/></td>
                                        
                                            <td>{{$page->title}}</td>
                                            <td><input type="checkbox" class="toggle-event" data-pageid="{{$page->id}}" data-on="Aktif" data-off="Pasif" data-offstyle="danger" data-onstyle="success" data-toggle="toggle" @if($page->status) checked @endif /></td>
                                    
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{route('page',$page->slug)}}" target="_blank" class="btn btn-sm btn-success text-light"><i class="fa fa-eye"></i></a>
                                                    <a href="{{route('admin.page.update',$page->id)}}" class="btn btn-sm btn-info text-light"><i class="fa fa-pen"></i></a>
                                                   <!-- route http de tanımlı name ile gelir -->
                                                    <a href="{{route('admin.page.delete',$page->id)}}" class="btn btn-sm btn-danger text-light"><i class="fa fa-times"></i></a>
                                                    
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
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js" integrity="sha512-Eezs+g9Lq4TCCq0wae01s9PuNWzHYoCMkE97e2qdkYthpI0pzC3UGB03lgEHn2XM85hDOUF6qgqqszs+iXU4UA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

$("#orders").sortable(
    {
        handle:'.handle',
        update:function(){
            const siralama = $("#orders").sortable('serialize');
            $.get("{{ route('admin.page.orders') }}?"+siralama,function(data,status){
                toastr.success('Sıralama Ayarı.', 'Sıralama kaydedildi.')
            });
        }
    }
);

</script>


<script>

$(function() {

    let adres = "{{route('admin.page.switch')}}";

    $('.toggle-event').change(function() {
       $.get(adres,{id:$(this).data('pageid'),status:$(this).prop('checked')}).then(function(data,text,xhr){
        if(xhr.status === 200){
            toastr.success('Güncellendi', 'Kayıt güncellendi.')
        }
       });
    })
  })

</script>
@endsection