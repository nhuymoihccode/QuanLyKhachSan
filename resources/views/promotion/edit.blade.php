@extends('layout.admin')
@section('title')
    Cập Nhật Khuyến Mãi
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('promotion.update', $promotion->id) }}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{ $promotion->id }}">

                <div class="mb-3">
                    <label class="form-label">Mã Khuyến Mãi</label>
                    <input type="text" name="code" class="form-control" value="{{ $promotion->code }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tên Khuyến Mãi</label>
                    <input type="text" name="name" class="form-control" value="{{ $promotion->name }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Phần Trăm Giảm Giá</label>
                    <input type="number" name="discount_percentage" class="form-control" value="{{ $promotion->discount_percentage }}" step="0.01" min="0" max="100" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số Tiền Tối Thiểu</label>
                    <input type="number" name="min_amount" class="form-control" value="{{ $promotion->min_amount }}" step="0.01" min="0" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày Bắt Đầu</label>
                    <input type="date" name="start_date" class="form-control" value="{{ $promotion->start_date->format('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày Kết Thúc</label>
                    <input type="date" name="end_date" class="form-control" value="{{ $promotion->end_date->format('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số Lượng</label>
                    <input type="number" name="quantity" class="form-control" value="{{ $promotion->quantity }}" min="0" required>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection