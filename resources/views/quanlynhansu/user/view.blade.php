@extends('quanlynhansu.layout')

@section('title')
<title>User | SkyMap Global</title>
@endsection

@section('content')
<div class="content-wrapper">
    @include('quanlynhansu.general.content-header',['name' => 'Nhân Viên'])

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="class card-header">

                        <div class="row">
                            <div class="class col-sm-12 text-center">
                                <span>Danh Sách Nhân Viên</span>
                            </div>
                            <div class="col col-sm">
                                <a href="{{route('qlns.getAddUser')}}" class="btn btn-primary active" role="button"
                                    aria-disabled="true">Thêm</a>
                            </div>
                            <div class="col col-sm col-lg-4">
                                <input type="text" class="form-control" placeholder="Nhập.." id="myInput_table">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="table_1" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Tình Trạng</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody id="table_1_tbody">
                                @foreach($listCTV as $item)
                                <tr>
                                    <td>{{$item -> id}}</td>
                                    <td>{{$item -> name}}</td>
                                    <td>{{$item -> email}}</td>
                                    <td>{{$item -> phone}}</td>
                                    <td>
                                        <form method="" action="">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{$item -> id}}">
                                            <select class="form-control" id="select_id" name="select_id"
                                                data-url="{{route('qlns.postStatusUser',['id' => $item -> id])}}">
                                                <option value="1" @if($item -> status == 1)
                                                    selected="selected" @endif>Làm việc</option>
                                                <option value="0" @if($item -> status== 0)
                                                    selected="selected" @endif>Đã nghỉ</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></a>
                                        <a href="{{route('qlns.getEditUser',['id'=> $item -> id])}}"
                                            class="btn btn-warning btn-sm"><i class="fas fa-user-edit"></i></a>
                                        <a data-url="{{route('qlns.getDeleteUser',['id' => $item -> id])}}"
                                            class="btn btn-danger btn-sm action_delete"><i
                                                class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-12">
                <div class="card">
                    <div class="class card-header">

                        <div class="row">
                            <div class="class col-sm-12 text-center">
                                <span>Danh Sách Quản Lý Bộ Phận</span>
                            </div>
                            <div class="col col-sm">
                                <a href="{{route('qlns.getAddUser')}}" class="btn btn-primary active" role="button"
                                    aria-disabled="true">Thêm</a>
                            </div>
                            <div class="col col-sm col-lg-4">
                                <input id="myInput" type="text" placeholder="Nhập.." class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <table id="table_2" class="table table-bordered table-hover" name="table_2">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Số Điện Thoại</th>
                                    <th>Tình Trạng</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody id="table_2_tbody">
                                @foreach($listManager as $item)
                                <tr>
                                    <td>{{$item -> id}}</td>
                                    <td>{{$item -> name}}</td>
                                    <td>{{$item -> email}}</td>
                                    <td>{{$item -> phone}}</td>
                                    <td>
                                        <form method="" action="">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{$item -> id}}">
                                            <select class="form-control" id="select_id" name="select_id"
                                                data-url="{{route('qlns.postStatusUser',['id' => $item -> id])}}">
                                                <option value="1" @if($item -> status == 1)
                                                    selected="selected" @endif>Làm việc</option>
                                                <option value="0" @if($item -> status== 0)
                                                    selected="selected" @endif>Đã nghỉ</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></a>
                                        <a href="{{route('qlns.getEditUser',['id'=> $item -> id])}}"
                                            class="btn btn-warning btn-sm"><i class="fas fa-user-edit"></i></a>
                                        <a data-url="{{route('qlns.getDeleteUser',['id' => $item -> id])}}"
                                            class="btn btn-danger btn-sm action_delete"><i
                                                class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
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
<script src="{{asset('vendor/giamdoc/user/view.js')}}"></script>
<script src="{{asset('vendor/sweetalert/sweetalert2@9.js')}}"></script>
@endsection
