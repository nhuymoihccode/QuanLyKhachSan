@extends('layout.admin')
@section('search')
    <form action="{{ route('bill.search') }}"
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
    Danh sách hóa đơn
@endsection
@section('content')
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th> Mã Đơn Hàng</th>
                            <th>Khách Hàng</th>
                            <th>Số Phòng</th>
                            <th>Dịch Vụ</th>
                            <th>Số Tiền</th>
                            <th>Ngày Thanh Toán</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th>Ngày Cập Nhật</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Khách Hàng</th>
                            <th>Số Phòng</th>
                            <th>Dịch Vụ</th>
                            <th>Số Tiền</th>
                            <th>Ngày Thanh Toán</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th>Ngày Cập Nhật</th>
                            <th>Thao Tác</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($bills as $bill)
                            <tr>
                                <td>{{ $bill->order->id ?? 'N/A' }}</td>
                                <td>{{ $bill->order->customer->name ?? $bill->customer_name ?? 'N/A' }}</td>
                                <td>{{ $bill->order->room->room_number ?? 'N/A' }}</td>
                                <td>
                                    @if ($bill->order->orderServices->isNotEmpty())
                                        @foreach ($bill->order->orderServices as $service)
                                            {{ $service->name ?? 'N/A' }}<br>
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ number_format($bill->amount, 0, ',', '.') }} VNĐ</td>
                                <td>{{ $bill->payment_date ? $bill->payment_date->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ ucfirst($bill->status) }}</td>
                                <td>{{ $bill->created_at ? $bill->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td>{{ $bill->updated_at ? $bill->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('bill.edit', $bill->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                        data-target="#deleteModal{{ $bill->id }}">
                                        Xóa
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal Xác Nhận Xóa -->
                            <!-- Modal Xác Nhận Xóa -->
                            <div class="modal fade" id="deleteModal{{ $bill->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="deleteModalLabel{{ $bill->id }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel{{ $bill->id }}">Xác Nhận Xóa</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn xóa hóa đơn ID <strong>{{ $bill->id }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                                            <form action="{{ route('bill.delete', $bill->id) }}" method="post"
                                                style="display: inline;">
                                                @csrf
                                                <!-- Loại bỏ @method('DELETE') -->
                                                <button type="submit" class="btn btn-danger">Xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
                {{ $bills->links() }}
            </div>
        </div>
    </div>
@endsection