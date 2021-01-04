<?php

namespace App\Http\Controllers\GiamDoc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Timesheet;

class ReportSalaryController extends Controller
{
    private $user;
    private $timesheet;
    public function __construct(User $user, Timesheet $timesheet)
    {
        $this->user = $user;
        $this->timesheet = $timesheet;
    }
    public function getSalary()
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
        $year_now = $year;

        return view('giamdoc.report.salary', compact('year_now', 'salary', 'listCTV', 'setting_salary', 'old_year', 'year', 'month'));
    }

    public function postSalary(Request $request)
    {
        $setting_time_salary = DB::table('settings')
            ->where('config_key', 'date_salary')
            ->value('config_value');
        $today = Carbon::now()->format('d');
        $month = $request->month;
        $year = $request->year;
        $year_now = Carbon::now('Asia/Ho_Chi_Minh')->year;
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

        return view('giamdoc.report.salary', compact('salary', 'listCTV', 'setting_salary', 'old_year', 'year', 'month', 'year_now'));
    }
}
