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
        if (!is_array($request->season)) {
            $request->season = [$request->season];
        }

        $imagePath = $request->file('image')->store('products', 'public');

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->image = $imagePath;
        $product->description = $request->description;
        $product->save();

        if ($request->has('season')) {
            $seasonIds = \App\Models\Season::whereIn('name', $request->season)->pluck('id')->toArray();
            $product->seasons()->attach($seasonIds);
        }

        return redirect('/products')->with('message', '作成しました');
    }

    public function show($id)
    {
        $product = Product::with('seasons')->findOrFail($id);
        return view('detail', compact('product'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product = Product::find($request->id);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        if ($request->has('season')) {
            $seasonIds = \App\Models\Season::whereIn('name', $request->season)->pluck('id')->toArray();
            $product->seasons()->sync($seasonIds);
        } else {
            $product->seasons()->sync([]);
        }

        $product->save();
        return redirect('/products')->with('message', '商品情報が更新されました');
    }

    public function updateImage(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'image' => 'image|mimes:jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
            $product->save();
        }

        return redirect()->back()->withInput();
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect('/products')->with('message', '商品情報を削除しました');
    }
}
