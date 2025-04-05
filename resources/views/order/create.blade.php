@extends('layout.admin')
@section('title')
Tạo Đơn Hàng
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('order.store') }}" method="post">
            @csrf

            <!-- Khách Hàng -->
            <div class="mb-3">
                <label class="form-label">Khách Hàng</label>
                <select name="customer_id" class="form-control" required>
                    <option value="">Chọn Khách Hàng</option>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Số Phòng -->
            <div class="mb-3">
                <label class="form-label">Số Phòng</label>
                <select name="room_id" class="form-control" required>
                    <option value="">Chọn Số Phòng</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->room_number }} ({{ ucfirst($room->status) }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Dịch Vụ -->
            <div class="mb-3">
                <label class="form-label">Dịch Vụ</label>
                <select name="service_id[]" class="form-control" multiple>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} VNĐ)</option>
                    @endforeach
                </select>
            </div>

            <!-- Ngày Check-In -->
            <div class="mb-3">
                <label class="form-label">Ngày Check-In</label>
                <input type="date" name="check_in" class="form-control" required>
            </div>

            <!-- Ngày Check-Out -->
            <div class="mb-3">
                <label class="form-label">Ngày Check-Out</label>
                <input type="date" name="check_out" class="form-control" required>
            </div>

            <!-- Tổng Giá -->
            <div class="mb-3">
                <label class="form-label">Tổng Giá</label>
                <input type="number" name="total_price" class="form-control" required step="0.01">
            </div>

            <!-- Trạng Thái -->
            <div class="mb-3">
                <label class="form-label">Trạng Thái</label>
                <select name="status" class="form-control" required>
                    <option value="pending">Đang Chờ</option>
                    <option value="confirmed">Đã Xác Nhận</option>
                    <option value="canceled">Đã Hủy</option>
                </select>
            </div>

            <!-- Khuyến Mãi (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Khuyến Mãi (tùy chọn)</label>
                <select name="promotion_id" class="form-control">
                    <option value="">Không áp dụng khuyến mãi</option>
                    @foreach ($promotions as $promotion)
                        <option value="{{ $promotion->id }}">{{ $promotion->name }} ({{ $promotion->discount_percentage }}%)</option>
                    @endforeach
                </select>
            </div>

            <!-- Tên Khách Hàng (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Tên Khách Hàng (tùy chọn)</label>
                <input type="text" name="customer_name" class="form-control">
            </div>

            <!-- Số Điện Thoại Khách Hàng (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Số Điện Thoại Khách Hàng (tùy chọn)</label>
                <input type="text" name="customer_phone" class="form-control" maxlength="20">
            </div>

            <!-- Email Khách Hàng (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Email Khách Hàng (tùy chọn)</label>
                <input type="email" name="customer_email" class="form-control" maxlength="100">
            </div>

            <!-- Địa Chỉ Khách Hàng (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Địa Chỉ Khách Hàng (tùy chọn)</label>
                <textarea name="customer_address" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Tạo</button>
        </form>
    </div>
</div>
@endsection