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

                                </div>
                                <div class="col col-12">
                                    <h2><b>Phiếu Chi</b></h2>
                                    <h5>Ngày {{$day}} Tháng {{$month}} Năm {{$year}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <tr>
                                    <td>Tên cộng tác viên: {{$user[0]->name}}</td>
                                </tr>
                                <tr>
                                    <td>Số điện thoại: {{$user[0]->phone}}</td>
                                </tr>
                                <tr>
                                    <td>Email: {{$user[0]->email}}</td>
                                </tr>
                                <tr>
                                    <td>Chức vụ: Cộng tác viên</td>
                                </tr>
                                <tr>
                                    <td>Lý do chi: Lương tháng {{$month}} năm {{$year}}</td>
                                </tr>
                                <tr>
                                    <td>Bằng chữ: {{$money}} đồng chẵn</td>
                                </tr>
                                <tr>
                                    <td>Kèm theo:</td>
                                </tr>
                                <tr>
                                    <td>Đã nhận đủ số tiền (bằng chữ): {{$money}} đồng chẵn</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col col-md-8">

                        </div>
                        <div class="col col-md-4">
                            <span>Ngày.....tháng.....năm....</span>
                        </div>
                    </div>

                    <table class="table table-borderless text-center">
                        <tr>
                            <td>Giám đốc</td>
                            <td>Kế toán trưởng</td>
                            <td>Thủ quỹ</td>
                            <td>Người lập phiếu</td>
                            <td>Người nhận tiền</td>
                        </tr>
                        <tr>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                        </tr>
                        <tr>
                            <td>{{$president_name}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$user[0]-> name}}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- tiếng anh --}}
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
                                    <h1><b>SKYMAP CO., LTD</b></h1>
                                    <h1><b>SkyMap Global</b></h1>

                                </div>
                                <div class="col col-12">
                                    <h2><b>PAYMENT RECEIPT</b></h2>
                                    <h5>Day {{$day}} Month {{$month}} Year {{$year}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover">
                                <tr>
                                    <td>Paid to: {{$user[0]->name}}</td>
                                </tr>
                                <tr>
                                    <td>Phone: {{$user[0]->phone}}</td>
                                </tr>
                                <tr>
                                    <td>Email: {{$user[0]->email}}</td>
                                </tr>
                                <tr>
                                    <td>Address: Coordinator group</td>
                                </tr>
                                <tr>
                                    <td>Purpose: Salary for {{$month}}-{{$year}}</td>
                                </tr>
                                <tr>
                                    <td>Amount: VND {{number_format($total_salary)}}</td>
                                </tr>
                                <tr>
                                    <td>In word: {{$money_eng}} Dong</td>
                                </tr>
                                <tr>
                                    <td>Attachment:</td>
                                </tr>
                                <tr>
                                    <td>Received full amount (in word): {{$money_eng}} DONG</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col col-md-8">

                        </div>
                        <div class="col col-md-4">
                            <span>Day.....month.....year....</span>
                        </div>
                    </div>

                    <table class="table table-borderless text-center">
                        <tr>
                            <td>Manager</td>
                            <td>Chief Accountant</td>
                            <td>Cashier</td>
                            <td>Prepared by</td>
                            <td>Recepient</td>
                        </tr>
                        <tr>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                            <td><br></td>
                        </tr>
                        <tr>
                            <td>{{$president_name}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
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
