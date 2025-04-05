@extends('layout.admin')
@section('title')
Cập Nhật Đơn Hàng
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('order.update', $order->id) }}" method="post">
            @csrf

            <input type="hidden" name="id" value="{{ $order->id }}">

            <!-- Khách Hàng -->
            <div class="mb-3">
                <label class="form-label">Khách Hàng</label>
                <select name="customer_id" class="form-control" required>
                    @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ $customer->id == $order->customer_id ? 'selected' : '' }}>
                            {{ $customer->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Số Phòng -->
            <div class="mb-3">
                <label class="form-label">Số Phòng</label>
                <select name="room_id" class="form-control" required>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ $room->id == $order->room_id ? 'selected' : '' }}>
                            {{ $room->room_number }} ({{ ucfirst($room->status) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Dịch Vụ -->
            <div class="mb-3">
                <label class="form-label">Dịch Vụ</label>
                <select name="service_id[]" class="form-control" multiple>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" {{ $order->orderServices->contains($service->id) ? 'selected' : '' }}>
                            {{ $service->name }} ({{ number_format($service->price, 0, ',', '.') }} VNĐ)
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Ngày Check-In -->
            <div class="mb-3">
                <label class="form-label">Ngày Check-In</label>
                <input type="date" name="check_in" class="form-control" value="{{ old('check_in', $order->check_in ? $order->check_in->format('Y-m-d') : '') }}" required>
            </div>

            <!-- Ngày Check-Out -->
            <div class="mb-3">
                <label class="form-label">Ngày Check-Out</label>
                <input type="date" name="check_out" class="form-control" value="{{ old('check_out', $order->check_out ? $order->check_out->format('Y-m-d') : '') }}" required>
            </div>

            <!-- Tổng Giá -->
            <div class="mb-3">
                <label class="form-label">Tổng Giá</label>
                <input type="number" name="total_price" class="form-control" value="{{ old('total_price', $order->total_price) }}" step="0.01" required>
            </div>

            <!-- Trạng Thái -->
            <div class="mb-3">
                <label class="form-label">Trạng Thái</label>
                <select name="status" class="form-control" required>
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Đang Chờ</option>
                    <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Đã Xác Nhận</option>
                    <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Đã Hủy</option>
                </select>
            </div>

            <!-- Khuyến Mãi (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Khuyến Mãi (tùy chọn)</label>
                <select name="promotion_id" class="form-control">
                    <option value="">Không áp dụng khuyến mãi</option>
                    @foreach ($promotions as $promotion)
                        <option value="{{ $promotion->id }}" {{ $promotion->id == $order->promotion_id ? 'selected' : '' }}>
                            {{ $promotion->name }} ({{ $promotion->discount_percentage }}%)
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tên Khách Hàng (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Tên Khách Hàng (tùy chọn)</label>
                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $order->customer_name) }}">
            </div>

            <!-- Số Điện Thoại Khách Hàng (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Số Điện Thoại Khách Hàng (tùy chọn)</label>
                <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone', $order->customer_phone) }}" maxlength="20">
            </div>

            <!-- Email Khách Hàng (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Email Khách Hàng (tùy chọn)</label>
                <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email', $order->customer_email) }}" maxlength="100">
            </div>

            <!-- Địa Chỉ Khách Hàng (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Địa Chỉ Khách Hàng (tùy chọn)</label>
                <textarea name="customer_address" class="form-control">{{ old('customer_address', $order->customer_address) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </form>
    </div>
</div>
@endsection