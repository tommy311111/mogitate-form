<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
  {
    $products = Product::paginate(6);
    return view('index', compact('products'));
  }

  public function search(Request $request)
{
    $keyword = $request->input('keyword');

    $query = Product::query();

    if (!empty($keyword)) {
        $query->where('name', 'LIKE', "%{$keyword}%");
    }

    $products = $query->paginate(6);

    return view('index', compact('products'));
}

   public function create()
    {
        return view('register'); 
    }

    public function store(ProductRequest $request)
    {
        
        // 'season'が単一の値の場合、配列に変換
    if (!is_array($request->season)) {
        $request->season = [$request->season];  // 単一の値を配列に変換
    }


        // 画像を保存
        $imagePath = $request->file('image')->store('products', 'public');

        // データを保存
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->image = $imagePath;
        $product->description = $request->description;
        $product->save();

        // 季節データの保存（もし `seasons` テーブルとリレーションがある場合）
        if ($request->has('season')) {
            $seasonIds = \App\Models\Season::whereIn('name', $request->season)->pluck('id')->toArray();
            $product->seasons()->attach($seasonIds);
        }

        // 商品一覧ページへリダイレクト
        return redirect('/products')->with('message', '作成しました');
    }


    public function show($id)
    {
        $product = Product::with('seasons')->findOrFail($id); // 商品と季節データを取得
        return view('detail', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
{
    // 商品を取得（idで指定）
    $product = Product::find($request->id);

    // 画像の処理
    if ($request->hasFile('image')) {
        // 既存画像を削除
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        // 新しい画像を保存
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
    }

    // データ更新
    $product->name = $request->name;
    $product->price = $request->price;
    $product->description = $request->description;
    
    // 季節の更新
    if ($request->has('season')) {
        $seasonIds = \App\Models\Season::whereIn('name', $request->season)->pluck('id')->toArray();
        $product->seasons()->sync($seasonIds);
    } else {
        $product->seasons()->sync([]); // 季節が選択されていない場合は関連を削除
    }

    // 商品情報を更新
    $product->save();

    // 商品一覧ページへリダイレクト
    return redirect('/products')->with('message', '商品情報が更新されました');
}



public function updateImage(Request $request, Product $product)
{
    $validatedData = $request->validate([
        'image' => 'image|mimes:jpeg,png|max:2048',
    ]);

    if ($request->hasFile('image')) {
        // 既存画像を削除
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        // 新しい画像を保存
        $imagePath = $request->file('image')->store('products', 'public');
        $product->image = $imagePath;
        $product->save();
    }

    // 現在の入力データをセッションに保存
    return redirect()->back()->withInput();
}

public function destroy($id)
{
    // IDで商品を検索し、見つからなければ404エラー
    $product = Product::findOrFail($id);
    
    // 商品を削除
    $product->delete();

    // 商品一覧ページにリダイレクト
    return redirect('/products')->with('message', '商品情報を削除しました');
}



}
