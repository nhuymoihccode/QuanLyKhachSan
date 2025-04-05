# Hotel Management System

Hotel Management System là một ứng dụng web được xây dựng bằng PHP (Laravel) nhằm hỗ trợ quản lý khách sạn, bao gồm đặt phòng, quản lý khách hàng, nhân viên, hóa đơn, dịch vụ, và các chức năng khác. Dự án này cung cấp giao diện người dùng thân thiện cho cả khách hàng và quản trị viên, cùng với hệ thống xác thực và phân quyền mạnh mẽ.

## Tính năng chính

### 1. Đặt phòng (Booking)
- Hiển thị danh sách phòng trống.
- Đặt phòng với các bước: chọn phòng, thêm dịch vụ bổ sung, xác nhận thông tin, thanh toán.
- Xem lịch sử đặt phòng của khách hàng.
- Hỗ trợ mã khuyến mãi (Promotions).

### 2. Quản trị viên (Admin)
- **Dashboard**: Hiển thị doanh thu (ngày/tháng), số hóa đơn đã thanh toán/chưa thanh toán, dịch vụ phổ biến nhất.
- **Quản lý khách hàng**: Thêm, sửa, xóa thông tin khách hàng.
- **Quản lý nhân viên, phòng, dịch vụ, thiết bị, ca làm việc, khách sạn**: CRUD (Create, Read, Update, Delete).
- **Quản lý hóa đơn và đơn hàng**: Theo dõi trạng thái thanh toán và đơn đặt phòng.
- **Quản lý khuyến mãi**: Tạo và áp dụng mã giảm giá.

### 3. Xác thực và phân quyền
- Đăng ký, đăng nhập, đăng xuất.
- Phân quyền: Admin và Customer.

## Công nghệ sử dụng
- **Backend**: PHP (Laravel Framework)
- **Frontend**: Blade Templates, Bootstrap, FontAwesome, Chart.js
- **Database**: MySQL (migration và seeder có sẵn)
- **Middleware**: Xác thực (Auth), phân quyền (Role-based)
- **Thư viện khác**: Pusher (thông báo real-time), Carbon (xử lý thời gian)

## Cấu trúc dự án
- **Routes**: `routes/web.php` - Định nghĩa các tuyến đường cho ứng dụng.
- **Controllers**:
  - `BookingController.php` - Quản lý quy trình đặt phòng.
  - `DashBoardController.php` - Hiển thị dashboard admin.
  - `CustomerController.php` - Quản lý khách hàng (CRUD mẫu).
  - `LoginController.php` & `RegisterController.php` - Xác thực người dùng.
- **Views**:
  - Giao diện khách hàng: `booking/index.blade.php`, `booking/rooms.blade.php`, v.v.
  - Giao diện admin: `dashboard/index.blade.php`, `customer/index.blade.php`, v.v.
- **Migrations**: `database/migrations` - Tạo cấu trúc bảng cơ sở dữ liệu.
- **Seeders**: `database/seeders` - Dữ liệu mẫu cho hệ thống.

## Hướng dẫn cài đặt

1. **Clone repository**:
   
   git clone <repository-url>
   cd hotel-management-system
   Cài đặt dependencies:
```bash   
composer install
npm install
````
Cấu hình môi trường:
Sử dụng Laragon hoặc Xampp để chưa Mysql


Chạy migration và seeder:
```bash
php artisan migrate:refresh --seed
```
Khởi động ứng dụng:
Truy cập google hoặc các trình duyệt khác: http://quanlykhachsan.test/customer
Cách sử dụng
Khách hàng: Truy cập /booking để xem danh sách phòng và đặt phòng.
Quản trị viên: Đăng nhập với tài khoản có vai trò admin để truy cập /dashboard và các chức năng quản lý.
Dữ liệu mẫu
Admin:
Email: huy@gmail.com | Password: 12345 (Admin)
Phòng: 101, 102, 201, v.v. với trạng thái available.
Dịch vụ: Giặt là (50,000 VNĐ), Spa (200,000 VNĐ), v.v.
