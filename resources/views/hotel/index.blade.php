@extends('layout.admin')
@section('title')
Danh sách khách sạn
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('hotel.create') }}" class="btn btn-sm btn-primary shadow-sm">Add New
                            Hotel</a>
                    </div>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Địa chỉ</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Địa chỉ</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Ngày tạo</th>
                        <th>Ngày cập nhật</th>
                        <th>Thao tác</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($hotels as $hotel)
                        <tr>
                            <td>{{$hotel->id}}</td>
                            <td>{{$hotel->name}}</td>
                            <td>{{$hotel->address}}</td>
                            <td>{{$hotel->phone}}</td>
                            <td>{{$hotel->email}}</td>
                            <td>{{$hotel->created_at}}</td>
                            <td>{{$hotel->updated_at}}</td>
                            <td><a href="{{ route('hotel.edit', $hotel->id) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <a class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#deleteModal{{ $hotel->id }}">
                                    Del
                                </a>
                            </td>
                        </tr>
                        {{-- modal xóa --}}
                        <div class="modal fade" id="deleteModal{{ $hotel->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $hotel->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $hotel->id }}">Xác Nhận Xóa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa <strong>{{ $hotel->name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                        <form action="{{ route('hotel.delete', $hotel->id) }}" method="POST" style="display: inline;">
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
            {{ $hotels->links() }}
        </div>
    </div>
</div>
@endsection