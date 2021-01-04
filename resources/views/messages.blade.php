@if(session('thatbai'))
<div class="alert alert-danger">
    {{session('thatbai')}}
</div>
@endif

@if(session('thanhcong'))
<div class="alert alert-success">
    {{session('thanhcong')}}
</div>
@endif
