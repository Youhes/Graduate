@extends('adminlte::page')

@section('title', '編集画面')

@section('content_header')
    <h1>編集画面</h1>
@stop

@section('content')
 <link rel="stylesheet" href="/css/edit.css" >
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
    <div class="row"> 
    <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">作成日時：{{ $item->updated_at->format('Y.m.d G:i') }}</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                            <button class="btn btn-outlaine-primary btn btn-default" onClick="history.back();">戻る</button>
                            </div>
                        </div>
                    </div>
                </div>
               
                <form method="POST" action="/items/{{ $item->id }}" id="update-item-{{ $item->id }}" enctype="multipart/form-data" >
                @csrf
                <div class="card-body">
                <!-- タイトル -->
                <div class="form-group">
                <label for="name" class="form-label">タイトル</label>
                <textarea name="name" id="name" class="form-control w-100">{{ old('name', $item->name) }}</textarea>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                 @enderror
                </div>

                <!-- 場所 -->
                <div class="form-group">
                <label for="type" class="form-label">場所</label>
                <textarea name="type" id="type" class="form-control w-100">{{ old('type', $item->type) }}</textarea>
                @error('type')
                <div class="text-danger">{{ $message }}</div>
                 @enderror
                </div>

                <!-- 詳細詳細 -->
                <div class="form-group">
                <label for="detail" class="form-label">詳細</label>
                <textarea name="detail" id="detail" class="form-control w-100">{{ old('detail', $item->detail) }}</textarea>
                @error('detail')
                <div class="text-danger">{{ $message }}</div>
                 @enderror
                </div>

                <!--画像-->
                <div class="bl_formGroup">
                <div class="example">
                        @if(!empty($item->path1))
                        <label for="image1" class="el_label">下の画像を変更</label>
                         <input type="file" class="el_form" id="image1" name="image1"></input><br>
                        <img src="{{ Storage::disk('s3')->url($item->path1) }}" onerror="this.style.display='none'" alt="登録画像"></img>
                        @else
                        <label for="image1" class="el_label">画像を追加</label>
                        <input type="file" class="el_form" id="image1" name="image1"></input>
                        @endif
                </div> 
                         
                <div class="example">
                         @if(!empty($item->path2))
                         <label for="image2" class="el_label">下の画像を変更</label>
                         <input type="file" class="el_form" id="image2" name="image2"></input><br>
                        <img src="{{ Storage::disk('s3')->url($item->path2) }}" onerror="this.style.display='none'" alt="登録画像"></img>
                        @else
                        <label for="image2" class="el_label">画像を追加</label>
                        <input type="file" class="el_form" id="image2" name="image2"></input>
                        @endif
                </div>
                        
                 <div class="example">
                         @if(!empty($item->path3))
                         <label for="image3" class="el_label">下の画像を変更
                         </label>
                         <input type="file" class="el_form" id="image3" name="image3"></input><br>
                        <img src="{{ Storage::disk('s3')->url($item->path3) }}" onerror="this.style.display='none'" alt="登録画像"></img>
                        @else
                        <label for="image3" class="el_label">画像を追加</label>
                         <input type="file" class="el_form" id="image3" name="image3"></input>
                        @endif                            
                 </div>

                 <div class="example">
                         @if(!empty($item->path4))
                         <label for="image4" class="el_label">下の画像を変更</label>
                         <input type="file" class="el_form" id="image4" name="image4"></input><br>
                         <img src="{{ Storage::disk('s3')->url($item->path4) }}" onerror="this.style.display='none'" alt="登録画像"></img>
                        @else
                         <label for="image4" class="el_label">画像を追加</label>
                         <input type="file" class="el_form" id="image4" name="image4"></input> 
                         @endif
                 </div>

                 <div class="example">
                         @if(!empty($item->path5))
                         <label for="image5" class="el_label">下の画像を変更</label>
                         <input type="file" class="el_form" id="image5" name="image5"></input><br>
                        <img src="{{ Storage::disk('s3')->url($item->path5) }}" onerror="this.style.display='none'" alt="登録画像"></img>
                        @else
                        <label for="image5" class="el_label">画像を追加</label>
                         <input type="file" class="el_form" id="image5" name="image5"></input>
                        @endif
                </div>
                <span>※画像は最大5枚までアップロードできます。</span>
                         @error('image1')
                         <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error('image2')
                         <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error('image3')
                         <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error('image4')
                         <div class="text-danger">{{ $message }}</div>
                        @enderror
                        @error('image5')
                         <div class="text-danger">{{ $message }}</div>
                        @enderror
                </div>


<div class="card-footer">
        <!-- 更新ボタン -->
        <button type="submit" class="btn btn-primary text-nowrap w-15">更新</button>       
    </form>

    <!-- 削除ボタン -->
    <form method="POST" class="mt-3" action="{{ route('item.destroy', $item->id) }}" onsubmit="return confirm('削除してよろしいですか？');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger text-nowrap w-15" id="delete-item-{{ $item->id }}">削除</button>
    </form>
    </div>
</div>
            </div>
     </div>
    </div>
 </div>
 </div>
    </div>
    </div>

@endsection
        