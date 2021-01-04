@extends('quanlynhansu.layout')
@section('title')
<title>Timesheet |Skymap Global</title>
@endsection
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Chi Tiết Timesheet : {{$user -> name}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('president.Dashboard')}}">Trang Chủ</a></li>
                        <li class="breadcrumb-item active">Chi Tiết Timesheet</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <form action="{{route('qlns.postDetailTimesheet')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col col-2">
                            @if($listTimesheet->first())
                            <a href="{{route('qlns.getPrintTimesheet',['id'=>$user -> id,'month' => $month,'year' => $year])}}"
                                class="btn btn-primary btnprn">In Timesheet</a>
                            @endif
                        </div>
                        <div class="col col-3"></div>
                        <div class="col col-2">
                            <select name="ctv" class="custom-select form-control">
                                @foreach($listCTV as $item)
                                <option value="{{$item -> id}}" @if($item -> id == $id) selected
                                    @endif>{{$item -> name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col col-2">
                            <select class="custom-select form-control" name="year">
                                @for($i =$old_year ; $i<= $year; $i++) <option value="{{$i}}" @if ($year==$i) selected
                                    @endif>
                                    {{$i}}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col col-2">
                            <select name="month" class="custom-select form-control">
                                @for($i =1 ; $i<= 12; $i++) <option value="{{$i}}" @if ($month==$i) selected @endif>
                                    {{$i}}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col col-1">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>

                    </div>
                </form>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>Họ và Tên:</td>
                                <td> {{$user->name}}</td>
                                <td>Số điện thoại:</td>
                                <td>{{$user -> phone}}</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>{{$user -> email}}</td>
                                <td>Vai trò:</td>
                                <td>Cộng tác viên</td>
                            </tr>
                            <tr>
                                <td>Tổng giờ làm:</td>
                                <td>{{$total_hour}}h</td>
                                <td>Hệ số lương:</td>
                                <td>{{$setting_salary}}</td>
                            </tr>
                            <tr>
                                <td>Tổng tiền (bằng số):</td>
                                <td>{{number_format($total_money)}}đ</td>
                                <td>Tổng tiền (bằng chữ):</td>
                                <td>{{$money}} đồng chẵn</td>
                            </tr>

                        </table>
                    </div>
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
                            <th>Mô Tả Công Việc</th>
                            <th>Đánh Giá Giờ Làm</th>
                            <th>Đánh Giá Hiệu Quả</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listTimesheet as $item)
                        <tr>
                            <td>{{$item -> date_work}}</td>
                            <td>{{$item -> start_time}}</td>
                            <td>{{$item -> end_time}}</td>
                            <td>{{$item -> total_hour}}</td>
                            <td>{{$item -> effective}}</td>
                            <td>{{$item -> project_name}}</td>
                            <td>{{$item -> description}}</td>
                            <td>{{$item -> confirm_hour}}</td>
                            <td>{{$item -> confirm_effective}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
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
<script src="{{asset('vendor/giamdoc/report/detail_timesheet.js')}}"></script>
<script src="{{asset('vendor/print/jquery.printPage.js')}}"></script>
@endsection
