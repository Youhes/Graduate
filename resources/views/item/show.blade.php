@extends('adminlte::page')

@section('title', '詳細画面')

@section('content_header')
    <h1>詳細画面</h1>
@stop

@section('content')
<link rel="stylesheet" href="/css/show.css" >
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
    <div class="row">
        
    <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title" >作成者 {{ $item->user->name }} 　| 　作成日時 {{ $item->updated_at->format('Y.m.d G:i') }} 　| 　最終更新 {{ $item->updated_at->format('Y.m.d G:i') }} </h3>
                    <span></span>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                            <button class="btn btn-outlaine-primary  btn-default" onClick="history.back();">戻る</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="form-group">
                    <label for="date">タイトル：</label><br>
                    <span class= "text">{!! nl2br($item->name) !!}</span>
                    </div>

                    <div class="form-group">
                    <label for="date">場所：</label><br>
                    <span class= "text">{!! nl2br($item->type) !!}</span>
                    </div>

                    <div class="form-group">
                    <label for="date">詳細： </label><br>
                    <span class= "text">{!! nl2br($item->detail) !!}</span>
                    </div>

                    <div class="form-group">
                    <label for="date">画像:</label>
                    </div>
               </div>

   

        <div class="example">
        @if(!empty($item->path1))
        <img src="{{ Storage::disk('s3')->url($item->path1) }}" onerror="this.style.display='none'" alt="登録画像"></img>
        @endif
        @if(!empty($item->path2))
        <img src="{{ Storage::disk('s3')->url($item->path2) }}" onerror="this.style.display='none'" alt="登録画像"></img>   
        @endif
        @if(!empty($item->path3))
        <img src="{{ Storage::disk('s3')->url($item->path3) }}" onerror="this.style.display='none'" alt="登録画像"></img>
        @endif
        @if(!empty($item->path4))
        <img src="{{ Storage::disk('s3')->url($item->path4) }}" onerror="this.style.display='none'" alt="登録画像"></img>
        @endif
        @if(!empty($item->path5))
       <img src="{{ Storage::disk('s3')->url($item->path5) }}" onerror="this.style.display='none'" alt="登録画像"></img>
        @endif
       </div>

    </div>
   

    
@stop


@section('css')
@stop

@section('js')
@stop



