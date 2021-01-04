<?php

namespace App\Http\Controllers\CongTacVien;

use App\Http\Controllers\Controller;
use App\Http\Requests\CongTacVien\TimesheetRequest;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\Timesheet;

class TimesheetController extends Controller
{
    private $timesheet;
    public function __construct(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
    }
    public function getAddTimesheet()
    {
        $id = auth()->user()->id;
        $date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $listProject_ = DB::table('project_users')
            ->where('user_id', $id)
            ->join('projects', 'project_users.project_id', '=', 'projects.id')
            ->where('projects.status', 1)
            ->whereNull('deleted_at')
            ->select('projects.id as id', 'projects.name as name', 'projects.end_time as end_time')
            ->get();
        $listProject = [];
        foreach ($listProject_ as $item) {
            if ($item->end_time == null || $item->end_time >= $date) {
                $listProject[] = $item;
            }
        }
        $start_time = Carbon::create(0, 1, 1, 8, 0, 0)->format('h:i');
        $end_time = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i');
        return view('congtacvien.timesheet.add', compact('listProject', 'date', 'start_time', 'end_time'));
    }


    public function postAddTimesheet(TimesheetRequest $request)
    {
        //kiểm tra nếu ngày đã khai báo thì thông báo
        $id = auth()->user()->id;
        $month = Carbon::now('Asia/Ho_Chi_Minh')->month;
        $year = Carbon::now('Asia/Ho_Chi_Minh')->year;
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $timesheet_create_of_month = $this->timesheet
            ->where('ctv_id', $id)
            ->whereMonth('date_work', $month)
            ->whereYear('date_work', $year)
            ->select('date_work')
            ->get();
        // foreach ($timesheet_create_of_month as $item) {
        //     if ($item->date_work == $request->date_work)
        //         return response()->json([
        //             'code' => 700,
        //             'i' => 'date_work',
        //             'message' => 'Ngày ' . $request->date_work . ' bạn đã khai báo!'
        //         ], 200);
        // }
        //kiểm tra điều kiện nhập vào
        if ($request->date_work > $now) {
            return response()->json([
                'code' => 700,
                'i' => 'date_work',
                'message' => 'Lỗi ngày làm việc'
            ], 200);
        }
        if ($request->total_hour < 0) {
            return response()->json([
                'code' => 700,
                'i' => 'total_hour',
                'message' => 'Giờ làm việc không được âm'
            ], 200);
        }
        if ($request->effective < 0 || $request->effective > 100) {
            return response()->json([
                'code' => 700,
                'i' => 'effective',
                'message' => 'Nhập sai hiệu quả công việc'
            ], 200);
        }
        $total_hour_math =   Carbon::parse(strtotime($request->end_time) - strtotime($request->start_time))->format('H:i');
        $timeArr = explode(':', $total_hour_math);
        $decTime = $timeArr[0] + ($timeArr[1]) / 60;
        if ($decTime < $request->total_hour) {
            return response()->json([
                'code' => 700,
                'i' => 'total_hour',
                'message' => 'Nhập sai giờ làm'
            ], 200);
        }
        //nếu chưa khai báo thì tạo mới
        try {
            DB::beginTransaction();
            $this->timesheet->create([
                'ctv_id' => $id,
                'manager_id' => auth()->user()->manager_id,
                'date_work' => $request->date_work,
                'project_id' => $request->project_id,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'total_hour' => $request->total_hour,
                'effective' => $request->effective,
                'description' => $request->description,
                'user_last_change' => 'ctv',
            ]);
            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ], 200);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            return response()->json([
                'code' => 500,
                'message' => 'fail'
            ], 500);
        }
    }

    public function getViewTimesheet()
    {
        $id = auth()->user()->id;
        $setting_time_salary = DB::table('settings')
            ->where('config_key', 'date_salary')
            ->value('config_value');
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d');
        if ($today < $setting_time_salary) {
            $month = Carbon::now('Asia/Ho_Chi_Minh')->month - 1;
        } else {
            $month = Carbon::now('Asia/Ho_Chi_Minh')->month;
        }
        $year = Carbon::now('Asia/Ho_Chi_Minh')->year;

        if ($month < 12) {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . ($month + 1) . '-' . $year)->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        } else {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . (1) . '-' . ($year + 1))->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        }
        $listTimesheet = DB::table('timesheets')
            ->whereDate('date_work', '>=', $date_old)
            ->whereDate('date_work', '<=', $date)
            ->where('ctv_id', $id)
            ->join('projects', 'timesheets.project_id', '=', 'projects.id')
            ->select('timesheets.id as id', 'timesheets.status_manager as status_manager', 'timesheets.date_work as date_work', 'timesheets.start_time as start_time', 'timesheets.end_time as end_time', 'timesheets.total_hour as total_hour', 'timesheets.effective as effective', 'timesheets.confirm_hour as confirm_hour', 'timesheets.confirm_effective as confirm_effective', 'timesheets.description as description', 'projects.name as name')
            ->orderBy('date_work', 'desc')
            ->get();
        //lấy năm lâu nhất cho đến bây giờ
        if ($this->timesheet->first()) {
            $old_year_ = $this->timesheet->orderBy('date_work', 'asc')->value('date_work');
            $old_year = Carbon::parse($old_year_)->format('Y');
        } else {
            $old_year = $year;
        }

        return view('congtacvien.timesheet.view', compact('listTimesheet', 'old_year', 'month', 'year'));
    }
    public function postViewTimesheet(Request $request)
    {
        $id = auth()->user()->id;
        $setting_time_salary = DB::table('settings')
            ->where('config_key', 'date_salary')
            ->value('config_value');
        $month = $request->data_month;
        $year = $request->data_year;
        if ($month < 12) {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . ($month + 1) . '-' . $year)->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        } else {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . (1) . '-' . ($year + 1))->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        }

        $listTimesheet = DB::table('timesheets')
            ->whereDate('date_work', '>=', $date_old)
            ->whereDate('date_work', '<=', $date)
            ->where('ctv_id', $id)
            ->join('projects', 'timesheets.project_id', '=', 'projects.id')
            ->select('timesheets.id as id', 'timesheets.status_manager as status_manager', 'timesheets.date_work as date_work', 'timesheets.start_time as start_time', 'timesheets.end_time as end_time', 'timesheets.total_hour as total_hour', 'timesheets.effective as effective', 'timesheets.confirm_hour as confirm_hour', 'timesheets.confirm_effective as confirm_effective', 'timesheets.description as description', 'projects.name as name')
            ->orderBy('date_work', 'desc')
            ->get();
        if ($this->timesheet->first()) {
            $old_year_ = $this->timesheet->orderBy('date_work', 'asc')->value('date_work');
            $old_year = Carbon::parse($old_year_)->format('Y');
        } else {
            $old_year = $year;
        }
        return view('congtacvien.timesheet.view', compact('listTimesheet', 'old_year', 'month', 'year'));
    }



    public function getEditTimesheet($id)
    {
        $user_id = auth()->user()->id;
        $date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $timesheet = $this->timesheet->findOrFail($id);
        $listProject_ = DB::table('project_users')
            ->where('user_id', $user_id)
            ->join('projects', 'project_users.project_id', '=', 'projects.id')
            ->select('projects.*')
            ->get();
        $listProject = [];
        foreach ($listProject_ as $item) {
            if ($item->end_time == null || $item->end_time >= $date) {
                $listProject[] = $item;
            }
        }
        return view('congtacvien.timesheet.edit', compact('timesheet', 'listProject'));
    }
    public function postEditTimesheet($id, Request $request)
    {
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        //kiểm tra điều kiện nhập vào
        if ($request->date_work > $now) {
            return response()->json([
                'code' => 700,
                'i' => 'date_work',
                'message' => 'Lỗi ngày làm việc'
            ], 200);
        }
        if ($request->total_hour < 0) {
            return response()->json([
                'code' => 700,
                'i' => 'total_hour',
                'message' => 'Giờ làm việc không được âm'
            ], 200);
        }
        if ($request->effective < 0 || $request->effective > 100) {
            return response()->json([
                'code' => 700,
                'i' => 'effective',
                'message' => 'Nhập sai hiệu quả công việc'
            ], 200);
        }

        $total_hour_math =   Carbon::parse(strtotime($request->end_time) - strtotime($request->start_time))->format('H:i');
        $timeArr = explode(':', $total_hour_math);
        $decTime = $timeArr[0] + ($timeArr[1]) / 60;
        if ($decTime < $request->total_hour) {
            return response()->json([
                'code' => 700,
                'i' => 'total_hour',
                'message' => 'Nhập sai giờ làm'
            ], 200);
        }
        $time_ctv = DB::table('settings')
            ->where('config_key', 'date_ctv')
            ->value('config_value');

        //convert sang dạng datetime
        $setting_time_ctv = Carbon::now('Asia/Ho_Chi_Minh')->subDays($time_ctv)->format('Y-m-d');
        $timesheetUpdate = $this->timesheet->findOrFail($id);
        if ($timesheetUpdate->date_work <= $setting_time_ctv && $timesheetUpdate->status_manager == 0) {
            return response()->json([
                'code' => 700,
                'i' => 'date_work',
                'message' => 'Không có quyền sửa bản khai này!'
            ], 200);
        }
        try {
            DB::beginTransaction();
            $timesheetUpdate->update([
                'project_id' => $request->project_id,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'total_hour' => $request->total_hour,
                'effective' => $request->effective,
                'description' => $request->description,
                'user_last_change' => 'ctv',
            ]);
            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'code' => 500,
                'message' => 'fail'
            ], 500);
        }
    }

    public function deleteTimesheet($id)
    {
        $time_ctv = DB::table('settings')
            ->where('config_key', 'date_ctv')
            ->value('config_value');
        //convert sang dạng datetime
        $setting_time_ctv = Carbon::now('Asia/Ho_Chi_Minh')->subDays($time_ctv)->format('Y-m-d');
        $timesheetUpdate = $this->timesheet->findOrFail($id);
        if ($timesheetUpdate->date_work <= $setting_time_ctv && $timesheetUpdate->status_manager == 0) {
            return response()->json([
                'code' => 700,
                'i' => 'date_work',
                'message' => 'Không có quyền xóa bản khai này!'
            ], 200);
        }
        $this->timesheet->findOrFail($id)->forceDelete();
        return response()->json([
            'code' => 200,
            'message' => 'success'
        ], 200);
    }
}
