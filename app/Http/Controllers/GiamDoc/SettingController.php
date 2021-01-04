<?php

namespace App\Http\Controllers\GiamDoc;

use App\Http\Controllers\Controller;
use App\Http\Requests\GiamDoc\SettingRequest;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Traits\StorageImageTrait;
use Carbon\Carbon;
use DB;
use Hash;

class SettingController extends Controller
{
    use StorageImageTrait;
    private $setting;
    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
    }
    public function getSetting()
    {
        $date_ctv = $this->setting->where('config_key', 'date_ctv')->value('config_value');
        $footer = $this->setting->where('config_key', 'footer')->value('config_value');
        $date_salary = $this->setting->where('config_key', 'date_salary')->value('config_value');;
        $salary = $this->setting->where('config_key', 'salary')->value('config_value');;
        return view('giamdoc.setting', compact('date_ctv', 'date_salary', 'footer', 'salary'));
    }

    public function postSetting(SettingRequest $request)
    {
        if (Hash::check($request->password, auth()->user()->password)) {
            try {
                DB::beginTransaction();
                $this->setting->where('config_key', 'date_ctv')->update([
                    'config_value' => $request->date_ctv,
                ]);
                $this->setting->where('config_key', 'date_salary')->update([
                    'config_value' => $request->date_salary,
                ]);
                $this->setting->where('config_key', 'footer')->update([
                    'config_value' => $request->footer,
                ]);
                $this->setting->where('config_key', 'salary')->update([
                    'config_value' => $request->salary,
                ]);
                $dataUploadImage = $this->storageTraitUpload($request, 'logo', 'logo');
                if (!empty($dataUploadImage)) {
                    $logoCreate = $dataUploadImage['file_path'];
                    $this->setting->where('config_key', 'logo')->update([
                        'config_value' => $logoCreate,
                    ]);
                }
                DB::commit();
                return back()->with('thanhcong', 'Cập nhật thông tin thành công');
            } catch (\Throwable $th) {
                dd($th);
                DB::rollback();
                return back()->with('thatbai', 'Cập nhật thất bại!');
            }
        } else
            return back()->with('thatbai', 'Mật khẩu không chính xác');
    }
}
