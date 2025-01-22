@extends('adminlte::page')

@section('title', '写真管理システム')

@section('content_header')
    <h1>写真管理</h1>
@stop

@section('content')
<link rel="stylesheet" href="/css/style.css" >
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <div class="row">
                    <form id="form1" method="GET" action="{{route('/items/index')}}">
                                    @csrf
                                        <input type="keyword" class="form-control" name="keyword" value="{{ $keyword }}" placeholder="検索キーワード">
                                        <input type="submit" value="検索" class="btn btn-primary" style="color:white">
                                 </form>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">フォルダ一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <a href="{{ url('items/add') }}" class="btn btn-default">新規登録</a>
                            </div>
                        </div>
                    </div>
                </div>

    <ul class="bl_flexContainer">
    @foreach ($items as $item)
    <li class="el_flexItem">
    <button class="card card-skin">
  <div class="card__imgframe"><img src="{{ asset('storage/images/' . basename($item->path1)) }}" alt="" height="150px"></div>
  <div class="card__textbox">
  <li>
    <a href="/items/show/{{ $item->id }}" class="btn btn-outline-primary" margin-bottom="10px">
    詳細
    </a>
    <a href="/items/edit/{{ $item->id }}" class="btn btn-outline-primary">
    編集
    </a></li>
    <div class="card__titletext">
    {!! (Str::limit($item->name, 36, '...')) !!}
    </div>
    
    
    
  </div>
</button>
</li>
       @endforeach
       @if (empty($item))
               キーワードに該当するデータ：0件            
        @endif
</ul>

            </div>
        </div>
    </div>
    {{ $items->appends(request()->query())->links('vendor/pagination.bootstrap-5') }}
@stop


@section('css')
@stop

@section('js')
@stop
