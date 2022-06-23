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
                                <td>
                                    @if(App\Models\UserRole::hasRole("Kategorileri Düzenle",Auth::user()->roleCount))
                                    <a data-category-id="{{$category->id}}"  title="Kategoriyi düzenle" class="btn btn-sm btn-primary edit-click"><i class="fa fa-edit text-white"></i></a>
                                    @endif
                                    @if(App\Models\UserRole::hasRole("Kategorileri Sil",Auth::user()->roleCount))
                                    <a data-category-name="{{$category->name}}" data-category-id="{{$category->id}}" data-category-count="{{$category->articleCount()}}" title="Kategoriyi sil" class="btn btn-sm btn-danger remove-click"><i class="fa fa-times text-white"></i></a>
                                    @endif
                                </td>
                                
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                  
                </div>
            </div>
        </div>
    </div>

</div>


  <!-- Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="post" action="{{route('admin.category.update')}}">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Kategoriyi Düzenle</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
                @csrf
                <div class="form-group">
                    <label>Kategori Adı</label>
                    <input id="kategori" type="text" class="form-control" name="category" />
                    <input id="kategori_id" name="id" type="hidden" />
                </div>
                <div class="form-group">
                    <label>Kategori Slug</label>
                    <input id="slug" type="text" class="form-control" name="slug" />
                </div>
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
          <input type="submit" class="btn btn-success" value="Kaydet" />
        </div>
    </form>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kategoriyi Sil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
        </div>
        <div id="alertbody" class="modal-body">
            <div id="articleAlert" class="alert alert-danger"></div>
        </div>
        <div class="modal-footer">
            <form method="post" action="{{route('admin.category.delete')}}">
            @csrf 
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
             <input type="hidden" name="id" id="delete_id" />
             <input id="deleteBtn" type="submit" class="btn btn-danger" value="Sil" />
            </form>
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

    $(".remove-click").click(function(){
      
        let id = $(this).data('category-id');
        let count = $(this).data('category-count');
        let name = $(this).data('category-name');

        if(id == 1){
            $("#articleAlert").html(`${name} kategorisi sabit bir kategoridir. Silinen diğer kategoriler bu kategoriye aktarılacaktır.` );
            $('#alertbody').show();
            $("#deleteBtn").hide();
            $("#deleteModal").modal();
            return;
        }else{
            $("#deleteBtn").show();
        }


        $("#delete_id").val(id);

        if(count > 0){
            $("#articleAlert").html(`${name} kategorisine ait ${count} makale bulunmaktır. Silmek istediğinize emin misiniz ?` );
            $('#alertbody').show();
        }else{
            $('#alertbody').hide();
            $("#articleAlert").html('');
        }
        $("#deleteModal").modal();
        /*$.ajax({
            type:'GET',
            
            url:'{{route('admin.category.getdata')}}',
            data:{id:id},
            dataType: "json",

            success:function(data){
                $("#kategori").val(data.name);
                $("#slug").val(data.slug);
                $("#kategori_id").val(data.id);
                $("#editModal").modal();

            },
            error:function(data){
                // hata durumunda yapılacakalar etc
            }
        });*/
    });
    

    $(".edit-click").click(function(){
        let id = $(this).data('category-id');

        $.ajax({
            type:'GET',
            
            url:'{{route('admin.category.getdata')}}',
            data:{id:id},
            dataType: "json",

            success:function(data){
                $("#kategori").val(data.name);
                $("#slug").val(data.slug);
                $("#kategori_id").val(data.id);
                $("#editModal").modal();

            },
            error:function(data){
                // hata durumunda yapılacakalar etc
            }
        });
    });


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