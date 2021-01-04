<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('manager.Dashboard')}}" class="brand-link">
        <img src="{{$data_logo}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Skymap Global</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(auth()->user()->avatar_path)
                <img src="{{auth()->user()->avatar_path}}" class="img-circle elevation-2" alt="User Image">
                @else
                <img src="{{asset('adminlte/dist/img/avatar04.png')}}" class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('manager.Dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Trang Chủ
                        </p>
                    </a>
                </li>
                <li class="nav-header">QUẢN LÝ TIMESHEET</li>
                <li class="nav-item">
                    <a href="{{route('manager.getAssess')}}" class="nav-link">
                        <i class="fas fa-check nav-icon"></i>
                        <p>Đánh Giá</p>
                    </a>
                </li>
                <li class="nav-header">THÔNG TIN</li>
                <li class="nav-item">
                    <a href="{{route('manager.getProfile')}}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('manager.getPassword')}}" class="nav-link">
                        <i class="nav-icon fas fa-key"></i>
                        <p>Đổi Mật Khẩu</p>
                    </a>
                </li>
                <li class="nav-header">HOẠT ĐỘNG</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('logout')}}">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        Đăng Xuất
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
