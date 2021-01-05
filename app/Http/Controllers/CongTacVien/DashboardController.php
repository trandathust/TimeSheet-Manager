<?php

namespace App\Http\Controllers\CongTacVien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Models\Timesheet;

class DashboardController extends Controller
{
    private $timesheet;
    public function __construct(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
    }
    public function getDashboard()
    {

        //thêm timesheet mới
        $id = auth()->user()->id;
        $date_today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $start_time = Carbon::create(0, 1, 1, 8, 0, 0)->format('h:i');
        $end_time = Carbon::now('Asia/Ho_Chi_Minh')->format('H:i');
        $day_now = Carbon::now('Asia/Ho_Chi_Minh')->format('d');

        $listProject_ = DB::table('project_users')
            ->where('user_id', $id)
            ->join('projects', 'project_users.project_id', '=', 'projects.id')
            ->where('projects.status', 1)
            ->whereNull('deleted_at')
            ->select('projects.id as id', 'projects.name as name', 'projects.end_time as end_time')
            ->get();
        $listProject = [];
        foreach ($listProject_ as $item) {
            if ($item->end_time == null || $item->end_time >= $date_today) {
                $listProject[] = $item;
            }
        }
        //bảng thống kê timesheet trong tháng.
        $setting_time_salary = DB::table('settings')
            ->where('config_key', 'date_salary')
            ->value('config_value');
        if ($day_now < $setting_time_salary) {
            $month = Carbon::now()->month - 1;
        } else {
            $month = Carbon::now()->month;
        }
        $year = Carbon::now()->year;
        $date = Carbon::parse(($setting_time_salary - 1) . '-' . ($month + 1) . '-' . $year)->format('Y-m-d');
        $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        $listTimesheet = DB::table('timesheets')
            ->whereDate('date_work', '>=', $date_old)
            ->whereDate('date_work', '<=', $date)
            ->where('ctv_id', $id)
            ->join('projects', 'timesheets.project_id', '=', 'projects.id')
            ->select('timesheets.id as id', 'timesheets.status_manager as status_manager', 'timesheets.date_work as date_work', 'timesheets.start_time as start_time', 'timesheets.end_time as end_time', 'timesheets.total_hour as total_hour', 'timesheets.effective as effective', 'timesheets.confirm_hour as confirm_hour', 'timesheets.confirm_effective as confirm_effective', 'timesheets.description as description', 'projects.name as name')
            ->orderBy('date_work', 'desc')
            ->get();

        //biểu đồ thời gian làm việc trong tháng.
        $hour_work_ofMonth = DB::table('timesheets')
            ->select(DB::raw('day(date_work) as getDay'), 'total_hour as total_hour', 'confirm_hour as confirm_hour', 'effective as effective', 'confirm_effective as confirm_effective')
            ->whereDate('date_work', '>=', $date_old)
            ->where('ctv_id', $id)
            ->orderBy(DB::raw('date_work'), 'ASC')
            ->get();
        $total_hour = 0;
        $salary = 0;
        $setting_salary = DB::table('settings')
            ->where('config_key', 'salary')
            ->value('config_value');
        foreach ($hour_work_ofMonth as $item) {
            $total_hour = $total_hour + $item->total_hour;
            if ($item->confirm_hour != null && $item->confirm_effective != null) {
                $salary = $salary + $item->confirm_hour * $item->confirm_effective / 100 * $setting_salary;
            } else {
                $salary = $salary + $item->total_hour * $item->effective / 100 * $setting_salary;
            }
        }
        $setting_salary = DB::table('settings')
            ->where('config_key', 'salary')
            ->value('config_value');
        return view('congtacvien.content', compact('listTimesheet', 'listProject', 'date_today', 'start_time', 'end_time', 'hour_work_ofMonth', 'total_hour', 'salary'));
    }
}
