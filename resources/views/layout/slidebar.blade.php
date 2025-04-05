<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('customer.index') }}">
        <div class="sidebar-brand-icon">
            <i class="fa-solid fa-hotel"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Hotel Management</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard.index') }}" onclick="activateLink(this)">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('bill.index') }}" onclick="activateLink(this)">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Bill Management</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('order.index') }}" onclick="activateLink(this)">
            <i class="fas fa-fw fa-money-bill-trend-up"></i>
            <span>Order Management</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('staff.index') }}" onclick="activateLink(this)">
            <i class="bi bi-person-workspace"></i>
            <span>Staff Management</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('customer.index') }}" onclick="activateLink(this)">
            <i class="bi bi-person-circle"></i>
            <span>Customer Management</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('device.index') }}" onclick="activateLink(this)">
            <i class="fas fa-solid fa-house-laptop"></i>
            <span>Device Management</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('service.index') }}" onclick="activateLink(this)">
            <i class="fa-solid fa-bell-concierge"></i>
            <span>Service Management</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('promotion.view') }}" onclick="activateLink(this)">
            <i class="fa-solid fa-bell-concierge"></i>
            <span>Promotion Management</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('room.index') }}" onclick="activateLink(this)">
            <i class="fa-solid fa-person-shelter"></i>
            <span>Room Management</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('shift.index') }}" onclick="activateLink(this)">
            <i class="fa-solid fa-user-clock"></i>
            <span>Work Shift Management</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('hotel.index') }}" onclick="activateLink(this)">
            <i class="fa-solid fa-hotel"></i>
            <span>Hotel Management</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

<script>
    // Hàm để kích hoạt liên kết và lưu trạng thái vào localStorage
    function activateLink(link) {
        // Xóa lớp 'active' khỏi tất cả các liên kết
        const links = document.querySelectorAll('.nav-link');
        links.forEach(l => l.classList.remove('active'));

        // Thêm lớp 'active' vào liên kết đã nhấn
        link.classList.add('active');

        // Lưu trạng thái vào localStorage
        localStorage.setItem('activeLink', link.getAttribute('href'));
    }

    // Hàm để cập nhật trạng thái active dựa trên URL hiện tại
    function updateActiveLink() {
        const currentUrl = window.location.pathname; // Lấy đường dẫn hiện tại (ví dụ: /bill)
        const links = document.querySelectorAll('.nav-link');
        let activeLinkFound = false;

        links.forEach(link => {
            const href = link.getAttribute('href');
            // So sánh phần đường dẫn cơ bản (bỏ qua domain và tham số)
            const hrefPath = new URL(href, window.location.origin).pathname; // Chuyển href thành đường dẫn tuyệt đối
            if (hrefPath === currentUrl) {
                link.classList.add('active');
                activeLinkFound = true;
                localStorage.setItem('activeLink', hrefPath); // Cập nhật localStorage
            } else {
                link.classList.remove('active');
            }
        });

        // Nếu không tìm thấy liên kết khớp, sử dụng giá trị từ localStorage
        if (!activeLinkFound && localStorage.getItem('activeLink')) {
            links.forEach(link => {
                const hrefPath = new URL(link.getAttribute('href'), window.location.origin).pathname;
                if (hrefPath === localStorage.getItem('activeLink')) {
                    link.classList.add('active');
                }
            });
        }
    }

    // Gọi hàm cập nhật khi trang được tải và khi URL thay đổi
    window.onload = updateActiveLink; // Cập nhật khi tải trang
    window.addEventListener('popstate', updateActiveLink); // Cập nhật khi back/forward
    window.addEventListener('hashchange', updateActiveLink); // Cập nhật khi thay đổi hash

    // Theo dõi thay đổi URL thủ công (nhập URL mới)
    setInterval(() => {
        const newUrl = window.location.pathname;
        if (newUrl !== localStorage.getItem('lastCheckedUrl')) {
            updateActiveLink();
            localStorage.setItem('lastCheckedUrl', newUrl);
        }
    }, 100); // Kiểm tra mỗi 100ms
</script>