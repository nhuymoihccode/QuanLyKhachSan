@extends('layout.admin')
@section('title')
    Danh sách khách sạn
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{route('hotel.update')}}" method="post">
                @csrf
                <input hidden type="text" name="id"  class="form-control" value="{{$hotel->id}}">

                <div class="mb-3">
                  <label class="form-label">Tên</label>
                  <input type="text" name="name" class="form-control" value="{{$hotel->name}}">
                </div>
                <div class="mb-3">
                  <label class="form-label">Địa chỉ</label>
                  <input type="text" name="address" class="form-control" value="{{$hotel->address}}">
                </div>
                <div class="mb-3">
                  <label class="form-label">SĐT</label>
                  <input type="text" name="phone" class="form-control" value="{{$hotel->phone}}">
                </div>
                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" value="{{$hotel->email}}">
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
              </form>
        </div>
    </div>
@endsection
