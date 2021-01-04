@extends('congtacvien.layout')
@section('title')
<title>Timesheet | SkyMapGlobal</title>
@section('content')
<div class="content-wrapper">
    @include('congtacvien.general.content-header',['name' => 'Khai Time Sheet'])
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <form role="form" method="POST" action="{{route('ctv.postAddTimesheet')}}" id="form_timesheet">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Ngày</label>
                                <input type="date" name="date_work" id="date_work" class="form-control"
                                    value="{{$date}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Chọn Dự Án</label>
                                <select class="custom-select" name="project_id" id="project_id">
                                    @foreach($listProject as $item)
                                    <option value="{{$item -> id}}">{{$item -> name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label>Giờ Đến (h))</label>
                                <input type="time" name="start_time" id="start_time" class="form-control"
                                    value="{{$start_time}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Giờ Về (h)</label>
                                <input type="time" name="end_time" id="end_time" class="form-control"
                                    value="{{$end_time}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Giờ làm (h)</label>
                                <input type="number" name="total_hour" id="total_hour" min="0" max="24"
                                    class="form-control" placeholder="Giờ Làm (8)">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Hiệu Quả (%)</label>
                                <input type="number" name="effective" id="effective" min="0" max="100"
                                    class="form-control" placeholder="Nhập hiệu quả(90%)">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="comment">Mô tả công việc</label>
                                <textarea class="form-control" rows="5" name="description" id="description"
                                    placeholder="Nhập mô tả..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row justify-content-md-center">
                            <button type="submit" class="btn btn-primary btn_submit">Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<script src="{{asset('vendor/congtacvien/timesheet/add.js')}}"></script>
<script src="{{asset('vendor/sweetalert/sweetalert2@9.js')}}"></script>
@endsection
