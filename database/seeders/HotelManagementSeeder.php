<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HotelManagementSeeder extends Seeder
{
    public function run()
    {
        // Tạo dữ liệu cho bảng users
        DB::table('users')->insert([
            ['name' => 'Huy', 'email' => 'huy@gmail.com', 'password' => Hash::make('12345'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'role' => 'admin'],
            ['name' => 'Khai', 'email' => 'khai@gmail.com', 'password' => Hash::make('123456'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'role' => 'admin'],
            ['name' => 'Quyen', 'email' => 'quyen@gmail.com', 'password' => Hash::make('1234567'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'role' => 'admin'],
            ['name' => 'Lac', 'email' => 'lac@gmail.com', 'password' => Hash::make('12345678'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(), 'role' => 'admin']
        ]);

        // Tạo dữ liệu cho bảng hotels
        DB::table('hotels')->insert([
            ['name' => 'Khách sạn Hà Nội', 'address' => '123 Đường Lê Lợi, Hà Nội', 'phone' => '0123456789', 'email' => 'hanoi.hotel@example.com', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Khách sạn Sài Gòn', 'address' => '456 Đường Nguyễn Huệ, TP. HCM', 'phone' => '0987654321', 'email' => 'saigon.hotel@example.com', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);

        // Tạo dữ liệu cho bảng customers
        DB::table('customers')->insert([
            ['name' => 'Nguyễn Văn A', 'phone' => '0911111111', 'email' => 'nguyenvana@example.com', 'address' => 'Hà Nội', 'total_paid' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Trần Thị B', 'phone' => '0922222222', 'email' => 'tranthib@example.com', 'address' => 'TP. HCM', 'total_paid' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Trịnh Trần T', 'phone' => '0933333333', 'email' => 'trinhtrant@example.com', 'address' => 'Hà Nội', 'total_paid' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Đặng Văn E', 'phone' => '0944444444', 'email' => 'dangvane@example.com', 'address' => 'TP. HCM', 'total_paid' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Lại Văn H', 'phone' => '0955555555', 'email' => 'laivanh@example.com', 'address' => 'Hà Nội', 'total_paid' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Nguyễn Thị C', 'phone' => '0966666666', 'email' => 'nguyenthic@example.com', 'address' => 'TP. HCM', 'total_paid' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Tạo dữ liệu cho bảng staffs
        DB::table('staffs')->insert([
            ['hotel_id' => 1, 'name' => 'Phạm Văn C', 'position' => 'Lễ tân', 'phone' => '0933333333', 'email' => 'phamvanc@example.com', 'started_at' => Carbon::now(), 'salary' => 5000000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['hotel_id' => 2, 'name' => 'Lê Thị D', 'position' => 'Quản lý', 'phone' => '0944444444', 'email' => 'lethid@example.com', 'started_at' => Carbon::now(), 'salary' => 10000000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Tạo dữ liệu cho bảng rooms
        DB::table('rooms')->insert([
            ['hotel_id' => 1, 'room_number' => '101', 'type' => 'single', 'price' => 300000, 'status' => 'available', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['hotel_id' => 2, 'room_number' => '102', 'type' => 'double', 'price' => 700000, 'status' => 'available', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['hotel_id' => 1, 'room_number' => '103', 'type' => 'double', 'price' => 750000, 'status' => 'available', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['hotel_id' => 2, 'room_number' => '104', 'type' => 'double', 'price' => 730000, 'status' => 'available', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['hotel_id' => 1, 'room_number' => '105', 'type' => 'double', 'price' => 800000, 'status' => 'available', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['hotel_id' => 1, 'room_number' => '201', 'type' => 'single', 'price' => 1100000, 'status' => 'available', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['hotel_id' => 2, 'room_number' => '202', 'type' => 'single', 'price' => 1050000, 'status' => 'available', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['hotel_id' => 1, 'room_number' => '203', 'type' => 'single', 'price' => 1300000, 'status' => 'available', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['hotel_id' => 2, 'room_number' => '204', 'type' => 'single', 'price' => 1500000, 'status' => 'available', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Tạo dữ liệu cho bảng devices
        DB::table('devices')->insert([
            ['name' => 'TV', 'type' => 'Electronics', 'quantity' => 100, 'status' => 'in_stock', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Máy lạnh', 'type' => 'Electronics', 'quantity' => 80, 'status' => 'in_stock', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Tủ lạnh', 'type' => 'Electronics', 'quantity' => 90, 'status' => 'in_stock', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // Tạo dữ liệu cho bảng services
        DB::table('services')->insert([
            ['name' => 'Giặt là', 'description' => 'Dịch vụ giặt ủi quần áo', 'price' => 50000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Đồ ăn sáng', 'description' => 'Buffet sáng', 'price' => 100000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Spa', 'description' => 'Dịch vụ spa thư giãn', 'price' => 200000, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // // Tạo dữ liệu cho bảng orders
        // DB::table('orders')->insert([
        //     [
        //         'customer_id' => 1,
        //         'room_id' => 1,
        //         'check_in' => Carbon::parse('2025-01-01'),
        //         'check_out' => Carbon::parse('2025-01-05'),
        //         'total_price' => 1500000,
        //         'status' => 'confirmed',
        //         'customer_name' => 'Nguyễn Văn A',
        //         'customer_phone' => '0911111111',
        //         'customer_email' => 'nguyenvana@example.com',
        //         'customer_address' => 'Hà Nội',
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now(),
        //     ],
        // ]);

        // // Tạo dữ liệu cho bảng order_service
        // DB::table('order_service')->insert([
        //     ['order_id' => 1, 'service_id' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        //     ['order_id' => 1, 'service_id' => 2, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        //     ['order_id' => 2, 'service_id' => 3, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        // ]);

        // Tạo dữ liệu cho bảng shifts
        DB::table('shifts')->insert([
            ['staff_id' => 1, 'start_time' => '08:00:00', 'end_time' => '16:00:00', 'date' => Carbon::parse('2025-01-01'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['staff_id' => 2, 'start_time' => '13:00:00', 'end_time' => '07:00:00', 'date' => Carbon::parse('2025-01-01'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        // // Tạo dữ liệu cho bảng bills
        // DB::table('bills')->insert([
        //     ['order_id' => 1, 'amount' => 1500000, 'payment_date' => Carbon::parse('2025-01-01'), 'status' => 'paid', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
        //     ['order_id' => 2, 'amount' => 2000000, 'payment_date' => Carbon::parse('2025-01-03'), 'status' => 'paid', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
        // ]);

        // Tạo dữ liệu cho bảng promotions
        DB::table('promotions')->insert([
            ['code' => 'TET2025', 'name' => 'Tết Nguyên Đán 2025', 'discount_percentage' => 10.00, 'quantity' => 5, 'min_amount' => 1000000.00, 'start_date' => Carbon::parse('2025-01-20'), 'end_date' => Carbon::parse('2025-02-05'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'WOMENSDAY2025', 'name' => 'Chào mừng Quốc tế Phụ nữ 8/3', 'discount_percentage' => 15.00, 'quantity' => 4, 'min_amount' => 500000.00, 'start_date' => Carbon::parse('2025-03-01'), 'end_date' => Carbon::parse('2025-03-10'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'VALENTINE2025', 'name' => 'Valentine Day', 'discount_percentage' => 25.00, 'quantity' => 10, 'min_amount' => 1000000.00, 'start_date' => Carbon::parse('2025-03-08'), 'end_date' => Carbon::parse('2025-03-18'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'NATIONALDAY2025', 'name' => 'Quốc khánh 2/9', 'discount_percentage' => 7.00, 'quantity' => 3, 'min_amount' => 1500000.00, 'start_date' => Carbon::parse('2025-08-28'), 'end_date' => Carbon::parse('2025-09-05'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'CHRISTMAS2025', 'name' => 'Giáng Sinh 2025', 'discount_percentage' => 13.00, 'quantity' => 6, 'min_amount' => 800000.00, 'start_date' => Carbon::parse('2025-12-20'), 'end_date' => Carbon::parse('2025-12-25'), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}