<?php

namespace App\Http\Requests\GiamDoc;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            'date_ctv' => 'bail|required',
            'date_salary' => 'bail|required',
            'footer' => 'required',
            'password' => 'required',
            'salary' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'date_ctv.required' => 'Chưa có thông tin',
            'date_salary.required' => 'Chưa có thông tin',
            'date_footer.required' => 'Chưa có thông tin',
            'password.required' => 'Chưa nhập mật khẩu',
            'salary.required' => 'Chưa nhập thông tin',
        ];
    }
}
