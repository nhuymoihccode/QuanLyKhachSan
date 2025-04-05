@extends('layout.admin')
@section('title')
Danh sách nhân viên
@endsection
@section('content')
    <div class="card shadow mb-4">
      <div class="card-body">
        <form action="{{ route('staff.store') }}" method="post">
          @csrf
          <div class="mb-3">
            <label class="form-label">Mã khách sạn đã đặt</label>
            <input type="text" name="hotel_id" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Tên</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Chức vụ</label>
            <input type="text" name="position" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">SĐt</label>
            <input type="text" name="phone" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Lương</label>
            <input type="text" name="salary" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary">Tạo</button>
        </form>
      </div>
    </div>
@endsection