<?php

namespace App\Http\Requests\GiamDoc;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Chưa nhập tên dự án',
            'name.min' => 'Tên dự án quá ngắn',
            'name.max' => 'Tên dự án quá dài'
        ];
    }
}
