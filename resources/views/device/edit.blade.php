@extends('layout.admin')
@section('title')
    Danh sách thiết bị
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{route('device.update')}}" method="post">
                @csrf
                <input hidden type="text" name="id"  class="form-control" value="{{$device->id}}">

                <div class="mb-3">
                  <label  class="form-label">Mã phòng đã đặt</label>
                  <input type="text" name="room_id" class="form-control" value="{{$device->room_id}}">
                </div>
                <div class="mb-3">
                  <label  class="form-label">Tên</label>
                  <input type="text" name="name" class="form-control" value="{{$device->name}}">
                </div>

                <div class="mb-3">
                    <label  class="form-label">SDT</label>
                    <input type="text" name="type" class="form-control" value="{{$device->type}}"> 
                  </div>

                  <div class="mb-3">
                    <label  class="form-label">Email</label>
                    <input type="text" name="status" class="form-control" value="{{$device->status}}">
                  </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
              </form>
        </div>
    </div>
@endsection
