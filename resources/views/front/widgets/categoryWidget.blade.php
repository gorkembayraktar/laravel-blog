
<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            Kategoriler
        </div>
        <div class="list-group">
            @foreach ($categories as $category )
                <li class="list-group-item @if(Request::segment(2) == $category->slug) active disabled @endif">
                <a href="{{route('kategori',$category->slug)}}">{{$category->name}}</a> <span class="badge badge-info">{{$category->articleCount()}}</span>
                </li>
            @endforeach
        </div>
    </div>
</div>