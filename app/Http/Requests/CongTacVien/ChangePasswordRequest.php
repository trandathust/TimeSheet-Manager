<?php

namespace App\Http\Requests\CongTacVien;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'currentpassword' => 'bail|required',
            'newpassword' => 'bail|required|min:6|max:32',
            'repassword' => 'bail|required|same:newpassword'
        ];
    }
    public function messages()
    {
        return [
            'currentpassword.required' => 'Chưa nhập mật khẩu',
            'newpassword.required' => 'Chưa nhập mật khẩu',
            'newpassword.min' => 'Mật khẩu quá ngắn',
            'newpassword.max' => 'Mật khẩu quá dài',
            'repassword.required' => 'Chưa xác thực mật khẩu',
            'repassword.same' => 'Xác thực mật khẩu không khớp'
        ];
    }
}
