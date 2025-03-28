<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
   public function rules()
{
    $isUpdate = request()->route('product') !== null; // 更新時かどうかを判定

    return [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|between:0,10000',
        'image' => [
            $isUpdate ? 'nullable' : 'required', // 更新時はnullable、新規作成時は必須
            'image',
            'mimes:png,jpeg',
            'max:2048',
            function ($attribute, $value, $fail) use ($isUpdate) {
                // 更新時、画像が空で、既存の画像もない場合はエラー
                if ($isUpdate && empty($value) && !request()->route('product')->image) {
                    $fail('商品画像を登録してください');
                }
            }
        ],
        'description' => 'required|string|max:120',
        'season' => 'required|array|min:1',
    ];
}


     public function messages()
{
    return [
        'name.required' => '商品名を入力してください',
        'name.string' => '商品名は文字列で入力してください',
        'name.max' => '商品名は255文字以内で入力してくださ',
        
        'price.required' => '値段を入力してください',
        'price.numeric' => '数値で入力してください',
        'price.between' => '0〜10000円以内で入力してください',
        
        'image.required' => '商品画像を登録してください',
        'image.image' => '画像ファイルを選択してください',
        'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        
        'description.required' => '商品説明を入力してください',
        'description.string' => '説明は文字列で入力してください',
        'description.max' => '説明は120文字以内で入力してください',
        
        'season.required' => '季節を選択してください',
        'season.min' => '季節を少なくとも1つ選択してください',
    ];
}

}
