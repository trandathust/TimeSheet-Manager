<?php

namespace App\Http\Requests\CongTacVien;

use Illuminate\Foundation\Http\FormRequest;

class TimesheetRequest extends FormRequest
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
            'date_work' => 'bail|required',
            'project_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'total_hour' => 'required',
            'effective' => 'required',
            'description' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'date_work.required' => 'Chưa chọn thời gian',
            'project_id.required' => 'Chưa chọn dự án',
            'start_time.required' => 'Chưa nhập thời gian đến',
            'end_time.required' => 'Chưa nhập thời gian về',
            'total_hour.required' => 'Chưa nhập thời gian làm việc',
            'effective.required' => 'Chưa nhập hiệu quả công việc',
            'description.required' => 'Chưa nhập mô tả công việc',
        ];
    }
}
