<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Traits\StorageImageTrait;
use App\Http\Requests\GiamDoc\ChangePasswordRequest;
use Hash;

class ProfileController extends Controller
{
    use StorageImageTrait;
    public function getProfile()
    {
        return view('quanly.profile.profile');
    }
    public function postProfile(Request $request)
    {
        $user = auth()->user();
        $dataUpdate = ([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'birthday' => $request->birthday,
        ]);
        $dataUploadImage = $this->storageTraitUpload($request, 'avatar', 'avatar');
        if (!empty($dataUploadImage)) {
            $dataUpdate['avatar_name'] = $dataUploadImage['file_name'];
            $dataUpdate['avatar_path'] = $dataUploadImage['file_path'];
        }
        $user->update($dataUpdate);
        return back()->with('thanhcong', 'Đã cập nhật thông tin!');
    }

    public function getPassword()
    {
        return view('quanly.profile.password');
    }
    public function postPassword(ChangePasswordRequest $request)
    {
        $user  = auth()->user();
        if (Hash::check($request->currentpassword, $user->password)) {
            $user->update([
                'password' => Hash::make($request->newpassword),
            ]);
            return back()->with('thanhcong', 'Đổi mật khẩu thành công');
        };
        return back()->with('thatbai', 'Sai Mật Khẩu');
    }
}
