<?php

namespace App\Http\Controllers\QuanLyNhanSu;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Traits\ConvertMoney;

class ReportTimesheetController extends Controller
{
    use ConvertMoney;
    private $user;
    private $timesheet;
    public function __construct(User $user, Timesheet $timesheet)
    {
        $this->user = $user;
        $this->timesheet = $timesheet;
    }
    public function getTimesheet()
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

        $listCTV = DB::table('timesheets')
            ->join('users', 'timesheets.ctv_id', '=', 'users.id')
            ->where('users.role', '=', 'ctv')
            ->select('users.name as name', 'users.phone as phone', 'users.id as id', DB::raw('SUM(timesheets.total_hour) as total_hour'), DB::raw('SUM(timesheets.confirm_hour) as confirm_hour'), DB::raw('ROUND(AVG(confirm_effective),2) as confirm_effective'))
            ->whereDate('date_work', '>=', $date_old)
            ->whereDate('date_work', '<=', $date)
            ->groupBy('name', 'phone', 'id')
            ->get();

        $setting_salary = DB::table('settings')
            ->where('config_key', 'salary')
            ->value('config_value');
        //tính lương tổng
        $salary = [];
        foreach ($listCTV as $item) {
            $list_timesheet_ = DB::table('timesheets')
                ->where('ctv_id', $item->id)
                ->whereDate('date_work', '>=', $date_old)
                ->whereDate('date_work', '<=', $date)
                ->get();
            $total_money_ = 0;
            foreach ($list_timesheet_ as $subitem) {
                $total_money_ = $total_money_ + $subitem->confirm_hour * $subitem->confirm_effective / 100 * $setting_salary;
            }
            $salary[] = [
                'id' => $item->id,
                'total_money' => $total_money_,
            ];
        }
        if ($this->timesheet->first()) {
            $old_year_ = $this->timesheet->orderBy('date_work', 'asc')->value('date_work');
            $old_year = Carbon::parse($old_year_)->format('Y');
        } else {
            $old_year = $year;
        }
        $ctv_id = null;
        $listCTV_all = DB::table('users')
            ->where('role', 'ctv')
            ->get();

