@extends('layout.admin')
@section('title')
Danh sách phòng
@endsection
@section('content')
    <div class="card shadow mb-4">
      <div class="card-body">
        <form action="{{ route('room.store') }}" method="post">
          @csrf
          <div class="mb-3">
            <label class="form-label">Mã khách sạn đã đặt</label>
            <input type="text" name="hotel_id" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Tên</label>
            <input type="text" name="room_number" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Loại</label>
            <input type="text" name="type" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Giá phòng</label>
            <input type="text" name="price" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <input type="text" name="status" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary">Tạo</button>
        </form>
      </div>
    </div>
@endsection