@extends('layout.admin')
@section('title')
Danh sách nhân viên
@endsection
@section('content')
<div class="card shadow mb-4">
  <div class="card-body">
    <form action="{{route('staff.update')}}" method="post">
      @csrf
      <input hidden type="text" name="id" class="form-control" value="{{$staff->id}}">

      <div class="mb-3">
        <label class="form-label">Mã khách sạn đã đặt</label>
        <input type="text" name="hotel_id" class="form-control" value="{{$staff->hotel_id}}">
      </div>

      <div class="mb-3">
        <label class="form-label">Tên</label>
        <input type="text" name="name" class="form-control" value="{{$staff->name}}">
      </div>

      <div class="mb-3">
        <label class="form-label">Chức vụ</label>
        <input type="text" name="position" class="form-control" value="{{$staff->position}}">
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{$staff->email}}">
      </div>
      <div class="mb-3">
        <label class="form-label">SĐT</label>
        <input type="text" name="phone" class="form-control" value="{{$staff->phone}}">
      </div>
      <div class="mb-3">
        <label class="form-label">Lương</label>
        <input type="text" name="salary" class="form-control" value="{{$staff->salary}}">
      </div>
      <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
  </div>
</div>
@endsection