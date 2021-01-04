@extends('quanly.layout')

@section('title')
<title>Timesheet | Skymap Global</title>
@endsection
@section('content')

<div class="content-wrapper">
    @include('quanly.general.content-header',['name'=>'Đánh Giá Timesheet'])

    <section class="content">
        {{-- timesheet trong tháng  --}}
        <div class="card">
            <div class="card-header">
                <form action="{{route('manager.postViewAssess')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for=""><b>Timesheet Trong Tháng</b></label>
                        </div>
                        <div class="col col-3 align-self-end">
                            <input id="myInput_table" type="text" placeholder="Nhập tên.." class="form-control">
                        </div>
                        <div class="col col-2">
                        </div>

                        <div class="col col-2">
                            <select name="ctv" class="custom-select form-control">
                                <option value="">Tất Cả</option>
                                @foreach($listCTVofManager as $item)
                                <option value="{{$item -> id}}" @if($item -> id == $ctv_id) selected
                                    @endif>{{$item -> name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col col-2">
                            <select name="data_year" class="custom-select form-control">
                                @for($i =$old_year ; $i<= $year; $i++) <option value="{{$i}}" @if ($data_year==$i)
                                    selected @endif>
                                    {{$i}}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col col-2">
                            <select name="data_month" class="custom-select form-control">
                                @for($i =1 ; $i<= 12; $i++) <option value="{{$i}}" @if ($data_month==$i) selected
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
                    <tbody id="table_assess_tbody">
                        @foreach($listTimesheet as $item)
                        <tr>
                            <td>{{$item -> user_name}}</td>
                            <td>{{$item -> date_work}}</td>
                            <td>{{$item -> total_hour}}</td>
                            <td>{{$item -> effective}}</td>
                            <td>{{$item -> project_name}}</td>
                            <td>{{$item -> description}}</td>
                            <td>
                                <form action="{{route('manager.postAssess',['id'=>$item -> id])}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="confirm_hour_hidden" id="confirm_hour_hidden"
                                        value="{{$item -> confirm_hour}}">
                                    <input type="hidden" name="confirm_effective_hidden" id="confirm_effective_hidden"
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
                                <form method="POST" action="{{route('manager.postAssess',['id'=> $item -> id])}}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <input type="number" name="confirm_hour" id="confirm_hour"
                                                class="form-control" min="0" max="24" placeholder="Giờ Làm"
                                                value="{{$item -> confirm_hour}}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="number" name="confirm_effective" id="confirm_effective"
                                                class="form-control" min="0" max="100" placeholder="Hiệu Quả"
                                                value="{{$item -> confirm_effective}}">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <button type="submit"
                                                data-url="{{route('manager.postAssess',['id'=> $item -> id])}}"
                                                class="btn btn-primary btn_submit"><i class="fas fa-check"></i></button>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <a href="{{route('manager.getDetailTimesheet',['id'=> $item -> id])}}"
                                                type="submit" class="btn btn-warning"><i class="fas fa-search"></i></a>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{--timesheet bị thay đổi--}}
        @if(!empty($listTimesheetChange))
        <div class="card">
            <div class="card-header">
                <form action="{{route('manager.postViewAssess')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label for=""><b>Timesheet Bị Thay Đổi</b></label>
                        </div>
                        <div class="col col-3 align-self-end">
                            <input id="myInput" type="text" placeholder="Nhập tên.." class="form-control">
                        </div>
                        <div class="col col-2">
                        </div>

                        <div class="col col-2">
                            <select name="ctv" class="custom-select form-control">
                                <option value="">Tất Cả</option>
                                @foreach($listCTVofManager as $item)
                                <option value="{{$item -> id}}" @if($item -> id == $ctv_id) selected
                                    @endif>{{$item -> name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col col-2">
                            <input type="hidden" name="data_year" value="{{$year}}">
                            <select class="custom-select form-control" disabled>
                                @for($i =$old_year ; $i<= $year; $i++) <option value="{{$i}}" @if ($year==$i) selected
                                    @endif>
                                    {{$i}}</option>
                                    @endfor
                            </select>
                        </div>
                        <div class="col col-2">
                            <input type="hidden" name="data_month" value="{{$month}}">
                            <select name="data_month" class="custom-select form-control" disabled>
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
                <table id="table_assess_2" class="table table-bordered table-hover" name="table_assess">
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
                    <tbody id="table_assess_2_tbody">
                        @foreach($listTimesheetChange as $item)
                        <tr>
                            <td>{{$item -> user_name}}</td>
                            <td>{{$item -> date_work}}</td>
                            <td>{{$item -> total_hour}}</td>
                            <td>{{$item -> effective}}</td>
                            <td>{{$item -> project_name}}</td>
                            <td>{{$item -> description}}</td>
                            <td>
                                <form action="{{route('manager.postAssess',['id'=>$item -> id])}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="confirm_hour_hidden" id="confirm_hour_hidden"
                                        value="{{$item -> confirm_hour}}">
                                    <input type="hidden" name="confirm_effective_hidden" id="confirm_effective_hidden"
                                        value="{{$item -> confirm_effective}}">
                                    <input type="checkbox" name="status" id="status" @if($item -> date_work >
                                    $setting_time_ctv || $item -> status_manager == 1)
                                    value="0"
                                    checked
                                    @endif value="1"
                                    data-url="{{route('manager.postAssess',['id'=>$item -> id])}}">
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="{{route('manager.postAssess',['id'=> $item -> id])}}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <input type="number" name="confirm_hour" id="confirm_hour"
                                                class="form-control" min="0" max="24" placeholder="Giờ Làm"
                                                value="{{$item -> confirm_hour}}">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <input type="number" name="confirm_effective" id="confirm_effective"
                                                class="form-control" min="0" max="100" placeholder="Hiệu Quả"
                                                value="{{$item -> confirm_effective}}">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <button type="submit"
                                                data-url="{{route('manager.postAssess',['id'=> $item -> id])}}"
                                                class="btn btn-primary btn_submit_change"><i
                                                    class="fas fa-check"></i></button>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <a href="{{route('manager.getDetailTimesheet',['id'=> $item -> id])}}"
                                                type="submit" class="btn btn-warning"><i class="fas fa-search"></i></a>
                                        </div>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </section>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('js')
<!-- DataTables -->
<script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendor/quanly/assess.js')}}"></script>
<script src="{{asset('vendor/sweetalert/sweetalert2@9.js')}}"></script>
@endsection
