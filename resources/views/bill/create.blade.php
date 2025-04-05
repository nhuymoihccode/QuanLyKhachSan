@extends('layout.admin')
@section('title')
Tạo Hóa Đơn
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('bill.store') }}" method="post">
            @csrf

            <!-- Đơn Hàng -->
            <div class="mb-3">
                <label class="form-label">Đơn Hàng</label>
                <select name="order_id" class="form-control" required>
                    <option value="">Chọn Đơn Hàng</option>
                    @foreach ($orders as $order)
                        <option value="{{ $order->id }}">{{ $order->id }} - {{ $order->customer->name ?? $order->customer_name ?? 'Khách lẻ' }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Số Tiền -->
            <div class="mb-3">
                <label class="form-label">Số Tiền</label>
                <input type="number" name="amount" class="form-control" required step="0.01">
            </div>

            <!-- Ngày Thanh Toán -->
            <div class="mb-3">
                <label class="form-label">Ngày Thanh Toán</label>
                <input type="date" name="payment_date" class="form-control" required>
            </div>

            <!-- Trạng Thái -->
            <div class="mb-3">
                <label class="form-label">Trạng Thái</label>
                <select name="status" class="form-control" required>
                    <option value="paid">Đã Thanh Toán</option>
                    <option value="unpaid" selected>Chưa Thanh Toán</option>
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