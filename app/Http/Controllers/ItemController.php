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
        //dd($images);

        $paths = [];
        foreach ($images as $image) {
            if ($image->isValid()) {
                $path = $image->store('public/images');
                $paths[] = $path;
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
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:100',
        ],
        [
            'name.required' => 'タイトルは必須です。',
            'name.max' => '100文字以内で入力してください。',
        ]);

        $item = Item::find($request->id);

        $images = $request->file('images');
        $paths = $item->images;
       

        $paths = [];
        foreach ($images as $image) {
            if (isset($image)) {
                    Storage::disk('public')->delete('images/'.$image);
                    $path = $image->store('public/images');
                    $paths[] = $path;
                        }
                    };
                     //dd($images);

       
        $item->update([
        'name'=> $request->name,
        'type'=> $request->type,
        'detail' => $request->detail,
        'paths' => $paths,
        ]);

        return redirect('/items')->with('success', "フォルダ{$item->id}を更新しました！");
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
