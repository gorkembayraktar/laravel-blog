@extends('back.layouts.master')
@section('title','Kullanıcı Rolleri')
@section('content')

  

  <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Profil bilgileri</h6>
                        </div>
                        <div class="card-body">
                           <div class="row">
                                <div class="col">Profil Id:</div>
                                <div class="col-8">{{$user->id}}</div>
                           </div>
                           <div class="row">
                            <div class="col">Profil Adı:</div>
                            <div class="col-8">{{$user->name}}</div>
                       </div>
                        </div>

                        
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Profil Rolleri</h6>
        </div>
        <form method="POST" action="{{route('admin.users.role.update',$user->id)}}">
            @csrf
        <div class="card-body">
  
            <div class="row">
                @foreach ( $roles as  $role)
                <div class="col-md-4 col-6">
                    <input type="checkbox" {{ ($user->roleCount & $role->id) == $role->id ? 'checked' : '' }} name="roles[]" value="{{$role->id}}" id="role_{{$role->id}}" />
                    <label for="role_{{$role->id}}">{{$role->name}}</label>
                </div>
                @endforeach
            </div>

        </div>

        <div class="card-footer">
            <div class="form-group">
                <button type="submit" class="btn btn-primary float-right">Rolleri Kaydet</button>
            </div>
        </div>

        </form>

        
</div>
@endsection
