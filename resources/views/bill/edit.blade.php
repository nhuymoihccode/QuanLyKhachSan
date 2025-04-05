@extends('layout.admin')
@section('title')
Cập Nhật Hóa Đơn
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('bill.update', $bill->id) }}" method="post">
            @csrf

            <input type="hidden" name="id" value="{{ $bill->id }}">

            <!-- Đơn Hàng -->
            <div class="mb-3">
                <label class="form-label">Đơn Hàng</label>
                <select name="order_id" class="form-control" required>
                    @foreach ($orders as $order)
                        <option value="{{ $order->id }}" {{ $order->id == $bill->order_id ? 'selected' : '' }}>
                            {{ $order->id }} - {{ $order->customer->name ?? $order->customer_name ?? 'Khách lẻ' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Số Tiền -->
            <div class="mb-3">
                <label class="form-label">Số Tiền</label>
                <input type="number" name="amount" class="form-control" value="{{ old('amount', $bill->amount) }}" step="0.01" required>
            </div>

            <!-- Ngày Thanh Toán -->
            <div class="mb-3">
                <label class="form-label">Ngày Thanh Toán</label>
                <input type="date" name="payment_date" class="form-control" value="{{ old('payment_date', $bill->payment_date ? $bill->payment_date->format('Y-m-d') : '') }}" required>
            </div>

            <!-- Trạng Thái -->
            <div class="mb-3">
                <label class="form-label">Trạng Thái</label>
                <select name="status" class="form-control" required>
                    <option value="paid" {{ $bill->status == 'paid' ? 'selected' : '' }}>Đã Thanh Toán</option>
                    <option value="unpaid" {{ $bill->status == 'unpaid' ? 'selected' : '' }}>Chưa Thanh Toán</option>
                </select>
            </div>

            <!-- Tên Khách Hàng (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Tên Khách Hàng (tùy chọn)</label>
                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $bill->customer_name) }}">
            </div>

            <!-- Số Điện Thoại Khách Hàng (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Số Điện Thoại Khách Hàng (tùy chọn)</label>
                <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone', $bill->customer_phone) }}" maxlength="20">
            </div>

            <!-- Email Khách Hàng (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Email Khách Hàng (tùy chọn)</label>
                <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email', $bill->customer_email) }}" maxlength="100">
            </div>

            <!-- Địa Chỉ Khách Hàng (tùy chọn) -->
            <div class="mb-3">
                <label class="form-label">Địa Chỉ Khách Hàng (tùy chọn)</label>
                <textarea name="customer_address" class="form-control">{{ old('customer_address', $bill->customer_address) }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Cập Nhật</button>
        </form>
    </div>
</div>
@endsection