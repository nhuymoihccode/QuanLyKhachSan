@extends('layout.admin')
@section('search')
<form action="{{ route('service.search') }}"
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
    Danh sách dịch vụ
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('service.create') }}" class="btn btn-sm btn-primary shadow-sm">Add New
                                Service</a>
                        </div>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Mô tả</th>
                            <th>Giá</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Tên</th>
                            <th>Mô tả</th>
                            <th>Giá</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Thao tác</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($services as $service)
                            <tr>
                                <td>{{$service->id}}</td>
                                <td>{{$service->name}}</td>
                                <td>{{$service->description}}</td>
                                <td>{{$service->price}}</td>
                                <td>{{$service->created_at}}</td>
                                <td>{{$service->updated_at}}</td>
                                <td><a href="{{ route('service.edit', $service->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <a class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#deleteModal{{ $service->id }}">
                                        Del
                                    </a>
                                </td>
                            </tr>
                            {{-- modal xóa --}}
                        <div class="modal fade" id="deleteModal{{ $service->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $service->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $service->id }}">Xác Nhận Xóa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa dịch vụ <strong>{{ $service->name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                        <form action="{{ route('service.delete', $service->id) }}" method="POST" style="display: inline;">
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
                {{ $services->links() }}
            </div>
        </div>
    </div>
@endsection