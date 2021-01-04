<?php

namespace App\Http\Controllers\GiamDoc;

use App\Http\Controllers\Controller;
use App\Http\Requests\GiamDoc\ChangePasswordRequest;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Hash;
use Auth;

class ProfileController extends Controller
{
    use StorageImageTrait;
    public function getProfile()
    {
        return view('giamdoc.profile.profile');
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
        return view('giamdoc.profile.password');
    }
    public function postPassword(ChangePasswordRequest $request)
    {
        $user  = Auth::user();
        if (Hash::check($request->currentpassword, $user->password)) {
            $user->update([
                'password' => Hash::make($request->newpassword),
            ]);
            return back()->with('thanhcong', 'Đổi mật khẩu thành công');
        };
        return back()->with('thatbai', 'Sai Mật Khẩu');
    }
}
