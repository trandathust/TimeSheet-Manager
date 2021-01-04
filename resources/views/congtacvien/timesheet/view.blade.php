@extends('congtacvien.layout')
@section('title')
<title>Timesheet | SkyMapGlobal</title>
@endsection
@section('content')
<div class="content-wrapper">
    @include('congtacvien.general.content-header',['name'=>'Thống Kê'])
    <section class="content">
        <div class="card">
            <div class="class card-header">
                <form action="{{route('ctv.postViewTimesheet')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col col-7 align-self-end">
                            <a href="{{route('ctv.getAddTimesheet')}}" class="btn btn-primary">Khai
                                Báo</a>
                        </div>
                        <div class="col col-2">
                            <select name="data_year" class="custom-select form-control">
                                @for($i =$old_year ; $i<= $year; $i++) <option value="{{$i}}" @if ($year==$i) selected
                                    @endif>
                                    {{$i}}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col col-2">
                            <select name="data_month" class="custom-select form-control">
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
                            <td style="color: red">{{$item -> confirm_effective}}@if($item ->confirm_effective)% @endif
                            </td>
                            <td>

                                @if($item -> date_work <= $setting_time_ctv && $item -> status_manager == 0 )
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
<script src="{{asset('vendor/sweetalert/sweetalert2@9.js')}}"></script>
<script src="{{asset('vendor/congtacvien/timesheet/view.js')}}"></script>
<script src="{{asset('vendor/congtacvien/timesheet/delete.js')}}"></script>
@endsection
