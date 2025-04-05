@extends('layout.admin')
@section('search')
    <form action="{{ route('order.search') }}"
        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" name="search" class="form-control bg-light border-0 small" placeholder="Tìm kiếm hóa đơn..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <input type="submit" class="btn btn-primary" value="Search">
            </div>
        </div>
    </form>
@endsection
@section('title')
Danh sách đơn hàng
@endsection
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách Hàng</th>
                        <th>Số Phòng</th>
                        <th>Dịch Vụ</th>
                        <th>Trạng Thái</th>
                        <th>Check in</th>
                        <th>Check out</th>
                        <th>Tài khoản tạo</th>
                        <th>Ngày Tạo</th>
                        <th>Ngày Cập Nhật</th>
                        <th>Thao Tác</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Khách Hàng</th>
                        <th>Số Phòng</th>
                        <th>Dịch Vụ</th>
                        <th>Trạng Thái</th>
                        <th>Check in</th>
                        <th>Check out</th>
                        <th>Tài khoản tạo</th>
                        <th>Ngày Tạo</th>
                        <th>Ngày Cập Nhật</th>
                        <th>Thao Tác</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer->name ?? $order->customer_name ?? 'N/A' }}</td>
                            <td>{{ $order->room->room_number ?? 'N/A' }}</td>
                            <td>
                                @if ($order->orderServices->isNotEmpty())
                                    @foreach ($order->orderServices as $service)
                                        {{ $service->name ?? 'Không có' }}<br>
                                    @endforeach
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>{{ $order->check_in ? $order->check_in->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ $order->check_out ? $order->check_out->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            <td>{{ $order->updated_at ? $order->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('order.edit', $order->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                <button class="btn btn-sm btn-danger" data-toggle="modal"
                                    data-target="#deleteModal{{ $order->id }}">
                                    Xóa
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Xác Nhận Xóa -->
                        <div class="modal fade" id="deleteModal{{ $order->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="deleteModalLabel{{ $order->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $order->id }}">Xác Nhận Xóa</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Bạn có chắc chắn muốn xóa đơn hàng ID <strong>{{ $order->id }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                        <form action="{{ route('order.delete', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <!-- Loại bỏ @method('DELETE') vì route dùng POST -->
                                            <button type="submit" class="btn btn-danger">Xóa</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection