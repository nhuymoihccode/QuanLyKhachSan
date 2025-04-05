@extends('layout.admin')
@section('title')
    Tạo Khuyến Mãi
@endsection
@section('content')
    <div class="card shadow mb-4">
      <div class="card-body">
        <form action="{{ route('promotion.store') }}" method="post">
          @csrf
          <div class="mb-3">
            <label class="form-label">Mã Khuyến Mãi</label>
            <input type="text" name="code" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Tên Khuyến Mãi</label>
            <input type="text" name="name" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Phần Trăm Giảm Giá</label>
            <input type="number" name="discount_percentage" class="form-control" step="0.01" min="0" max="100" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Số Tiền Tối Thiểu</label>
            <input type="number" name="min_amount" class="form-control" step="0.01" min="0" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Ngày Bắt Đầu</label>
            <input type="date" name="start_date" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Ngày Kết Thúc</label>
            <input type="date" name="end_date" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Số Lượng</label>
            <input type="number" name="quantity" class="form-control" min="0" required>
          </div>
          <button type="submit" class="btn btn-primary">Tạo</button>
        </form>
      </div>
    </div>
@endsection