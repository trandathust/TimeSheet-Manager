<?php

namespace App\Http\Controllers\QuanLy;

use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
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
        $manager_id = auth()->user()->id;
        //ngày tính lương được giám đốc cài đặt
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
        // dd($month, $year, $setting_time_salary);
        $date = Carbon::parse(($setting_time_salary - 1) . '-' . ($month + 1) . '-' . $year)->format('Y-m-d');
        $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');

        $listProject = DB::table('timesheets')
            ->join('projects', 'timesheets.project_id', '=', 'projects.id')
            ->select('projects.name as name', DB::raw('SUM(total_hour) as total_hour'), DB::raw('SUM(confirm_hour) as confirm_hour'), DB::raw('ROUND(AVG(effective),2) as effective'), DB::raw('ROUND(AVG(confirm_effective),2) as confirm_effective'))
            ->whereDate('date_work', '>=', $date_old)
            ->whereDate('date_work', '<=', $date)
            ->where('manager_id', $manager_id)
            ->groupBy('name')
            ->get();

        $total_hour = 0;
        $confirm_hour  = 0;
        $confirm_effective_ = 0;
        $confirm_effective = 0;
        if ($listProject->first()) {
            $i = 0;
            foreach ($listProject as $item) {
                $total_hour = $total_hour + $item->total_hour;
                $confirm_hour = $confirm_hour + $item->confirm_hour;
                $confirm_effective_ = $confirm_effective_ + $item->confirm_effective;
                $i = $i + 1;
            }
            $confirm_effective = round($confirm_effective_ / $i, 2);
        }
        // bảng thống kê bên phải
        $listTimesheet = DB::table('timesheets')
            ->whereDate('timesheets.date_work', '>=', $date_old)
            ->whereDate('timesheets.date_work', '<=', $date)
            ->where('timesheets.manager_id', $manager_id)
            ->join('projects', 'timesheets.project_id', '=', 'projects.id')
            ->join('users', 'users.id', '=', 'timesheets.ctv_id')
            ->select('users.name as user_name', 'timesheets.user_last_change as user_last_change', 'timesheets.created_at as created_at', 'timesheets.id as id', 'timesheets.status_manager as status_manager', 'timesheets.date_work as date_work', 'timesheets.start_time as start_time', 'timesheets.end_time as end_time', 'timesheets.total_hour as total_hour', 'timesheets.effective as effective', 'timesheets.confirm_hour as confirm_hour', 'timesheets.confirm_effective as confirm_effective', 'timesheets.description as description', 'projects.name as project_name')
            ->orderBy('timesheets.date_work', 'desc')
            ->get();
        $timesheet_total = 0;
        $timesheet_change = 0;
        $timesheet_new = 0;
        $timesheet_not_confirm = 0;
        $timesheet_confirm = 0;
        foreach ($listTimesheet as $item) {
            $created_at = Carbon::parse($item->created_at)->format('d');
            $timesheet_total = $timesheet_total + 1;
            if ($item->user_last_change == 'ctv' && ($item->confirm_effective != null || $item->confirm_hour != null)) {
                $timesheet_change = $timesheet_change + 1;
            }
            if ($created_at == $today) {
                $timesheet_new = $timesheet_new + 1;
            }
            if ($item->confirm_hour == null || $item->confirm_effective == null) {
                $timesheet_not_confirm = $timesheet_not_confirm + 1;
            }
            if ($item->confirm_hour != null && $item->confirm_effective != null) {
                $timesheet_confirm = $timesheet_confirm + 1;
            }
        }

        return view('quanly.content', compact('listTimesheet', 'listProject', 'total_hour', 'confirm_hour', 'confirm_effective', 'timesheet_total', 'timesheet_change', 'timesheet_new', 'timesheet_not_confirm', 'timesheet_confirm'));
    }
}
