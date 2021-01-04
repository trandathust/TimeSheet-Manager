<?php

namespace App\Http\Requests\CongTacVien;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'bail|required|min:3|max:255',
            'email' => 'bail|required|max:255',
            'phone' => 'bail|required|min:8|max:13'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Bạn chưa nhập tên',
            'name.min' => 'Tên quá ngắn',
            'name.max' => 'Tên quá dài',
            'email.required' => 'Bạn chưa nhập email',
            'email.unique' => 'Email đã tồn tại',
            'email.max' => 'Email quá dài',
            'phone.required' => 'Chưa nhập số điện thoại',
            'phone.min' => 'Số điện thoại quá ngắn',
            'phone.max' => 'Số điện thoại quá dài'
        ];
    }
}
