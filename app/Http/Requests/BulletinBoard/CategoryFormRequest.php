<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class CategoryFormRequest extends FormRequest
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
        return [
            'main_category_name' => 'required|min:1|max:100|unique:main_categories,main_category',
        ];
    }

    public function messages(){
        return [
            'main_category_name.required' => 'カテゴリーは必ず入力してください。',
            'main_category_name.min' => 'カテゴリーは1文字以上入力してください。',
            'main_category_name.max' => 'カテゴリーは100文字以内で入力してください。',
            'main_category_name.unique' => 'そのカテゴリーは既に登録されています。',
        ];
    }
}