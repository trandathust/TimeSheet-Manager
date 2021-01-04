@extends('quanly.layout')

@section('title')
<title>Timesheet | Skymap Global</title>
@endsection
@section('content')

<div class="content-wrapper">
    @include('quanly.general.content-header',['name'=>'Chi Tiết Timesheet'])

    <section class="content">
        <div class="card">
            <form action="{{route('manager.postAssess',['id' => $timesheet->id])}}">
                @csrf
                <div class="card-body">
                    <table id="table_assess" class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Cộng tác viên:</td>
                                <td>{{(optional($timesheet ->user)-> name)}}</td>
                                <td>Số điện thoại:</td>
                                <td>{{(optional($timesheet ->user)-> phone)}}</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>{{(optional($timesheet ->user)-> email)}}</td>
                                <td>Ngày làm việc:</td>
                                <td>{{$timesheet-> date_work}}</td>
                            </tr>
                            <tr>
                                <td>Giờ Đến:</td>
                                <td>{{$timesheet-> start_time}}</td>
                                <td>Giờ Về:</td>
                                <td>{{$timesheet-> end_time}}</td>
                            </tr>
                            <tr>
                                <td>Giờ làm việc:</td>
                                <td>{{$timesheet -> total_hour}}h</td>
                                <td>Hiệu quả công việc:</td>
                                <td>{{$timesheet -> effective}}%</td>
                            </tr>
                            <tr>
                                <td>Dự án:</td>
                                <td>{{optional($timesheet ->project)-> name}}h</td>
                                <td>Mô tả công việc:</td>
                                <td>{{$timesheet -> description}}%</td>
                            </tr>
                            <tr>
                                <td>Đánh giá thời gian:</td>
                                <td>
                                    <input type="number" name="confirm_hour" id="confirm_hour" min="0" max="24"
                                        class="form-control" value="{{$timesheet -> confirm_hour}}">
                                </td>
                                <td>Đánh giá hiệu quả:</td>
                                <td>
                                    <input type="number" name="confirm_effective" id="confirm_effective" min="0"
                                        max="100" class="form-control" value="{{$timesheet -> confirm_effective}}">
                                </td>
                            </tr>
                            <tr>
                                <td>Trạng thái Sửa/Không Được Sửa:</td>
                                <td><input type="checkbox" name="status" id="status" @if($timesheet -> date_work >=
                                    $setting_time_ctv || $timesheet -> status_manager == 1)
                                    value="0"
                                    checked
                                    @endif value="1"
                                    >
                                </td>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-primary btn_submit"
                                        data-url="{{route('manager.postAssess',['id' => $timesheet->id])}}">
                                        Lưu</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('css')
@endsection

@section('js')
<script src="{{asset('vendor/quanly/detail.js')}}"></script>
<script src="{{asset('vendor/sweetalert/sweetalert2@9.js')}}"></script>
@endsection
