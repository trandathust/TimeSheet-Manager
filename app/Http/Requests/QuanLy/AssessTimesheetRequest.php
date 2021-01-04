<?php

namespace App\Http\Requests\QuanLy;

use Illuminate\Foundation\Http\FormRequest;

class AssessTimesheetRequest extends FormRequest
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
            'confirm_hour' => 'bail|required',
            'confirm_effective' => 'bail|required'
        ];
    }
    public function messages()
    {
        return [
            'confirm_hour.required' => 'Chưa nhập thông tin',
            'confirm_effective.required' => 'Chưa nhập thông tin'
        ];
    }
}
