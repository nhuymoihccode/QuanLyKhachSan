@extends('layout.admin')
@section('title')
  Danh sách phòng
@endsection
@section('content')
  <div class="card shadow mb-4">
    <div class="card-body">
    <form action="{{route('room.update')}}" method="post">
      @csrf
      <input hidden type="text" name="id" class="form-control" value="{{$room->id}}">
      <div class="mb-3">
        <label class="form-label">Mã khách sạn đã đặt</label>
        <input type="text" name="hotel_id" class="form-control" value="{{$room->hotel_id}}">
      </div>
      <div class="mb-3">
        <label class="form-label">Tên</label>
        <input type="text" name="room_number" class="form-control" value="{{$room->room_number}}">
      </div>
      <div class="mb-3">
        <label class="form-label">Loại phòng</label>
        <select name="type" class="form-control">
          <option value="single" {{ $room->type == 'single' ? 'selected' : '' }}>Đơn</option>
          <option value="double" {{ $room->type == 'double' ? 'selected' : '' }}>Đôi</option>
          <option value="suite" {{ $room->type == 'suite' ? 'selected' : '' }}>Suite</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Giá phòng</label>
        <input type="text" name="price" class="form-control" value="{{$room->price}}">
      </div>
      <div class="mb-3">
        <label class="form-label">Trạng thái</label>
        <input type="text" name="status" class="form-control" value="{{$room->status}}">
      </div>
      <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
    </div>
  </div>
@endsection