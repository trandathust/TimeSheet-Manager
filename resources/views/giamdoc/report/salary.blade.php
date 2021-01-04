@extends('giamdoc.layout')
@section('title')
<title>Salary | SkymapGlobal</title>
@endsection
@section('content')
<div class="content-wrapper">
    @include('giamdoc.general.content-header',['name'=>'Tổng Tiền Lương'])
    <section class="content">
        <div class="card">
            <div class="class card-header">
                <form action="" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col col-3">
                            <input type="text" class="form-control" placeholder="Nhập tên..." id="myInput_table">
                        </div>
                        <div class="col col-2">
                            <select class="custom-select form-control" name="year">
                                @for($i =$old_year ; $i<= $year_now; $i++) <option value="{{$i}}" @if ($year==$i)
                                    selected @endif>
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
                        <div class="col col-2"></div>
                        <div class="col col-2">
                            <a href="{{route('president.getPrintTotalSalary',['month'=>$month,'year'=>$year])}}"
                                class="btn btn-primary btnprn" type="submit">In Tổng Tiền Lương</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table id="table_salary" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Họ tên CTV</th>
                            <th>Số tiền VNĐ</th>
                            <th>Ghi Chú</th>
                        </tr>
                    </thead>
                    <tbody id="table_salary_tbody">
                        @foreach($listCTV as $item)
                        <tr>
                            <th>{{$loop ->index + 1}}</th>
                            <td>{{$item -> name}}</td>
                            <td>
                                @foreach($salary as $subitem)
                                @if($subitem['id'] == $item -> id)
                                {{number_format($subitem['total_money'])}}đ
                                @endif
                                @endforeach
                            </td>
                            <td></td>
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
<script src="{{asset('vendor/giamdoc/report/salary.js')}}"></script>
<script src="{{asset('vendor/print/jquery.printPage.js')}}"></script>
@endsection
