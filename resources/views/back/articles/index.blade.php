@extends('back.layouts.master')
@section('title','Tüm Makaleler')
@section('content')

  

  <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold float-right text-primary">{{$articles->count()}} makale bulundu.</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
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
                                            <td>{{$article->getCategory->name}}</td>
                                            <td>{{$article->title}}</td>
                                            <td>{{substr($article->content,0,100) . '...'}}</td>
                                            <td>{{$article->hit}}</td>
                                            <td>{!!$article->status == 1 ? '<span class="text-success">Aktif</span>':'<span class="text-danger">Pasif</span>'!!}</td>
                                            <td>{{ $article->created_at->diffForHumans()}}</td>
                                            <td>{{$article->updated_at->diffForHumans()}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn btn-sm btn-success text-light"><i class="fa fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-info text-light"><i class="fa fa-pen"></i></a>
                                                    <a class="btn btn-sm btn-danger text-light"><i class="fa fa-times"></i></a>
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