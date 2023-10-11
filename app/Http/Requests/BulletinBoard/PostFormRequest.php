<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
            'main_category_name' => 'min:1|max:100|unique:main_categories,main_category',
            'sub_category_name' => 'min:1|max:100|unique:sub_categories,sub_category',
            'post_title' => 'min:4|max:100',
            'post_body' => 'min:10|max:5000',
            'comment' => 'min:10|max:2500',
        ];
    }

    public function messages(){
        return [
            'post_title.min' => 'タイトルは4文字以上入力してください。',
            'post_title.max' => 'タイトルは100文字以内で入力してください。',
            'post_body.min' => '内容は10文字以上入力してください。',
            'post_body.max' => '最大文字数は500文字です。',
            'comment.min' => '内容は10文字以上入力してください。',
            'comment.max' => '最大文字数は2500文字です。',
        ];
    }
}