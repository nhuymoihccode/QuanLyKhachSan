@extends('layout.admin')
@section('title')
Danh sách dịch vụ
@endsection
@section('content')
    <div class="card shadow mb-4">
      <div class="card-body">
        <form action="{{ route('service.store') }}" method="post">
          @csrf
          <div class="mb-3">
            <label class="form-label">Tên</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <input type="text" name="description" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Giá</label>
            <input type="text" name="price" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary">Tạo</button>
        </form>
      </div>
    </div>
@endsection