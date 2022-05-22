@extends('back.layouts.master')
@section('title','Profil Ayarları')
@section('content')


<div class="card shadow mb-4">
    <div class="card-header">
        Ayarlar
    </div>      
    <div class="card-body">
    
       
        <div class="row">
            <div class="col-sm">Adı Soyadı</div>
            <div class="col">{{auth()->user()->name}}</div>
        </div>
        <div class="row">
            <div class="col-sm">Email Adresi</div>
            <div class="col">{{auth()->user()->email}}</div>
        </div>
        <div class="form-group">
            <a href="{{ route('admin.profile.update')}}" class="btn btn-sm btn-success ">Güncelle</a>
        </div>

    </div>
</div>

@endsection

