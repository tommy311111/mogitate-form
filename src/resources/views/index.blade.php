@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<div class="products-container">
    <div class="products-header">
        <h2>商品一覧</h2>
        <a href="/products/register" class="add-product-btn btn">+ 商品を追加</a>
    </div>

    <div class="products-body">
        <aside class="search-panel">
            
                <input type="text" name="search" placeholder="商品名を検索" class="search-input">
                <button type="submit" class="search-btn">検索</button>
            
            <hr class="divider">
        </aside>

        <section class="products-grid">
            @foreach ($products as $product)
            <div class="product-card">
                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}">
                <div class="product-info">
                    <span class="product-name">{{ $product->name }}</span>
                    <span class="product-price">¥{{ number_format($product->price) }}</span>
                </div>
            </div>
            @endforeach
        </section>
    

        <div class="pagination">
         {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
        </div>
  </div>
</div>
@endsection