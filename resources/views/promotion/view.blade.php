@extends('layout.admin')

@section('search')
    <form action="{{ route('promotion.search') }}" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Tìm kiếm khuyến mãi..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <input type="submit" class="btn btn-primary" value="Search">
            </div>
        </div>
    </form>
@endsection

@section('title')
    Danh sách khuyến mãi
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('promotion.create') }}" class="btn btn-sm btn-primary shadow-sm">Thêm Khuyến Mãi Mới</a>
                        </div>
                        <tr>
                            <th>ID</th>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Phần trăm giảm</th>
                            <th>Số tiền tối thiểu</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Số lượng</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Mã</th>
                            <th>Tên</th>
                            <th>Phần trăm giảm</th>
                            <th>Số tiền tối thiểu</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Số lượng</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                            <th>Thao tác</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($promotions as $promotion)
                            <tr>
                                <td>{{ $promotion->id }}</td>
                                <td>{{ $promotion->code }}</td>
                                <td>{{ $promotion->name }}</td>
                                <td>{{ $promotion->discount_percentage }}%</td>
                                <td>{{ number_format($promotion->min_amount, 2) }}</td>
                                <td>{{ $promotion->start_date->format('d/m/Y') }}</td>
                                <td>{{ $promotion->end_date->format('d/m/Y') }}</td>
                                <td>{{ $promotion->quantity }}</td>
                                <td>{{ $promotion->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $promotion->updated_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('promotion.edit', $promotion->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $promotion->id }}">Xóa</button>
                                </td>
                            </tr>
                            <!-- Modal Xác Nhận Xóa -->
                            <div class="modal fade" id="deleteModal{{ $promotion->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $promotion->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $promotion->id }}">Xác Nhận Xóa</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa khuyến mãi <strong>{{ $promotion->name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                            <form action="{{ route('promotion.delete', $promotion->id) }}" method="POST" style="display: inline;">
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
                {{ $promotions->links() }}
            </div>
        </div>
    </div>
@endsection