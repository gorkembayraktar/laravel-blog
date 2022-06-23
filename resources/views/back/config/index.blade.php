@extends('back.layouts.master')
@section('title','Ayarlar')
@section('content')

  

<div class="card shadow mb-4">
        <div class="card-header">
            Ayarlar
        </div>      
        <div class="card-body">
        
                
                <form method="post" action="{{ route('admin.config.update')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Site Başlığı</label>
                                <input type="text" name="title" reqired class="form-control" value="{{$config->title}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-success">Site Aktiflik Durumu</label>
                                <select class="form-control" name="active">
                                    <option @if($config->active == 1) selected @endif value="1">Açık</option>
                                    <option @if($config->active == 0) selected @endif value="0">Kapalı</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Logo</label>
                                <input type="file" name="logo"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Favicon</label>
                                <input type="file" name="favicon" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Facebook</label>
                                <input type="text" name="facebook" class="form-control"  value = "{{$config->facebook}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>İnstagram</label>
                                <input type="text" name="instagram" class="form-control"  value = "{{$config->instagram}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Github</label>
                                <input type="text" name="github" class="form-control" value = "{{$config->github}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Youtube</label>
                                <input type="text" name="youtube" class="form-control"  value = "{{$config->youtube}}">
                            </div>
                        </div>
                    </div>

                    @if(App\Models\UserRole::hasRole("Admin Ayarlarını Düzenle",Auth::user()->roleCount))
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-success ">Güncelle</button>
                    </div>
                    @endif

                </form>
            
        </div>
</div>
@endsection





