<?php

namespace App\Http\Requests\GiamDoc;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'bail|required|min:2|max:255',
            'email' => 'bail|required|max:255|unique:users',
            'phone' => 'bail|unique:users|min:8|max:13',
            'password' => 'bail|required|min:6|max:32',
            'repassword' => 'bail|required|same:password',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Chưa nhập tên',
            'name.min' => 'Tên quá ngắn',
            'name.max' => 'Tên quá dài',
            'email.required' => 'Chưa nhập email',
            'email.unique' => 'Email đã tồn tại',
            'email.max' => 'Email quá dài',
            'phone.min' => 'Số điện thoại quá ngắn',
            'phone.max' => 'Số điện thoại quá dài',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'password.required' => 'Chưa nhập mật khẩu',
            'password.min' => 'Mật khẩu quá ngắn',
            'password.max' => 'Mật khẩu quá dài',
            'repassword.required' => 'Chưa xác nhận mật khẩu',
            'repassword.same' => 'Mật khẩu không khớp'
        ];
    }
}
