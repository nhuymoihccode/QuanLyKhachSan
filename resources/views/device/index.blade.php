@extends('layout.admin')
@section('search')
<form action="{{ route('device.search') }}"
    class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Seach for..."
            aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <input type="submit" class="btn btn-primary" value="Search">
        </div>
    </div>
</form>
@endsection
@section('title')
Danh sách thiết bị
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('device.create') }}" class="btn btn-sm btn-primary shadow-sm">Add New
                            Device</a>
                    </div>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Loại</th>
                        <th>Số lượng</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Loại</th>
                        <th>Số lượng</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                        <th>Thao tác</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($devices as $device)
                        <tr>
                            <td>{{$device->id}}</td>
                            <td>{{$device->name}}</td>
                            <td>{{$device->type}}</td>
                            <td>{{$device->quantity}}</td>
                            <td>{{$device->status}}</td>
                            <td>{{$device->created_at}}</td>
                            <td>{{$device->updated_at}}</td>
                            <td><a href="{{ route('device.edit', $device->id) }}"
                                class="btn btn-sm btn-primary">Edit</a>
                            <a class="btn btn-sm btn-danger" data-toggle="modal"
                                data-target="#deleteModal{{ $device->id }}">
                                Del
                            </a>
                            </td>
                        </tr>
                        {{-- modal xóa --}}
                        <div class="modal fade" id="deleteModal{{ $device->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $device->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $device->id }}">Xác Nhận Xóa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa thiết bị <strong>{{ $device->name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                        <form action="{{ route('device.delete', $device->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection