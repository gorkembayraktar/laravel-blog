@extends('back.layouts.master')
@section('title','Profil Ayarları')
@section('content')


<div class="card shadow mb-4">
    <div class="card-header">
        Ayarlar
    </div>      
    <div class="card-body">
            @if(session('update'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
            @endif

         
            @if(!session('passwordErrors'))
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                @endforeach
            @endif
  

            
            <form method="post" action="{{route('admin.profile.update.post')}}">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Adı Soyadı</label>
                            <input type="text" name="name" reqired class="form-control" value="{{auth()->user()->name}}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-success">Email Adresi</label>
                            <input type="text" name="email" reqired class="form-control" value="{{auth()->user()->email}}">
                        </div>
                    </div>
                </div>

              

             
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-success ">Güncelle</button>
                </div>


            </form>
        
    </div>
    
</div>

<div class="card shadow mb-4">
    <div class="card-header">
        Şifre Değiştir
    </div>      
    <div class="card-body">

            @if(session('passwordChange'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
            @endif

            
            @if(session('passerror'))
            <div class="alert alert-danger">
                {{session('passerror')}}
            </div>
            @endif


            @if(session('passwordErrors'))
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{$error}}
                    </div>
                @endforeach
            @endif
       
    
            
            <form method="post" action="{{route('admin.profile.update.password')}}">
                @csrf
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Mevcut Şifre</label>
                            <input type="password"  name="oldpw" reqired class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Şifre</label>
                            <input type="password" name="password" reqired class="form-control" >
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Şifre Kontrol</label>
                            <input type="password" name="password_confirmation" reqired class="form-control" >
                        </div>
                    </div>
                </div>


               
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-success ">Şifre Güncelle</button>
                </div>


            </form>
        
    </div>
    
</div>

@endsection

