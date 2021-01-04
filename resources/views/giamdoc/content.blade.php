@extends('giamdoc.layout')

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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><b>Tổng Quan Dự Án</b> </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span>Tổng cộng tác viên: {{$total_ctv}}</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span>
                                    Dự án không hoạt động: {{$total_project_off}}
                                </span>
                            </p>
                        </div>

                        <div class="position-relative mb-4">
                            <canvas id="project-chart" height="200"
                                data-project="{{json_encode($dataProject)}}"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Dự án đang hoạt động
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"> <b>Xếp Hạng Cộng Tác Viên</b> </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Xếp Hạng</th>
                                    <th>Nhân Viên</th>
                                    <th>Tổng Giờ Làm</th>
                                    <th style="color: red">Được Đánh Giá</th>
                                    <th>Tiền Lương Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rank_ctv as $item)
                                <tr>
                                    <th>{{$loop -> index + 1}}</th>
                                    <td>{{$item['name']}}</td>
                                    <td>{{$item['total_hour']}}</td>
                                    <td style="color: red">{{$item['confirm_hour']}}</td>
                                    <td>{{$item['total_salary']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"> <b>Xếp Hạng Dự Án</b> </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Xếp Hạng</th>
                                    <th>Dự Án</th>
                                    <th>Số Nhân Viên</th>
                                    <th>Số Giờ Làm</th>
                                    <td style="color: red">Được Xác Nhận</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rank_project as $item)
                                <tr>
                                    <th>{{$loop -> index + 1}}</th>
                                    <td>{{$item['name']}}</td>
                                    <td>{{$item['total_ctv']}}</td>
                                    <td>{{$item['total_hour']}}</td>
                                    <td style="color:red">{{$item['confirm_hour']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
