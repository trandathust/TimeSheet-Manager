<?php

namespace App\Http\Controllers\QuanLyNhanSu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Models\Timesheet;
use App\Traits\ConvertMoney;

class PrintController extends Controller
{
    use ConvertMoney;
    private $timesheet;
    public function __construct(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
    }
    public function getPrintTimesheet($id, $month, $year)
    {
        //ngày tính lương được giám đốc cài đặt
        $setting_time_salary = DB::table('settings')
            ->where('config_key', 'date_salary')
            ->value('config_value');
        $today = Carbon::now()->format('d');

        if ($month < 12) {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . ($month + 1) . '-' . $year)->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        } else {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . (1) . '-' . ($year + 1))->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        }
        $listTimesheet = DB::table('timesheets')
            ->whereDate('timesheets.date_work', '>=', $date_old)
            ->whereDate('timesheets.date_work', '<=', $date)
            ->where('timesheets.ctv_id', $id)
            ->join('projects', 'timesheets.project_id', '=', 'projects.id')
            ->join('users', 'users.id', '=', 'timesheets.ctv_id')
            ->select('users.name as user_name', 'timesheets.user_last_change as user_last_change', 'timesheets.created_at as created_at', 'timesheets.id as id', 'timesheets.status_manager as status_manager', 'timesheets.date_work as date_work', 'timesheets.start_time as start_time', 'timesheets.end_time as end_time', 'timesheets.total_hour as total_hour', 'timesheets.effective as effective', 'timesheets.confirm_hour as confirm_hour', 'timesheets.confirm_effective as confirm_effective', 'timesheets.description as description', 'projects.name as project_name')
            ->orderBy('date_work', 'desc')
            ->get();
        $user = DB::table('timesheets')
            ->join('users', 'timesheets.ctv_id', '=', 'users.id')
            ->where('users.id', $id)
            ->select('users.name as name', 'users.manager_id as manager_id', 'users.phone as phone', 'users.email as email', DB::raw('SUM(timesheets.total_hour) as total_hour'), DB::raw('SUM(timesheets.confirm_hour) as confirm_hour'), DB::raw('AVG(confirm_effective) as confirm_effective'))
            ->whereDate('date_work', '>=', $date_old)
            ->whereDate('date_work', '<=', $date)
            ->groupBy('name', 'phone', 'email', 'manager_id')
            ->get()->toArray();
        $setting_salary = DB::table('settings')
            ->where('config_key', 'salary')
            ->value('config_value');
        $total_salary = 0;
        foreach ($listTimesheet as $item) {
            $total_salary = $total_salary + ($item->confirm_hour * $item->confirm_effective / 100 * $setting_salary);
        }
        //tìm quản lý
        $manager_name = DB::table('users')
            ->where('id', $user[0]->manager_id)
            ->value('name');
        $president_name = DB::table('users')
            ->where('role', 'president')
            ->value('name');
        return view('quanlynhansu.report.print.print_timesheet', compact('listTimesheet', 'manager_name', 'president_name', 'setting_salary', 'user', 'month', 'year', 'total_salary'));
    }

    public function getPrintPayment($id, $month, $year)
    {
        $setting_time_salary = DB::table('settings')
            ->where('config_key', 'date_salary')
            ->value('config_value');
        $day = Carbon::now()->format('d');
        if ($month < 12) {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . ($month + 1) . '-' . $year)->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        } else {
            $date = Carbon::parse(($setting_time_salary - 1) . '-' . (1) . '-' . ($year + 1))->format('Y-m-d');
            $date_old = Carbon::parse($setting_time_salary . '-' . $month . '-' . $year)->format('Y-m-d');
        }
        $user = DB::table('timesheets')
            ->join('users', 'timesheets.ctv_id', '=', 'users.id')
            ->where('users.id', $id)
            ->select('users.name as name', 'users.manager_id as manager_id', 'users.phone as phone', 'users.email as email', DB::raw('SUM(timesheets.total_hour) as total_hour'), DB::raw('SUM(timesheets.confirm_hour) as confirm_hour'), DB::raw('AVG(confirm_effective) as confirm_effective'))
            ->whereDate('date_work', '>=', $date_old)
            ->whereDate('date_work', '<=', $date)
            ->groupBy('name', 'phone', 'email', 'manager_id')
            ->get()->toArray();
        $listTimesheet = DB::table('timesheets')
            ->whereDate('timesheets.date_work', '>=', $date_old)
            ->whereDate('timesheets.date_work', '<=', $date)
            ->where('timesheets.ctv_id', $id)
            ->join('projects', 'timesheets.project_id', '=', 'projects.id')
            ->join('users', 'users.id', '=', 'timesheets.ctv_id')
            ->select('users.name as user_name', 'timesheets.user_last_change as user_last_change', 'timesheets.created_at as created_at', 'timesheets.id as id', 'timesheets.status_manager as status_manager', 'timesheets.date_work as date_work', 'timesheets.start_time as start_time', 'timesheets.end_time as end_time', 'timesheets.total_hour as total_hour', 'timesheets.effective as effective', 'timesheets.confirm_hour as confirm_hour', 'timesheets.confirm_effective as confirm_effective', 'timesheets.description as description', 'projects.name as project_name')
            ->orderBy('date_work', 'desc')
            ->get();
        $setting_salary = DB::table('settings')
            ->where('config_key', 'salary')
            ->value('config_value');
        $total_salary = 0;
        foreach ($listTimesheet as $item) {
            $total_salary = $total_salary + ($item->confirm_hour * $item->confirm_effective / 100 * $setting_salary);
        }
        $money = $this->convert_number_to_words($total_salary);
        $money_eng = $this->convertNumberToWord($total_salary);
        //tìm quản lý
        $manager_name = DB::table('users')
            ->where('id', $user[0]->manager_id)
            ->value('name');
        $president_name = DB::table('users')
            ->where('role', 'president')
            ->value('name');
        return view('quanlynhansu.report.print.print_payment', compact('money_eng', 'money', 'day', 'manager_name', 'president_name', 'setting_salary', 'user', 'month', 'year', 'total_salary'));
    }

    public function getPrintTotalSalary($month, $year)
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
        $listCTV = DB::table('timesheets')
            ->join('users', 'timesheets.ctv_id', '=', 'users.id')
            ->where('users.role', '=', 'ctv')
            ->select('users.name as name', 'users.phone as phone', 'users.id as id', DB::raw('SUM(timesheets.confirm_hour) as confirm_hour'))
            ->whereDate('date_work', '>=', $date_old)
            ->whereDate('date_work', '<=', $date)
            ->groupBy('name', 'phone', 'id')
            ->get();

        $setting_salary = DB::table('settings')
            ->where('config_key', 'salary')
            ->value('config_value');
        //tính lương tổng
        $salary = [];
        $total_salary = 0;
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
            $total_salary = $total_salary + $total_money_;
        }
        if ($this->timesheet->first()) {
            $old_year_ = $this->timesheet->orderBy('date_work', 'asc')->value('date_work');
            $old_year = Carbon::parse($old_year_)->format('Y');
        } else {
            $old_year = $year;
        }

        return view('quanlynhansu.report.print.print_total_salary', compact('total_salary', 'salary', 'listCTV', 'setting_salary', 'month', 'year'));
    }
}
