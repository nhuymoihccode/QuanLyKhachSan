@extends('layout.admin')
@section('title')
    Cập Nhật Ca Làm Việc
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('shift.update') }}" method="post">
                @csrf
                <input type="hidden" name="id" class="form-control" value="{{ $shift->id }}">

                <div class="mb-3">
                    <label class="form-label">Mã nhân viên</label>
                    <select name="staff_id" class="form-control" required>
                        @foreach (\App\Models\Staff::all() as $staff)
                            <option value="{{ $staff->id }}" {{ $staff->id == $shift->staff_id ? 'selected' : '' }}>
                                {{ $staff->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Thời gian bắt đầu</label>
                    <input type="time" name="start_time" class="form-control" value="{{ $shift->start_time }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Thời gian kết thúc</label>
                    <input type="time" name="end_time" class="form-control" value="{{ $shift->end_time }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ngày</label>
                    <input type="date" name="date" class="form-control" value="{{ $shift->date->format('Y-m-d') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
@endsection