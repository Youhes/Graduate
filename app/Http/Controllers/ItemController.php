<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 商品一覧
     * param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // 商品一覧取得
        $items = Item::all();

        //クエリ生成
        $query = Item::query();
        //キーワード受け取り
        $keyword = $request->input('keyword');
        //もしキーワードがあったら
        if (isset($keyword)) {
            $query->where('detail', 'like', "%{$keyword}%");
            $query->orwhere('name', 'like', "%{$keyword}%");
            $query->orwhere('type', 'like', "%{$keyword}%");
        }


        //全件件取得
        $items = $query->orderBy('id', 'desc')->paginate(12);

        return view('item.index', compact('items', 'keyword'));
    }

    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
            ]);

            // 商品登録
            Item::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'path1' => $request->path1,
                'path2' => $request->path2,
                'path3' => $request->path3,
                'path4' => $request->path4,
                'path5' => $request->path5,
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        }
        return view('item.add');
    }

    /**
     * 画像の保存
     *
     *
     */
    public function store(Request $request)
    {
        // POSTリクエストのとき
        if ($request->isMethod('post')) {
            // バリデーション
            $this->validate($request, [
                'images.*' => 'nullable|file|mimes:jpeg,png,jpe,jpg|max:3000',
            ]);
        }

        $images = $request->file('images');
        //
        $paths = [];
        if (!empty($images)) {
            foreach ($images as $image) {
                if ($image->isValid()) {
                    // $path = $image->store('public/images');
                    $path = Storage::disk('s3')->put('guraduate/test', $image);
                    $paths[] = $path;
                }
            }
        }

        $item = new Item;
        $item->user_id = Auth::id();
        $item->name = $request->name;
        $item->type = $request->type;
        $item->detail = $request->detail;
        $item->paths = $paths;
        $item->save();

        return redirect('/items');
    }

    /**
     * 編集フォームを表示する
     */
    public function edit($id, Request $request)
    {
        $item = Item::find($id);
        $returnPage = $request->query('page', 1); //ページの取得
        return view('item.edit', compact('item', 'returnPage'));
    }

    /**
     * 更新する
     * 
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate(
            [
                'name' => 'required|max:100',
                'image1' => 'nullable',
                'image2' => 'nullable',
                'image3' => 'nullable',
                'image4' => 'nullable',
                'image5' => 'nullable',
            ],
            [
                'name.required' => 'タイトルは必須です。',
                'name.max' => '100文字以内で入力してください。',
            ]
        );

        $item = Item::find($id);


        if (!empty($request->file('image1'))) {
            if($item->path1){
                Storage::delete($item->path1);
            }
            $image1 = $request->file('image1');
            $path1 = Storage::disk('s3')->put('guraduate/test', $image1);
            $item->path1 = $path1;
            $item->update();
        }

        
        if (!empty($request->file('image2'))) {
            if($item->path2){
                Storage::delete($item->path2);
            }
            $image2 = $request->file('image2');
            $path2 = Storage::disk('s3')->put('guraduate/test', $image2);
            $item->path2 = $path2;
            $item->update();
        }

        if (!empty($request->file('image3'))) {
            if($item->path1){
                Storage::delete($item->path1);
            }
            $image3 = $request->file('image3');
            $path3 = Storage::disk('s3')->put('guraduate/test', $image3);
            $item->path3 = $path3;
            $item->update();
        }

        if (!empty($request->file('image4'))) {
            if($item->path4){
                Storage::delete($item->path4);
            }
            $image4 = $request->file('image4');
            $path4 = Storage::disk('s3')->put('guraduate/test', $image4);
            $item->path4 = $path4;
            $item->update();
        }

        if (!empty($request->file('image5'))) {
            if($item->path5){
                Storage::delete($item->path5);
            }
            $image5 = $request->file('image5');
            $path5 = Storage::disk('s3')->put('guraduate/test', $image5);
            $item->path5 = $path5;
            $item->update();
        }

        $item->update([
            'name' => $request->name,
            'type' => $request->type,
            'detail' => $request->detail,
        
        ]);

        return redirect('/items');
    }
     /*
    *詳細表示      
    * 
    */
    public function show($id)
    {

    $item = Item::findOrfail($id);
    return view('item.show', compact('item'));
    }

    /**
     * 削除する
     * 
     * @param Request $request
     * @param $id
     * @return Response
     *
     */
    public function destroy(Request $request, $id)
    {
        $item = Item::find($id);
        $item->delete();

        return redirect('/items')->with('success', "フォルダ{$item->id}を削除しました！");
    }
}
