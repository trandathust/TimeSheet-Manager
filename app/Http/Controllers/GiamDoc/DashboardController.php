<?php

namespace App\Http\Controllers\GiamDoc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $setting_time_salary = DB::table('settings')
            ->where('config_key', 'date_salary')
            ->value('config_value');
        $setting_salary = DB::table('settings')
            ->where('config_key', 'salary')
            ->value('config_value');
        $year = Carbon::now()->year;
        //lấy ra danh sách tháng tính lương trong năm.
        $listDate = [];
        $today = Carbon::now()->format('d');
        if ($today < $setting_time_salary) {
            $month_now = Carbon::now()->month - 1;
        } else {
            $month_now = Carbon::now()->month;
        }
        for ($i = 1; $i <= $month_now; $i++) {
            $month = $i;
            if ($month < 12) {
                $date = Carbon::parse(($setting_time_salary - 1) . '-' . ($month + 1) . '-' . $year)->format('Y-m-d');
                $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
                $listDate[] = [
                    'date' => $date,
                    'date_old' => $date_old,
                ];
            } else {
                $date = Carbon::parse(($setting_time_salary - 1) . '-' . (1) . '-' . ($year + 1))->format('Y-m-d');
                $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
                $listDate[] = [
                    'date' => $date,
                    'date_old' => $date_old,
                ];
            }
        }
        $dataSalary = [];
        $month_ = 1;
        foreach ($listDate as $item) {
            //lấy ra tổng số timesheet theo tháng
            $listTimesheet  = $this->timesheet
                ->whereDate('date_work', '>=', $item['date_old'])
                ->whereDate('date_work', '<=', $item['date'])
                ->get();
            $total_money = 0;

            foreach ($listTimesheet as $subitem) {
                $total_money = $total_money + $subitem['confirm_hour'] * $subitem['confirm_effective'] / 100 * $setting_salary;
            }
            $dataSalary[] = [
                'total_money' => $total_money,
                'month' => $month_,
            ];
            $month_ = $month_ + 1;
        }

        //tổng tiền lương cả năm
        $total_Salary_of_Year = 0;
        foreach ($dataSalary as $item) {
            $total_Salary_of_Year = $total_Salary_of_Year + $item['total_money'];
        }


        //thống kê giờ làm trong tháng
        if ($month_now < 12) {
            $date_month_now = Carbon::parse(($setting_time_salary - 1) . '-' . ($month_now + 1) . '-' . $year)->format('Y-m-d');
            $date_old_month_now = Carbon::parse($setting_time_salary . '-' . $month_now . '-' . $year)->format('Y-m-d');
        } else {
            $date_month_now = Carbon::parse(($setting_time_salary - 1) . '-' . (1) . '-' . ($year + 1))->format('Y-m-d');
            $date_old_month_now = Carbon::parse($setting_time_salary . '-' . $month_now . '-' . $year)->format('Y-m-d');
        }

        $dataHour = DB::table('timesheets')
            ->whereDate('date_work', '>=', $date_old_month_now)
            ->whereDate('date_work', '<=', $date_month_now)
            ->select(DB::raw('SUM(total_hour) as total_hour'), DB::raw('SUM(confirm_hour) as confirm_hour'), 'date_work as date_work')
            ->groupBy('date_work')
            ->orderBy('date_work', 'asc')
            ->get();

        $total_hour_of_month = 0;
        $total_hour_of_month_confirm = 0;
        foreach ($dataHour as $item) {
            $total_hour_of_month = $total_hour_of_month + $item->total_hour;
            $total_hour_of_month_confirm = $total_hour_of_month_confirm + $item->confirm_hour;
        }

        //tổng quan dự án

        //lấy ra danh sách dự án
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $listProject_ = DB::table('projects')
            ->whereNull('projects.deleted_at')
            ->join('project_users', 'projects.id', '=', 'project_users.project_id')
            ->join('users', 'project_users.user_id', '=', 'users.id')
            ->where('users.role', 'ctv')
            ->select('projects.id as id', 'projects.end_time as end_time', 'projects.name as name', 'projects.status as status', DB::raw('COUNT(user_id) as count'))
            ->groupBy('name', 'end_time', 'status', 'id')
            ->get();

        $dataProject = [];
        foreach ($listProject_ as $item) {
            if ($item->status == 1 && ($item->end_time == null || $item->end_time >= $now)) {
                $dataProject[] = $item;
            }
        }
        $total_project_off = 0;
        $listProject_ = DB::table('projects')->get();
        foreach ($listProject_ as $item) {
            if ($item->status == 0 || ($item->end_time < $now && $item->end_time != null)) {
                $total_project_off = $total_project_off + 1;
            }
        }

        $total_ctv = 0;
        $total_ctv = DB::table('users')
            ->where('role', 'ctv')
            ->where('status', 1)
            ->get();
        $total_ctv = count($total_ctv);

        //xếp hạng cộng tác viên
        $list_ctv = DB::table('timesheets')
            ->whereDate('date_work', '>=', $date_old_month_now)
            ->whereDate('date_work', '<=', $date_month_now)
            ->join('users', 'timesheets.ctv_id', '=', 'users.id')
            ->select('users.name as name', 'users.id as id', DB::raw('SUM(total_hour) as total_hour'), DB::raw('SUM(confirm_hour) as confirm_hour'))
            ->groupBy('name', 'id')
            ->orderBy('total_hour', 'asc')
            ->simplePaginate(3);

        $rank_ctv = [];
        foreach ($list_ctv as $item) {
            $list_ctv_temp = DB::table('timesheets')
                ->whereDate('date_work', '>=', $date_old_month_now)
                ->whereDate('date_work', '<=', $date_month_now)
                ->where('ctv_id', $item->id)
                ->get();
            $total_salary_ctv = 0;
            foreach ($list_ctv_temp as $subitem) {
                $total_salary_ctv = $total_salary_ctv + $subitem->confirm_hour * $subitem->confirm_effective / 100 * $setting_salary;
            }
            $rank_ctv[] = [
                'total_salary' => $total_salary_ctv,
                'name' => $item->name,
                'total_hour' => $item->total_hour,
                'confirm_hour' => $item->confirm_hour,
            ];
        }


        //xếp hạng dự án
        $list_project = DB::table('timesheets')
            ->whereDate('date_work', '>=', $date_old_month_now)
            ->whereDate('date_work', '<=', $date_month_now)
            ->join('projects', 'timesheets.project_id', '=', 'projects.id')
            ->select('projects.id as id', 'projects.name as name', DB::raw('SUM(timesheets.total_hour) as total_hour'), DB::raw('SUM(timesheets.confirm_hour) as confirm_hour'))
            ->groupBy('projects.name', 'projects.id')
            // ->orderBy('timesheets.total_hour', 'asc')
            ->simplePaginate(3);

        $rank_project = [];
        foreach ($list_project as $item) {
            foreach ($dataProject as $subitem) {
                if ($subitem->id  == $item->id) {
                    $rank_project[] = [
                        'name' => $item->name,
                        'total_hour' => $item->total_hour,
                        'confirm_hour' => $item->confirm_hour,
                        'total_ctv' => $subitem->count,
                    ];
                }
            }
        }
        return view('giamdoc.content', compact('rank_project', 'rank_ctv', 'total_ctv', 'total_project_off', 'dataProject', 'total_hour_of_month_confirm', 'total_hour_of_month', 'dataSalary', 'total_Salary_of_Year', 'dataHour'));
    }
}
