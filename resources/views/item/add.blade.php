@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
            <form action="{{ '/items/store' }}" method="POST" enctype="multipart/form-data" multiple accept=“image/png,image/jpeg,image/jpg,image/jpe”>
                    @csrf
                    <div class="card-body">

                    <!-- <div class="form-group">
                    <label for="date">日付</label>
                    <input type="date" class="form-control" name="date" id="date" max="today">
                    </div> -->
                    
                        <div class="form-group">
                            <label for="name">タイトル</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="タイトル">
                        </div>

                        <div class="form-group">
                            <label for="type">場所</label>
                            <input type="text" class="form-control" id="type" name="type" placeholder="場所">
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <input type="text" class="form-control" id="detail" name="detail" placeholder="詳細説明">
                        </div>

                         <div class="bl_formGroup">
                         <label for="image1" class="el_label">①画像アップロード</label>
                         <input type="file" class="el_form" id="image1" name="images[]" ></input>
                        <br>
                         <label for="image2" class="el_label">②画像アップロード</label>
                         <input type="file" class="el_form" id="image2" name="images[]"></input>
                         <br>
                         <label for="image3" class="el_label">③画像アップロード</label>
                         <input type="file" class="el_form" id="image3" name="images[]"></input>
                         <br>
                         <label for="image4" class="el_label">④画像アップロード</label>
                         <input type="file" class="el_form" id="image4" name="images[]"></input>
                         <br>
                         <label for="image5" class="el_label">⑤画像アップロード</label>
                         <input type="file" class="el_form" id="image5" name="images[]"></input>
                         
                        
                        <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                         </div>
                         </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
