@extends('giamdoc.layout')
@section('title')
<title>Setting | Skymap Global</title>
@endsection
@section('content')
<div class="content-wrapper">
    @include('giamdoc.general.content-header',['name'=>'Cài Đặt'])
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form method="POST" action="{{route('president.postSetting')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="form-group col-md-6">
                                <label>Sau (x) ngày Cộng Tác Viên không được sửa Timesheet</label>
                                <input class="form-control @error('date_ctv') is-invalid @enderror" name="date_ctv"
                                    type="number" min="0" placeholder="Nhập x" value="{{$date_ctv}}">
                                @error('date_ctv')
                                <div class="sub_error" style=" color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Ngày Tính Lương</label>
                                <input class="form-control @error('date_salary') is-invalid @enderror" type="number"
                                    min="1" max="31" name="date_salary" value="{{$date_salary}}">
                                @error('date_salary')
                                <div class="sub_error" style=" color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Chân Trang</label>
                                <input class="form-control @error('footer') is-invalid @enderror" type="text"
                                    name="footer" value="{{$footer}}">
                                @error('footer')
                                <div class="sub_error" style=" color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Hệ Số Lương</label>
                                <input class="form-control @error('salary') is-invalid @enderror" type="text"
                                    name="salary" value="{{$salary}}">
                                @error('salary')
                                <div class="sub_error" style=" color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label>Logo</label>
                                <input class="form-control-file @error('logo') is-invalid @enderror" type="file"
                                    name="logo">
                                @error('logo')
                                <div class="sub_error" style=" color: red;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label>Mật Khẩu Xác Thực</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    name="password">
                                @error('password')
                                <div class="sub_error" style=" color: red;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @include('messages')
                    <div class="card-footer">
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
