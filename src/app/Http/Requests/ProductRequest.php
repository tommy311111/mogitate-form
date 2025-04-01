<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $isUpdate = request()->route('product') !== null;
        return [
            'name' => 'required|string|max:255|regex:/\D/',
            'price' => 'required|numeric|between:0,10000',
            'image' => [
                $isUpdate ? 'nullable' : 'required',
                'image',
                'mimes:png,jpeg',
                'max:2048',
                function ($attribute, $value, $fail) use ($isUpdate) {
                    if ($isUpdate) {
                        $product = request()->route('product');
                        if (!$product->image && !request()->hasFile('image')) {
                            $fail('商品画像を登録してください');
                        }
                    }
                }
            ],
            'description' => 'required|string|max:120|regex:/\D/',
            'season' => 'required|array|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'name.string' => '商品名は文字列で入力してください',
            'name.max' => '商品名は255文字以内で入力してください',
            'name.regex' => '商品名には少なくとも1文字以上の数字以外の文字を含めてください。',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.between' => '0〜10000円以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'description.required' => '商品説明を入力してください',
            'description.string' => '説明は文字列で入力してください',
            'description.max' => '説明は120文字以内で入力してください',
            'description.regex' => '商品説明には少なくとも1文字以上の数字以外の文字を含めてください。',
            'season.required' => '季節を選択してください',
            'season.min' => '季節を少なくとも1つ選択してください',
        ];
    }
}
