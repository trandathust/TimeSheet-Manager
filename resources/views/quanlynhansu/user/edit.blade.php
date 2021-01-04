@extends('quanlynhansu.layout')
@section('title')
<title>User | SkymapGlobal</title>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('quanlynhansu.general.content-header',['name'=> 'Sửa Nhân Viên'])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <!-- form start -->
                <form method="POST" action="{{route('qlns.postEditUser',['id' => $user -> id])}}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label>Tên nhân viên</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Nhập tên" value="{{$user -> name}}">
                                @error('name')
                                <li class="sub_error" style="color: red;">{{ $message }}</li>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Nhập email"
                                    value="{{$user -> email}}">
                                @error('email')
                                <li class="sub_error" style="color: red;">{{ $message }}</li>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="Nhập số điện thoại" value="{{$user -> phone}}">
                                @error('phone')
                                <li class="sub_error" style="color: red;">{{ $message }}</li>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Mật khẩu</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Nhập mật khẩu">
                                @error('password')
                                <li class="sub_error" style="color: red;">{{ $message }}</li>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Xác nhận mật khẩu</label>
                                <input type="password" name="repassword"
                                    class="form-control @error('repassword') is-invalid @enderror" placeholder="">
                                @error('repassword')
                                <li class="sub_error" style="color: red;">{{ $message }}</li>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label>Địa chỉ</label>
                                <input type="text" name="address" class="form-control" placeholder="Nhập địa chỉ"
                                    value="{{$user -> address}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Ngày Sinh</label>
                                <input type="date" name="birthday" class="form-control" value="{{$user -> birthday}}">

                            </div>
                            <div class="form-group col-md-4">
                                <label class="my-1 mr-2">Vai trò</label>
                                <select class="custom-select my-1 mr-sm-2" name="role">
                                    <option value="manager" @if($user -> role == "manager") selected @endif>Quản Lý
                                    </option>
                                    <option value="ctv" @if($user -> role === "ctv") selected @endif>Cộng Tác Viên
                                    </option>
                                </select>
                            </div>
                            <div class=" form-group col-md-4">
                                <label class="my-1 mr-2">Chọn Quản Lý</label>
                                <select class="custom-select my-1 mr-sm-2" name="manager" id="manager"
                                    data-url="{{route('qlns.getListProjectOfManager')}}">
                                    <option value="">Giám Đốc</option>
                                    @foreach($listManager as $item)
                                    <option value="{{$item -> id}}" @if($user -> manager_id == $item -> id) selected
                                        @endif>{{$item -> name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Phân Công Dự Án</label>
                                <select class="custom-select" name="projects[]" multiple id="projects">
                                    @foreach($listProject as $item)
                                    <option value="{{$item -> id}}" @foreach($listProjectUser as $subitem) @if($item ->
                                        id==$subitem -> project_id) selected @endif @endforeach>{{$item -> name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Ảnh đại diện</label>
                                <input type="file" name="avatar" class="form-control-file">
                            </div>
                            <div class="form-group col-md 4">
                                <div class="row">
                                    <div class="col-8">
                                        <label>Tình trạng</label>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="status" name="status" value="1" checked />Làm việc
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="status" name="status" value="0" /> Tạm nghỉ
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @include('messages')
                        <div class="row justify-content-md-center">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>

@endsection
@section('js')
<script language="JavaScript" type="text/javascript" src="{{asset('vendor/giamdoc/user/edit.js')}}"></script>

@endsection
