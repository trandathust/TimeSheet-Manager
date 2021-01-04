@extends('giamdoc.layout')
@section('title')
<title>Salary | SkymapGlobal</title>
@endsection
@section('content')
<div class="content-wrapper">
    @include('giamdoc.general.content-header',['name'=>'Tổng Tiền Lương'])
    <section class="content">
        <div class="card">
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
                            <h2><b>TỔNG HỢP LƯƠNG CỘNG TÁC VIÊN</b></h2>
                            <h4>Tháng {{$month}} năm {{$year}}</h4>
                        </div>
                    </div>
                </div>
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
                    <tfoot>
                        <tr>
                            <td colspan="11">
                                <table class="table table-condensed total-result">
                                    <tr>
                                        <td><b>Tổng Tiền:</b></td>
                                        <td>{{number_format($total_salary)}}đ</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('vendor/print/print.css')}}">
@endsection

@section('js')

<script src="{{asset('vendor/giamdoc/report/salary.js')}}"></script>
<script src="{{asset('vendor/print/jquery.printPage.js')}}"></script>
@endsection
