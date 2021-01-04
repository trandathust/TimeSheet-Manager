@extends('congtacvien.layout')
@section('title')
<title>Profile | SkymapGlobal</title>
@endsection
@section('content')
<div class="content-wrapper">
    @include('congtacvien.general.content-header',['name' => 'Sửa Thông Tin'])
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="POST" enctype="multipart/form-data" action="{{route('ctv.postProfile')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="InputName">Tên</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    id="InputName" value="{{$user -> name}}" placeholder="Nhập tên">
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="InputEmail">Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{$user -> email}}"
                                    placeholder="Nhập email">
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="InputEmail">Số điện thoại</label>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror" value="{{$user -> phone}}"
                                    placeholder="Nhập số điện thoại">
                                @error('phone')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="InputAddress">Địa chỉ</label>
                                <input type="text" name="address"
                                    class="form-control @error('address') is-invalid @enderror" id="InputAddress"
                                    value="{{$user -> address}}" placeholder="Nhập địa chỉ">
                                @error('address')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Ngày sinh</label>
                                <input type="date" name="birthday"
                                    class="form-control @error('birthday') is-invalid @enderror"
                                    value="{{$user -> birthday }}">
                                @error('birthday')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class=" form-group col-md-6">
                                <label>Ảnh đại diện</label>
                                <input type="file" name="avatar" class="form-control-file">
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
        </div>
    </section>
</div>
@endsection
