@extends('quanly.layout')

@section('content')
<div class="content-wrapper">
    @include('quanly.general.content-header',['name'=>'Đổi Mật Khẩu'])

    <section class="content">
        <div class="container-fluid">

            <div class="card card-primary">
                <form method="POST" action="{{route('manager.postPassword')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-row justify-content-md-center">
                            <div class="form col-md-6">
                                <label for="InputPassword">Mật khẩu hiện tại:</label>
                                <input type="password" name="currentpassword"
                                    class="form-control @error('currentpassword') is-invalid @enderror"
                                    placeholder="******">
                                @error('currentpassword')
                                <li class="sub_error" style="color: red;">{{ $message }}</li>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row justify-content-md-center">
                            <div class="form col-md-6">
                                <label for="InputRePassword">Mật khẩu mới:</label>
                                <input type="password" name="newpassword"
                                    class="form-control @error('newpassword') is-invalid @enderror">
                                @error('newpassword')
                                <li class="sub_error" style="color: red;">{{ $message }}</li>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row justify-content-md-center">
                            <div class="form col-md-6">
                                <label for="InputRePassword">Nhập lại mật khẩu:</label>
                                <input type="password" name="repassword"
                                    class="form-control @error('repassword') is-invalid @enderror">
                                @error('repassword')
                                <li class="sub_error" style="color: red;">{{ $message }}</li>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @include('messages')
                        <div class="form-row justify-content-md-center">

                            <div class="form col-md-3">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Lưu</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection
