<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use Carbon\Carbon;

class SettingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data_footer = DB::table('settings')
            ->where('config_key', 'footer')
            ->value('config_value');
        $data_logo = DB::table('settings')
            ->where('config_key', 'logo')
            ->value('config_value');
        view()->share('data_footer', $data_footer);
        view()->share('data_logo', $data_logo);
        //số ngày sau khi nhập timesheet mà cộng tác viên được sửa
        $time_ctv = DB::table('settings')
            ->where('config_key', 'date_ctv')
            ->value('config_value');

        //convert sang dạng datetime
        $setting_time_ctv = Carbon::now('Asia/Ho_Chi_Minh')->subDays($time_ctv)->format('Y-m-d');
        view()->share('setting_time_ctv', $setting_time_ctv);


        return $next($request);
    }
}
