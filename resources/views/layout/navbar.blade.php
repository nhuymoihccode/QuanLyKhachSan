<!-- trang navbar -->
<nav class="navbar navbar-expand-lg" style="background-color: #007bff;">
    <div class="container">
        <a class="navbar-brand d-flex" href="{{route('booking.index')}}" style="color: white;">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSibs2_-upVyg8exAbYYdk9f6GhOFk-H9RjVA&s"
                alt="Logo" style="height: 40px;">
            <p>Hotel Funny</p>
        </a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('booking.index')}}" style="color: white;">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('booking.rooms') }}">Danh sách phòng</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('booking.history') }}">Lịch sử đặt phòng</a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('promotions.index') }}" style="color: white;">Thông tin khuyến mãi</a>
                </li>
            </ul>
        </div>
        <div>
            @if(Auth::check())
                <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle d-flex" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">Chào mừng,
                                {{ session('user_name') }}</span>
                            <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                            aria-labelledby="userDropdown">
                            @if(Auth::user()->role === 'admin')
                                <a class="dropdown-item" href="{{ route('dashboard.index') }}">
                                    <i class="fas fa-tachometer-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Di chuyển đến Admin
                                </a>
                            @endif
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            @else
                <a type="button" href="{{ route('login.index') }}" class="btn button-login">
                    Đăng nhập
                </a>
            @endif
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>
{{-- modal logout --}}
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title me-auto" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('login.logout') }}">Logout</a>
            </div>
        </div>
    </div>
</div>