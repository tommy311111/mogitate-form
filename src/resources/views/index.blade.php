@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="products-container">
    <div class="products-header">
        @if(request()->has('keyword') && request()->keyword !== '')
        <h2>"{{ request()->keyword }}"の商品一覧</h2>
        @else
        <h2>商品一覧</h2>
        @endif
        <a href="/products/register" class="add-product-btn btn">+ 商品を追加</a>
    </div>
    <form action="/products/search" method="get">
        @csrf
        <div class="products-body">
            <aside class="search-panel">
                <input type="text" name="keyword" placeholder="商品名で検索" class="search-input" value="{{ request()->keyword }}">
                <input class="search-btn btn" type="submit" value="検索">
                <label for="sort-select" class="sort-label">価格順で表示</label>
                <select name="sort" id="sort-select" class="sort-select">
                    <option value="">価格で並び替え</option>
                    <option value="high" {{ request()->sort == 'high' ? 'selected' : '' }}>高い順に表示</option>
                    <option value="low" {{ request()->sort == 'low' ? 'selected' : '' }}>低い順に表示</option>
                </select>
                <input type="submit" value="適用" class="sort-btn btn">
                <div class="filter-tags">
                    @if(request()->has('sort'))
                    <span class="filter-tag">
                        {{ request()->sort == 'high' ? '高い順に表示' : '低い順に表示' }}
                        <a href="{{ url()->current() }}?{{ http_build_query(request()->except('sort')) }}" class="remove-filter">×</a>
                    </span>
                    @endif
                </div>
                <hr class="divider">
            </aside>
            <section class="products-grid">
                @foreach ($products as $product)
                <a href="{{ url('/products/' . $product->id) }}" class="product-card">
                    <div class="product-card">
                        <div class="product-card__img">
                            <img src="{{ asset('storage/' .$product->image) }}" alt="{{ $product->name }}">
                        </div>
                        <div class="product-info">
                            <p class="product-name">{{ $product->name }}</p>
                            <p class="product-price">¥{{ number_format($product->price) }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </section>
            <div class="pagination">
                {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        </div>
    </form>
</div>
@endsection
