@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="product-detail-container">
    <form action="{{ url('/products/' . $product->id . '/update') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PATCH')

        <div class="product-detail-top">
            <div class="product-detail-left">
                <p class="breadcrumb"><a href="{{ url('/products') }}" class="highlight">商品一覧</a> ＞ {{ old('name', $product->name) }}</p>
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                <input type="file" name="image" class="file-input">
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="error">
                    @error('image')
                    {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="product-detail-right">
                <label for="name">商品名</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
                <div class="error">
                    @error('name')
                    {{ $message }}
                    @enderror
                </div>

                <label for="price">値段</label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required>
                <div class="error">
                    @error('price')
                    {{ $message }}
                    @enderror
                </div>

                <label>季節</label>
                <ul class="season-list">
                    @php
                        $seasons = ['春', '夏', '秋', '冬'];
                        $selectedSeasons = old('season') !== null ? old('season') : $product->seasons->pluck('name')->toArray();
                    @endphp

                    @foreach ($seasons as $season)
                        <li>
                            <input type="checkbox" name="season[]" value="{{ $season }}" id="season_{{ $season }}"
                                @if(in_array($season, $selectedSeasons)) checked @endif>
                            <label for="season_{{ $season }}">{{ $season }}</label>
                        </li>
                    @endforeach
                </ul>
                <div class="error">
                    @error('season')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="product-detail-bottom">
            <label for="description">商品説明</label>
            <textarea name="description" id="description" rows="8" required>{{ old('description', $product->description) }}</textarea>
            <div class="error">
                @error('description')
                {{ $message }}
                @enderror
            </div>

            <div class="button-group">
                <div class="left-buttons">
                    <a href="{{ url('/products') }}" class="btn back-btn">戻る</a>
                    <input class="save-btn btn" type="submit" value="変更を保存">
                </div>
            </div>
        </form>

        <div class="right-buttons">
            <form action="{{ url('/products/' . $product->id . '/delete') }}" method="POST" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn">
                    <img src="{{ asset('storage/images/trash.png') }}" alt="削除" class="trash-icon">
                </button>
            </form>
        </div>
    </div>
@endsection
