@extends('back.layouts.master')
@section('title','Tüm Kategoriler')
@section('content')



<div class="row">
    <div class="col-md-4">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Kategori Oluştur</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('admin.category.create')}}">
                    @csrf
                    <div class="form-group">
                        <label for="">Kategori Adı</label>
                        <input type="text" name="category" required class="form-control" >
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm btn-block float-right">Ekle</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Basic Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tüm Kategoriler</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                               
                                    
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Kategori Adı</th>
                                <th>Makale Sayısı </th>
                                <th>Durum </th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{$category->name}}</td>
                                <td>{{$category->articleCount()}}</td>
                                <td><input type="checkbox" class="toggle-event" data-categoryid="{{$category->id}}" data-on="Aktif" data-off="Pasif" data-offstyle="danger" data-onstyle="success" data-toggle="toggle" @if($category->status) checked @endif /></td>
                                <td></td>
                                
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                  
                </div>
            </div>
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

    let adres = "{{route('admin.category.switch')}}";

    $('.toggle-event').change(function() {
       $.get(adres,{id:$(this).data('categoryid'),status:$(this).prop('checked')}).then(function(data,text,xhr){
        if(xhr.status === 200){
            toastr.success('Güncellendi', 'Kategori güncellendi.')
        }
       });
    })
  })

</script>
@endsection