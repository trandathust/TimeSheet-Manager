<?php

namespace App\Http\Controllers\QuanLyNhanSu;

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

        return view('quanlynhansu.content', compact('total_hour_of_month_confirm', 'total_hour_of_month', 'dataSalary', 'total_Salary_of_Year', 'dataHour'));
    }
}