        $year_now = Carbon::now('Asia/Ho_Chi_Minh')->year;
        return view('quanlynhansu.report.all_timesheet', compact('year_now', 'salary', 'ctv_id', 'listCTV_all', 'listCTV', 'setting_salary', 'old_year', 'year', 'month'));
    }

    public function postTimesheet(Request $request)
    {
        $setting_time_salary = DB::table('settings')
            ->where('config_key', 'date_salary')
            ->value('config_value');
        $today = Carbon::now()->format('d');
        $year_now = Carbon::now('Asia/Ho_Chi_Minh')->year;
        $month = $request->month;

        $year = $request->year;
        $ctv_id = $request->ctv;

        if ($month < 12) {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . ($month + 1) . '-' . $year)->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        } else {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . (1) . '-' . ($year + 1))->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        }
        if ($ctv_id) {
            $listCTV = DB::table('timesheets')
                ->join('users', 'timesheets.ctv_id', '=', 'users.id')
                ->where('users.id', '=', $ctv_id)
                ->select('users.name as name', 'users.phone as phone', 'users.id as id', DB::raw('SUM(timesheets.total_hour) as total_hour'), DB::raw('SUM(timesheets.confirm_hour) as confirm_hour'), DB::raw('ROUND(AVG(confirm_effective),2) as confirm_effective'))
                ->whereDate('date_work', '>=', $date_old)
                ->whereDate('date_work', '<=', $date)
                ->groupBy('name', 'phone', 'id')
                ->get();
        } else {
            $listCTV = DB::table('timesheets')
                ->join('users', 'timesheets.ctv_id', '=', 'users.id')
                ->where('users.role', '=', 'ctv')
                ->select('users.name as name', 'users.phone as phone', 'users.id as id', DB::raw('SUM(timesheets.total_hour) as total_hour'), DB::raw('SUM(timesheets.confirm_hour) as confirm_hour'), DB::raw('ROUND(AVG(confirm_effective),2) as confirm_effective'))
                ->whereDate('date_work', '>=', $date_old)
                ->whereDate('date_work', '<=', $date)
                ->groupBy('name', 'phone', 'id')
                ->get();
        }
        $setting_salary = DB::table('settings')
            ->where('config_key', 'salary')
            ->value('config_value');
        //tính lương tổng
        $salary = [];
        foreach ($listCTV as $item) {
            $list_timesheet_ = DB::table('timesheets')
                ->where('ctv_id', $item->id)
                ->whereDate('date_work', '>=', $date_old)
                ->whereDate('date_work', '<=', $date)
                ->get();
            $total_money_ = 0;
            foreach ($list_timesheet_ as $subitem) {
                $total_money_ = $total_money_ + $subitem->confirm_hour * $subitem->confirm_effective / 100 * $setting_salary;
            }
            $salary[] = [
                'id' => $item->id,
                'total_money' => $total_money_,
            ];
        }
        if ($this->timesheet->first()) {
            $old_year_ = $this->timesheet->orderBy('date_work', 'asc')->value('date_work');
            $old_year = Carbon::parse($old_year_)->format('Y');
        } else {
            $old_year = $year;
        }
        $listCTV_all = DB::table('users')
            ->where('role', 'ctv')
            ->get();

        return view('quanlynhansu.report.all_timesheet', compact('year_now', 'salary', 'ctv_id', 'listCTV_all', 'listCTV', 'setting_salary', 'old_year', 'year', 'month'));
    }



    public function getDetailTimesheet($id, $month, $year)
    {
        $setting_time_salary = DB::table('settings')
            ->where('config_key', 'date_salary')
            ->value('config_value');

        if ($month < 12) {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . ($month + 1) . '-' . $year)->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        } else {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . (1) . '-' . ($year + 1))->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        }
        $setting_salary = DB::table('settings')
            ->where('config_key', 'salary')
            ->value('config_value');

        $listTimesheet = DB::table('timesheets')
            ->whereDate('timesheets.date_work', '>=', $date_old)
            ->whereDate('timesheets.date_work', '<=', $date)
            ->where('timesheets.ctv_id', $id)
            ->join('projects', 'timesheets.project_id', '=', 'projects.id')
            ->select('timesheets.user_last_change as user_last_change', 'timesheets.created_at as created_at', 'timesheets.id as id', 'timesheets.status_manager as status_manager', 'timesheets.date_work as date_work', 'timesheets.start_time as start_time', 'timesheets.end_time as end_time', 'timesheets.total_hour as total_hour', 'timesheets.effective as effective', 'timesheets.confirm_hour as confirm_hour', 'timesheets.confirm_effective as confirm_effective', 'timesheets.description as description', 'projects.name as project_name')
            ->orderBy('date_work', 'desc')
            ->get();
        $total_money = 0;
        $total_hour = 0;
        foreach ($listTimesheet as $subitem) {
            $total_hour = $total_hour + $subitem->confirm_hour;
            $total_money = $total_money + $subitem->confirm_hour * $subitem->confirm_effective / 100 * $setting_salary;
        }

        if ($this->timesheet->first()) {
            $old_year_ = $this->timesheet->orderBy('date_work', 'asc')->value('date_work');
            $old_year = Carbon::parse($old_year_)->format('Y');
        } else {
            $old_year = $year;
        }
        $user = $this->user->findOrFail($id);
        $listCTV = $this->user->where('role', 'ctv')->get();
        $money = $this->convert_number_to_words($total_money);
        return view('quanlynhansu.report.detail_timesheet', compact('total_hour', 'money', 'id', 'listCTV', 'user', 'total_money', 'setting_salary', 'old_year', 'year', 'month', 'listTimesheet'));
    }

    public function postDetailTimesheet(Request $request)
    {
        $setting_time_salary = DB::table('settings')
            ->where('config_key', 'date_salary')
            ->value('config_value');
        $month = $request->month;
        $year = $request->year;
        $id = $request->ctv;

        if ($month < 12) {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . ($month + 1) . '-' . $year)->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        } else {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . (1) . '-' . ($year + 1))->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        }

        $setting_salary = DB::table('settings')
            ->where('config_key', 'salary')
            ->value('config_value');

        $listTimesheet = DB::table('timesheets')
            ->whereDate('timesheets.date_work', '>=', $date_old)
            ->whereDate('timesheets.date_work', '<=', $date)
            ->where('timesheets.ctv_id', $id)
            ->join('projects', 'timesheets.project_id', '=', 'projects.id')
            ->select('timesheets.user_last_change as user_last_change', 'timesheets.created_at as created_at', 'timesheets.id as id', 'timesheets.status_manager as status_manager', 'timesheets.date_work as date_work', 'timesheets.start_time as start_time', 'timesheets.end_time as end_time', 'timesheets.total_hour as total_hour', 'timesheets.effective as effective', 'timesheets.confirm_hour as confirm_hour', 'timesheets.confirm_effective as confirm_effective', 'timesheets.description as description', 'projects.name as project_name')
            ->orderBy('date_work', 'asc')
            ->get();
        $total_money = 0;
        $total_hour = 0;
        foreach ($listTimesheet as $subitem) {
            $total_hour = $total_hour + $subitem->confirm_hour;
            $total_money = $total_money + $subitem->confirm_hour * $subitem->confirm_effective / 100 * $setting_salary;
        }

        if ($this->timesheet->first()) {
            $old_year_ = $this->timesheet->orderBy('date_work', 'asc')->value('date_work');
            $old_year = Carbon::parse($old_year_)->format('Y');
        } else {
            $old_year = $year;
        }


        $user = $this->user->findOrFail($id);
        $listCTV = $this->user->where('role', 'ctv')->get();
        $money = $this->convert_number_to_words($total_money);
        return view('quanlynhansu.report.detail_timesheet', compact('total_hour', 'money', 'id', 'listCTV', 'user', 'total_money', 'setting_salary', 'old_year', 'year', 'month', 'listTimesheet'));
    }

    public function getDetail()
    {
        return back();
    }
}
