<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'condition_id' => 'required|exists:conditions,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'brand' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'images.required' => '出品画像をアップロードしてください。',
            'category_id.required' => 'カテゴリーを選択して下さい。',
            'condition_id.required' => '商品状態を選択してください。',
            'name.required' => '商品名を入力してください。',
            'price.required' => '販売価格を入力してください。',
        ];
    }
}
