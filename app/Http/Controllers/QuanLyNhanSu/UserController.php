<?php

namespace App\Http\Controllers\QuanLyNhanSu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Http\Requests\GiamDoc\UserRequest;
use App\Models\ProjectUser;
use DB;
use Hash;
use App\Traits\StorageImageTrait;
use Carbon\Carbon;

class UserController extends Controller
{
    use StorageImageTrait;
    private $user;
    private $project;
    private $project_users;
    public function __construct(User $user, Project $project, ProjectUser $project_users)
    {
        $this->user = $user;
        $this->project = $project;
        $this->project_users = $project_users;
    }
    public function getViewUser()
    {
        $listCTV = $this->user->where('role', '=', 'ctv')->get();
        $listManager = $this->user->where('role', '=', 'manager')->get();
        return view('quanlynhansu.user.view', compact('listCTV', 'listManager'));
    }
    public function getAddUser()
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $listManager = $this->user->where('role', '=', 'manager')->where('status', 1)->get();
        $listProject_ = $this->project->where('status', 1)->get();
        $listProject = [];
        foreach ($listProject_ as $item) {
            if ($item->end_time == null || $item->end_time >= $now) {
                $listProject[] = $item;
            }
        }
        return view('quanlynhansu.user.add', compact('listManager', 'listProject'));
    }
    public function postAddUser(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $userCreate = ([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'birthday' => $request->birthday,
                'role' => $request->role,
                'manager_id' => $request->manager,
                'status' => $request->status,
            ]);
            $dataUploadImage = $this->storageTraitUpload($request, 'avatar', 'avatar');
            if (!empty($dataUploadImage)) {
                $userCreate['avatar_name'] = $dataUploadImage['file_name'];
                $userCreate['avatar_path'] = $dataUploadImage['file_path'];
            }
            $user_new = $this->user->create($userCreate);

            //thêm vào bảng project_user
            $listProject = $request->projects;
            if (!empty($listProject)) {
                foreach ($listProject as $item) {
                    $this->project_users->create([
                        'user_id' => $user_new->id,
                        'project_id' => $item,
                    ]);
                }
            }
            DB::commit();
            return back()->with('thanhcong', 'Đã thêm nhân viên mới!');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return back()->with('thatbai', 'Thất bại!');
        }
    }


    public function getEditUser($id)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $user = $this->user->findOrFail($id);
        $listManager = $this->user->where('role', '=', 'manager')->where('status', 1)->get();
        $listProject_ = $this->project->where('status', 1)->get();
        $listProject = [];
        foreach ($listProject_ as $item) {
            if ($item->end_time == null || $item->end_time >= $now) {
                $listProject[] = $item;
            }
        }
        $listProjectUser = $this->project_users->where('user_id', $id)->get();
        return view('quanlynhansu.user.edit', compact('user', 'listManager', 'listProject', 'listProjectUser'));
    }

    public function postEditUser($id, Request $request)
    {
        try {
            DB::beginTransaction();
            $userUpdate = ([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'birthday' => $request->birthday,
                'role' => $request->role,
                'manager_id' => $request->manager,
                'status' => $request->status,
            ]);
            if ($request->password) {
                $userUpdate['password'] =  Hash::make($request->password);
            }
            $dataUploadImage = $this->storageTraitUpload($request, 'avatar', 'avatar');
            if (!empty($dataUploadImage)) {
                $userUpdate['avatar_name'] = $dataUploadImage['file_name'];
                $userUpdate['avatar_path'] = $dataUploadImage['file_path'];
            }
            $user_new = $this->user->findOrFail($id)->update($userUpdate);

            //thêm vào bảng project_user
            DB::table('project_users')->where('user_id', $id)->delete();
            $listProject = $request->projects;
            if (!empty($listProject)) {
                foreach ($listProject as $item) {
                    $this->project_users->create([
                        'user_id' => $id,
                        'project_id' => $item,
                    ]);
                }
            }
            DB::commit();
            return back()->with('thanhcong', 'Đã sửa thông tin nhân viên!');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return back()->with('thatbai', 'Thất bại!');
        }
    }

    public function postStatusUser($id, Request $request)
    {
        $this->user->findOrFail($id)->update([
            'status' => $request->status,
        ]);
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ], 200);
    }

    public function getListProjectOfManager(Request $request)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        //lấy ra dự án đang còn hoạt động.
        if ($request->select == null) {
            $listProject_ = DB::table('projects')
                ->where('projects.status', 1)
                ->select('projects.name as name', 'projects.id as id', 'projects.end_time as end_time')
                ->get();
        } else {
            $listProject_ = DB::table('project_users')
                ->join('projects', 'projects.id', '=', 'project_users.project_id')
                ->where('project_users.user_id', $request->select)
                ->where('projects.status', 1)
                ->select('projects.name as name', 'projects.id as id', 'projects.end_time as end_time')
                ->get();
        }
        $listProject = [];
        foreach ($listProject_ as $item) {
            if ($item->end_time == null || $item->end_time >= $now) {
                $listProject[] = $item;
            }
        }
        return response()->json([
            'listProject' => $listProject,
            'code' => 200,
            'message' => 'success'
        ], 200);
    }

    public function getDeleteUser($id)
    {
        $this->user->findOrFail($id)->delete();
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ], 200);
    }
}
