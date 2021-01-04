@extends('quanlynhansu.layout')

@section('title')
<title>Dashboard | SkyMapGlobal</title>
@endsection
@section('content')
<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Trang Chủ</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"><b>Thống Kê Giờ Làm Trong Tháng</b></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">
                                        <a style="color: #93979b">{{$total_hour_of_month}}h</a> -
                                        <a style="color: #007bff">{{$total_hour_of_month_confirm}}h</a></span>
                                    <span class="text-muted"> Tổng giờ làm</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                </p>
                            </div>

                            <div class="position-relative mb-4">
                                <canvas id="hour-chart" height="200" data-hour="{{$dataHour}}"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> Đã xác nhận
                                </span>

                                <span>
                                    <i class="fas fa-square text-gray"></i> Chưa xác nhận
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"> <b>Thống Kê Tiền Lương</b> </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">{{number_format($total_Salary_of_Year)}}VNĐ</span>
                                    <span class="text-muted">Năm nay</span>
                                </p>

                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="salary-chart" height="200"
                                    data-salary="{{json_encode($dataSalary)}}"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> Tiền lương
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('js')
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('vendor/giamdoc/dashboard/dashboard.js')}}"></script>


@endsection
