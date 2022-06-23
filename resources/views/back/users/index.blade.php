@extends('back.layouts.master')
@section('title','Tüm Kullanıcılar')
@section('content')



  <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold float-right text-primary">Toplam {{$users->count()}} kullanıcı bulunuyor.</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                               
                                    
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kullanıcı ID</th>
                                            <th>Adı</th>
                                            <th>Email Adresi</th>
                                            <th>Oluşturma tarih</th>
                                            <th>Aksiyon</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>{{$user->id}}</td>
                                            <td>{{$user->name}}</th>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->updated_at}}</td>
                                            <td>
                                                <div class="btn-group">
                                                   @if($permission)
                                                    <a href="{{route('admin.users.roles',$user->id)}}" class="btn btn-sm btn-success text-light"><i class="fa fa-drum-steelpan"></i></a>
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
