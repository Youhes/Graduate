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
        if (empty($images)) {
            $images = [];
        } else {
            foreach ($images as $image) {
                if ($image->isValid()) {
                    $path = $image->store('public/images');
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
     * 
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|max:100',
                'path1' => 'nullable',
                'path2' => 'nullable',
                'path3' => 'nullable',
                'path4' => 'nullable',
                'path5' => 'nullable',
            ],
            [
                'name.required' => 'タイトルは必須です。',
                'name.max' => '100文字以内で入力してください。',
            ]
        );

        $item = Item::find($id);


        if (empty($image1['image1'])) {
            $path1 = $item->path1;
        } else {
            Storage::delete($item->path1);
            $image1 = $request->file('image1');
            $path1 = $image1->store('public/images');
        }

        if (empty($image2['image2'])) {
            $path2 = $item->path2;
        } else {
            Storage::delete($item->path2);
            $image2 = $request->file('image2');
            $path2 = $image2->store('public/images');
        }


        if (empty($image3['image3'])) {
            $path3 = $item->path3;
        } else {
            Storage::delete($item->path3);
            $image3 = $request->file('image3');
            $path3 = $image3->store('public/images');
        }

        if (empty($image4['image4'])) {
            $path4 = $item->path4;
        } else {
            Storage::delete($item->path4);
            $image4 = $request->file('image4');
            $path4 = $image4->store('public/images');
        }

        if (empty($image5['image5'])) {
            $path5 = $item->path5;
        } else {
            Storage::delete($item->path5);
            $image5 = $request->file('image5');
            $path5 = $image5->store('public/images');
        }


        $item->update([
            'name' => $request->name,
            'type' => $request->type,
            'detail' => $request->detail,
            'path1' => $path1,
            'path2' => $path2,
            'path3' => $path3,
            'path4' => $path4,
            'path5' => $path5,
        ]);

        return redirect('/items');
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
