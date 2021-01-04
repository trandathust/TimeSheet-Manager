@extends('quanlynhansu.layout')
@section('title')
<title>Profile | SkyMapGlobal</title>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('quanlynhansu.general.content-header',['name' => 'Đổi Thông Tin'])

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <form method="POST" enctype="multipart/form-data" action="{{route('qlns.postProfile')}}">
                            @csrf
                            <div class="card-body">
                                <div class="form-row">
                                    <!-- row 1 -->
                                    <div class="form-group col-md-6">
                                        <label for="InputName">Tên</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{auth() ->user() -> name}}" placeholder="Nhập tên">
                                        @error('name')
                                        <li class="sub_error" style="color: red;">{{ $message }}</li>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="InputEmail">Email</label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror" id="InputEmail"
                                            value="{{auth() ->user() -> email}}" placeholder="Nhập email">
                                        @error('email')
                                        <li class="sub_error" style="color: red;">{{ $message }}</li>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="InputEmail">Số điện thoại</label>
                                        <input type="text" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror" id="InputEmail"
                                            value="{{auth() ->user() -> phone}}" placeholder="Nhập email">
                                        @error('phone')
                                        <li class="sub_error" style="color: red;">{{ $message }}</li>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="InputAddress">Địa chỉ</label>
                                        <input type="text" name="address"
                                            class="form-control @error('address') is-invalid @enderror"
                                            id="InputAddress" value="{{auth() ->user() -> address}}"
                                            placeholder="Nhập địa chỉ">
                                        @error('address')
                                        <li class="sub_error" style="color: red;">{{ $message }}</li>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Ngày sinh</label>
                                        <input type="date" name="birthday"
                                            class="form-control @error('birthday') is-invalid @enderror"
                                            value="{{auth() ->user() -> birthday }}">
                                        @error('birthday')
                                        <li class="sub_error" style="color: red;">{{ $message }}</li>
                                        @enderror
                                    </div>
                                    <div class=" form-group col-md-6">
                                        <label>Ảnh đại diện</label>
                                        <input type="file" name="avatar" class="form-control-file">
                                    </div>
                                </div>
                            </div>
                            <!--end car-body-->
                            <!-- /.card-body -->
                            <div class="card-footer">
                                @include('messages')
                                <div class="row justify-content-md-center">
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
    </section>
    <!-- /.content -->
</div>



@endsection
