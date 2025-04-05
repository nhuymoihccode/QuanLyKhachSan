@extends('layout.admin')
@section('title')
    Danh sách khách hàng
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{route('customer.update')}}" method="post">
                @csrf
                <input hidden type="text" name="id"  class="form-control" value="{{$customer->id}}">

                <div class="mb-3">
                  <label  class="form-label">Tên</label>
                  <input type="text" name="name" class="form-control" value="{{$customer->name}}">
                </div>

                <div class="mb-3">
                    <label  class="form-label">SDT</label>
                    <input type="text" name="phone" class="form-control" value="{{$customer->phone}}"> 
                  </div>

                  <div class="mb-3">
                    <label  class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{$customer->email}}">
                  </div>

                  <div class="mb-3">
                    <label  class="form-label">Địa chỉ</label>
                    <input type="text" name="address" class="form-control" value="{{$customer->address}}">
                  </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
              </form>
        </div>
    </div>
    
@endsection
