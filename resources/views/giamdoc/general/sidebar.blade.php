<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{route('president.Dashboard')}}" class="brand-link">
        <img src="{{$data_logo}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SkymapGlobal</span>
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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('president.Dashboard')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Trang Chủ
                        </p>
                    </a>
                </li>
                <li class="nav-header">BÁO CÁO</li>
                <li class="nav-item">
                    <a href="{{route('president.getTimesheet')}}" class="nav-link">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>TimeSheet</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('president.getSalary')}}" class="nav-link">
                        <i class="fas fa-dollar-sign nav-icon"></i>
                        <p>Tổng Tiền Lương</p>
                    </a>
                </li>
                <li class="nav-header">QUẢN LÝ DỰ ÁN</li>
                <li class="nav-item">
                    <a href="{{route('president.getAddProject')}}" class="nav-link">
                        <i class="fas fa-plus nav-icon"></i>
                        <p>Thêm</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('president.getViewProject')}}" class="nav-link">
                        <i class="fas fa-align-justify nav-icon"></i>
                        <p>Xem</p>
                    </a>
                </li>
                <li class="nav-header">THÔNG TIN</li>
                <li class="nav-item">
                    <a href="{{route('president.getProfile')}}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('president.getPassword')}}" class="nav-link">
                        <i class="nav-icon fas fa-key"></i>
                        <p>Đổi Mật Khẩu</p>
                    </a>
                </li>
                <li class="nav-header">HOẠT ĐỘNG</li>
                <li class="nav-item">
                    <a href="{{route('president.getSetting')}}" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>
                            Cài Đặt
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('logout')}}">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        Đăng Xuất
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
