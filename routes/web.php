<?php

use Illuminate\Support\Facades\Route;


Route::get('', 'LoginController@Login')->name('getLogin');
Route::post('', 'LoginController@postLogin')->name('postLogin');
Route::get('logout', 'LoginController@Logout')->name('logout');

Route::middleware(['setting'])->group(function () {
    Route::middleware(['CheckCTV'])->group(function () {
        //cộng tác viên
        Route::prefix('nhan-vien')->group(function () {
            Route::get('trang-chu', 'CongTacVien\DashboardController@getDashboard')->name('ctv.Dashboard');

            //thông tin người dùng
            Route::prefix('ca-nhan')->group(function () {
                Route::get('thong-tin', 'CongTacVien\ProfileController@getProfile')->name('ctv.getProfile');
                Route::post('thong-tin', 'CongTacVien\ProfileController@postProfile')->name('ctv.postProfile');
                Route::get('mat-khau', 'CongTacVien\ProfileController@getPassword')->name('ctv.getPassword');
                Route::post('mat-khau', 'CongTacVien\ProfileController@postPassword')->name('ctv.postPassword');
            });

            //timesheet
            Route::prefix('timesheet')->group(function () {
                Route::get('khai-bao', 'CongTacVien\TimesheetController@getAddTimesheet')->name('ctv.getAddTimesheet');
                Route::post('khai-bao', 'CongTacVien\TimesheetController@postAddTimesheet')->name('ctv.postAddTimesheet');
                Route::get('sua/{id}', 'CongTacVien\TimesheetController@getEditTimesheet')->name('ctv.getEditTimesheet');
                Route::post('sua/{id}', 'CongTacVien\TimesheetController@postEditTimesheet')->name('ctv.postEditTimesheet');
                Route::get('thong-ke', 'CongTacVien\TimesheetController@getViewTimesheet')->name('ctv.getViewTimesheet');
                Route::post('thong-ke', 'CongTacVien\TimesheetController@postViewTimesheet')->name('ctv.postViewTimesheet');
                Route::get('xoa/{id}', 'CongTacVien\TimesheetController@deleteTimesheet')->name('ctv.deleteTimesheet');
            });
        });
    });
    //quản lý
    Route::middleware(['CheckQL'])->group(function () {
        Route::prefix('quan-ly')->group(function () {
            Route::get('trang-chu', 'QuanLy\DashboardController@getDashboard')->name('manager.Dashboard');

            //cá nhân
            Route::prefix('ca-nhan')->group(function () {
                Route::get('thong-tin', 'QuanLy\ProfileController@getProfile')->name('manager.getProfile');
                Route::post('thong-tin', 'QuanLy\ProfileController@postProfile')->name('manager.postProfile');
                Route::get('mat-khau', 'QuanLy\ProfileController@getPassword')->name('manager.getPassword');
                Route::post('mat-khau', 'QuanLy\ProfileController@postPassword')->name('manager.postPassword');
            });

            //timesheet

            Route::prefix('timesheet')->group(function () {
                Route::get('danh-gia', 'QuanLy\TimesheetController@getAssess')->name('manager.getAssess');
                Route::post('danh-gia-timesheet/{id}', 'QuanLy\TimesheetController@postAssess')->name('manager.postAssess');
                Route::get('xem-chi-tiet/{id}', 'QuanLy\TimesheetController@getDetailTimesheet')->name('manager.getDetailTimesheet');
                Route::post('xem-chi-tiet/{id}', 'QuanLy\TimesheetController@postDetailTimesheet')->name('manager.postDetailTimesheet');
                Route::post('danh-gia', 'QuanLy\TimesheetController@postViewAssess')->name('manager.postViewAssess');
            });
        });
    });
    Route::middleware(['CheckQLNS'])->group(function() {
        // người dùng
        Route::prefix('qlns')->group(function () {
            Route::get('trang-chu', 'QuanLyNhanSu\DashboardController@getDashboard')->name('qlns.Dashboard');

            Route::prefix('nhan-vien')->group(function () {
                Route::get('xem', 'QuanLyNhanSu\UserController@getViewUser')->name('qlns.getViewUser');
                Route::get('them-moi', 'QuanLyNhanSu\UserController@getAddUser')->name('qlns.getAddUser');
                Route::post('them-moi', 'QuanLyNhanSu\UserController@postAddUser')->name('qlns.postAddUser');
                Route::get('sua/{id}', 'QuanLyNhanSu\UserController@getEditUser')->name('qlns.getEditUser');
                Route::post('sua/{id}', 'QuanLyNhanSu\UserController@postEditUser')->name('qlns.postEditUser');
                Route::post('trangthai/{id}', 'QuanLyNhanSu\UserController@postStatusUser')->name('qlns.postStatusUser');
                Route::get('xoa/{id}', 'QuanLyNhanSu\UserController@getDeleteUser')->name('qlns.getDeleteUser');
                Route::get('du-an-cua-quan-ly', 'QuanLyNhanSu\UserController@getListProjectOfManager')->name('qlns.getListProjectOfManager');
            });

            //thông tin cá nhân
            Route::prefix('ca-nhan')->group(function () {
                Route::get('thong-tin', 'QuanLyNhanSu\ProfileController@getProfile')->name('qlns.getProfile');
                Route::post('thong-tin', 'QuanLyNhanSu\ProfileController@postProfile')->name('qlns.postProfile');
                Route::get('mat-khau', 'QuanLyNhanSu\ProfileController@getPassword')->name('qlns.getPassword');
                Route::post('mat-khau', 'QuanLyNhanSu\ProfileController@postPassword')->name('qlns.postPassword');
            });

            //báo cáo và in báo cáo
            Route::prefix('bao-cao')->group(function () {
                Route::get('timesheet', 'QuanLyNhanSu\ReportTimesheetController@getTimesheet')->name('qlns.getTimesheet');
                Route::post('timesheet', 'QuanLyNhanSu\ReportTimesheetController@postTimesheet')->name('qlns.postTimesheet');
                Route::get('tien-luong', 'QuanLyNhanSu\ReportSalaryController@getSalary')->name('qlns.getSalary');
                Route::post('tien-luong', 'QuanLyNhanSu\ReportSalaryController@postSalary')->name('qlns.postSalary');
                Route::get('chi-tiet-timesheet/{id}/{month}/{year}', 'QuanLyNhanSu\ReportTimesheetController@getDetailTimesheet')->name('qlns.getDetailTimesheet');
                Route::post('chi-tiet-timesheet', 'QuanLyNhanSu\ReportTimesheetController@postDetailTimesheet')->name('qlns.postDetailTimesheet');
                Route::get('chi-tiet-timesheet', 'QuanLyNhanSu\ReportTimesheetController@getDetail');
            });

            Route::prefix('print')->group(function () {
                Route::get('timesheet/{id}/{month}/{year}', 'QuanLyNhanSu\PrintController@getPrintTimesheet')->name('qlns.getPrintTimesheet');
                Route::get('payment/{id}/{month}/{year}', 'QuanLyNhanSu\PrintController@getPrintPayment')->name('qlns.getPrintPayment');
                Route::get('total-salary/{month}/{year}', 'QuanLyNhanSu\PrintController@getPrintTotalSalary')->name('qlns.getPrintTotalSalary');
            });
        });
    });

    Route::middleware(['CheckGD'])->group(function () {
        //giám đốc
        Route::prefix('giam-doc')->group(function () {
            Route::get('trang-chu', 'GiamDoc\DashboardController@getDashboard')->name('president.Dashboard');

            //quản lý dự án
            Route::prefix('du-an')->group(function () {
                Route::get('xem', 'GiamDoc\ProjectController@getViewProject')->name('president.getViewProject');
                Route::get('them-moi', 'GiamDoc\ProjectController@getAddProject')->name('president.getAddProject');
                Route::post('them-moi', 'GiamDoc\ProjectController@postAddProject')->name('president.postAddProject');
                Route::get('sua/{id}', 'GiamDoc\ProjectController@getEditProject')->name('president.getEditProject');
                Route::post('sua/{id}', 'GiamDoc\ProjectController@postEditProject')->name('president.postEditProject');
                Route::get('xoa/{id}', 'GiamDoc\ProjectController@deleteProject')->name('president.deleteProject');
            });

            //thông tin cá nhân
            Route::prefix('ca-nhan')->group(function () {
                Route::get('thong-tin', 'GiamDoc\ProfileController@getProfile')->name('president.getProfile');
                Route::post('thong-tin', 'GiamDoc\ProfileController@postProfile')->name('president.postProfile');
                Route::get('mat-khau', 'GiamDoc\ProfileController@getPassword')->name('president.getPassword');
                Route::post('mat-khau', 'GiamDoc\ProfileController@postPassword')->name('president.postPassword');
            });

            //báo cáo và in báo cáo
            Route::prefix('bao-cao')->group(function () {
                Route::get('timesheet', 'GiamDoc\ReportTimesheetController@getTimesheet')->name('president.getTimesheet');
                Route::post('timesheet', 'GiamDoc\ReportTimesheetController@postTimesheet')->name('president.postTimesheet');
                Route::get('tien-luong', 'GiamDoc\ReportSalaryController@getSalary')->name('president.getSalary');
                Route::post('tien-luong', 'GiamDoc\ReportSalaryController@postSalary')->name('president.postSalary');
                Route::get('chi-tiet-timesheet/{id}/{month}/{year}', 'GiamDoc\ReportTimesheetController@getDetailTimesheet')->name('president.getDetailTimesheet');
                Route::post('chi-tiet-timesheet', 'GiamDoc\ReportTimesheetController@postDetailTimesheet')->name('president.postDetailTimesheet');
                Route::get('chi-tiet-timesheet', 'GiamDoc\ReportTimesheetController@getDetail');
            });

            Route::prefix('print')->group(function () {
                Route::get('timesheet/{id}/{month}/{year}', 'GiamDoc\PrintController@getPrintTimesheet')->name('president.getPrintTimesheet');
                Route::get('payment/{id}/{month}/{year}', 'GiamDoc\PrintController@getPrintPayment')->name('president.getPrintPayment');
                Route::get('total-salary/{month}/{year}', 'GiamDoc\PrintController@getPrintTotalSalary')->name('president.getPrintTotalSalary');
            });

            //cài đặt
            Route::prefix('cai-dat')->group(function () {
                Route::get('', 'GiamDoc\SettingController@getSetting')->name('president.getSetting');
                Route::post('', 'GiamDoc\SettingController@postSetting')->name('president.postSetting');
            });
        });
    });
});
