@extends('layout.admin')
@section('title')
    Tạo Ca Làm Việc
@endsection
@section('content')
    <div class="card shadow mb-4">
      <div class="card-body">
        <form action="{{ route('shift.store') }}" method="post">
          @csrf
          <div class="mb-3">
            <label class="form-label">Mã nhân viên</label>
            <select name="staff_id" class="form-control" required>
                <option value="">Chọn nhân viên</option>
                @foreach (\App\Models\Staff::all() as $staff)
                    <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Thời gian bắt đầu</label>
            <input type="time" name="start_time" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Thời gian kết thúc</label>
            <input type="time" name="end_time" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Ngày</label>
            <input type="date" name="date" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary">Tạo</button>
        </form>
      </div>
    </div>
@endsection