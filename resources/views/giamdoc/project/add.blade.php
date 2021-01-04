@extends('giamdoc.layout')
@section('title')
<title>Project | SkyMapGlobal</title>
@endsection
@section('content')
<div class="content-wrapper">
    @include('giamdoc.general.content-header',['name'=>'Thêm Dự Án'])

    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form id="form_add">
                    @csrf
                    <div class="card-body">
                        <div class="class row">
                            <div class="class col col-md-12">
                                <label for="InputName">Tên Dự Án</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Nhập tên dự án">
                            </div>
                            <div class="class col col-md-12">
                                <label for="comment">Mô tả</label>
                                <textarea class="form-control" rows="5" id="description" name="description"
                                    placeholder="Nhập mô tả..."></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="InputBirthDay">Bắt đầu</label>
                                <input type="date" name="start_time" id="start_time" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="InputBirthDay">Kết thúc</label>
                                <input type="date" name="end_time" id="end_time" class="form-control">
                            </div>
                            <div class="form-group col-md 4 ">
                                <div class="row">
                                    <div class="col-md-1"></div>
                                    <div class="col-4">
                                        <label>Hiện trạng</label>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-md-1"></div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="status" name="status" value="1" checked />Hoạt
                                        động
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" class="status" name="status" value="0" /> Tạm dừng
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-md-center">
                            <button type="submit" class="btn btn-primary btn_submit_project"
                                data-url="{{route('president.postAddProject')}}">Thêm mới</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>

@endsection

@section('js')
<script language="JavaScript" type="text/javascript" src="{{asset('vendor/giamdoc/project/add.js')}}"></script>
<script src="{{asset('vendor/sweetalert/sweetalert2@9.js')}}"></script>
@endsection
