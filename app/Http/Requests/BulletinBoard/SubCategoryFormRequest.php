<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryFormRequest extends FormRequest
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
            'main_category_id' => 'required|numeric',
            'sub_category_name' => 'required|min:1|max:100|unique:sub_categories,sub_category',
        ];
    }

    public function messages(){
        return [
            'main_category_id.required' => 'カテゴリーは必ず選択してください。',
            'main_category_id.numeric' => 'そのカテゴリーは登録されておりません。',
            'sub_category_name.required' => 'サブカテゴリーは必ず入力してください。',
            'sub_category_name.min' => 'サブカテゴリーは1文字以上入力してください。',
            'sub_category_name.max' => 'サブカテゴリーは100文字以内で入力してください。',
            'sub_category_name.unique' => 'そのサブカテゴリーは既に登録されています。',
        ];
    }
}