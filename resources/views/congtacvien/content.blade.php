@extends('congtacvien.layout')
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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"><b>Thống Kê Trong Tháng</b></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">{{$total_hour}}h</span>
                                    <span>Giờ Làm Việc</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        <i class="fas fa-dollar-sign"></i>{{number_format($salary)}}đ
                                    </span>
                                    <span class="text-muted">Tiền lương tạm tính</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="work-chart" height="210" width="500"
                                    data-hour="{{$hour_work_ofMonth}}"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> Được xác nhận
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-square text-secondary"></i> Chưa xác nhận
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"><b>Thống Kê Tiền Lương Trong Năm</b></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">
                                        <i class="fas fa-dollar-sign"></i>
                                        {{number_format($total_salary_of_year)}}đ </span>
                                    <span>Tổng tiền lương</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        {{$total_hour_of_year}}h
                                    </span>
                                    <span class="text-muted">Giờ làm việc</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="salary-chart" height="210" width="500"
                                    data-salary="{{json_encode($total_hour_each_Month)}}"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> Tiền lương
                                </span>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <h3 class="card-title"><b>Khai Báo TimeSheet</b></h3>
                            </div>
                            <form method="POST" action="{{route('ctv.postAddTimesheet')}}" id="form_timesheet">
                                @csrf
                                <div class="card-body">
                                    <div class="form-row">
                                        <!--row -->
                                        <div class="form-group col-md-6">
                                            <label>Ngày</label>
                                            <input type="date" name="date_work" id="date_work" value="{{$date_today}}"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Chọn Dự Án</label>
                                            <select class="custom-select" name="project_id" id="project_id">
                                                @foreach($listProject as $item)
                                                <option value="{{$item -> id}}">{{$item -> name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col">
                                            <label>Giờ Đến (h))</label>
                                            <input type="time" name="start_time" id="start_time" class="form-control"
                                                value="{{$start_time}}">
                                        </div>
                                        <div class="form-group col">
                                            <label>Giờ Về (h)</label>
                                            <input type="time" name="end_time" id="end_time" class="form-control"
                                                value="{{$end_time}}">
                                        </div>
                                        <div class="form-group col">
                                            <label>Giờ làm (h)</label>
                                            <input type="number" name="total_hour" id="total_hour" min="0" max="24"
                                                class="form-control" placeholder="Giờ Làm (8)">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <!--row -->
                                        <div class="form-group col-md-6">
                                            <label>Hiệu Quả (%)</label>
                                            <input type="number" name="effective" id="effective" min="0" max="100"
                                                class="form-control" placeholder="Nhập hiệu quả(90%)">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="comment">Mô tả công việc</label>
                                            <textarea class="form-control" rows="2" name="description" id="description"
                                                placeholder="Nhập mô tả..."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <!--end car-body-->
                                <div class="row justify-content-md-center">
                                    <button type="submit" data-url="{{route('ctv.postAddTimesheet')}}"
                                        class="btn btn-primary btn_submit btn-sm">Lưu</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.row -->

            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title"><b>Timesheet Trong Tháng</b></h3>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_timesheet" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Giờ Đến</th>
                                <th>Giờ Về</th>
                                <th>Giờ Làm</th>
                                <th>Hiệu Quả</th>
                                <th>Dự Án</th>
                                <th>Mô tả công việc</th>
                                <th style="color: red">Giờ Làm</th>
                                <th style="color: red">Hiệu Quả</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listTimesheet as $item)
                            <tr>
                                <td>{{$item -> date_work}}</td>
                                <td>{{$item -> start_time}}</td>
                                <td>{{$item -> end_time}}</td>
                                <td>{{$item -> total_hour}}h</td>
                                <td>{{$item -> effective}}%</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item -> description}}</td>
                                <td style="color: red">{{$item -> confirm_hour}}@if($item ->confirm_hour)h @endif</td>
                                <td style="color: red">{{$item -> confirm_effective}}@if($item ->confirm_effective)%
                                    @endif
                                </td>
                                <td>
                                    @if($item -> date_work <= $setting_time_ctv && $item -> status_manager == 0)
                                        @elseif($item -> confirm_hour != null or $item -> confirm_effective != null)
                                        @elseif($item ->date_work > $setting_time_ctv)
                                        <a href="{{route('ctv.getEditTimesheet',['id'=> $item -> id])}}"
                                            class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                        <a data-url="{{route('ctv.deleteTimesheet',['id'=> $item -> id])}}"
                                            class="btn btn-danger action_delete"><i class="fas fa-trash-alt"></i></a>
                                        @else
                                        <a href="{{route('ctv.getEditTimesheet',['id'=> $item -> id])}}"
                                            class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                        <a data-url="{{route('ctv.deleteTimesheet',['id'=> $item -> id])}}"
                                            class="btn btn-danger action_delete"><i class="fas fa-trash-alt"></i></a>
                                        @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
<script src="{{asset('vendor/congtacvien/dashboard/dashboard.js')}}"></script>
<script src="{{asset('vendor/congtacvien/timesheet/delete.js')}}"></script>
<script src="{{asset('vendor/sweetalert/sweetalert2@9.js')}}"></script>
@endsection
