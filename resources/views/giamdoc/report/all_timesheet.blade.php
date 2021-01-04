@extends('giamdoc.layout')

@section('title')
<title>TimeSheet | SkyMapGlobal</title>
@endsection

@section('content')
<div class="content-wrapper">
    @include('giamdoc.general.content-header',['name'=>'TimeSheet'])
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="class card-header">
                        <form action="{{route('president.postTimesheet')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col col-3 align-self-end">
                                    <input type="text" class="form-control" placeholder="Nhập tên..."
                                        id="myInput_table">
                                </div>

                                <div class="col col-2"></div>
                                <div class="col col-2">
                                    <select name="ctv" class="custom-select form-control">
                                        <option value="">Tất Cả</option>
                                        @foreach($listCTV_all as $item)
                                        <option value="{{$item -> id}}" @if($item -> id == $ctv_id) selected
                                            @endif>{{$item -> name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col col-2">
                                    <select class="custom-select form-control" name="year">
                                        @for($i =$old_year ; $i<= $year_now ; $i++) <option value="{{$i}}"
                                            @if($year==$i) selected @endif>
                                            {{$i}}</option>
                                            @endfor
                                    </select>
                                </div>
                                <div class="col col-2">
                                    <select name="month" class="custom-select form-control">
                                        @for($i =1 ; $i<= 12; $i++) <option value="{{$i}}" @if ($month==$i) selected
                                            @endif>
                                            {{$i}}</option>
                                            @endfor
                                    </select>
                                </div>
                                <div class="col col-1">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <table id="table_timesheet" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Nhân Viên</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Tổng Giờ Làm</th>
                                    <th>Giờ Làm Được Đánh Giá</th>
                                    <th>Hiệu Quả Trung Bình</th>
                                    <th>Thành Tiền</th>
                                    <th style="width: 30%">Hành Động</th>
                                </tr>
                            </thead>
                            <tbody id="table_timesheet_tbody">
                                @foreach($listCTV as $item)
                                <tr>
                                    <td>{{$item -> name}}</td>
                                    <td>{{$item -> phone}}</td>
                                    <td>{{$item -> total_hour}}h</td>
                                    <td>{{$item -> confirm_hour}}h</td>
                                    <td>{{$item -> confirm_effective}} %</td>
                                    <td>
                                        @foreach($salary as $subitem)
                                        @if($subitem['id'] == $item -> id)
                                        {{number_format($subitem['total_money'])}}đ
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{route('president.getDetailTimesheet',['id'=>$item->id,'month'=>$month,'year'=>$year])}}"
                                            class="btn btn-primary btn-sm" role="button" aria-pressed="true">Chi
                                            tiết</a>
                                        <a href="{{route('president.getPrintTimesheet',['id'=>$item -> id,'month' => $month,'year' => $year])}}"
                                            class="btn btn-warning btn-sm btnprn" role="button" aria-pressed="true">In
                                            Timesheet</a>
                                        <a href="{{route('president.getPrintPayment',['id'=>$item -> id,'month' => $month,'year' => $year])}}"
                                            class="btn btn-danger btn-sm btnprn" role="button" aria-pressed="true">In
                                            Phiếu
                                            Chi</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
<script src="{{asset('vendor/giamdoc/report/all_timesheet.js')}}"></script>
<script src="{{asset('vendor/print/jquery.printPage.js')}}"></script>

@endsection
