@extends('layout.admin')
@section('title')
    Danh sách dịch vụ
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{route('service.update')}}" method="post">
                @csrf
                <input hidden type="text" name="id"  class="form-control" value="{{$service->id}}">

                <div class="mb-3">
                  <label class="form-label">Tên</label>
                  <input type="text" name="name" class="form-control" value="{{$service->name}}">
                </div>
                <div class="mb-3">
                  <label class="form-label">Mô tả</label>
                  <input type="text" name="description" class="form-control" value="{{$service->description}}">
                </div>
                <div class="mb-3">
                  <label class="form-label">Giá</label>
                  <input type="text" name="price" class="form-control" value="{{$service->price}}">
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
              </form>
        </div>
    </div>
@endsection
