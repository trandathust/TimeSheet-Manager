<?php

namespace App\Http\Controllers\CongTacVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\StorageImageTrait;
use App\Models\User;
use Auth;
use App\Http\Requests\CongTacVien\ProfileRequest;
use App\Http\Requests\CongTacVien\ChangePasswordRequest;
use DB;
use Hash;

class ProfileController extends Controller
{
    use StorageImageTrait;
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function getPassword()
    {
        return view('congtacvien.profile.password');
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
    public function getProfile()
    {
        $user = Auth::user();
        return view('congtacvien.profile.profile', compact('user'));
    }
    public function postProfile(ProfileRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'birthday' => $request->birthday,
                'phone' => $request->phone,
            ];
            $dataUploadAvatar = $this->storageTraitUpload($request, 'avatar', 'avatar');
            if (!empty($dataUploadAvatar)) {
                $data['avatar_name'] = $dataUploadAvatar['file_name'];
                $data['avatar_path'] = $dataUploadAvatar['file_path'];
            }
            $user->update($data);
            DB::commit();
            return back()->with('thanhcong', 'Đã lưu thông tin!');
        } catch (Exception $exception) {
            DB::rollBack();
            return back()->with('thatbai', 'Thất bại!');
        }
    }
}
