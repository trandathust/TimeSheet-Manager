<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuanLy\AssessTimesheetRequest;
use Illuminate\Http\Request;
use App\Models\Timesheet;
use Auth;
use Carbon\Carbon;
use DB;
use App\Models\User;

class TimesheetController extends Controller
{
    private $timesheet;
    private $user;
    public function __construct(Timesheet $timesheet, User $user)
    {
        $this->timesheet = $timesheet;
        $this->user = $user;
    }
    public function getAssess()
    {
        $manager_id = auth()->user()->id;
        //ngày tính lương được giám đốc cài đặt
        $date_temp = $this->getDateAndDateOld();
        $date_old = $date_temp['date_old'];
        $date = $date_temp['date'];
        $year = $date_temp['year'];
        $month = $date_temp['month'];
        $listTimesheet = DB::table('timesheets')
            ->whereDate('timesheets.date_work', '>=', $date_old)
            ->whereDate('timesheets.date_work', '<=', $date)
            ->where('timesheets.manager_id', $manager_id)
            ->join('projects', 'timesheets.project_id', '=', 'projects.id')
            ->join('users', 'users.id', '=', 'timesheets.ctv_id')
            ->select('users.name as user_name', 'timesheets.user_last_change as user_last_change', 'timesheets.created_at as created_at', 'timesheets.id as id', 'timesheets.status_manager as status_manager', 'timesheets.date_work as date_work', 'timesheets.start_time as start_time', 'timesheets.end_time as end_time', 'timesheets.total_hour as total_hour', 'timesheets.effective as effective', 'timesheets.confirm_hour as confirm_hour', 'timesheets.confirm_effective as confirm_effective', 'timesheets.description as description', 'projects.name as project_name')
            ->orderBy('timesheets.date_work', 'desc')
            ->get();
        $listCTVofManager = $this->user->where('manager_id', $manager_id)->get();
        //lấy năm lâu nhất cho đến bây giờ
        $old_year_ = $this->timesheet->orderBy('date_work', 'asc')->value('date_work');
        $old_year = Carbon::parse($old_year_)->format('Y');
        $ctv_id = null;
        $data_year = $year;
        $data_month = $month;
        $listTimesheetChange = [];
        foreach ($listTimesheet as $item) {
            if ($item->user_last_change == 'ctv' && ($item->confirm_effective != null || $item->confirm_hour != null)) {
                $listTimesheetChange[] = $item;
            }
        }
        return view('quanly.timesheet.assess', compact('listTimesheetChange', 'data_month', 'data_year', 'ctv_id', 'listTimesheet', 'old_year', 'month', 'year', 'listCTVofManager'));
    }
    public function postAssess($id, Request $request)
    {
        if ($request->confirm_hour < 0 || $request->confirm_hour > 24) {
            return response()->json([
                'code' => 700,
                'message' => 'Nhập sai giờ!'
            ], 200);
        }
        if ($request->confirm_effective < 0) {
            return response()->json([
                'code' => 700,
                'message' => 'Nhập sai hiệu quả!'
            ], 200);
        }
        try {
            DB::beginTransaction();
            if ($request->status_manager != null) {
                //check xem timesheet của tháng nào. nếu của tháng trước đã chốt lương thì không được sửa
                $timesheet = $this->timesheet->findOrFail($id);
                $date_temp = $this->getDateAndDateOld();
                $date_old = $date_temp['date_old'];
                if ($timesheet->date_work < $date_old)
                    return response()->json([
                        'code' => 700,
                        'message' => 'Bạn không có quyền sửa timesheet tháng này!'
                    ], 200);
                $timesheet->update([
                    'confirm_hour' => $request->confirm_hour,
                    'confirm_effective' => $request->confirm_effective,
                    'user_last_change' => 'manager',
                    'status_manager' => $request->status_manager,
                ]);
            } else {
                $this->timesheet->findOrFail($id)->update([
                    'confirm_hour' => $request->confirm_hour,
                    'confirm_effective' => $request->confirm_effective,
                    'user_last_change' => 'manager',
                ]);
            }

            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'Thông tin timesheet đã được lưu lại!'
            ], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'code' => 500,
                'message' => 'fail'
            ], 500);
        }
    }

    private function getDateAndDateOld()
    {
        $setting_time_salary = DB::table('settings')
            ->where('config_key', 'date_salary')
            ->value('config_value');
        $today = Carbon::now()->format('d');
        if ($today < $setting_time_salary) {
            $month = Carbon::now()->month - 1;
        } else {
            $month = Carbon::now()->month;
        }
        $year = Carbon::now()->year;

        if ($month < 12) {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . ($month + 1) . '-' . $year)->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        } else {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . (1) . '-' . ($year + 1))->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        }
        $data = [
            'date' => $date,
            'date_old' => $date_old,
            'year' => $year,
            'month' => $month,
        ];
        return $data;
    }



    //xem timesheet
    public function getDetailTimesheet($id)
    {
        $timesheet = $this->timesheet->findOrfail($id);
        return view('quanly.timesheet.detail', compact('timesheet'));
    }

    public function postViewAssess(Request $request)
    {

        $manager_id = auth()->user()->id;
        //ngày tính lương được giám đốc cài đặt
        $setting_time_salary = DB::table('settings')
            ->where('config_key', 'date_salary')
            ->value('config_value');
        $today = Carbon::now()->format('d');
        $ctv_id = $request->ctv;
        $year = $request->data_year;
        $month = $request->data_month;
        $data_year = $request->data_year;
        $data_month = $request->data_month;
        if ($month < 12) {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . ($month + 1) . '-' . $year)->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        } else {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . (1) . '-' . ($year + 1))->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        }
        $listCTVofManager = $this->user->where('manager_id', $manager_id)->get();
        //lấy năm lâu nhất cho đến bây giờ
        $old_year_ = $this->timesheet->orderBy('date_work', 'asc')->value('date_work');
        $old_year = Carbon::parse($old_year_)->format('Y');
        if ($ctv_id == null) {
            $listTimesheet = DB::table('timesheets')
                ->whereDate('timesheets.date_work', '>=', $date_old)
                ->whereDate('timesheets.date_work', '<=', $date)
                ->where('timesheets.manager_id', $manager_id)
                ->join('projects', 'timesheets.project_id', '=', 'projects.id')
                ->join('users', 'users.id', '=', 'timesheets.ctv_id')
                ->select('users.name as user_name', 'timesheets.user_last_change as user_last_change', 'timesheets.created_at as created_at', 'timesheets.id as id', 'timesheets.status_manager as status_manager', 'timesheets.date_work as date_work', 'timesheets.start_time as start_time', 'timesheets.end_time as end_time', 'timesheets.total_hour as total_hour', 'timesheets.effective as effective', 'timesheets.confirm_hour as confirm_hour', 'timesheets.confirm_effective as confirm_effective', 'timesheets.description as description', 'projects.name as project_name')
                ->orderBy('date_work', 'desc')
                ->get();
        } elseif ($ctv_id != null) {
            $listTimesheet = DB::table('timesheets')
                ->whereDate('timesheets.date_work', '>=', $date_old)
                ->whereDate('timesheets.date_work', '<=', $date)
                ->where('timesheets.manager_id', $manager_id)
                ->where('timesheets.ctv_id', $ctv_id)
                ->join('projects', 'timesheets.project_id', '=', 'projects.id')
                ->join('users', 'users.id', '=', 'timesheets.ctv_id')
                ->select('users.name as user_name', 'timesheets.user_last_change as user_last_change', 'timesheets.created_at as created_at', 'timesheets.id as id', 'timesheets.status_manager as status_manager', 'timesheets.date_work as date_work', 'timesheets.start_time as start_time', 'timesheets.end_time as end_time', 'timesheets.total_hour as total_hour', 'timesheets.effective as effective', 'timesheets.confirm_hour as confirm_hour', 'timesheets.confirm_effective as confirm_effective', 'timesheets.description as description', 'projects.name as project_name')
                ->orderBy('date_work', 'desc')
                ->get();
        }
        $listTimesheetChange = [];
        foreach ($listTimesheet as $item) {
            if ($item->user_last_change == 'ctv' && ($item->confirm_effective != null || $item->confirm_hour != null)) {
                $listTimesheetChange[] = $item;
            }
        }
        return view('quanly.timesheet.assess', compact('listTimesheetChange', 'listTimesheet', 'old_year', 'ctv_id', 'month', 'year', 'data_year', 'listCTVofManager', 'data_month'));
    }
}
