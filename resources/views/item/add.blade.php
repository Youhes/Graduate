@extends('adminlte::page')

@section('title', '登録画面')

@section('content_header')
    <h1>登録画面</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                </div>
            @endif -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">新規登録</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
            <div class="input-group-append">
                            <button class="btn btn-outlaine-primary  btn-default" onClick="history.back();">戻る</button>
                            </div>
                            </div>
                        </div>
                    </div>
                

          
            <form action="{{ '/items/store' }}" method="post" enctype="multipart/form-data" multiple accept=“image/png,image/jpeg,image/jpg,image/jpe”>
                    @csrf
                    <div class="card-body">

                    <!-- <div class="form-group">
                    <label for="date">日付</label>
                    <input type="date" class="form-control" name="date" id="date" max="today">
                    </div> -->
                    
                        <div class="form-group">
                            <label for="name">タイトル</label>
                            <textarea class="form-control" id="name" name="name" placeholder="タイトル"></textarea>
                       @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror 
                        </div>

                        <div class="form-group">
                            <label for="type">場所</label>
                            <textarea class="form-control" id="type" name="type" placeholder="場所"></textarea>
                            @error('type')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror 
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <textarea class="form-control" id="detail" name="detail" placeholder="詳細説明"></textarea>
                            @error('detail')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror 
                        </div>

                         <div class="bl_formGroup">
                         <label for="image1" class="el_label">画像アップロード</label>
                         <input type="file" class="el_form" id="image1" name="images[]" ></input>
                        <br>
                         <label for="image2" class="el_label">画像アップロード</label>
                         <input type="file" class="el_form" id="image2" name="images[]"></input>
                         <br>
                         <label for="image3" class="el_label">画像アップロード</label>
                         <input type="file" class="el_form" id="image3" name="images[]"></input>
                         <br>
                         <label for="image4" class="el_label">画像アップロード</label>
                         <input type="file" class="el_form" id="image4" name="images[]"></input>
                         <br>
                         <label for="image5" class="el_label">画像アップロード</label>
                         <input type="file" class="el_form" id="image5" name="images[]"></input><br>
                         <span>※画像は最大5枚までアップロードできます。</span>
                         @error('images.*')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror 
                        
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
