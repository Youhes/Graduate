<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

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
    if(isset($keyword))
    {
       $query->where('detail','like',"%{$keyword}%");
       $query->orwhere('name','like',"%{$keyword}%");
    }

//全件件取得
$items = $query->orderBy('id', 'asc')->paginate(12);

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
                'type' => $request->type,
                'detail' => $request->detail,
            ]);

            return redirect('/items');
        }

        return view('item.add');
    }


/*
 *詳細表示      
 * 
 *  
 */
     public function show($id){

        $item = Item::findOrFail($id);
        return view('item.show')->with('item', $item);
     }

}
