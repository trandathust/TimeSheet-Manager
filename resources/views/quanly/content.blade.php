@extends('quanly.layout')
@section('title')
<title>SkymapGlobal | Timesheet</title>
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
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"><b>Thống Kê Dự Án</b></h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg">
                                        <a style="color: #7d8286">{{$total_hour}}h</a> -
                                        <a style="color: #007bff">{{$confirm_hour}}h</a>
                                    </span>
                                    <span>Giờ Làm Việc</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span class="text-success">
                                        {{$confirm_effective}}%
                                    </span>
                                    <span class="text-muted">Hiệu quả trung bình</span>
                                </p>
                            </div>
                            <div class="position-relative mb-4">
                                <canvas id="sales-chart" height="200" data-project="{{$listProject}}"></canvas>
                            </div>

                            <div class="d-flex flex-row justify-content-end">
                                <span class="mr-2">
                                    <i class="fas fa-square text-secondary"></i> Chưa xác nhận
                                </span>
                                <span class="mr-2">
                                    <i class="fas fa-square text-primary"></i> Đã xác nhận
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title"> <b>Timesheet Tháng Này</b> </h3>
                                <hr>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-9 col-form-label">Tổng số:</label>
                                <div class="col-sm-3">{{$timesheet_total}}</div>
                                <label class="col-sm-9 col-form-label">Mới tạo:</label>
                                <div class="col-sm-3">{{$timesheet_new}}</div>
                                <label class="col-sm-9 col-form-label">Bị sửa:</label>
                                <div class="col-sm-3">{{$timesheet_change}}</div>
                                <label class="col-sm-9 col-form-label">Chưa đánh giá:</label>
                                <div class="col-sm-3">{{$timesheet_not_confirm}}</div>
                                <label class="col-sm-9 col-form-label">Đã đánh giá:</label>
                                <div class="col-sm-3">{{$timesheet_confirm}}</div>
                                <div class="form col-md-12">
                                    <br>
                                </div>
                                <div class="form col-md-12">
                                    <hr>
                                </div>
                                <div class="form col-md-12">
                                    <a href="{{route('manager.getAssess')}}" type="submit"
                                        class="btn btn-primary btn-block">Chi Tiết</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Timesheet Chưa Đánh Giá - Đánh Giá Ngay</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="table_assess" class="table table-bordered table-hover" name="table_assess">
                                <thead>
                                    <tr>
                                        <th>Nhân Viên</th>
                                        <th style="width:11%">Ngày</th>
                                        <th>Giờ Làm</th>
                                        <th>Hiệu Quả</th>
                                        <th>Dự Án</th>
                                        <th>Mô Tả</th>
                                        <th style="width:10%">Quyền Sửa</th>
                                        <th style="width:40%">Xác Nhận</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listTimesheet as $item)
                                    @if($item->confirm_hour == null || $item->confirm_effective == null)
                                    <tr>
                                        <td>{{$item -> user_name}}</td>
                                        <td>{{$item -> date_work}}</td>
                                        <td>{{$item -> total_hour}}</td>
                                        <td>{{$item -> effective}}</td>
                                        <td>{{$item -> project_name}}</td>
                                        <td>{{$item -> description}}</td>
                                        <td>
                                            <form action="{{route('manager.postAssess',['id'=>$item -> id])}}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="confirm_hour_hidden" id="confirm_hour_hidden"
                                                    value="{{$item -> confirm_hour}}">
                                                <input type="hidden" name="confirm_effective_hidden"
                                                    id="confirm_effective_hidden"
                                                    value="{{$item -> confirm_effective}}">
                                                <input type="checkbox" name="status" id="status" @if($item -> date_work
                                                >$setting_time_ctv)
                                                value="0"
                                                checked
                                                @elseif($item -> status_manager == 1)
                                                value="0"
                                                checked
                                                @endif
                                                value="1"
                                                data-url="{{route('manager.postAssess',['id'=>$item -> id])}}">
                                            </form>
                                        </td>
                                        <td>
                                            <form method="POST"
                                                action="{{route('manager.postAssess',['id'=> $item -> id])}}">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <input type="number" name="confirm_hour" id="confirm_hour"
                                                            class="form-control" min="0" max="24" placeholder="Giờ Làm"
                                                            value="{{$item -> confirm_hour}}">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <input type="number" name="confirm_effective"
                                                            id="confirm_effective" class="form-control" min="0"
                                                            max="100" placeholder="Hiệu Quả"
                                                            value="{{$item -> confirm_effective}}">
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <button type="submit"
                                                            data-url="{{route('manager.postAssess',['id'=> $item -> id])}}"
                                                            class="btn btn-primary btn_submit"><i
                                                                class="fas fa-check"></i></button>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <a href="{{route('manager.getDetailTimesheet',['id'=> $item -> id])}}"
                                                            type="submit" class="btn btn-warning"><i
                                                                class="fas fa-search"></i></a>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                            </table>
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
<script src="{{asset('adminlte/plugins/chart.js/Chart.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendor/quanly/dashboard/dashboard.js')}}"></script>

<script src="{{asset('vendor/quanly/dashboard/assess.js')}}"></script>
<script src="{{asset('vendor/sweetalert/sweetalert2@9.js')}}"></script>
@endsection
