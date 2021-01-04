@extends('giamdoc.layout')
@section('title')
<title>Project | SkymapGlobal</title>
@endsection
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('giamdoc.general.content-header',['name'=>'Danh Sách Dự Án'])

    <section class="content">

        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col col-sm">
                        <a href="{{route('president.getAddProject')}}" class="btn btn-primary active" role="button"
                            aria-disabled="true">Thêm</a>
                    </div>
                    <div class="col col-sm col-lg-4">
                        <input type="text" class="form-control" placeholder="Nhập tên dự án" id="myInput">
                    </div>
                </div>
                <table id="table_project" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th style="width: 35%">Mô Tả</th>
                            <th>Bắt Đầu</th>
                            <th>Kết Thúc</th>
                            <th>Tình Trạng</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody id="table_project_tbody">
                        @foreach($listProject as $item)
                        <tr>
                            <td>{{$item -> id}}</td>
                            <td>{{$item -> name}}</td>
                            <td>{{$item -> description}}</td>
                            <td>{{$item -> start_time }}</td>
                            <td>{{$item -> end_time}}</td>
                            <td>
                                <form action="">
                                    @csrf
                                    <input type="hidden" name="id" id="id" value="{{$item -> id}}">
                                    <input type="hidden" name="name" id="name" value="{{$item -> name}}">
                                    <input type="hidden" name="start_time" id="start_time"
                                        value="{{$item -> start_time}}">
                                    <input type="hidden" name="end_time" id="end_time" value="{{$item -> end_time}}">
                                    <input type="hidden" name="description" id="description"
                                        value="{{$item -> description}}">
                                    <select name="status" id="status" class="form-control"
                                        data-url="{{route('president.getEditProject',['id' => $item ->  id])}}">
                                        <option value="1" @if($item -> status == 1 )
                                            selected="selected" @endif>Hoạt Động</option>
                                        <option value="0" @if($item -> status == 0 || ($item -> end_time < date('Y-m-d')
                                                && $item -> end_time !=null))
                                                selected="selected" @endif>Tạm Dừng</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="{{route('president.getEditProject',['id' => $item -> id])}}"
                                    class="btn btn-primary btn-sm"><i class="fas fa-search"></i></a>
                                <a data-url="{{route('president.deleteProject',['id' => $item -> id])}}"
                                    class="btn btn-danger btn-sm action_delete"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

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
<script src="{{asset('vendor/giamdoc/project/view.js')}}"></script>
@endsection
