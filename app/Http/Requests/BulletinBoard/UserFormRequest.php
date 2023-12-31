<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
            'over_name' => 'string|max:10',
            'under_name' => 'string|max:10',
            'over_name_kana' => 'string|kana|max:30',
            'under_name_kana' => 'string|kana|max:30',
            'mail_address' => 'email|max:100|unique:users,mail_address',
            'birth_day' => 'after:2000/01/01|before:today|date',
            'password' => 'required|alpha_num|min:8|max:30|confirmed',
            'password_confirmation' => 'required|alpha_num|min:8|max:20',
        ];
    }

    // 日付けの組み立て
    public function getValidatorInstance()
    {
        if ($this->input('old_day') && $this->input('old_month') && $this->input('old_year'))
        {
            $birth_day = implode('-', $this->only(['old_year', 'old_month', 'old_day']));
            $this->merge([
                'birth_day' => $birth_day,
            ]);
        }

        return parent::getValidatorInstance();
    }

    public function messages(){
        return [
            'over_name.string' => '文字列で入力してください。',
            'over_name.max' => '10文字以内で入力してください。',
            'under_name.string' => '文字列で入力してください。',
            'under_name.max' => '10文字以内で入力してください。',
            'over_name_kana.string' => '文字列で入力してください。',
            'over_name_kana.kana' => 'カタカナで入力してください。',
            'over_name_kana.max' => '10文字以内で入力してください。',
            'under_name_kana.string' => '文字列で入力してください。',
            'under_name_kana.kana' => 'カタカナで入力してください。',
            'under_name_kana.max' => '10文字以内で入力してください。',
            'mail_address.email' => '有効なメールアドレスを入力してください。',
            'mail_address.max' => '100文字以内で入力してください。',
            'mail_address.unique' => 'そのメールアドレスは既に登録されています。',
            'birth_day.date' => '有効な日付を入力してください。',
            'birth_day.before' => '有効な日付を入力してください。',
            'birth_day.after' => '2000年以降の生年月日を入力してください。',
            'password.alpha_num' => '英数字のみで入力してください。',
            'password.min' => '8文字以上で入力してください。',
            'password.max' => '30文字以内で入力してください。',
            'password.confirmed' => '確認用のパスワードが一致しません',
            'password_confirmation.alpha_num' => '英数字のみで入力してください。',
            'password_confirmation.min' => '8文字以上で入力してください。',
            'password_confirmation.max' => '30文字以内で入力してください。',
        ];
    }
}