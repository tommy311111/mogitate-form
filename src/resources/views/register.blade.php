@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
 <div class="container">
        <h2>商品登録</h2>
    <form action="/products" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="label-container">
            <label>商品名</label> <span class="required">必須</span>
        </div>
        <input type="text" name="name" placeholder="商品名を入力" value="{{ old('name') }}" required>
        <div class="error">
             @error('name')
             {{ $message }}
             @enderror
        </div>
        
        <div class="label-container">
            <label>値段</label> <span class="required">必須</span>
        </div>  
        <input type="number" name="price" placeholder="値段を入力" value="{{ old('price') }}" required>
        <div class="error">
             @error('price')
             {{ $message }}
             @enderror
        </div>
        
        <div class="label-container">
            <label>商品画像</label> <span class="required">必須</span>
        </div>
        <input type="file" name="image" required>
        <div class="error">
             @error('image')
             {{ $message }}
             @enderror
        </div>
        
        <div class="label-container">
            <label>季節</label> <span class="required">必須</span>
            <span class="optional">複数選択可</span>
        </div>
        <div class="checkbox-group">
            <label class="radio-style">
                <input type="checkbox" name="season[]" value="春" {{ in_array('春', old('season', [])) ? 'checked' : '' }}> 春
            </label>
            <label class="radio-style">
                <input type="checkbox" name="season[]" value="夏" {{ in_array('夏', old('season', [])) ? 'checked' : '' }}> 夏
            </label>
            <label class="radio-style">
                <input type="checkbox" name="season[]" value="秋" {{ in_array('秋', old('season', [])) ? 'checked' : '' }}> 秋
            </label>
            <label class="radio-style">
                <input type="checkbox" name="season[]" value="冬" {{ in_array('冬', old('season', [])) ? 'checked' : '' }}> 冬
            </label>
        </div>
        <div class="error">
             @error('season')
             {{ $message }}
             @enderror
        </div>   
    
        <div class="label-container">
            <label>商品説明</label> <span class="required">必須</span>
        </div>
        <textarea name="description" rows="8" placeholder="商品説明を入力" required>{{ old('description') }}</textarea>
        <div class="error">
             @error('description')
             {{ $message }}
             @enderror
        </div>
        
        <div class="button-group">
            <a href="{{ url('/products') }}" class="back-btn btn">戻る</a>
            <input class="submit-btn btn" type="submit" value="登録">
        </div>
    </form>  
</div>
@endsection
