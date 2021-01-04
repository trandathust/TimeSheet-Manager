@extends('giamdoc.layout')
@section('title')
<title>Project | SkyMapGlobal</title>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('giamdoc.general.content-header',['name'=>'Sửa Thông Tin Dự Án'])

    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-primary">
                    <form>
                        @csrf
                        <div class="card-body">
                            <div class="class row">
                                <div class="class col col-md-12">
                                    <label for="InputName">Tên Dự Án</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Nhập tên dự án" value="{{$project-> name}}">
                                </div>
                                <div class="class col col-md-12">
                                    <label for="comment">Mô tả</label>
                                    <textarea class="form-control" rows="5" id="description" name="description"
                                        placeholder="Nhập mô tả...">value="{{$project-> description}}"</textarea>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="InputBirthDay">Bắt đầu</label>
                                    <input type="date" name="start_time" id="start_time" class="form-control"
                                        value="{{$project-> start_time}}">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="InputBirthDay">Kết thúc</label>
                                    <input type="date" name="end_time" id="end_time" class="form-control"
                                        value="{{$project-> end_time}}">
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
                                            <input type="radio" class="status" name="status" value="1" @if($project->
                                            status == 1) checked @endif />Hoạt
                                            động
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" class="status" name="status" value="0" @if($project->
                                            status == 0) checked @endif /> Tạm dừng
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row justify-content-md-center">
                                <button type="submit" class="btn btn-primary btn_submit_project"
                                    data-url="{{route('president.postEditProject',['id' => $project -> id])}}">Lưu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>



@endsection

@section('js')
<script src="{{asset('vendor/sweetalert/sweetalert2@9.js')}}"></script>
<script src="{{asset('vendor/giamdoc/project/edit.js')}}"></script>
@endsection
