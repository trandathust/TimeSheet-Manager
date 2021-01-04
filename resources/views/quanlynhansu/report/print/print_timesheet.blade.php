@extends('quanlynhansu.layout')

@section('title')
<title>Timesheet | Skymap Global</title>
@endsection
@section('content')

<div class="content-wrapper">
    @include('quanlynhansu.general.content-header',['name'=>'In Timesheet'])

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="card">
                        <div class="card-title text-center">
                            <div class="row">
                                <div class="col col-1">

                                </div>
                                <div class="col col-3 ">
                                    <img src="{{$data_logo}}" class="image-logo">
                                </div>
                                <div class="col col-8">
                                    <h1><b>CÔNG TY THHH CÔNG NGHỆ CAO</b></h1>
                                    <h1><b>SkyMap Global</b></h1>
                                    <h2><b>TIMESHEET THÁNG {{$month}} NĂM {{$year}}</b></h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <tr>
                                    <td>Tên cộng tác viên: {{$user[0] -> name}}</td>
                                    <td>Số điện thoại: {{$user[0] -> phone }}</td>
                                    <td>Email: {{$user[0] -> email}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <table class="table table-bordered table-hover table-sm">
                        <tbody>
                            <tr>
                                <th>No</th>
                                <th>Nhân Viên</th>
                                <th style="width:11%">Ngày</th>
                                <th>Giờ Đến</th>
                                <th>Giờ Về</th>
                                <th>Giờ Làm</th>
                                <th>Hiệu Quả</th>
                                <th>Dự Án</th>
                                <th>Mô Tả</th>
                                <th>Đánh Giá Giờ Làm</th>
                                <th>Đánh Giá Hiệu Quả</th>
                            </tr>
                            @foreach($listTimesheet as $item)
                            <tr>
                                <td>{{$loop -> index+1}}</td>
                                <td>{{$item -> user_name}}</td>
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
                            <tr>
                                <td colspan="11">
                                    <table class="table table-condensed total-result">
                                        <tr>
                                            <td><b>Tổng giờ làm cộng tác viên đánh giá:</b></td>
                                            <td>{{$user[0] -> total_hour}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Tổng giờ làm quản lý đánh giá:</b></td>
                                            <td>{{$user[0] -> confirm_hour}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Hệ số lương:</b></td>
                                            <td>{{number_format($setting_salary)}}đ</td>
                                        </tr>
                                        <tr>
                                            <td><b>Tổng Tiền:</b></td>
                                            <td>{{number_format($total_salary)}}đ</td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>

                    </table>

                </div>
                <div class="card-footer">
                    <table class="table table-borderless text-center">
                        <tr>
                            <td>Giám Đốc</td>
                            <td>Quản Lý</td>
                            <td>Cộng Tác Viên</td>
                        </tr>
                        <tr>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                        </tr>
                        <tr>
                            <td>{{$president_name}}</td>
                            <td>{{$manager_name}}</td>
                            <td>{{$user[0]-> name}}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('css')

<link rel="stylesheet" href="{{asset('vendor/print/print.css')}}">
@endsection

@section('js')

@endsection
